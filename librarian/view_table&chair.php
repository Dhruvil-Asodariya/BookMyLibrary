<?php
require "../session_check.php";
require "../db_config.php";

if ($_SESSION['role'] != "Librarian") {
    header("Location: ../login.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| IMPORTANT
|--------------------------------------------------------------------------
| You need library_id for current librarian.
| Best way: save it in session at login.
| Example:
|   $_SESSION['library_id'] = 1;
|
| If not already in session, fetch it from your library table using user_id.
*/
$user_id = $_SESSION['id'];

if (isset($_SESSION['library_id'])) {
    $library_id = intval($_SESSION['library_id']);
} else {
    $libQuery = mysqli_query($con, "SELECT library_id FROM library WHERE user_id = '$user_id' LIMIT 1");
    $libData = mysqli_fetch_assoc($libQuery);
    $library_id = $libData ? intval($libData['library_id']) : 0;
}

if ($library_id <= 0) {
    die("Library not found for this librarian.");
}

/* ---------------------------------------------
   Helper: JSON response
--------------------------------------------- */
function jsonResponse($status, $message)
{
    header('Content-Type: application/json');
    echo json_encode([
        "status" => $status,
        "message" => $message
    ]);
    exit;
}

/* ---------------------------------------------
   Helper: sync library capacity
--------------------------------------------- */
function syncLibraryCapacity($con, $library_id)
{
    $tableCountQuery = mysqli_query($con, "
        SELECT COUNT(*) AS total_tables
        FROM library_tables
        WHERE library_id = '$library_id'
    ");

    $chairCountQuery = mysqli_query($con, "
        SELECT COUNT(*) AS total_chairs
        FROM library_chairs
        WHERE library_id = '$library_id'
    ");

    if (!$tableCountQuery || !$chairCountQuery) {
        throw new Exception("Failed to calculate library capacity.");
    }

    $tableCountData = mysqli_fetch_assoc($tableCountQuery);
    $chairCountData = mysqli_fetch_assoc($chairCountQuery);

    $total_tables = intval($tableCountData['total_tables']);
    $total_chairs = intval($chairCountData['total_chairs']);

    $updateLibrary = mysqli_query($con, "
        UPDATE library
        SET table_capacity = '$total_tables',
            chair_capacity = '$total_chairs'
        WHERE library_id = '$library_id'
    ");

    if (!$updateLibrary) {
        throw new Exception("Failed to update library capacity: " . mysqli_error($con));
    }
}

/* ---------------------------------------------
   Helper: chair position
--------------------------------------------- */
function getChairPosition($index, $total)
{
    $chairsPerSide = ceil($total / 4);

    if ($index <= $chairsPerSide) {
        $sideIndex = $index;
        return [
            "side" => "top",
            "ratio" => $sideIndex / ($chairsPerSide + 1)
        ];
    }

    if ($index <= $chairsPerSide * 2) {
        $sideIndex = $index - $chairsPerSide;
        return [
            "side" => "right",
            "ratio" => $sideIndex / ($chairsPerSide + 1)
        ];
    }

    if ($index <= $chairsPerSide * 3) {
        $sideIndex = $index - ($chairsPerSide * 2);
        return [
            "side" => "bottom",
            "ratio" => $sideIndex / ($chairsPerSide + 1)
        ];
    }

    $sideIndex = $index - ($chairsPerSide * 3);
    return [
        "side" => "left",
        "ratio" => $sideIndex / ($chairsPerSide + 1)
    ];
}

/* ---------------------------------------------
   POST actions: add / update / delete
--------------------------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $action = $_POST['action'];

    /* ADD TABLE */
    if ($action === 'add_table') {
        $table_name = trim($_POST['table_name'] ?? '');
        $chair_count = intval($_POST['chair_count'] ?? 0);

        if ($table_name === '') {
            jsonResponse("error", "Table name is required.");
        }

        if ($chair_count < 1 || $chair_count > 12) {
            jsonResponse("error", "Chair count must be between 1 and 12.");
        }

        $table_name_safe = mysqli_real_escape_string($con, $table_name);

        $check = mysqli_query($con, "
            SELECT table_id
            FROM library_tables
            WHERE library_id = '$library_id' AND table_name = '$table_name_safe'
            LIMIT 1
        ");

        if (mysqli_num_rows($check) > 0) {
            jsonResponse("error", "Table name already exists in this library.");
        }

        mysqli_begin_transaction($con);

        try {
            $insertTable = mysqli_query($con, "
                INSERT INTO library_tables (library_id, table_name, chair_count)
                VALUES ('$library_id', '$table_name_safe', '$chair_count')
            ");

            if (!$insertTable) {
                throw new Exception(mysqli_error($con));
            }

            $table_id = mysqli_insert_id($con);

            for ($i = 1; $i <= $chair_count; $i++) {
                $insertChair = mysqli_query($con, "
                    INSERT INTO library_chairs (table_id, library_id, chair_no, status)
                    VALUES ('$table_id', '$library_id', '$i', 'available')
                ");

                if (!$insertChair) {
                    throw new Exception(mysqli_error($con));
                }
            }

            syncLibraryCapacity($con, $library_id);

            mysqli_commit($con);
            jsonResponse("success", "Table added successfully.");
        } catch (Exception $e) {
            mysqli_rollback($con);
            jsonResponse("error", "Add failed: " . $e->getMessage());
        }
    }

    /* UPDATE TABLE */
    if ($action === 'update_table') {
        $table_id = intval($_POST['table_id'] ?? 0);
        $table_name = trim($_POST['table_name'] ?? '');
        $chair_count = intval($_POST['chair_count'] ?? 0);

        if ($table_id <= 0) {
            jsonResponse("error", "Invalid table.");
        }

        if ($table_name === '') {
            jsonResponse("error", "Table name is required.");
        }

        if ($chair_count < 1 || $chair_count > 12) {
            jsonResponse("error", "Chair count must be between 1 and 12.");
        }

        $table_name_safe = mysqli_real_escape_string($con, $table_name);

        $checkCurrent = mysqli_query($con, "
            SELECT *
            FROM library_tables
            WHERE table_id = '$table_id' AND library_id = '$library_id'
            LIMIT 1
        ");

        if (mysqli_num_rows($checkCurrent) == 0) {
            jsonResponse("error", "Table not found.");
        }

        $currentData = mysqli_fetch_assoc($checkCurrent);
        $old_chair_count = intval($currentData['chair_count']);

        $checkDuplicate = mysqli_query($con, "
            SELECT table_id
            FROM library_tables
            WHERE library_id = '$library_id'
              AND table_name = '$table_name_safe'
              AND table_id != '$table_id'
            LIMIT 1
        ");

        if (mysqli_num_rows($checkDuplicate) > 0) {
            jsonResponse("error", "Another table already has this name.");
        }

        $bookedCountQuery = mysqli_query($con, "
            SELECT COUNT(*) AS booked_count
            FROM library_chairs
            WHERE table_id = '$table_id'
              AND library_id = '$library_id'
              AND status = 'booked'
        ");

        $bookedCountData = mysqli_fetch_assoc($bookedCountQuery);
        $booked_count = intval($bookedCountData['booked_count']);

        if ($chair_count < $booked_count) {
            jsonResponse("error", "Cannot reduce chairs below booked chair count ($booked_count).");
        }

        mysqli_begin_transaction($con);

        try {
            $updateTable = mysqli_query($con, "
                UPDATE library_tables
                SET table_name = '$table_name_safe',
                    chair_count = '$chair_count'
                WHERE table_id = '$table_id' AND library_id = '$library_id'
            ");

            if (!$updateTable) {
                throw new Exception(mysqli_error($con));
            }

            if ($chair_count > $old_chair_count) {
                for ($i = $old_chair_count + 1; $i <= $chair_count; $i++) {
                    $insertChair = mysqli_query($con, "
                        INSERT INTO library_chairs (table_id, library_id, chair_no, status)
                        VALUES ('$table_id', '$library_id', '$i', 'available')
                    ");

                    if (!$insertChair) {
                        throw new Exception(mysqli_error($con));
                    }
                }
            } elseif ($chair_count < $old_chair_count) {
                $deleteExtra = mysqli_query($con, "
                    DELETE FROM library_chairs
                    WHERE table_id = '$table_id'
                      AND library_id = '$library_id'
                      AND chair_no > '$chair_count'
                      AND status = 'available'
                ");

                if (!$deleteExtra) {
                    throw new Exception(mysqli_error($con));
                }
            }

            syncLibraryCapacity($con, $library_id);

            mysqli_commit($con);
            jsonResponse("success", "Table updated successfully.");
        } catch (Exception $e) {
            mysqli_rollback($con);
            jsonResponse("error", "Update failed: " . $e->getMessage());
        }
    }

    /* DELETE TABLE */
    if ($action === 'delete_table') {
        $table_id = intval($_POST['table_id'] ?? 0);

        if ($table_id <= 0) {
            jsonResponse("error", "Invalid table.");
        }

        $check = mysqli_query($con, "
            SELECT table_id
            FROM library_tables
            WHERE table_id = '$table_id' AND library_id = '$library_id'
            LIMIT 1
        ");

        if (mysqli_num_rows($check) == 0) {
            jsonResponse("error", "Table not found.");
        }

        $bookedCheck = mysqli_query($con, "
            SELECT COUNT(*) AS booked_count
            FROM library_chairs
            WHERE table_id = '$table_id'
              AND library_id = '$library_id'
              AND status = 'booked'
        ");

        $bookedData = mysqli_fetch_assoc($bookedCheck);
        $booked_count = intval($bookedData['booked_count']);

        if ($booked_count > 0) {
            jsonResponse("error", "Cannot delete table because some chairs are booked.");
        }

        mysqli_begin_transaction($con);

        try {
            $deleteChairs = mysqli_query($con, "
                DELETE FROM library_chairs
                WHERE table_id = '$table_id' AND library_id = '$library_id'
            ");

            if (!$deleteChairs) {
                throw new Exception(mysqli_error($con));
            }

            $deleteTable = mysqli_query($con, "
                DELETE FROM library_tables
                WHERE table_id = '$table_id' AND library_id = '$library_id'
            ");

            if (!$deleteTable) {
                throw new Exception(mysqli_error($con));
            }

            syncLibraryCapacity($con, $library_id);

            mysqli_commit($con);
            jsonResponse("success", "Table deleted successfully.");
        } catch (Exception $e) {
            mysqli_rollback($con);
            jsonResponse("error", "Delete failed: " . $e->getMessage());
        }
    }
}

/* ---------------------------------------------
   Load tables + chairs for display
--------------------------------------------- */
$tables = [];
$tableQuery = mysqli_query($con, "
    SELECT *
    FROM library_tables
    WHERE library_id = '$library_id'
    ORDER BY table_id ASC
");

while ($tableRow = mysqli_fetch_assoc($tableQuery)) {
    $table_id = $tableRow['table_id'];

    $chairs = [];
    $chairQuery = mysqli_query($con, "
        SELECT *
        FROM library_chairs
        WHERE table_id = '$table_id' AND library_id = '$library_id'
        ORDER BY chair_no ASC
    ");

    while ($chairRow = mysqli_fetch_assoc($chairQuery)) {
        $chairs[] = $chairRow;
    }

    $tableRow['chairs'] = $chairs;
    $tables[] = $tableRow;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Table & Chair | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../image/title_image.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: "JetBrains Mono", "Fira Code", Consolas, monospace;
        }

        body {
            margin: 0;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #38bdf8;
            font-size: clamp(18px, 4vw, 26px);
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #cbd5f5;
        }

        .legend-box {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 2px solid;
        }

        .legend-available {
            border-color: #38bdf8;
            background: #094b67;
        }

        .legend-selected {
            border-color: #38bdf8;
            background: #38bdf8;
        }

        .legend-sold {
            background: #344767;
            border-color: #64748b;
        }

        .hall {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .table-unit {
            position: relative;
            width: 100%;
            max-width: 266px;
            aspect-ratio: 1/1;
            margin: 10px auto;
            padding: 10px;
        }

        .table {
            position: absolute;
            inset: 50% auto auto 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background: #1e293b;
            border-radius: 12px;
            border: 2px solid #38bdf8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: clamp(10px, 2.5vw, 13px);
            font-weight: 700;
            color: #38bdf8;
            text-align: center;
        }

        .table span {
            font-size: clamp(9px, 2vw, 11px);
            color: #cbd5f5;
        }

        .chair {
            position: absolute;
            border: 2px solid #38bdf8;
            background: #094b67;
            color: #fff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
        }

        .chair:hover {
            background: #2e9dcd;
            color: #032635;
        }

        .chair.selected {
            background: #38bdf8;
            color: #032635;
            border-color: #38bdf8;
        }

        .chair.booked {
            background: #344767;
            border-color: #64748b;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }

        .btn {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #020617;
            padding: 12px 30px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            max-width: 90%;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .breadcrumb-wrapper {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .breadcrumb {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb .dashboard {
            color: #ef4444;
            font-weight: 600;
        }

        .breadcrumb .separator {
            color: #9ca3af;
        }

        .breadcrumb a {
            text-decoration: none;
            color: #ef4444;
        }

        .breadcrumb .current {
            color: #fff;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .hall {
                gap: 25px;
                padding: 12px;
            }

            .table-unit {
                max-width: 180px;
            }

            .btn {
                width: 100%;
            }

            .breadcrumb {
                font-size: 13px;
            }
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .popup-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 320px;
            text-align: center;
        }

        .popup-box input {
            padding: 8px;
            width: 90%;
        }

        .popup-lable {
            color: #000;
            font-size: 14px;
        }

        .popup-box button {
            padding: 8px 14px;
            margin: 5px;
            border: none;
            background: #0ea5e9;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        .cancel {
            background: #ef4444 !important;
        }

        .edit-icon {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #0ea5e9;
            color: #fff;
            padding: 6px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            z-index: 2;
        }

        .delete-icon {
            position: absolute;
            top: 8px;
            right: -25px;
            background: #ef4444;
            color: #fff;
            padding: 6px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            z-index: 2;
        }

        .edit-icon:hover {
            background: #0284c7;
        }

        .delete-icon:hover {
            background: #dc2626;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <a href="home.php" class="dashboard">Dashboard</a>
            <span class="separator">›</span>
            <span class="current">View Table & Chair</span>
        </nav>
    </div>

    <div class="legend">
        <div class="legend-item">
            <div class="legend-box legend-available"></div> Available
        </div>
        <div class="legend-item">
            <div class="legend-box legend-selected"></div> Selected
        </div>
        <div class="legend-item">
            <div class="legend-box legend-sold"></div> Booked
        </div>
    </div>

    <div class="actions">
        <button class="btn" onclick="openAddTablePopup()">+ Add New Table</button>
    </div>

    <div class="hall">
        <?php foreach ($tables as $tableRow): ?>
            <div class="table-unit" data-table-id="<?php echo $tableRow['table_id']; ?>" data-table-name="<?php echo htmlspecialchars($tableRow['table_name']); ?>" data-chair-count="<?php echo $tableRow['chair_count']; ?>">

                <div class="edit-icon" onclick="openEditPopup(this)">
                    <i class="fa fa-pen"></i>
                </div>

                <div class="delete-icon" onclick="deleteTable(this)">
                    <i class="fa fa-trash"></i>
                </div>

                <?php
                foreach ($tableRow['chairs'] as $chair) {
                    $pos = getChairPosition($chair['chair_no'], $tableRow['chair_count']);
                    $statusClass = ($chair['status'] === 'booked') ? 'booked' : '';
                    $style = '';

                    if ($pos['side'] === 'top') {
                        $style = "top:-10%; left:" . ($pos['ratio'] * 100) . "%; transform:translateX(-50%);";
                    } elseif ($pos['side'] === 'right') {
                        $style = "right:-10%; top:" . ($pos['ratio'] * 100) . "%; transform:translateY(-50%);";
                    } elseif ($pos['side'] === 'bottom') {
                        $style = "bottom:-10%; left:" . ($pos['ratio'] * 100) . "%; transform:translateX(-50%);";
                    } elseif ($pos['side'] === 'left') {
                        $style = "left:-10%; top:" . ($pos['ratio'] * 100) . "%; transform:translateY(-50%);";
                    }
                ?>
                    <div class="chair <?php echo $statusClass; ?>" style="<?php echo $style; ?>">
                        C<?php echo $chair['chair_no']; ?>
                    </div>
                <?php } ?>

                <div class="table">
                    <?php echo htmlspecialchars($tableRow['table_name']); ?><br>
                    <span><?php echo $tableRow['chair_count']; ?> Chairs</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="popup-overlay" id="editPopup">
        <div class="popup-box">
            <h3 style="color:#000;">Edit Table</h3>

            <input type="hidden" id="editTableId">

            <label class="popup-lable">Table Name:</label><br>
            <input type="text" id="tableNameInput">
            <br><br>

            <label class="popup-lable">Number of Chairs:</label><br>
            <input type="number" id="chairInput" min="1" max="12">
            <br><br>

            <button onclick="updateTable()">Update</button>
            <button onclick="closePopup()" class="cancel">Cancel</button>
        </div>
    </div>

    <div class="popup-overlay" id="addTablePopup">
        <div class="popup-box">
            <h3 style="color:#000;">Add New Table</h3>

            <label class="popup-lable">Table Name:</label><br>
            <input type="text" id="newTableName" placeholder="TABLE 1">
            <br><br>

            <label class="popup-lable">Number of Chairs:</label><br>
            <input type="number" id="newChairCount" min="1" max="12">
            <br><br>

            <button onclick="createNewTable()">Create</button>
            <button onclick="closeAddPopup()" class="cancel">Cancel</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll(".chair").forEach(chair => {
            chair.addEventListener("click", function() {
                if (this.classList.contains("booked")) return;
                this.classList.toggle("selected");
            });
        });

        function openEditPopup(icon) {
            const tableUnit = icon.closest('.table-unit');
            document.getElementById('editTableId').value = tableUnit.dataset.tableId;
            document.getElementById('tableNameInput').value = tableUnit.dataset.tableName;
            document.getElementById('chairInput').value = tableUnit.dataset.chairCount;
            document.getElementById('editPopup').style.display = "flex";
        }

        function closePopup() {
            document.getElementById('editPopup').style.display = "none";
        }

        function openAddTablePopup() {
            document.getElementById("addTablePopup").style.display = "flex";
        }

        function closeAddPopup() {
            document.getElementById("addTablePopup").style.display = "none";
        }

        function createNewTable() {
            const tableName = document.getElementById("newTableName").value.trim();
            const chairCount = document.getElementById("newChairCount").value;

            const formData = new FormData();
            formData.append("action", "add_table");
            formData.append("table_name", tableName);
            formData.append("chair_count", chairCount);

            fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire({
                            toast: true,
                            position: "top",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                });
        }

        function updateTable() {
            const tableId = document.getElementById("editTableId").value;
            const tableName = document.getElementById("tableNameInput").value.trim();
            const chairCount = document.getElementById("chairInput").value;

            const formData = new FormData();
            formData.append("action", "update_table");
            formData.append("table_id", tableId);
            formData.append("table_name", tableName);
            formData.append("chair_count", chairCount);

            fetch("", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire({
                            toast: true,
                            position: "top",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                });
        }

        function deleteTable(element) {
            const tableUnit = element.closest(".table-unit");
            const tableId = tableUnit.dataset.tableId;

            Swal.fire({
                title: "Delete table?",
                text: "This action cannot be undone",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ef4444",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Yes, delete it"
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append("action", "delete_table");
                    formData.append("table_id", tableId);

                    fetch("", {
                            method: "POST",
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === "success") {
                                Swal.fire({
                                    toast: true,
                                    position: "top",
                                    icon: "success",
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error", data.message, "error");
                            }
                        });
                }
            });
        }
    </script>
</body>
</html>
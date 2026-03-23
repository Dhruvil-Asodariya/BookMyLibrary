<?php
require "../session_check.php";
require "../db_config.php";

if ($_SESSION['role'] != "Admin") {
    header("Location: ../login.php");
    exit();
}

date_default_timezone_set('Asia/Kolkata');
mysqli_query($con, "SET time_zone = '+05:30'");

/* ---------------------------------------------
   GET LIBRARY ID FROM URL
--------------------------------------------- */
$library_id = isset($_GET['library_id']) ? intval($_GET['library_id']) : 0;

if ($library_id <= 0) {
    die("Invalid library id.");
}

/* ---------------------------------------------
   EXPIRE OLD BOOKINGS + FREE CHAIRS
--------------------------------------------- */
mysqli_query($con, "
    UPDATE chair_bookings cb
    JOIN library_chairs lc ON lc.chair_id = cb.chair_id
    SET cb.status = 'expired',
        lc.status = 'available'
    WHERE cb.status = 'active'
      AND cb.end_time <= NOW()
");

/* ---------------------------------------------
   GET LIBRARY DETAILS
--------------------------------------------- */
$libraryQuery = mysqli_query($con, "
    SELECT * FROM library
    WHERE library_id = '$library_id'
    LIMIT 1
");

if (!$libraryQuery || mysqli_num_rows($libraryQuery) == 0) {
    die("Library not found.");
}

$libraryData = mysqli_fetch_assoc($libraryQuery);

/* ---------------------------------------------
   Helper: chair position
--------------------------------------------- */
function getChairPosition($index, $total)
{
    $chairsPerSide = ceil($total / 4);

    if ($index <= $chairsPerSide) {
        return [
            "side" => "top",
            "ratio" => $index / ($chairsPerSide + 1)
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
   LOAD TABLES + CHAIRS
--------------------------------------------- */
$tables = [];

$tableQuery = mysqli_query($con, "
    SELECT * FROM library_tables
    WHERE library_id = '$library_id'
    ORDER BY table_id ASC
");

while ($tableRow = mysqli_fetch_assoc($tableQuery)) {
    $table_id = $tableRow['table_id'];
    $chairs = [];

    $chairQuery = mysqli_query($con, "
        SELECT 
            lc.*,
            CASE
                WHEN EXISTS (
                    SELECT 1
                    FROM chair_bookings cb
                    WHERE cb.chair_id = lc.chair_id
                      AND cb.table_id = lc.table_id
                      AND cb.library_id = lc.library_id
                      AND cb.status = 'active'
                      AND NOW() < cb.end_time
                ) THEN 'booked'
                ELSE 'available'
            END AS current_status
        FROM library_chairs lc
        WHERE lc.table_id = '$table_id'
          AND lc.library_id = '$library_id'
        ORDER BY lc.chair_no ASC
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
            margin-bottom: 10px;
            color: #38bdf8;
            font-size: clamp(18px, 4vw, 26px);
        }

        .library-title {
            text-align: center;
            color: #cbd5f5;
            margin-bottom: 20px;
            font-size: 15px;
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

        .legend-sold {
            background: #344767;
            border-color: #64748b;
        }

        .hall {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 40px;
            max-width: 1100px;
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
            cursor: default;
        }

        .chair.booked {
            background: #344767;
            border-color: #64748b;
            color: #94a3b8;
        }

        .breadcrumb-wrapper {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
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
            transition: 0.2s ease;
        }

        .breadcrumb .current {
            color: #fff;
            font-weight: 600;
        }

        .no-data {
            text-align: center;
            color: #cbd5f5;
            font-size: 16px;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            .hall {
                gap: 25px;
                padding: 12px;
            }

            .table-unit {
                max-width: 140px;
            }

            .breadcrumb {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <a href="home.php" class="dashboard">Dashboard</a>
            <span class="separator">›</span>
            <a href="library_list.php" class="dashboard">Library List</a>
            <span class="separator">›</span>
            <span class="current">View Table & Chair</span>
        </nav>
    </div>

    <!-- <h2>Table & Chair View</h2> -->
    <div class="library-title">
        Library: <strong><?php echo htmlspecialchars($libraryData['library_name']); ?></strong>
    </div>

    <div class="legend">
        <div class="legend-item">
            <div class="legend-box legend-available"></div> Available
        </div>
        <div class="legend-item">
            <div class="legend-box legend-sold"></div> Booked
        </div>
    </div>

    <?php if (count($tables) > 0): ?>
        <div class="hall">
            <?php foreach ($tables as $tableRow): ?>
                <div class="table-unit">
                    <?php
                    foreach ($tableRow['chairs'] as $chair) {
                        $pos = getChairPosition($chair['chair_no'], $tableRow['chair_count']);
                        $statusClass = ($chair['current_status'] === 'booked') ? 'booked' : '';
                        $style = '';

                        if ($pos['side'] === 'top') {
                            $style = "top:-10%; left:" . ($pos['ratio'] * 100) . "%; transform:translateX(-50%);";
                        } elseif ($pos['side'] === 'right') {
                            $style = "right:-10%; top:" . ($pos['ratio'] * 100) . "%; transform:translateY(-50%);";
                        } elseif ($pos['side'] === 'bottom') {
                            $style = "bottom:-10%; left:" . ($pos['ratio'] * 100) . "%; transform:translateX(-50%);";
                        } else {
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
    <?php else: ?>
        <div class="no-data">No tables found for this library.</div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</body>

</html>
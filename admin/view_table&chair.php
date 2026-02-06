<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Table & Chair View | Library System</title>
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
            margin-bottom: 25px;
            color: #38bdf8;
            font-size: clamp(18px, 4vw, 26px);
        }

        /* ---------- LEGEND ---------- */
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

        /* Main Hall */
        .hall {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 40px;
            /* space between tables */
            max-width: 1100px;
            margin: auto;
            padding: 20px;
            /* outer spacing */
        }

        /* Table Unit */
        .table-unit {
            position: relative;
            width: 100%;
            max-width: 266px;
            aspect-ratio: 1/1;
            margin: 10px;
            /* extra space */
            padding: 10px;
        }

        /* Table */
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

        /* Chair */
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

        .chair small {
            font-size: clamp(8px, 1.8vw, 10px);
            color: #bbf7d0;
        }

        .chair:hover {
            background: #2e9dcd;
            color: #032635;
        }

        /* Selected */
        .chair.selected {
            background: #38bdf8;
            color: #032635;
            border-color: #38bdf8;
        }

        /* Booked */
        .chair.booked {
            background: #344767;
            border-color: #64748b;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .chair.booked small {
            color: #94a3b8;
        }

        /* Chair Positions */
        .top {
            top: -8%;
            left: 50%;
            transform: translateX(-50%);
        }

        .left {
            left: -8%;
            top: 50%;
            transform: translateY(-50%);
        }

        .right {
            right: -8%;
            top: 50%;
            transform: translateY(-50%);
        }

        .bottom {
            bottom: -8%;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Action Button */
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

        /* Breadcrumb Container */
        .breadcrumb-wrapper {
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        /* Breadcrumb Layout */
        .breadcrumb {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 6px;
        }

        /* Dashboard */
        .breadcrumb .dashboard {
            color: #ef4444;
            font-weight: 600;
        }

        /* Separator */
        .breadcrumb .separator {
            color: #9ca3af;
        }

        /* Links */
        .breadcrumb a {
            text-decoration: none;
            color: #ef4444;
            transition: 0.2s ease;
        }

        .breadcrumb a:hover {
            text-decoration: none;
        }

        /* Current Page */
        .breadcrumb .current {
            color: #ffffffff;
            font-weight: 600;
        }

        /* Mobile Adjustments */
        @media (max-width: 600px) {
            .hall {
                gap: 25px;
                padding: 12px;
            }

            .table-unit {
                max-width: 140px;
            }

            .btn {
                width: 100%;
            }

            .breadcrumb {
                font-size: 13px;
            }
        }

        /* popup */
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
        }

        .popup-box {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .popup-box input {
            padding: 6px;
            width: 80px;
        }

        .popup-lable {
            color: #000;
            font-size: 14px;
        }

        .popup-box button {
            padding: 6px 14px;
            margin: 5px;
            border: none;
            background: #0ea5e9;
            color: #fff;
            border-radius: 6px;
        }



        .cancel {
            background: #ef4444 !important;
        }

        /* edit icon */
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
        }

        .edit-icon:hover {
            background: #0284c7;
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

    <!-- STATUS LEGEND -->
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


    <!-- <h2>Table & Chair Booking</h2> -->

    <div class="hall">

        <!-- TABLE 1 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <!-- TOP -->
            <div class="chair top">C2</div>
            <div class="chair top" style="left:30%">C1</div>
            <div class="chair top" style="left:70%">C3</div>

            <!-- RIGHT -->
            <div class="chair right">C5</div>
            <div class="chair right" style="top:30%">C4</div>
            <div class="chair right" style="top:70%">C6</div>

            <!-- BOTTOM -->
            <div class="chair bottom">C8</div>
            <div class="chair bottom" style="left:30%">C7</div>
            <div class="chair bottom" style="left:70%">C9</div>

            <!-- LEFT -->
            <div class="chair left">C11</div>
            <div class="chair left" style="top:30%">C10</div>
            <div class="chair left" style="top:70%">C12</div>

            <div class="table">TABLE 1<br><span>12 Chairs</span></div   >
        </div>

        <!-- TABLE 2 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="120">C1<br></div>
            <div class="chair left booked" data-price="120">C2<br></div>
            <div class="chair right" data-price="120">C3<br></div>
            <div class="table">TABLE 2<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 3 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="180">C1<br></div>
            <div class="chair left" data-price="180">C2<br></div>
            <div class="chair right" data-price="180">C3<br></div>
            <div class="chair bottom booked" data-price="180">C4<br></div>
            <div class="table">TABLE 3<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 4 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="100">C1<br></div>
            <div class="chair left" data-price="100">C2<br></div>
            <div class="chair right" data-price="100">C3<br></div>
            <div class="table">TABLE 4<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 5 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="150">C1<br></div>
            <div class="chair left" data-price="150">C2<br></div>
            <div class="chair right" data-price="150">C3<br></div>
            <div class="chair bottom" data-price="150">C4<br></div>
            <div class="table">TABLE 5<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 6 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="120">C1<br></div>
            <div class="chair left booked" data-price="120">C2<br></div>
            <div class="chair right" data-price="120">C3<br></div>
            <div class="table">TABLE 6<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 7 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="180">C1<br></div>
            <div class="chair left" data-price="180">C2<br></div>
            <div class="chair right" data-price="180">C3<br></div>
            <div class="chair bottom booked" data-price="180">C4<br></div>
            <div class="table">TABLE 7<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 8 -->
        <div class="table-unit">
            <!-- EDIT ICON -->
            <div class="edit-icon" onclick="openEditPopup(this)">
                <i class="fa fa-pen"></i>
            </div>

            <div class="chair top" data-price="100">C1<br></div>
            <div class="chair left" data-price="100">C2<br></div>
            <div class="chair right" data-price="100">C3<br></div>
            <div class="table">TABLE 8<br><span>3 Chairs</span></div>
        </div>

    </div>

    <div class="popup-overlay" id="editPopup">
        <div class="popup-box">
            <h3>Edit Table</h3>

            <label class="popup-lable">Table Name:</label>
            <input type="text" id="tableNameInput">

            <br><br>

            <label class="popup-lable">Number of Chairs:</label>
            <input type="number" id="chairInput" min="1" max="12">

            <br><br>

            <button onclick="updateChairs()">Update</button>
            <button onclick="closePopup()" class="cancel">Cancel</button>
        </div>
    </div>



    <div class="popup-overlay" id="addTablePopup">
        <div class="popup-box">
            <h3>Add New Table</h3>

            <label class="popup-lable">Table Name:</label>
            <input type="text" id="newTableName" placeholder="TABLE 9">

            <br><br>

            <label class="popup-lable">Number of Chairs:</label>
            <input type="number" id="newChairCount" min="1" max="12">

            <br><br>

            <button onclick="createNewTable()">Create</button>
            <button onclick="closeAddPopup()" class="cancel">Cancel</button>
        </div>
    </div>

    <!-- <div class="actions">
        <button class="btn" onclick="confirmBooking()">Confirm Booking</button>
    </div> -->
    <?php include 'footer.php'; ?>
</body>

<script>
    // Toggle Chair Selection
    document.querySelectorAll(".chair").forEach(chair => {
        chair.addEventListener("click", function() {
            if (this.classList.contains("booked")) return;
            this.classList.toggle("selected");
        });
    });

    function confirmBooking() {
        const selected = document.querySelectorAll(".chair.selected");

        if (selected.length === 0) {
            alert("❌ Please select at least one chair.");
            return;
        }

        let total = 0;
        let details = [];

        selected.forEach(chair => {
            const price = parseInt(chair.dataset.price);
            const table = chair.closest(".table-unit").querySelector(".table").innerText.split("\n")[0];
            const seat = chair.childNodes[0].nodeValue.trim();

            details.push(`${table} - ${seat}`);

            chair.classList.remove("selected");
            chair.classList.add("booked");
        });

        alert("✅ Booking Confirmed:\n\n" + details.join("\n"));
    }
</script>
<script>
    let selectedTable = null;

    /* OPEN POPUP */
    function openEditPopup(icon) {
        selectedTable = icon.closest('.table-unit');

        const chairCount = selectedTable.querySelectorAll('.chair').length;
        document.getElementById('chairInput').value = chairCount;

        // get table name
        const tableName = selectedTable.querySelector('.table').childNodes[0].nodeValue.trim();
        document.getElementById('tableNameInput').value = tableName;

        document.getElementById('editPopup').style.display = "flex";
    }


    /* CLOSE POPUP */
    function closePopup() {
        document.getElementById('editPopup').style.display = "none";
    }

    /* UPDATE CHAIRS */
    function updateChairs() {

        const count = parseInt(document.getElementById('chairInput').value);
        const tableName = document.getElementById('tableNameInput').value;

        if (!selectedTable) return;

        /* REMOVE OLD CHAIRS */
        selectedTable.querySelectorAll('.chair').forEach(c => c.remove());

        /* TABLE SIZE INCREASE */
        let baseSize = 170;
        if (count > 4) baseSize = 170 + (count - 4) * 12;
        selectedTable.style.maxWidth = baseSize + "px";

        /* SCALE INNER TABLE */
        const tableBox = selectedTable.querySelector('.table');
        tableBox.style.width = "60%";
        tableBox.style.height = "60%";

        /* DISTRIBUTE CHAIRS */
        const chairsPerSide = Math.ceil(count / 4);
        let chairNo = 1;

        for (let i = 0; i < chairsPerSide && chairNo <= count; i++)
            addChair("top", chairNo++, (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= count; i++)
            addChair("right", chairNo++, (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= count; i++)
            addChair("bottom", chairNo++, (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= count; i++)
            addChair("left", chairNo++, (i + 1) / (chairsPerSide + 1));

        /* UPDATE TABLE NAME + CHAIR TEXT */
        tableBox.innerHTML = tableName + "<br><span>" + count + " Chairs</span>";

        closePopup();
    }


    /* CREATE & POSITION CHAIR */
    function addChair(position, number, ratio) {

        const chair = document.createElement('div');
        chair.className = "chair";
        chair.dataset.price = "150";
        chair.innerHTML = "C" + number;

        // enable selection click
        chair.onclick = function() {
            if (this.classList.contains("booked")) return;
            this.classList.toggle("selected");
        }

        if (position === "top") {
            chair.style.top = "-10%";
            chair.style.left = (ratio * 100) + "%";
            chair.style.transform = "translateX(-50%)";
        }

        if (position === "bottom") {
            chair.style.bottom = "-10%";
            chair.style.left = (ratio * 100) + "%";
            chair.style.transform = "translateX(-50%)";
        }

        if (position === "left") {
            chair.style.left = "-10%";
            chair.style.top = (ratio * 100) + "%";
            chair.style.transform = "translateY(-50%)";
        }

        if (position === "right") {
            chair.style.right = "-10%";
            chair.style.top = (ratio * 100) + "%";
            chair.style.transform = "translateY(-50%)";
        }

        selectedTable.appendChild(chair);
    }
</script>

<script>
    let tableCounter = document.querySelectorAll(".table-unit").length + 1;

    /* OPEN ADD TABLE POPUP */
    function openAddTablePopup() {
        document.getElementById("addTablePopup").style.display = "flex";
    }

    /* CLOSE ADD TABLE POPUP */
    function closeAddPopup() {
        document.getElementById("addTablePopup").style.display = "none";
    }

    /* CREATE NEW TABLE */
    function createNewTable() {

        const name = document.getElementById("newTableName").value || "TABLE " + tableCounter;
        const chairCount = parseInt(document.getElementById("newChairCount").value);

        if (!chairCount || chairCount < 1) {
            alert("Enter valid chair count");
            return;
        }

        const hall = document.querySelector(".hall");

        /* CREATE TABLE UNIT */
        const tableUnit = document.createElement("div");
        tableUnit.className = "table-unit";

        /* EDIT ICON */
        const editIcon = document.createElement("div");
        editIcon.className = "edit-icon";
        editIcon.innerHTML = '<i class="fa fa-pen"></i>';
        editIcon.onclick = function() {
            openEditPopup(this);
        };

        tableUnit.appendChild(editIcon);

        /* TABLE BOX */
        const tableBox = document.createElement("div");
        tableBox.className = "table";
        tableBox.innerHTML = `${name}<br><span>${chairCount} Chairs</span>`;
        tableUnit.appendChild(tableBox);

        /* ADD CHAIRS */
        const chairsPerSide = Math.ceil(chairCount / 4);
        let chairNo = 1;

        function addChair(position, ratio) {

            const chair = document.createElement("div");
            chair.className = "chair";
            chair.dataset.price = "150";
            chair.innerHTML = "C" + chairNo++;

            chair.onclick = function() {
                if (this.classList.contains("booked")) return;
                this.classList.toggle("selected");
            };

            if (position === "top") {
                chair.style.top = "-10%";
                chair.style.left = (ratio * 100) + "%";
                chair.style.transform = "translateX(-50%)";
            }

            if (position === "bottom") {
                chair.style.bottom = "-10%";
                chair.style.left = (ratio * 100) + "%";
                chair.style.transform = "translateX(-50%)";
            }

            if (position === "left") {
                chair.style.left = "-10%";
                chair.style.top = (ratio * 100) + "%";
                chair.style.transform = "translateY(-50%)";
            }

            if (position === "right") {
                chair.style.right = "-10%";
                chair.style.top = (ratio * 100) + "%";
                chair.style.transform = "translateY(-50%)";
            }

            tableUnit.appendChild(chair);
        }

        for (let i = 0; i < chairsPerSide && chairNo <= chairCount; i++)
            addChair("top", (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= chairCount; i++)
            addChair("right", (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= chairCount; i++)
            addChair("bottom", (i + 1) / (chairsPerSide + 1));

        for (let i = 0; i < chairsPerSide && chairNo <= chairCount; i++)
            addChair("left", (i + 1) / (chairsPerSide + 1));

        hall.appendChild(tableUnit);

        tableCounter++;
        closeAddPopup();
    }
</script>


</html>
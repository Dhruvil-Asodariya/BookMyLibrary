<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Table & Chair Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
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
            border-color: #22c55e;
            background: #052e16;
        }

        .legend-selected {
            border-color: #22c55e;
            background: #22c55e;
        }

        .legend-sold {
            background: #344767;
            border-color: #64748b;
        }

        /* Main Hall */
        .hall {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 25px;
            max-width: 1000px;
            margin: auto;
        }

        /* Table Unit */
        .table-unit {
            position: relative;
            width: 100%;
            max-width: 170px;
            aspect-ratio: 1/1;
            margin: auto;
            padding: 10px;
        }

        /* Table */
        .table {
            position: absolute;
            inset: 50% auto auto 50%;
            transform: translate(-50%, -50%);
            width: 55%;
            height: 55%;
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
            width: 28%;
            height: 28%;
            border: 2px solid #22c55e;
            border-radius: 8px;
            background: #052e16;
            color: #22c55e;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: clamp(9px, 2vw, 11px);
            cursor: pointer;
            transition: 0.2s ease;
            text-align: center;
        }

        .chair small {
            font-size: clamp(8px, 1.8vw, 10px);
            color: #bbf7d0;
        }

        .chair:hover {
            background: #22c55e;
            color: #022c22;
        }

        /* Selected */
        .chair.selected {
            background: #22c55e;
            color: #022c22;
            border-color: #22c55e;
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
        }

        .btn {
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            color: #020617;
            padding: 12px 30px;
            border-radius: 10px;
            border: none;
            font-weight: 700;
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
                gap: 18px;
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
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <a href="home.php" class="dashboard">Dashboard</a>
            <span class="separator">›</span>
            <a href="library_list.php"><span class="dashboard">Library List</span></a>
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
            <div class="legend-box legend-sold"></div> Sold
        </div>
    </div>

    <!-- <h2>Table & Chair Booking</h2> -->

    <div class="hall">

        <!-- TABLE 1 -->
        <div class="table-unit">
            <div class="chair top" data-price="150">C1<br><small>₹150</small></div>
            <div class="chair left" data-price="150">C2<br><small>₹150</small></div>
            <div class="chair right" data-price="150">C3<br><small>₹150</small></div>
            <div class="chair bottom" data-price="150">C4<br><small>₹150</small></div>
            <div class="table">TABLE 1<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 2 -->
        <div class="table-unit">
            <div class="chair top" data-price="120">C1<br><small>₹120</small></div>
            <div class="chair left booked" data-price="120">C2<br><small>₹120</small></div>
            <div class="chair right" data-price="120">C3<br><small>₹120</small></div>
            <div class="table">TABLE 2<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 3 -->
        <div class="table-unit">
            <div class="chair top" data-price="180">C1<br><small>₹180</small></div>
            <div class="chair left" data-price="180">C2<br><small>₹180</small></div>
            <div class="chair right" data-price="180">C3<br><small>₹180</small></div>
            <div class="chair bottom booked" data-price="180">C4<br><small>₹180</small></div>
            <div class="table">TABLE 3<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 4 -->
        <div class="table-unit">
            <div class="chair top" data-price="100">C1<br><small>₹100</small></div>
            <div class="chair left" data-price="100">C2<br><small>₹100</small></div>
            <div class="chair right" data-price="100">C3<br><small>₹100</small></div>
            <div class="table">TABLE 4<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 1 -->
        <div class="table-unit">
            <div class="chair top" data-price="150">C1<br><small>₹150</small></div>
            <div class="chair left" data-price="150">C2<br><small>₹150</small></div>
            <div class="chair right" data-price="150">C3<br><small>₹150</small></div>
            <div class="chair bottom" data-price="150">C4<br><small>₹150</small></div>
            <div class="table">TABLE 1<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 2 -->
        <div class="table-unit">
            <div class="chair top" data-price="120">C1<br><small>₹120</small></div>
            <div class="chair left booked" data-price="120">C2<br><small>₹120</small></div>
            <div class="chair right" data-price="120">C3<br><small>₹120</small></div>
            <div class="table">TABLE 2<br><span>3 Chairs</span></div>
        </div>

        <!-- TABLE 3 -->
        <div class="table-unit">
            <div class="chair top" data-price="180">C1<br><small>₹180</small></div>
            <div class="chair left" data-price="180">C2<br><small>₹180</small></div>
            <div class="chair right" data-price="180">C3<br><small>₹180</small></div>
            <div class="chair bottom booked" data-price="180">C4<br><small>₹180</small></div>
            <div class="table">TABLE 3<br><span>4 Chairs</span></div>
        </div>

        <!-- TABLE 4 -->
        <div class="table-unit">
            <div class="chair top" data-price="100">C1<br><small>₹100</small></div>
            <div class="chair left" data-price="100">C2<br><small>₹100</small></div>
            <div class="chair right" data-price="100">C3<br><small>₹100</small></div>
            <div class="table">TABLE 4<br><span>3 Chairs</span></div>
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

            total += price;
            details.push(`${table} - ${seat} (₹${price})`);

            chair.classList.remove("selected");
            chair.classList.add("booked");
        });

        alert("✅ Booking Confirmed:\n\n" + details.join("\n") + `\n\nTotal: ₹${total}`);
    }
</script>


</html>
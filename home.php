<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | Library System</title>
    <link rel="icon" href="image/title_image.png" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;

            /* 🔹 GRADIENT BACKGROUND */
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
        }

        /* ---------- NAVBAR ---------- */
        .navbar {
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* LEFT: LOGO IMAGE + NAME */
        .nav-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-left img {
            height: 80px;
            width: 130px;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            white-space: nowrap;
            color: #fff;
        }

        /* CENTER: MENU */
        .nav-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .nav-center a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 15px;
            transition: color 0.3s;
        }

        .nav-center a:hover {
            color: #38bdf8;
        }

        /* RIGHT: PROFILE + LOGOUT */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #fff;
        }

        .profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #38bdf8;
        }

        .profile span {
            font-size: 14px;
        }

        .logout-btn {
            padding: 6px 14px;
            border-radius: 6px;
            background: #ef4444;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* ---------- MAIN CONTENT ---------- */
        .main {
            flex: 1;
            padding: 40px 20px;
            max-width: 1100px;
            margin: auto;
            width: 100%;
        }

        .main h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            color: #ffffff;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #555;
        }

        .card .value {
            font-size: 36px;
            font-weight: bold;
            color: #1f2937;
        }

        .books {
            border-left: 5px solid #3b82f6;
        }

        .fine {
            border-left: 5px solid #ef4444;
        }

        .today {
            border-left: 5px solid #22c55e;
        }

        .returned {
            border-left: 5px solid #a855f7;
        }

        .overdue {
            border-left: 5px solid #f97316;
        }

        /* ---------- FOOTER ---------- */
        .footer {
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            text-align: center;
            padding: 15px 20px;
            font-size: 14px;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .nav-center {
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-right {
                justify-content: center;
                width: 100%;
            }

            .brand-name {
                font-size: 18px;
            }

            .main h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <!-- LEFT: LOGO IMAGE -->
        <div class="nav-left">
            <img src="image/BookMyLibrary.png" alt="Library Logo">
        </div>

        <!-- CENTER: MAIN MENU -->
        <div class="nav-center">
            <a href="#">Dashboard</a>
            <a href="#">Books</a>
            <a href="#">Issued</a>
            <a href="#">Fines</a>
        </div>

        <!-- RIGHT: PROFILE + LOGOUT -->
        <div class="nav-right">
            <div class="profile">
                <img src="image/profile_image.jpg" alt="Profile">
                <span>Dobariya Parth</span>
            </div>
            <a href="login.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main">
        <h1>Library Dashboard</h1>

        <div class="dashboard">
            <div class="card books">
                <h2>Books Issued</h2>
                <div class="value">12</div>
            </div>

            <div class="card fine">
                <h2>Total Fine (₹)</h2>
                <div class="value">250</div>
            </div>
            <div class="card today">
                <h2>Issued Today</h2>
                <div class="value" id="issuedToday">3</div>
            </div>

            <div class="card returned">
                <h2>Returned</h2>
                <div class="value" id="returned">5</div>
            </div>

            <div class="card overdue">
                <h2>Overdue</h2>
                <div class="value" id="overdue">2</div>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        © 2026 All right reserved by BookMyLibrary | Designed for Professional Use
    </footer>

</body>

</html>
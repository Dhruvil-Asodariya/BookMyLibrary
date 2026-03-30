<?php
require "../session_check.php";

if ($_SESSION['role'] != "Admin") {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php 
include '../db_config.php'; 
include '../update_status.php';
?>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="../image/title_image.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "JetBrains Mono", "Fira Code", Consolas, monospace;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
            color: #333;
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-left img {
            height: 80px;
            width: 130px;
        }

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
        }

        .nav-center a:hover {
            color: #38bdf8;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #fff;
        }

        .profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #38bdf8;
            object-fit: cover;
        }

        .logout-btn {
            padding: 6px 14px;
            border-radius: 6px;
            background: #ef4444;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown link */
        .dropdown>a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 15px;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown link */
        .dropdown>a.dropbtn {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 15px;
            cursor: pointer;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: rgba(15, 23, 42, 0.95);
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 100;
            top: 35px;
        }

        /* Links inside dropdown */
        .dropdown-content a {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            transition: background 0.2s;
        }

        .dropdown-content a:hover {
            color: #38bdf8;
            /* darker blue */
        }

        /* Show dropdown when active */
        .dropdown-content.show {
            display: block;
        }

        .dropdown-content hr {
            width: 100%;
            margin: 6px 0;
            border: none;
            height: 1px;
            background: linear-gradient(to right, transparent, #999, transparent);
        }



        /* ---------- MAIN CONTENT ---------- */
        .main {
            flex: 1;
            padding: 40px 20px;
            margin: auto;
            width: 100%;
        }

        .main h1 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 30px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }

        /* ---------- CARDS ---------- */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
            margin-bottom: 40px;
        }

        .card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 25px 22px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.02));
            opacity: 0.6;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
            cursor: pointer;
        }

        .card-content {
            position: relative;
            z-index: 1;
        }

        .card h2 {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .card .value {
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .card .sub {
            font-size: 13px;
            opacity: 0.8;
        }

        /* Accent Bars */
        .books {
            border-left: 5px solid #3b82f6;
        }

        .issued {
            border-left: 5px solid #22c55e;
        }

        .users {
            border-left: 5px solid #a855f7;
        }

        .libraries {
            border-left: 5px solid #06b6d4;
        }

        .category {
            border-left: 5px solid #f59e0b;
        }

        /* Teal color */


        .pending {
            border-left: 5px solid #f97316;
        }

        .totalfine {
            border-left: 5px solid #ef4444;
        }

        /* ---------- CHART SECTION ---------- */
        .charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        .chart-card h3 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 500;
            opacity: 0.95;
        }

        .chart-wrapper {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            color: #fff;
            height: 400px;
            /* increase this */
            width: 100%;
        }

        .chart-wrapper h3 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 500;
            opacity: 0.95;
        }

        /* ---------- FOOTER ---------- */
        .footer {
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            text-align: center;
            padding: 15px 20px;
            font-size: 14px;
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

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
            }

            .nav-center {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-right {
                justify-content: center;
            }

            .main h1 {
                font-size: 24px;
            }

            .nav-center {
                flex-direction: column;
                gap: 8px;
            }

            .dropdown-content {
                position: relative;
                top: 0;
                box-shadow: none;
            }

            .breadcrumb {
                font-size: 13px;
            }
        }

        .alert-box {
            width: 350px;
            margin: 20px auto;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeIn 0.4s ease;
        }

        .alert-success {
            background: #e6f9ec;
            color: #1e7e34;
            border-left: 4px solid #28a745;
        }

        .alert-error {
            background: #fdecea;
            color: #c82333;
            border-left: 4px solid #dc3545;
        }

        .alert-close {
            cursor: pointer;
            font-weight: bold;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <?php
    $user_id = $_SESSION['id'];
    $user = mysqli_query($con, "SELECT * FROM user WHERE user_id = $user_id");
    $data = mysqli_fetch_assoc($user);
    ?>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-left">
            <a href="home.php">
                <img src="../image/BookMyLibrary.png" alt="Library Logo">
            </a>
        </div>

        <div class="nav-center">
            <a href="home.php">Dashboard</a>

            <!-- Books Dropdown -->
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropbtn">Book <i class="fa-solid fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="book_list.php">Book List</a>
                    <a href="issued_book.php">Issued Book</a>
                </div>
            </div>

            <a href="user_list.php">User</a>

            <!-- Library Dropdown -->
            <a href="library_list.php">Library</a>

            <div class="dropdown">
                <a href="javascript:void(0);" class="dropbtn">Fine <i class="fa-solid fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="fine_list.php">Fine List</a>
                    <a href="pending_fine_list.php">Fine Pending</a>
                </div>
            </div>

            <a href="category_list.php">Category</a>

            <a href="review&rating_list.php">Review & Rating</a>

            <a href="librarian_requests.php">Request</a>
        </div>

        <div class="nav-right">
            <div class="profile">
                <img src="../image/<?php echo $data['image']; ?>" alt="Profile">
                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropbtn"><?php echo $data['first_name'] . " " . $data['last_name']; ?></a>
                    <div class="dropdown-content">
                        <a href="profile.php">My Profile</a>
                        <a href="../change_password.php">Change Password</a>
                        <!-- <a href="#">Screen Lock</a> -->
                        <hr>
                        <a href="../logout.php">Logout</a>

                    </div>
                </div>
            </div>
            <a href="../login.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <?php
    if (isset($_COOKIE['success'])) {
    ?>
        <div class="alert-box alert-success">
            <span><?php echo $_COOKIE['success']; ?></span>
            <span class="alert-close" onclick="this.parentElement.style.display='none'">&times;</span>
        </div>
    <?php
    }

    if (isset($_COOKIE['error'])) {
    ?>
        <div class="alert-box alert-error">
            <span><?php echo $_COOKIE['error']; ?></span>
            <span class="alert-close" onclick="this.parentElement.style.display='none'">&times;</span>
        </div>
    <?php
    }
    ?>

    <!-- <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <span class="current">Dashboard</span>
        </nav>
    </div> -->

    <!-- MAIN CONTENT -->
    <main class="main">
        <!-- <h1>Admin Dashboard</h1> -->

        <!-- CARDS -->
        <?php
        $books = mysqli_query($con, "SELECT * FROM book_list");
        $book_count = mysqli_num_rows($books);

        $users = mysqli_query($con, "SELECT * FROM user");
        $user_count = mysqli_num_rows($users);

        $library = mysqli_query($con, "SELECT * FROM library");
        $library_count = mysqli_num_rows($library);

        $category = mysqli_query($con, "SELECT * FROM category");
        $category_count = mysqli_num_rows($category);

        $issue = mysqli_query($con, "SELECT * FROM issue WHERE status = 'Issued' OR status = 'Overdue' OR status = 'Yet to Return' OR status = 'Return at library'");
        $issue_count = mysqli_num_rows($issue);

        $total_fine = mysqli_query($con, "SELECT SUM(amount) AS total FROM payment_history where payment_status = 'Paid'");
        $fine_data = mysqli_fetch_assoc($total_fine);

        $total_pending_fine = mysqli_query($con, "SELECT SUM(amount) AS total FROM payment_history where payment_status = 'Unpaid'");
        $pending_fine_data = mysqli_fetch_assoc($total_pending_fine);
        ?>
        <div class="dashboard">
            <div class="card books" onclick="card_book()">
                <div class="card-content">
                    <h2>Total Registered Books</h2>
                    <div class="value" id="totalBooks"><?php echo $book_count; ?></div>
                    <div class="sub">All books in system</div>
                </div>
            </div>

            <div class="card users" onclick="card_users()">
                <div class="card-content">
                    <h2>Total Registered Users</h2>
                    <div class="value" id="totalUsers"><?php echo $user_count; ?></div>
                    <div class="sub">Active members</div>
                </div>
            </div>

            <div class="card libraries" onclick="card_libraries()">
                <div class="card-content">
                    <h2>Total Registered Libraries</h2>
                    <div class="value" id="totalLibraries"><?php echo $library_count; ?></div>
                    <div class="sub">Libraries in network</div>
                </div>
            </div>

            <div class="card category" onclick="card_category()">
                <div class="card-content">
                    <h2>Total Categories</h2>
                    <div class="value" id="totalCategories"><?php echo $category_count; ?></div>
                    <div class="sub">Book categories in system</div>
                </div>
            </div>

            <div class="card issued" onclick="card_issued()">
                <div class="card-content">
                    <h2>Total Issued Books</h2>
                    <div class="value" id="totalIssued"><?php echo $issue_count; ?></div>
                    <div class="sub">Currently borrowed</div>
                </div>
            </div>

            <div class="card pending" onclick="card_pending()">
                <div class="card-content">
                    <h2>Total Fine Pending (₹)</h2>
                    <div class="value" id="finePending"><?php echo isset($pending_fine_data['total']) ? $pending_fine_data['total'] : 0 ?></div>
                    <div class="sub">Yet to be collected</div>
                </div>
            </div>

            <div class="card totalfine" onclick="card_totalfine()">
                <div class="card-content">
                    <h2>Total Fine Collected (₹)</h2>
                    <div class="value" id="fineCollected"><?php echo $fine_data['total']; ?></div>
                    <div class="sub">Overall revenue</div>
                </div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="charts">
            <div class="chart-card">
                <h3>Books Status</h3>
                <canvas id="booksChart"></canvas>
            </div>

            <div class="chart-wrapper">
                <h3>Fine Tracking</h3>
                <canvas id="fineChart"></canvas>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>

    <!-- ---------- LIVE DATA & CHART SCRIPT ---------- -->
    <script>
        // Select all dropdown buttons
        const dropdowns = document.querySelectorAll('.dropbtn');

        dropdowns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent page jump
                const content = this.nextElementSibling;

                // Toggle current dropdown
                content.classList.toggle('show');

                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other !== this) {
                        other.nextElementSibling.classList.remove('show');
                    }
                });
            });
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            if (!e.target.matches('.dropbtn')) {
                document.querySelectorAll('.dropdown-content').forEach(dc => dc.classList.remove('show'));
            }
        });

        // 🔒 FIXED VALUES
        const books = parseInt(document.getElementById("totalBooks").textContent) || 0;
        const collected = parseInt(document.getElementById("fineCollected").textContent) || 0;
        const issued = parseInt(document.getElementById("totalIssued").textContent) || 0;
        const pending = parseInt(document.getElementById("finePending").textContent) || 0;

        // Charts
        const booksCtx = document.getElementById('booksChart').getContext('2d');
        const fineCtx = document.getElementById('fineChart').getContext('2d');

        // Doughnut Chart for Books
        const booksChart = new Chart(booksCtx, {
            type: 'doughnut',
            data: {
                labels: ['Issued', 'Available'],
                datasets: [{
                    data: [issued, books - issued],
                    backgroundColor: ['#22c55e', '#3b82f6'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => value
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Bar Chart for Fine
        const fineChart = new Chart(fineCtx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Collected'],
                datasets: [{
                    label: 'Fine Amount (₹)',
                    data: [pending, collected],
                    backgroundColor: ['#f97316', '#ef4444'],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff'
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        anchor: 'end',
                        align: 'end',
                        formatter: (value) => value
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#fff'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#fff'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        function card_book() {
            window.location.href = "book_list.php";
        }

        function card_users() {
            window.location.href = "user_list.php";
        }

        function card_libraries() {
            window.location.href = "library_list.php";
        }

        function card_category() {
            window.location.href = "category_list.php";
        }

        function card_issued() {
            window.location.href = "issued_book.php";
        }

        function card_pending() {
            window.location.href = "pending_fine_list.php";
        }

        function card_totalfine() {
            window.location.href = "fine_list.php";
        }

        setTimeout(() => {
            document.querySelectorAll(".alert-box").forEach(alert => {
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 400);
            });
        }, 5000);
    </script>



</body>

</html>
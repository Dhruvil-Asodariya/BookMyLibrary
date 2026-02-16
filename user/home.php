<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Library Books</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "JetBrains Mono", "Fira Code", Consolas, monospace;
        }

        body {
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
            color: #fff;
        }

        /* container */
        .container {
            width: 95%;
            max-width: 1400px;
            margin: auto;
            padding: 30px 20px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 26px;
        }

        /* top bar */
        .top-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .top-bar input,
        .top-bar select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        /* reset button */
        .reset-btn {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            background: #ef4444;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .reset-btn:hover {
            background: #dc2626;
        }

        /* grid */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        /* card */
        .book-card {
            position: relative;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            transition: .4s;
        }

        .book-card:hover {
            transform: translateY(-10px) scale(1.02);
        }

        /* image */
        .book-img {
            height: 230px;
            background-size: cover;
            background-position: center;
        }

        /* content */
        .book-content {
            padding: 16px;
        }

        .book-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .book-info {
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 4px;
        }

        /* status badge */
        .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .available {
            background: #22c55e;
            color: #022c22;
        }

        .unavailable {
            background: #ef4444;
            color: #2c0202;
        }

        /* button */
        .book-btn {
            width: 100%;
            margin-top: 12px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .book-btn:hover {
            transform: scale(1.05);
        }

        /* responsive */
        @media(max-width:1200px) {
            .book-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media(max-width:900px) {
            .book-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .book-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        /* MODAL BACKGROUND */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        /* MODAL BOX */
        .modal-box {
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
            padding: 25px;
            width: 95%;
            max-width: 450px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            position: relative;
        }

        /* CLOSE BUTTON */
        .close-modal {
            position: absolute;
            right: 15px;
            top: 12px;
            font-size: 24px;
            cursor: pointer;
        }

        /* BOOK INFO */
        .modal-book {
            display: flex;
            gap: 15px;
            margin-bottom: 18px;
        }

        .modal-book img {
            width: 80px;
            border-radius: 10px;
        }

        /* FORM */
        .book-form label {
            display: block;
            margin-top: 12px;
            font-size: 14px;
        }

        .book-form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* CONFIRM BUTTON */
        .confirm-btn {
            width: 100%;
            margin-top: 18px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #22c55e, #15803d);
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .confirm-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="top-bar">
            <input type="text" id="searchBook" placeholder="Search books...">

            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="Programming">Programming</option>
                <option value="Science">Science</option>
                <option value="History">History</option>
            </select>

            <button class="reset-btn" onclick="resetFilters()">Reset</button>
        </div>

        <div class="book-grid" id="bookGrid">

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

            <div class="book-card">
                <div class="status-badge">Available</div>
                <div class="book-img" style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')"></div>
                <div class="book-content">
                    <div class="book-title">Java Programming</div>
                    <div class="book-info">Author: James Gosling</div>
                    <div class="book-info">Category: Programming</div>
                    <div class="book-info">Copies: 5</div>
                    <button class="book-btn">Book Now</button>
                </div>
            </div>

        </div>

    </div>


    <!-- BOOK NOW MODAL -->
    <div class="modal" id="bookModal">
        <div class="modal-box">

            <span class="close-modal" onclick="closeModal()">×</span>

            <h2>Book Reservation</h2>

            <div class="modal-book">
                <img src="../image/91xUz2EuYdL._AC_UF1000,1000_QL80_.jpg" id="modalBookImg">
                <div>
                    <h3 id="modalBookTitle">Java Programming</h3>
                    <p>Author: James Gosling</p>
                    <p>Category: Programming</p>
                </div>
            </div>

            <form class="book-form">

                <label>Your Name</label>
                <input type="text" placeholder="Enter your name" required>

                <label>Email</label>
                <input type="email" placeholder="Enter your email" required>

                <label>Issue Date</label>
                <input type="date" required>

                <label>Return Date</label>
                <input type="date" required>

                <button type="submit" class="confirm-btn">Confirm Booking</button>

            </form>

        </div>
    </div>

</body>

<script>
    function openModal() {
        document.getElementById("bookModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("bookModal").style.display = "none";
    }

    /* attach to all Book Now buttons */
    document.querySelectorAll(".book-btn").forEach(btn => {
        btn.addEventListener("click", openModal);
    });
</script>


</html>
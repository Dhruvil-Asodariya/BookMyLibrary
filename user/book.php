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
            margin-top: 20px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        /* top bar */
        .top-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .top-bar input,
        .top-bar select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            border-radius: 8px;
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
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            justify-items: center;
            /* center cards horizontally */
        }

        /* card */
        .book-card {
            width: 100%;
            /* NOT 220px */
            max-width: 220px;
            /* keeps design size */
            height: 300px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            transition: 0.4s ease;
            cursor: pointer;
        }

        /* Netflix expand */
        .book-card:hover {
            transform: scale(1.08);
            z-index: 10;
        }

        /* Image */
        .book-img {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        /* Glass blur */
        .glass {
            position: absolute;
            inset: 0;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.25);
            opacity: 0;
            transition: 0.4s;
        }

        .book-card:hover .glass {
            opacity: 1;
        }

        .book-card.programming .glass {
            background: linear-gradient(to top, rgba(99, 102, 241, 0.95), rgba(59, 130, 246, 0.6), transparent);
        }

        .book-card.history .glass {
            background: linear-gradient(to top, rgba(180, 83, 9, 0.95), rgba(234, 88, 12, 0.6), transparent);
        }

        .book-card.science .glass {
            background: linear-gradient(to top, rgba(16, 185, 129, 0.95), rgba(6, 182, 212, 0.6), transparent);
        }


        /* Hidden text */
        .book-content {
            position: absolute;
            bottom: 0;
            padding: 14px;
            color: white;
            opacity: 0;
            transform: translateY(20px);
            transition: 0.4s;
        }

        /* Show text on hover */
        .book-card:hover .book-content {
            opacity: 1;
            transform: translateY(0);
        }

        /* Title */
        .book-title {
            font-size: 16px;
            font-weight: 600;
        }

        /* Animated stars */
        .stars {
            color: #ffd700;
            font-size: 16px;
            letter-spacing: 1px;
        }

        .rating-text {
            font-size: 13px;
            color: #fff;
        }

        .book-card:hover .stars {
            transform: scale(0.9);
            letter-spacing: 2px;
        }

        /* Info */
        .book-info {
            font-size: 12px;
            margin-top: 4px;
        }

        /* Status */
        .status-badge {
            padding: 3px 8px;
            font-size: 11px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .available {
            color: #dcfce7;
            background: #166534;
        }

        .unavailable {
            color: #fee2e2;
            background: #991b1b;
        }

        /* Button */
        .book-btn {
            margin-top: 10px;
            width: 100%;
            padding: 8px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 12px;
            font-weight: 600;
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
            <input type="text" id="searchBook" placeholder="Search by title, author, year">

            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="Programming">Programming</option>
                <option value="Science">Science</option>
                <option value="History">History</option>
            </select>

            <select id="statusFilter">
                <option value="">Status</option>
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>

            <select id="libraryFilter">
                <option value="">Library</option>
                <option value="Main Library">Main Library</option>
                <option value="Central Library">Central Library</option>
            </select>

            <select id="languageFilter">
                <option value="">Language</option>
                <option value="English">English</option>
                <option value="Hindi">Hindi</option>
            </select>

            <select id="ratingFilter">
                <option value="">Rating</option>
                <option value="5">5 Star</option>
                <option value="4">4 Star & Above</option>
                <option value="3">3 Star & Above</option>
                <option value="2">2 Star & Above</option>
            </select>


            <button class="reset-btn" onclick="resetFilters()">Reset</button>
        </div>


        <div class="book-grid" id="bookGrid">
            <div class="book-card programming"
                data-title="Java Programming"
                data-author="James Gosling"
                data-year="2020"
                data-category="Programming"
                data-status="Available"
                data-library="Main Library"
                data-language="English"
                data-rating="4.5">

                <div class="book-img"
                    style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')">

                    <!-- Glass blur overlay -->
                    <div class="glass"></div>

                    <!-- Hidden content -->
                    <div class="book-content">
                        <div class="status-badge available">Available</div>

                        <div class="book-title">Java Programming</div>

                        <div class="book-info">Author: James Gosling</div>
                        <div class="book-info">Year: 2020</div>
                        <div class="book-info">Category: Programming</div>
                        <div class="book-info">Library: Main Library</div>
                        <div class="book-info">Language: English</div>
                        <div class="book-info">Available Copy: 3</div>

                        <div class="book-rating">
                            <span class="stars"></span>
                            <span class="rating-text">(4.5)</span>
                        </div>

                        <button class="book-btn">Book Now</button>
                    </div>
                </div>
            </div>

            <div class="book-card science"
                data-title="Database Management System"
                data-author="Abraham Silberschatz"
                data-year="2019"
                data-category="Science"
                data-status="Available"
                data-library="Central Library"
                data-language="English"
                data-rating="4.2">

                <div class="book-img"
                    style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')">

                    <!-- Glass blur overlay -->
                    <div class="glass"></div>

                    <!-- Hidden content -->
                    <div class="book-content">
                        <div class="status-badge available">Available</div>

                        <div class="book-title">Database Management System</div>

                        <div class="book-info">Author: Abraham Silberschatz</div>
                        <div class="book-info">Year: 2019</div>
                        <div class="book-info">Category: Science</div>
                        <div class="book-info">Library: Central Library</div>
                        <div class="book-info">Language: English</div>
                        <div class="book-info">Available Copy: 5</div>

                        <div class="book-rating">
                            <span class="stars"></span>
                            <span class="rating-text">(4.2)</span>
                        </div>

                        <button class="book-btn">Book Now</button>
                    </div>
                </div>
            </div>

            <div class="book-card programming"
                data-title="Python Programming"
                data-author="Guido van Rossum"
                data-year="2021"
                data-category="Programming"
                data-status="Available"
                data-library="Main Library"
                data-language="English"
                data-rating="4.7">

                <div class="book-img"
                    style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')">

                    <!-- Glass blur overlay -->
                    <div class="glass"></div>

                    <!-- Hidden content -->
                    <div class="book-content">
                        <div class="status-badge available">Available</div>

                        <div class="book-title">Python Programming</div>

                        <div class="book-info">Author: Guido van Rossum</div>
                        <div class="book-info">Year: 2021</div>
                        <div class="book-info">Category: Programming</div>
                        <div class="book-info">Library: Main Library</div>
                        <div class="book-info">Language: English</div>
                        <div class="book-info">Available Copy: 2</div>

                        <div class="book-rating">
                            <span class="stars"></span>
                            <span class="rating-text">(4.7)</span>
                        </div>

                        <button class="book-btn">Book Now</button>
                    </div>
                </div>
            </div>

            <div class="book-card history"
                data-title="World History"
                data-author="Howard Zinn"
                data-year="2018"
                data-category="History"
                data-status="Unavailable"
                data-library="Central Library"
                data-language="Hindi"
                data-rating="3.9">

                <div class="book-img"
                    style="background-image:url('../image/91xUz2EuYdL._AC_UF1000\,1000_QL80_.jpg')">

                    <!-- Glass blur overlay -->
                    <div class="glass"></div>

                    <!-- Hidden content -->
                    <div class="book-content">
                        <div class="status-badge unavailable">Unavailable</div>

                        <div class="book-title">World History</div>


                        <div class="book-info">Author: Howard Zinn</div>
                        <div class="book-info">Year: 2018</div>
                        <div class="book-info">Category: History</div>
                        <div class="book-info">Library: Central Library</div>
                        <div class="book-info">Language: Hindi</div>
                        <div class="book-info">Available Copy: 4</div>

                        <div class="book-rating">
                            <span class="stars"></span>
                            <span class="rating-text">(3.9)</span>
                        </div>

                        <button class="book-btn">Book Now</button>
                    </div>
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

    <?php include 'footer.php'; ?>

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

    function printStars(rating) {
        let full = Math.floor(rating);
        let half = rating % 1 >= 0.5 ? 1 : 0;
        let empty = 5 - full - half;

        return "★".repeat(full) + (half ? "⯪" : "") + "☆".repeat(empty);
    }

    /* get rating from text */
    let ratingValue = 3.9;

    document.querySelector(".stars").textContent = printStars(ratingValue);
    document.querySelector(".rating-text").textContent = "(" + ratingValue + ")";

    document.querySelectorAll(".book-card").forEach(card => {

        let rating = parseFloat(card.dataset.rating);

        let starsEl = card.querySelector(".stars");
        let textEl = card.querySelector(".rating-text");

        starsEl.textContent = printStars(rating);
        textEl.textContent = "(" + rating + ")";
    });
</script>

<script>
    const searchInput = document.getElementById("searchBook");
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const libraryFilter = document.getElementById("libraryFilter");
    const languageFilter = document.getElementById("languageFilter");
    const ratingFilter = document.getElementById("ratingFilter");

    const books = document.querySelectorAll(".book-card");

    function filterBooks() {

        let searchValue = searchInput.value.toLowerCase();
        let categoryValue = categoryFilter.value.toLowerCase();
        let statusValue = statusFilter.value.toLowerCase();
        let libraryValue = libraryFilter.value.toLowerCase();
        let languageValue = languageFilter.value.toLowerCase();
        let ratingValue = ratingFilter.value;

        books.forEach(book => {

            let title = book.dataset.title.toLowerCase();
            let author = book.dataset.author.toLowerCase();
            let year = book.dataset.year.toLowerCase();
            let category = book.dataset.category.toLowerCase();
            let status = book.dataset.status.toLowerCase();
            let library = book.dataset.library.toLowerCase();
            let language = book.dataset.language.toLowerCase();
            let rating = parseFloat(book.dataset.rating);

            let matchesSearch =
                title.includes(searchValue) ||
                author.includes(searchValue) ||
                year.includes(searchValue);

            let matchesCategory = !categoryValue || category === categoryValue;
            let matchesStatus = !statusValue || status === statusValue;
            let matchesLibrary = !libraryValue || library === libraryValue;
            let matchesLanguage = !languageValue || language === languageValue;

            /* Rating filter */
            let matchesRating = !ratingValue || rating >= parseFloat(ratingValue);

            if (matchesSearch && matchesCategory && matchesStatus &&
                matchesLibrary && matchesLanguage && matchesRating) {
                book.style.display = "block";
            } else {
                book.style.display = "none";
            }
        });
    }


    /* Event listeners */
    searchInput.addEventListener("keyup", filterBooks);
    categoryFilter.addEventListener("change", filterBooks);
    statusFilter.addEventListener("change", filterBooks);
    libraryFilter.addEventListener("change", filterBooks);
    languageFilter.addEventListener("change", filterBooks);
    ratingFilter.addEventListener("change", filterBooks);


    /* Reset */
    function resetFilters() {
        searchInput.value = "";
        categoryFilter.value = "";
        statusFilter.value = "";
        libraryFilter.value = "";
        languageFilter.value = "";
        ratingFilter.value = "";
        filterBooks();
    }
</script>


</html>
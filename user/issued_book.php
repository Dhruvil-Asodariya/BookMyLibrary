<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Issued Book List | Library System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="icon" href="../image/title_image.png" type="image/png">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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

        .container {
            width: 100%;
            /* Full width */
            max-width: 100%;
            /* Remove restriction */
            padding: 40px;
        }

        .card {
            background: #ffffff;
            padding: 35px;
            /* Increased padding */
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .title-area h3 {
            margin: 0;
            font-size: 24px;
            /* Larger heading */
            font-weight: 700;
            color: #1f2937;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .btn {
            padding: 10px 18px;
            /* Bigger buttons */
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .btn-add {
            background: #16a34a;
            color: #fff;
        }

        .btn-add:hover {
            background: #15803d;
        }

        .btn-renew {
            background: #facc15;
            color: #1f2937;
            display: inline-block;
        }

        .btn-renew:hover {
            background: #eab308;
        }

        .btn-pay {
            background: #16a34a;
            color: #fff;
            display: inline-block;
        }

        .btn-pay:hover {
            background: #15803d;
        }

        td {
            white-space: nowrap;
            /* ⬅ Prevent line break */
        }

        .model-link {
            color: #2660de;
            cursor: pointer;
            text-decoration: underline;
        }

        table.dataTable {
            width: 100% !important;
            font-size: 14px;
            /* Bigger text */
        }

        table.dataTable thead th {
            background: #f9fafb;
            color: #374151;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 12px;
            /* More header height */
        }

        table.dataTable tbody td {
            padding: 14px 12px;
            /* Increase row height */
            vertical-align: middle;
        }

        table.dataTable tbody tr {
            transition: background 0.2s;
        }

        table.dataTable tbody tr:hover {
            background: #f3f4f6;
        }

        .status {
            padding: 6px 16px;
            /* Bigger badge */
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .issued {
            background: #dcfce7;
            color: #166534;
        }

        .unissued {
            background: #fee2e2;
            color: #991b1b;
        }

        img.cover {
            width: 55px;
            /* Bigger image */
            height: 75px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        /* DataTable Buttons */
        .dt-buttons .dt-button {
            background: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            color: #374151 !important;
            border-radius: 8px !important;
            padding: 8px 14px !important;
            font-size: 13px !important;
            margin-right: 6px;
        }

        .dt-buttons .dt-button:hover {
            background: #e5e7eb !important;
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

        /* Overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        /* Modal Box */
        .modal-box {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 14px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.25s ease;
        }

        /* Header */
        .modal-header h3 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 10px;
        }

        /* Body */
        .modal-body p {
            font-size: 15px;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 6px;
        }

        .modal-body span {
            font-size: 13px;
            color: #6b7280;
        }

        /* Buttons */
        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .modal-actions .btn {
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .cancel-btn {
            background: #f1f5f9;
            color: #334155;
        }

        .cancel-btn:hover {
            background: #e2e8f0;
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #fff;
        }

        .delete-btn:hover {
            opacity: 0.9;
        }

        .status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status.available {
            background: #dcfce7;
            color: #166534;
        }

        .status.unavailable {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-toggle {
            background: #16a34a;
            color: #fff;

            display: inline-block;
            padding: 10px 18px;
            margin-top: 10px;
            /* Bigger buttons */
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .btn-toggle:hover {
            background: #15803d;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }


        @media (max-width: 768px) {
            .top-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            img.cover {
                width: 45px;
                height: 60px;
            }

            .breadcrumb {
                font-size: 13px;
            }
        }

        .book-id {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .book-id:hover {
            text-decoration: underline;
        }

        /* Backdrop */
        .modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        /* Card */
        .modal-card {
            background: #ffffff;
            width: 700px;
            max-width: 95%;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeSlide 0.25s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .modal-header-p {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header-p h3 {
            font-size: 18px;
            color: #0f172a;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Pills container */
        .pill-group {
            display: flex;
            gap: 8px;
        }

        /* Base pill */
        .pill {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
        }

        /* Role pill (Blue) */
        .pill-role-librarian {
            background-color: #fef3c7;
            color: #92400e;
        }

        .pill-role-user {
            background-color: #e0f2fe;
            color: #075985;
        }

        .pill-role-admin {
            background-color: #ede9fe;
            color: #5b21b6;
        }

        /* Status pills */
        .pill-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .pill-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Close */
        .close-icon {
            font-size: 22px;
            cursor: pointer;
            color: #64748b;
        }

        .close-icon:hover {
            color: #ef4444;
        }

        /* Body */
        .modal-body-p {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 20px;
            padding: 20px;
        }

        /* Image */
        .book-image img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        /* Details */
        .book-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .detail span {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }

        .detail p {
            margin-top: 4px;
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Footer */
        .modal-footer {
            padding: 14px 20px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }

        /* Buttons */
        .btn-secondary {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #cbd5f5;
            background: #f8fafc;
            color: #1e293b;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #e0e7ff;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .modal-body {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .book-details {
                grid-template-columns: 1fr;
            }
        }

        /* Backdrop */
        .l-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.65);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        /* Card */
        .l-modal-card {
            background: #ffffff;
            width: 700px;
            max-width: 95%;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeSlide 0.25s ease;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .l-modal-header-p {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .l-modal-header-p h3 {
            font-size: 18px;
            color: #0f172a;
        }

        .l-header-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Pills container */
        .l-pill-group {
            display: flex;
            gap: 8px;
        }

        /* Base pill */
        .l-pill {
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
        }

        /* Status pills */
        .l-pill-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .l-pill-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Close */
        .l-close-icon {
            font-size: 22px;
            cursor: pointer;
            color: #64748b;
        }

        .l-close-icon:hover {
            color: #ef4444;
        }

        /* Body */
        .l-modal-body-p {
            display: grid;
            grid-template-columns: 580px 1fr;
            gap: 20px;
            padding: 20px;
        }

        /* Image */
        .l-book-image img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        /* Details */
        .l-book-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .l-detail span {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }

        .l-detail p {
            margin-top: 4px;
            font-size: 15px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Footer */
        .l-modal-footer {
            padding: 14px 20px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }

        /* Buttons */
        .l-btn-secondary {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #cbd5f5;
            background: #f8fafc;
            color: #1e293b;
            cursor: pointer;
        }

        .l-btn-secondary:hover {
            background: #e0e7ff;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .l-modal-body {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .l-book-details {
                grid-template-columns: 1fr;
            }
        }

        .advanced-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .advanced-filters input,
        .advanced-filters select {
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            min-width: 180px;
        }

        .filter-box {
            display: flex;
            flex-direction: column;
        }

        .filter-box label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .btn-area {
            justify-content: flex-end;
        }

        .upi-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            animation: fadeIn .25s ease;
        }

        .upi-card {
            width: 360px;
            background: linear-gradient(145deg, #ffffff, #f4f4f4);
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .3);
            animation: slideUp .3s ease;
        }

        .upi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .upi-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .upi-close {
            font-size: 22px;
            cursor: pointer;
        }

        .upi-body {
            text-align: center;
        }

        .upi-qr-box {
            background: #fff;
            padding: 12px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .15);
        }

        .upi-qr-box img {
            width: 220px;
        }

        .upi-amount {
            font-size: 26px;
            font-weight: 700;
            margin: 15px 0 5px;
        }

        .upi-text {
            color: #666;
            font-size: 13px;
        }

        .upi-apps {
            margin-top: 10px;
        }

        .upi-apps span {
            background: #eee;
            padding: 6px 10px;
            margin: 0 4px;
            border-radius: 6px;
            font-size: 12px;
        }

        .upi-footer {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .upi-cancel,
        .upi-paid {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .upi-cancel {
            background: #e5e5e5;
        }

        .upi-paid {
            background: #16a34a;
            color: #fff;
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px);
                opacity: 0
            }

            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        .renew-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .renew-card {
            width: 360px;
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .3);
        }

        .renew-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .renew-body label {
            font-size: 13px;
            margin-top: 10px;
            display: block;
        }

        .renew-body input {
            width: 100%;
            padding: 9px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .renew-footer {
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }

        .renew-confirm {
            flex: 1;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }

        .renew-cancel {
            flex: 1;
            background: #e5e5e5;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }

        .renew-error {
            color: red;
            font-size: 12px;
        }

        .return-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .return-card {
            width: 360px;
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .3);
        }

        .return-body label {
            display: block;
            margin-top: 10px;
            font-size: 13px;
        }

        .return-body input {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-top: 5px;
        }

        .return-footer {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .return-confirm {
            flex: 1;
            background: #16a34a;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }

        .return-cancel {
            flex: 1;
            background: #e5e5e5;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }

        .return-error {
            color: red;
            font-size: 12px;
        }

        .rating-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .rating-card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            text-align: center;
            width: 320px;
        }

        .rating-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .skip-btn {
            flex: 1;
            background: #e5e5e5;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .submit-btn {
            flex: 1;
            background: #16a34a;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .stars-select span {
            font-size: 26px;
            cursor: pointer;
            color: #ccc;
        }

        .stars-select span.active {
            color: gold;
        }

        .rating-card textarea {
            width: 100%;
            height: 70px;
            margin-top: 10px;
        }
    </style>

</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="breadcrumb-wrapper">
        <nav class="breadcrumb">
            <a href="home.php" class="dashboard">Dashboard</a>
            <span class="separator">›</span>
            <span class="current">Issued Book List</span>
        </nav>
    </div>
    <div class="container">
        <div class="card">
            <div class="top-actions">
                <div class="title-area">
                    <h3>Issued Book Details</h3>
                    <div class="subtitle">See your issued book data</div>
                </div>
                <div class="advanced-filters">

                    <div class="filter-box">
                        <label>Issue Date</label>
                        <input type="date" id="filterIssueDate">
                    </div>

                    <div class="filter-box">
                        <label>Return Date</label>
                        <input type="date" id="filterReturnDate">
                    </div>

                    <div class="filter-box btn-area">
                        <label>&nbsp;</label>
                        <button class="btn btn-add" onclick="resetFilters()">Reset</button>
                    </div>

                </div>
                <div></div>


            </div>

            <table id="bookTable" class="display">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Issue ID</th>
                        <th>Book ID</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Fine Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>24842354</td>
                        <td><span class="model-link" onclick="openBookModal()">24842354</span></td>
                        <td>12-01-2026</td>
                        <td>08-02-2026</td>
                        <td>0</td>
                        <td><span class="status issued">Issued</span></td>
                        <td>
                            <!-- <a><button class="btn btn-edit">Renew</button></a> -->
                            <!-- <button class="btn btn-pay">Pay</button><br> -->
                            <button class="btn btn-return"
                                data-book="24842354"
                                data-issue="2026-01-12"
                                data-return="2026-02-08">
                                Return
                            </button>
                            <button class="btn btn-renew"
                                data-book="24842354"
                                data-return="2026-02-08">
                                Renew
                            </button>


                        </td>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>24842354</td>
                        <td><span class="model-link" onclick="openBookModal()">24842354</span></td>
                        <td>12-01-2026</td>
                        <td>08-02-2026</td>
                        <td>100</td>
                        <td><span class="status unissued">Unissued</span></td>
                        <td>
                            <button class="btn btn-return"
                                data-book="24842354"
                                data-issue="2026-01-12"
                                data-return="2026-02-08">
                                Return
                            </button>
                            <!-- <button class="btn btn-pay"
                                data-amount="1"
                                data-book="24842354">
                                Pay
                            </button> -->

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-backdrop" id="bookModal">
        <div class="modal-card">

            <div class="modal-header-p">
                <h3>Book Details</h3>
                <span class="close-icon" onclick="closeBookModal()">×</span>
            </div>

            <div class="modal-body-p">
                <div class="book-image">
                    <img src="../image/91xUz2EuYdL._AC_UF1000,1000_QL80_.jpg" alt="Book Image">
                </div>

                <div class="book-details">
                    <div class="detail">
                        <span>Book ID</span>
                        <p>24842354</p>
                    </div>
                    <div class="detail">
                        <span>Title</span>
                        <p>Introduction to Java</p>
                    </div>
                    <div class="detail">
                        <span>Author</span>
                        <p>James Gosling</p>
                    </div>
                    <div class="detail">
                        <span>Category</span>
                        <p>Programming</p>
                    </div>
                    <div class="detail">
                        <span>Publish Year</span>
                        <p>2020</p>
                    </div>
                    <div class="detail">
                        <span>Library Name</span>
                        <p>Main Library</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeBookModal()">Close</button>
            </div>

        </div>
    </div>

    <div class="l-modal-backdrop" id="libraryModal">
        <div class="l-modal-card">

            <div class="l-modal-header-p">
                <div class="l-header-left">
                    <h3>Library Details</h3>

                    <div class="l-pill-group">
                        <span class="l-pill pill-active">Active</span>
                        <!-- <span class="pill pill-inactive">Inactive</span> -->
                    </div>
                </div>
                <span class="close-icon" onclick="closeLibraryModal()">×</span>
            </div>

            <div class="l-modal-body-p">

                <div class="l-book-details">
                    <div class="l-detail">
                        <span>Library ID</span>
                        <p>24842354</p>
                    </div>
                    <div class="l-detail">
                        <span>Library Name</span>
                        <p>Central City Library</p>
                    </div>
                    <div class="l-detail">
                        <span>Library Owner Name</span>
                        <p>James Gosling</p>
                    </div>
                    <div class="l-detail">
                        <span>Table capacity</span>
                        <p>120</p>
                    </div>
                    <div class="l-detail">
                        <span>Chair Capacity</span>
                        <p>240</p>
                    </div>
                    <div class="l-detail">
                        <span>Open At</span>
                        <p>08:00 AM</p>
                    </div>
                    <div class="l-detail">
                        <span>Close At</span>
                        <p>09:00 PM</p>
                    </div>
                    <div class="l-detail">
                        <span>Library Location</span>
                        <p>Downtown, Rajkot</p>
                    </div>
                </div>
            </div>

            <div class="l-modal-footer">
                <button class="l-btn-secondary" onclick="closeLibraryModal()">Close</button>
            </div>

        </div>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Delete Issued Book Record</h3>
            </div>

            <div class="modal-body">
                <p>⚠️ Are you sure you want to delete this issued book record?</p>
                <span>This action cannot be undone.</span>
            </div>

            <div class="modal-actions">
                <button class="btn cancel-btn" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn delete-btn" onclick="confirmDelete()">Yes, Delete</button>
            </div>
        </div>
    </div>

    <div id="upiModal" class="upi-modal">

        <div class="upi-card">

            <div class="upi-header">
                <h2>Complete Payment</h2>
                <span class="upi-close" onclick="closeUPIModal()">×</span>
            </div>

            <div class="upi-body">

                <div class="upi-qr-box">
                    <img id="upiQR" src="" alt="UPI QR">
                </div>

                <div class="upi-details">
                    <p class="upi-amount">₹ <span id="upiAmount">100</span></p>
                    <p class="upi-text">Scan QR using any UPI app</p>

                    <div class="upi-apps">
                        <span>GPay</span>
                        <span>PhonePe</span>
                        <span>Paytm</span>
                    </div>
                </div>

            </div>

            <div class="upi-footer">
                <button class="upi-cancel" onclick="closeUPIModal()">Cancel</button>
                <button class="upi-paid" onclick="demoSuccess()">I have paid</button>
            </div>

        </div>

    </div>

    <div id="renewModal" class="renew-modal">

        <div class="renew-card">

            <div class="renew-header">
                <h3>Renew Book</h3>
                <span onclick="closeRenew()">×</span>
            </div>

            <div class="renew-body">

                <label>Book ID</label>
                <input type="text" name="renew_book_id" readonly>

                <label>Current Return Date</label>
                <input type="date" name="old_return_date" readonly>

                <label>New Return Date</label>
                <input type="date" name="new_return_date">

                <small class="renew-error"></small>

            </div>

            <div class="renew-footer">
                <button class="renew-cancel" onclick="closeRenew()">Cancel</button>
                <button class="renew-confirm" onclick="confirmRenew()">Confirm Renew</button>
            </div>

        </div>

    </div>

    <div id="returnModal" class="return-modal">

        <div class="return-card">

            <div class="return-header">
                <h3>Return Book</h3>
                <span onclick="closeReturn()">×</span>
            </div>

            <div class="return-body">

                <label>Book ID</label>
                <input type="text" name="return_book_id" readonly>

                <label>Issue Date</label>
                <input type="date" name="issue_date" readonly>

                <label>Expected Return Date</label>
                <input type="date" name="expected_return" readonly>

                <label>Actual Return Date</label>
                <input type="date" name="actual_return">

                <label>Fine (₹)</label>
                <input type="text" name="fine_amount" readonly value="0">

                <small class="return-error"></small>

            </div>

            <div class="return-footer">
                <button class="return-cancel" onclick="closeReturn()">Cancel</button>
                <button class="return-confirm" onclick="confirmReturn()">Confirm Return</button>
            </div>

        </div>

    </div>

    <div id="ratingModal" class="rating-modal">

        <div class="rating-card">

            <h3>Rate this Book</h3>

            <div class="stars-select">
                <span data-rate="1">★</span>
                <span data-rate="2">★</span>
                <span data-rate="3">★</span>
                <span data-rate="4">★</span>
                <span data-rate="5">★</span>
            </div>

            <textarea placeholder="Write feedback (optional)"></textarea>

            <div class="rating-actions">
                <button class="skip-btn" onclick="skipRating()">Skip</button>
                <button class="submit-btn" onclick="submitRating()">Submit Rating</button>
            </div>

        </div>
    </div>



    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Export Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        var table = $('#bookTable').DataTable({
            responsive: true,
            dom: 'Brtip',
            buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6] // column indexes you want
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
            ],
            pageLength: 5,
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true
        });

        function formatDateForTable(date) {
            if (!date) return "";
            const parts = date.split("-");
            return parts[2] + "-" + parts[1] + "-" + parts[0]; // yyyy-mm-dd → dd-mm-yyyy
        }

        // Issue filter
        $('#filterIssueDate').on('change', function() {
            let val = formatDateForTable(this.value);
            table.column(5).search(val).draw();
        });


        // Return filter
        $('#filterReturnDate').on('change', function() {
            let val = formatDateForTable(this.value);
            table.column(7).search(val).draw();
        });


        // RESET filters
        function resetFilters() {
            $('#filterIssueDate').val('');
            $('#filterReturnDate').val('');

            table.columns().search('').draw();
        }

        const deleteModal = document.getElementById("deleteModal");

        function openDeleteModal() {
            deleteModal.style.display = "flex";
        }

        function closeDeleteModal() {
            deleteModal.style.display = "none";
        }

        function confirmDelete() {
            closeDeleteModal();
            alert("Issued book record deleted successfully!");
            // Here you can remove the row or call backend later
        }

        function openBookModal() {
            document.getElementById("bookModal").style.display = "flex";
        }

        function closeBookModal() {
            document.getElementById("bookModal").style.display = "none";
        }

        function openLibraryModal() {
            document.getElementById("libraryModal").style.display = "flex";
        }

        function closeLibraryModal() {
            document.getElementById("libraryModal").style.display = "none";
        }
    </script>

    <script>
        document.querySelectorAll(".btn-pay").forEach(btn => {
            btn.addEventListener("click", function() {

                const amount = this.dataset.amount || 100;
                const bookId = this.dataset.book || "TEST";

                const upiLink =
                    `upi://pay?pa=test@upi&pn=BookMyLibrary&am=${amount}&cu=INR&tn=Book:${bookId}`;

                const qrURL =
                    "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" +
                    encodeURIComponent(upiLink);

                document.getElementById("upiQR").src = qrURL;
                document.getElementById("upiAmount").textContent = amount;

                document.getElementById("upiModal").style.display = "flex";
            });
        });

        function closeUPIModal() {
            document.getElementById("upiModal").style.display = "none";
        }

        function demoSuccess() {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: 'Payment successful!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
            closeUPIModal();
        }
    </script>

    <script>
        const renewModal = document.getElementById("renewModal");
        const newDateInput = renewModal.querySelector('[name="new_return_date"]');
        const oldDateInput = renewModal.querySelector('[name="old_return_date"]');
        const renewBtn = renewModal.querySelector(".renew-confirm");
        const errorBox = renewModal.querySelector(".renew-error");

        // OPEN RENEW
        document.querySelectorAll(".btn-renew").forEach(btn => {
            btn.addEventListener("click", function() {

                renewModal.style.display = "flex";

                oldDateInput.value = formatDate(this.dataset.return);
                newDateInput.value = "";

                renewBtn.disabled = true;
                errorBox.textContent = "";
            });
        });

        // CLOSE
        function closeRenew() {
            renewModal.style.display = "none";
        }

        // FORMAT DATE
        function formatDate(dateStr) {
            const d = new Date(dateStr);
            return d.toISOString().split('T')[0];
        }


        // 🟢 LIVE VALIDATION
        newDateInput.addEventListener("input", function() {

            const today = new Date().setHours(0, 0, 0, 0);
            const oldDate = new Date(oldDateInput.value).setHours(0, 0, 0, 0);
            const newDate = new Date(this.value).setHours(0, 0, 0, 0);

            if (!this.value) {
                errorBox.textContent = "Please select new return date";
                renewBtn.disabled = true;
                return;
            }

            if (newDate < today) {
                errorBox.textContent = "Past date not allowed";
                renewBtn.disabled = true;
                return;
            }

            if (newDate <= oldDate) {
                errorBox.textContent = "New return date must be after current return date";
                renewBtn.disabled = true;
                return;
            }

            // valid
            errorBox.textContent = "";
            renewBtn.disabled = false;
        });


        // CONFIRM
        function confirmRenew() {

            if (renewBtn.disabled) return;

            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: 'Book renewed successfully!',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            closeRenew();
        }
    </script>

    <script>
        const returnModal = document.getElementById("returnModal");

        const actualDateInput = returnModal.querySelector('[name="actual_return"]');
        const expectedInput = returnModal.querySelector('[name="expected_return"]');
        const fineInput = returnModal.querySelector('[name="fine_amount"]');
        const returnBtn = returnModal.querySelector(".return-confirm");
        const returnError = returnModal.querySelector(".return-error");

        const today = new Date().setHours(0, 0, 0, 0);

        // OPEN RETURN
        document.querySelectorAll(".btn-return").forEach(btn => {
            btn.addEventListener("click", function() {

                returnModal.style.display = "flex";

                returnModal.querySelector('[name="return_book_id"]').value =
                    this.dataset.book;

                returnModal.querySelector('[name="issue_date"]').value =
                    this.dataset.issue;

                returnModal.querySelector('[name="expected_return"]').value =
                    this.dataset.return;

                returnModal.querySelector('[name="actual_return"]').value =
                    today;

                actualDateInput.value = "";
                fineInput.value = "0";
                returnBtn.disabled = true;
                returnError.textContent = "";
            });
        });

        // CLOSE
        function closeReturn() {
            returnModal.style.display = "none";
        }


        // 🟢 LIVE VALIDATION + FINE CALCULATION
        actualDateInput.addEventListener("input", function() {

            const actualDate = new Date(this.value);
            const expectedDate = new Date(expectedInput.value);

            if (!this.value) {
                returnError.textContent = "Select return date";
                returnBtn.disabled = true;
                return;
            }

            // fine calculation ₹5 per day
            if (actualDate > expectedDate) {
                const diffDays =
                    Math.ceil((actualDate - expectedDate) / (1000 * 60 * 60 * 24));
                fineInput.value = diffDays * 5;
            } else {
                fineInput.value = 0;
            }

            returnError.textContent = "";
            returnBtn.disabled = false;
        });


        // CONFIRM RETURN
        function confirmReturn() {

            if (returnBtn.disabled) return;

            const fine = parseInt(fineInput.value);

            // 🟥 STEP 1 — IF FINE EXISTS → PAY FIRST
            if (fine > 0) {
                Swal.fire({
                    toast: true,
                    icon: 'warning',
                    position: 'top',
                    title: 'Please pay fine before returning book',
                    timer: 2500,
                    showConfirmButton: false
                });
                return;
            }

            // 🟩 STEP 2 — RETURN SUCCESS
            Swal.fire({
                toast: true,
                icon: 'success',
                position: 'top',
                title: 'Book returned successfully',
                timer: 2000,
                showConfirmButton: false
            });

            closeReturn();

            // 🟦 STEP 3 — OPEN RATING MODAL AFTER RETURN
            setTimeout(() => {
                openRatingModal();
            }, 2000);
        }

        let selectedRating = 0;

        function openRatingModal() {
            document.getElementById("ratingModal").style.display = "flex";
        }

        // select stars
        document.querySelectorAll(".stars-select span").forEach(star => {
            star.addEventListener("click", function() {

                selectedRating = this.dataset.rate;

                document.querySelectorAll(".stars-select span")
                    .forEach(s => s.classList.remove("active"));

                for (let i = 0; i < selectedRating; i++) {
                    document.querySelectorAll(".stars-select span")[i]
                        .classList.add("active");
                }
            });
        });

        function submitRating() {

            if (selectedRating == 0) {
                alert("Please select rating");
                return;
            }

            Swal.fire({
                toast: true,
                icon: 'success',
                position: 'top',
                title: 'Thank you for rating!',
                timer: 2000,
                showConfirmButton: false
            });

            document.getElementById("ratingModal").style.display = "none";
        }

        function skipRating() {

            document.getElementById("ratingModal").style.display = "none";

            Swal.fire({
                toast: true,
                icon: 'info',
                position: 'top',
                title: 'Rating skipped',
                timer: 1800,
                showConfirmButton: false
            });
        }
    </script>

</body>

</html>
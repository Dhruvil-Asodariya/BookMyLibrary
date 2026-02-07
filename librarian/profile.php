<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Profile</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "JetBrains Mono", "Fira Code", Consolas, monospace;
        }

        body {
            background: linear-gradient(120deg, #0f172a, #1e3a8a);
        }

        /* Main Layout */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            gap: 30px;
        }

        /* LEFT PROFILE */
        .profile-left {
            width: 300px;
            text-align: center;
            border-right: 1px solid #ddd;
            padding-right: 20px;
        }

        .profile-img img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Modal background */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }

        /* Popup card */
        .modal-content {
            background: #fff;
            width: 380px;
            margin: 6% auto;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Close button */
        .close {
            float: right;
            font-size: 22px;
            cursor: pointer;
        }

        /* Drag area */
        .drop-area {
            border: 2px dashed #4f46e5;
            padding: 25px;
            border-radius: 10px;
            margin-top: 15px;
            background: #f8fafc;
            transition: 0.3s;
        }

        .drop-area.dragover {
            background: #eef2ff;
            border-color: #4338ca;
        }

        .drop-area p {
            margin: 0;
            font-weight: 600;
        }

        .drop-area span {
            display: block;
            margin: 10px 0;
            color: #777;
        }

        /* Hidden file input */
        #fileInput {
            display: none;
        }

        /* Browse button */
        .browse-btn {
            background: #4f46e5;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            display: inline-block;
        }

        /* Preview */
        .preview-area img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-top: 15px;
            object-fit: cover;
            display: none;
        }

        /* Save button */
        .save-btn {
            margin-top: 15px;
            padding: 10px 18px;
            background: #16a34a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }



        .profile-left h2 {
            margin-top: 15px;
        }

        .profile-left p {
            color: #555;
            margin-bottom: 15px;
        }

        .change-btn {
            background: #2563eb;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        /* RIGHT SIDE */
        .profile-right {
            flex: 1;
        }

        /* Card Sections */
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin-bottom: 15px;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        /* validation */
        .error {
            color: red;
            font-size: 12px;
            margin-top: 4px;
        }

        input.invalid {
            border: 1px solid red;
        }

        input.valid {
            border: 1px solid green;
        }

        /* Edit Button */
        .edit-btn {
            float: right;
            background: #2563eb;
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        input:disabled {
            background: #f1f3f5;
            cursor: not-allowed;
        }

        /* Responsive */
        @media(max-width:900px) {
            .container {
                flex-direction: column;
            }

            .profile-left {
                border-right: none;
                border-bottom: 1px solid #ddd;
                padding-bottom: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="profile-left">
            <div class="profile-img">
                <img src="../image/default_profile.png" id="profileImage">
            </div>

            <h2>James Gosling</h2>
            <p>Library Owner</p>

            <button class="change-btn" onclick="openPopup()">Change Profile</button>
        </div>


        <!-- Popup -->
        <div class="modal" id="profileModal">
            <div class="modal-content">
                <span class="close" onclick="closePopup()">×</span>

                <h3>Upload Profile Photo</h3>

                <!-- Drag & Drop Area -->
                <div class="drop-area" id="dropArea">
                    <p>Drag & Drop Image Here</p>
                    <span>OR</span>
                    <input type="file" id="fileInput" accept="image/*">
                    <label for="fileInput" class="browse-btn">Browse File</label>
                </div>

                <div class="preview-area">
                    <img id="previewImage">
                </div>

                <button class="save-btn" onclick="saveProfile()">Save Photo</button>
            </div>
        </div>


        <!-- RIGHT DETAILS -->
        <div class="profile-right">

            <!-- Personal Details -->
            <div class="card">
                <h3>Personal Details</h3>
                <div class="form-grid">

                    <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" id="name" value="James Gosling" disabled>
                        <span id="nameError" class="error"></span>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" value="library@gmail.com" disabled>
                        <span id="emailError" class="error"></span>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" id="phone" value="+91 9876543210" disabled>
                        <span id="phoneError" class="error"></span>
                    </div>

                </div>
            </div>

            <!-- Library Details -->
            <div class="card">
                <h3>Library Details</h3>
                <div class="form-grid">

                    <div class="form-group">
                        <label>Library Name</label>
                        <input type="text" id="libraryName" value="Central City Library" disabled>
                        <small class="error" id="libraryError"></small>
                    </div>

                    <div class="form-group">
                        <label>Open Time</label>
                        <input type="time" id="openTime" value="08:00" disabled>
                        <small class="error" id="openError"></small>
                    </div>

                    <div class="form-group">
                        <label>Close Time</label>
                        <input type="time" id="closeTime" value="21:00" disabled>
                        <small class="error" id="closeError"></small>
                    </div>

                    <div class="form-group">
                        <label>Library Address</label>
                        <input type="text" id="address" value="Downtown, Rajkot" disabled>
                        <small class="error" id="addressError"></small>
                    </div>

                </div>
            </div>

            <button class="edit-btn" onclick="toggleEdit()" id="editBtn">Edit Profile</button>


        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script>
        let selectedImage = "";

        function openPopup() {
            document.getElementById("profileModal").style.display = "block";
        }

        function closePopup() {
            document.getElementById("profileModal").style.display = "none";
        }

        // file input preview
        document.getElementById("fileInput").addEventListener("change", function() {
            handleFile(this.files[0]);
        });

        // drag & drop
        const dropArea = document.getElementById("dropArea");

        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("dragover");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("dragover");
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("dragover");
            const file = e.dataTransfer.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (!file) return;

            selectedImage = URL.createObjectURL(file);
            const preview = document.getElementById("previewImage");
            preview.src = selectedImage;
            preview.style.display = "block";
        }

        // save profile image
        function saveProfile() {
            if (selectedImage === "") {
                alert("Please select image");
                return;
            }

            document.getElementById("profileImage").src = selectedImage;
            closePopup();
        }
    </script>

    <script>
        // GLOBAL variable
        let editMode = false;

        /* ================= TOGGLE EDIT MODE ================= */

        function toggleEdit() {

            const fields = document.querySelectorAll("input");
            const btn = document.getElementById("editBtn");

            if (!editMode) {
                fields.forEach(field => field.disabled = false);
                btn.innerText = "Save Profile";
                editMode = true;
            } else {

                if (!validateAll()) return;

                fields.forEach(field => field.disabled = true);
                btn.innerText = "Edit Profile";
                editMode = false;
            }
        }

        /* ================= VALIDATION ================= */

        function validateAll() {

            let isValid = true;

            // Name
            let name = document.getElementById("name");
            if (name.value.trim().length < 3) {
                showError(name, "nameError", "Enter valid owner name");
                isValid = false;
            } else showSuccess(name, "nameError");

            // Email
            let email = document.getElementById("email");
            let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.value.match(emailPattern)) {
                showError(email, "emailError", "Enter valid email");
                isValid = false;
            } else showSuccess(email, "emailError");

            // Phone
            let phone = document.getElementById("phone");
            if (phone.value.length < 10) {
                showError(phone, "phoneError", "Enter valid phone number");
                isValid = false;
            } else showSuccess(phone, "phoneError");

            // Library Name
            let library = document.getElementById("libraryName");
            if (library.value.trim() === "") {
                showError(library, "libraryError", "Library name required");
                isValid = false;
            } else showSuccess(library, "libraryError");

            // Open Time
            let open = document.getElementById("openTime");
            if (open.value === "") {
                showError(open, "openError", "Select opening time");
                isValid = false;
            } else showSuccess(open, "openError");

            // Close Time
            let close = document.getElementById("closeTime");
            if (close.value === "") {
                showError(close, "closeError", "Select closing time");
                isValid = false;
            } else showSuccess(close, "closeError");

            // Address
            let address = document.getElementById("address");
            if (address.value.trim() === "") {
                showError(address, "addressError", "Address required");
                isValid = false;
            } else showSuccess(address, "addressError");

            return isValid;
        }

        /* ================= HELPER FUNCTIONS ================= */

        function showError(input, errorId, message) {
            document.getElementById(errorId).innerText = message;
            input.classList.add("invalid");
            input.classList.remove("valid");
        }

        function showSuccess(input, errorId) {
            document.getElementById(errorId).innerText = "";
            input.classList.remove("invalid");
            input.classList.add("valid");
        }
    </script>



</body>

</html>
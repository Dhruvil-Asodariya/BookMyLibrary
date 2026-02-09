<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Library System</title>
    <link rel="icon" href="../image/title_image.png" type="image/png">


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
            border: 2px dashed #16a34a;
            padding: 25px;
            border-radius: 10px;
            margin-top: 15px;
            background: #f8fafc;
            transition: 0.3s;
        }

        .drop-area.dragover {
            background: #eef2ff;
            border-color: #16a34a;
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
            background: #16a34a;
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

        .cancel-btn {
            margin-top: 15px;
            padding: 10px 18px;
            background: #2563eb;
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
            background: #16a34a;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        .remove-btn {
            background: #ef4444;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            margin-top: 5px;
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
            padding: 28px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card h3 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .sub {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
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

        .p {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 205.5px;
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
            background: #2563eb;
            color: white;
            padding: 11px 22px;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
            float: right;
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

            orm-grid {
                grid-template-columns: 1fr;
            }
        }

        .edit-card {
            background: #ffffff;
            padding: 28px;
            border-radius: 14px;
        }

        /* Header */
        .edit-header h3 {
            font-size: 22px;
            margin-bottom: 4px;
        }

        .edit-header p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }

        /* Form Layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #000000;
        }

        /* Inputs */
        .form-group input,
        .form-group textarea,
        .form-group select {
            padding: 12px 14px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #f9fafb;
            font-size: 14px;
            transition: 0.2s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #2563eb;
            background: #fff;
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        /* Full width address */
        .full-width {
            grid-column: span 2;
        }

        /* Buttons */
        .edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .save-btn {
            background: #2563eb;
            color: white;
            padding: 11px 22px;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            transition: 0.2s;
        }


        .cancel-btn {
            background: #e5e7eb;
            color: #111;
            padding: 11px 22px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        /* Validation */
        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        /* Responsive */
        @media(max-width:700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container">

        <div class="profile-left">
            <div class="profile-img">
                <img src="../image/91xUz2EuYdL._AC_UF1000,1000_QL80_.jpg" id="profileImage">
            </div>

            <h2>James Gosling</h2>
            <p>Library Owner</p>

            <button class="change-btn" onclick="openPopup()">Change Profile</button>
            <button class="remove-btn" id="removeProfileButton" onclick="removeProfile()">Remove Profile</button>
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
            <div class="card" id="viewProfile">

                <h3>Personal Details</h3>
                <p class="sub">Update your profile information</p>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Name</label>
                        <p class="p" id="viewName">James Gosling</p>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <p class="p" id="viewEmail">library@gmail.com</p>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <p class="p" id="viewPhone">+91 9876543210</p>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <p class="p" id="viewGender">Male</p>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <p class="p" id="viewAddress">123 Main Street, City, Country</p>
                    </div>

                </div>

                <div class="edit-actions">
                    <button class="edit-btn" onclick="openEditForm()">Edit profile</button>
                </div>
            </div>
            <div class="card edit-card" id="editProfile" style="display:none;">

                <div class="edit-header">
                    <h3>Edit Personal Details</h3>
                    <p>Update your profile information</p>
                </div>

                <div class="form-grid">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="editName" placeholder="Enter full name">
                        <span id="nameError" class="error"></span>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="editEmail" placeholder="Enter email">
                        <span id="emailError" class="error"></span>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" id="editPhone" placeholder="Enter phone number">
                        <span id="phoneError" class="error"></span>
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select id="editGender">
                            <option value="">Select gender</option>
                            <option selected>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                        <span id="genderError" class="error"></span>
                    </div>

                    <div class="form-group full-width">
                        <label>Address</label>
                        <textarea id="editAddress" rows="3" placeholder="Enter address">123 Main Street, City, Country</textarea>
                        <span id="addressError" class="error"></span>
                    </div>

                </div>

                <div class="edit-actions">
                    <button class="cancel-btn" onclick="cancelEdit()">Cancel</button>
                    <button class="save-btn" onclick="saveEdit()">Save Changes</button>
                </div>

            </div>



        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script>
        const defaultImage = "../image/default_profile.png";

        /* Check image on page load */
        window.onload = function() {
            toggleRemoveButton();
        };

        function toggleRemoveButton() {
            let currentImg = document.getElementById("profileImage").getAttribute("src");

            if (currentImg === defaultImage) {
                document.getElementById("removeProfileButton").style.display = "none";
            } else {
                document.getElementById("removeProfileButton").style.display = "inline-block";
            }
        }
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

            toggleRemoveButton(); // show remove button
            closePopup();
        }

        function removeProfile() {
            if (confirm("Are you sure you want to remove your profile?")) {
                document.getElementById("profileImage").src = defaultImage;

                toggleRemoveButton(); // hide remove button
            }
        }
    </script>

    <script>
        /* OPEN EDIT FORM */
        function openEditForm() {

            document.getElementById("viewProfile").style.display = "none";
            document.getElementById("editProfile").style.display = "block";

            // Fill edit fields from view
            document.getElementById("editName").value =
                document.getElementById("viewName").innerText;

            document.getElementById("editEmail").value =
                document.getElementById("viewEmail").innerText;

            document.getElementById("editPhone").value =
                document.getElementById("viewPhone").innerText;

            document.getElementById("editGender").value =
                document.getElementById("viewGender").innerText;

            document.getElementById("editAddress").value =
                document.getElementById("viewAddress").innerText;
        }

        /* CANCEL EDIT */
        function cancelEdit() {
            document.getElementById("editProfile").style.display = "none";
            document.getElementById("viewProfile").style.display = "block";
        }

        /* SAVE PROFILE */
        function saveEdit() {

            if (!validateForm()) return;

            // Update view values
            document.getElementById("viewName").innerText =
                document.getElementById("editName").value;

            document.getElementById("viewEmail").innerText =
                document.getElementById("editEmail").value;

            document.getElementById("viewPhone").innerText =
                document.getElementById("editPhone").value;

            document.getElementById("viewGender").innerText =
                document.getElementById("editGender").value;

            document.getElementById("viewAddress").innerText =
                document.getElementById("editAddress").value;

            cancelEdit(); // go back to view
        }

        /* VALIDATION */

        function validateForm() {

            let isValid = true;

            let name = document.getElementById("editName");
            if (name.value.trim().length < 3) {
                showError(name, "nameError", "Enter valid name");
                isValid = false;
            } else showSuccess(name, "nameError");

            let email = document.getElementById("editEmail");
            let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.value.match(emailPattern)) {
                showError(email, "emailError", "Enter valid email");
                isValid = false;
            } else showSuccess(email, "emailError");

            let phone = document.getElementById("editPhone");
            if (phone.value.length < 10) {
                showError(phone, "phoneError", "Enter valid phone");
                isValid = false;
            } else showSuccess(phone, "phoneError");

            // GENDER
            let gender = document.getElementById("editGender");
            if (!gender.value) {
                showError(gender, "genderError", "Select gender");
                isValid = false;
            } else showSuccess(gender, "genderError");

            // ADDRESS
            let address = document.getElementById("editAddress");
            if (address.value.trim().length < 10) {
                showError(address, "addressError", "Enter full address");
                isValid = false;
            } else showSuccess(address, "addressError");

            return isValid;
        }

        /* HELPERS */

        function showError(input, errorId, message) {
            document.getElementById(errorId).innerText = message;
            input.classList.add("invalid");
        }

        function showSuccess(input, errorId) {
            document.getElementById(errorId).innerText = "";
            input.classList.remove("invalid");
        }
    </script>




</body>

</html>
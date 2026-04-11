<?php
include("../db_config.php");

if (isset($_POST['payment_id'])) {

    $payment_id = $_POST['payment_id'];
    $current_status = $_POST['current_status'];

    $new_status = ($current_status == "Rejected") ? "Pending" : "Rejected";

    // 🔹 Get screenshot filename first
    $get = mysqli_query($con, "SELECT screenshot FROM payment_history WHERE payment_id='$payment_id'");
    $row = mysqli_fetch_assoc($get);

    if ($row && !empty($row['screenshot'])) {

        $file_path = "../payment_screenshot/" . $row['screenshot'];

        // 🔹 Check file exists then delete
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // 🔹 Update DB
    $update = mysqli_query(
        $con,
        "UPDATE payment_history 
         SET verify_status='$new_status',
             payment_method = NULL,
             payment_status = 'Unpaid',
             payment_date = NULL,
             utr_no = NULL,
             screenshot = NULL 
         WHERE payment_id='$payment_id'"
    );

    if ($update) {
        echo json_encode([
            "status" => "success",
            "newStatus" => $new_status
        ]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>
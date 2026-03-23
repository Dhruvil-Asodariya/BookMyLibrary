<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendLibraryMail($email, $name, $book_name, $status, $returnDate, $fine = 0)
{
    $mail = new PHPMailer(true);

    try {

        $mail = new PHPMailer(true);

        $mail->CharSet = 'UTF-8';

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dasodariya899@rku.ac.in';
        $mail->Password   = 'impt ujku nrtp taee';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('dasodariya899@rku.ac.in', 'Book My Library');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);

        // Default values
        $title = "";
        $content = "";

        // 📧 Content Based on Status
        if ($status == "Issued") {

            $title = "📚 Book Issued Successfully";

            $content = "
            Your book <b>$book_name</b> has been issued successfully.<br>
            Please return it before <b>$returnDate</b>.
            ";
        } elseif ($status == "Yet to return") {

            $title = "⏰ Return Reminder";

            $content = "
            Your book <b>$book_name</b> is due soon.<br>
            Please return it before <b>$returnDate</b> to avoid fines.
            ";
        } elseif ($status == "Overdue") {

            $title = "⚠ Book Overdue";

            $content = "
            Your book <b>$book_name</b> is overdue.<br>
            Current fine amount: <b>₹$fine</b><br>
            Please return it immediately.
            ";
        } elseif ($status == "Return at library") {
            
            $title = "📖 Return Confirmation";

            $content = "
            Your book <b>$book_name</b> has been returned at the library.<br>
            Thank you for visiting us.
            ";
        } elseif ($status == "Returned") {

            $title = "✅ Book Returned";

            $content = "
            Thank you for returning the book <b>$book_name</b>.<br>
            We hope you enjoyed reading it.
            ";
        }

        // 📧 HTML Email Template
        $message = "
        <div style='background:#1f2a36;padding:30px;font-family:Arial,sans-serif;color:#fff;'>

            <div style='max-width:650px;margin:auto;background:#2c3e50;border-radius:10px;padding:25px;'>

                <h2 style='text-align:center;color:#fff;'>
                    🚀 Welcome to <span style='color:#ff9f1c;'>Book My Library</span>
                </h2>

                <p style='text-align:center;color:#ddd;'>
                    Hello <b>$name</b>, we're glad to connect with you!
                </p>

                <div style='background:#3b4b5b;padding:20px;border-radius:8px;margin-top:20px;text-align:center;'>

                    <h3 style='color:#ffc107;'>$title</h3>

                    <p style='color:#eee;font-size:15px;'>
                        $content
                    </p>

                    <a href='http://localhost/BookMyLibrary/login.php'
                       style='display:inline-block;margin-top:15px;background:#4da3ff;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;'>
                       🔐 Visit Library
                    </a>

                </div>

                <div style='text-align:center;margin-top:25px;'>

                    <h3 style='color:#ffc107;'>📚 Book My Library</h3>

                    <p style='color:#ddd;'>
                        Manage your books, borrowing history, and payments easily.
                    </p>

                    <p style='color:#aaa;font-style:italic;'>
                        'Books are a uniquely portable magic.'
                    </p>

                </div>

                <div style='background:#3b4b5b;padding:20px;border-radius:8px;margin-top:25px;text-align:center;'>

                    <p>Best Wishes,</p>

                    <b>📖 The Book My Library Team</b>

                    <p style='margin-top:10px;font-size:13px;color:#ccc;'>
                        📧 support@bookmylibrary.com
                    </p>

                </div>

            </div>

        </div>
        ";

        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Mail Error: " . $mail->ErrorInfo;
    }
}

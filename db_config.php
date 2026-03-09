<?php
//Step-1 : Craete connection

$con = mysqli_connect("localhost", "root", "", "bookmyshow");

if ($con) {
    // echo "Connection Successfull";
} else {
    echo "Connection Failed";
}

//Step-2 : Create Database this is one time process so we can comment this code after creating database

// $create_db = "create database BookMyShow";

// if (mysqli_query($con, $create_db)) {
//     echo "Database Created Successfully";
// } else {
//     echo "Database Creation Failed";
// }

//Step-3 : Select Database
try {
    mysqli_select_db($con, "bookmyshow");
} catch (Exception) {
    echo "Error in connecting with DB";
}

//Step-4 : create Table is one time process so we can comment this code after creating database

//Table: Book_list

// $create_table = "CREATE TABLE book_list (
//     book_id INT PRIMARY KEY,
//     library_id INT,
//     title VARCHAR(100),
//     author VARCHAR(50),
//     category VARCHAR(25),
//     year INT(4),
//     language VARCHAR(25),
//     total_copy INT(3),
//     available_copy INT(3),
//     rating FLOAT(2,1),
//     status VARCHAR(25),
//     image VARCHAR(255),

//     CONSTRAINT fk_library
//     FOREIGN KEY (library_id)
//     REFERENCES library(library_id)
//     ON DELETE CASCADE
//     ON UPDATE CASCADE
// );";

// Table: category

// $create_table = "CREATE TABLE category (
//     category_id INT PRIMARY KEY,
//     category_name VARCHAR(100),
//     category_description VARCHAR(255),
//     status VARCHAR(10)
// );";

// Table: user

// $create_table = "CREATE TABLE user (
//     user_id INT PRIMARY KEY,
//     first_name VARCHAR(100),
//     last_name VARCHAR(100),
//     email VARCHAR(255),
//     contact_no INT(10),
//     gender VARCHAR(10),
//     address VARCHAR(255),
//     image VARCHAR(255),
//     role VARCHAR(10),
//     status VARCHAR(15)
// );";

// if (mysqli_query($con, $create_table)) {
//     echo "Table Created Successfully";
// } else {
//     echo "Table Creation Failed";
// }




<?php
session_start();
    // Check if form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data and sanitize
       $product1_feedback = $product2_feedback = $product3_feedback = $product4_feedback = $product5_feedback="";
        $product1_rating = $product2_rating = $product3_rating = $product4_rating = $product5_rating = 1;
        $phone = filter_var( htmlspecialchars($_SESSION["phone"]), FILTER_SANITIZE_NUMBER_INT);
        $product1_rating = filter_var(htmlspecialchars($_POST['product1_rating']), FILTER_SANITIZE_NUMBER_INT);
        $product1_feedback = filter_var($_POST['product1_feedback'], FILTER_SANITIZE_STRING);
        $product2_rating = filter_var($_POST['product2_rating'], FILTER_SANITIZE_NUMBER_INT);
        $product2_feedback = filter_var($_POST['product2_feedback'], FILTER_SANITIZE_STRING);
        $product3_rating = filter_var($_POST['product3_rating'], FILTER_SANITIZE_NUMBER_INT);
        $product3_feedback = filter_var($_POST['product3_feedback'], FILTER_SANITIZE_STRING);
        $product4_rating = filter_var($_POST['product4_rating'], FILTER_SANITIZE_NUMBER_INT);
        $product4_feedback = filter_var($_POST['product4_feedback'], FILTER_SANITIZE_STRING);
        $product5_rating = filter_var($_POST['product5_rating'], FILTER_SANITIZE_NUMBER_INT);
        $product5_feedback = filter_var($_POST['product5_feedback'], FILTER_SANITIZE_STRING);

        // Connect to database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "demo";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert feedback and ratings into database
        $sql = "INSERT INTO record_feedback (phone, product1_rating, product1_feedback, product2_rating, product2_feedback, product3_rating, product3_feedback, product4_rating, product4_feedback, product5_rating, product5_feedback)
        VALUES ('$phone', '$product1_rating', '$product1_feedback', '$product2_rating', '$product2_feedback', '$product3_rating', '$product3_feedback', '$product4_rating', '$product4_feedback', '$product5_rating', '$product5_feedback')";

        if ($conn->query($sql) === TRUE) {
            echo "Feedback submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
?>

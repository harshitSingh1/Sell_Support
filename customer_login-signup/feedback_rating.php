<?php
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'sellsupport');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the records for the given customer number
$custnum = htmlspecialchars($_SESSION["phone"]);
$sql = "SELECT * FROM record WHERE phone = $custnum";
$result = $conn->query($sql);

if($result->num_rows != 0){
    $products = array();
    while($row = $result->fetch_assoc()) {
        // Add each product to the products array
        for ($i = 1; $i <= 5; $i++) {
            $product = $row["product$i"];
            if (!empty($product) && !in_array($product, $products)) {
                array_push($products, $product);
            }
        }
    }
} else {
    echo "No records found for customer number $custnum";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback and Product Rating</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Feedback and Product Rating</h1>
    <form method="POST" action="submit_feedback.php">
        <input type="hidden" name="custnum" value="<?php echo $custnum; ?>">
        <?php foreach ($products as $product) { ?>
            <h2><?php echo $product; ?></h2>
            <label for="<?php echo $product; ?>_rating">Rating:</label>
            <select id="<?php echo $product; ?>_rating" name="<?php echo $product; ?>_rating">
                <option value="1">1 star</option>
                <option value="2">2 stars</option>
                <option value="3">3 stars</option>
                <option value="4">4 stars</option>
                <option value="5">5 stars</option>
            </select>
            <br>
            <label for="<?php echo $product; ?>_feedback">Feedback:</label>
            <textarea id="<?php echo $product; ?>_feedback" name="<?php echo $product; ?>_feedback"></textarea>
            <br>
        <?php } ?>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

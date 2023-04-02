<!DOCTYPE html>
<html>
<head>
	<title>Extract Data</title>
	<style>
form {
    max-width: 100%;
    margin: 0 auto;
    padding: 20px;
    border: 5px solid #21037a;
    border-radius: 15px;
    background-color: #f2f2f2;
}
table {
			/* border-collapse: collapse; */
			width: 100%;
		}
h1 {
    color: #002bff;
    text-align: center;
    margin-bottom: 20px;
}
h4{
    text-align: center;
}

table, th, td {
  border:1px solid black;
  text-align: left;
			padding: 8px;
}
th {
    text-align: left;
	/* background-color: blue; */
			color: white;
  }
  @media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 50%;
        margin-top: 0;
    }
}
</style>
</head>
<body>
<form form action="" method="post">
<h1>Your Product Reviews</h1>
	<?php
		// Connect to database
		$dbh = new PDO('mysql:host=localhost;dbname=sell_support', 'root', '');

		// Prepare and execute SQL query
		$stmt = $dbh->prepare('SELECT * FROM record WHERE product1 IS NOT NULL AND rating1 IS NOT NULL AND product2 IS NOT NULL AND rating2 IS NOT NULL AND product3 IS NOT NULL AND rating3 IS NOT NULL AND product4 IS NOT NULL AND rating4 IS NOT NULL AND product5 IS NOT NULL AND rating5 IS NOT NULL');
		$stmt->execute();

		// Display results in a table
		echo '<table>';
		echo '<tr><th style="background-color:#191970">Phone No.</th><th style="background-color:#0000FF">Product 1</th><th style="background-color:#0000FF">Rating 1</th><th style="background-color:#0000FF">Feedback 1</th><th style="background-color:#1E90FF">Product 2</th><th style="background-color:#1E90FF">Rating 2</th><th style="background-color:#1E90FF">Feedback 2</th><th style="background-color:#0000FF">Product 3</th><th style="background-color:#0000FF">Rating 3</th><th style="background-color:#0000FF">Feedback 3</th><th style="background-color:#1E90FF">Product 4</th><th style="background-color:#1E90FF">Rating 4</th><th style="background-color:#1E90FF">Feedback 4</th><th style="background-color:#0000FF">Product 5</th><th style="background-color:#0000FF">Rating 5</th><th style="background-color:#0000FF">Feedback 5</th></tr>';
		while ($row = $stmt->fetch()) {
			echo '<tr>';
			echo '<td style="background-color:#191970; color:white;">'.$row['phone'].'</td>';
			echo '<td style="background-color:#E6E6FA">' . $row['product1'] . '</td>';
            echo '<td style="background-color:#E6E6FA">' . $row['rating1'] . '</td>';
            echo '<td style="background-color:#E6E6FA">' . $row['feedback1'] . '</td>';
			echo '<td>' . $row['product2'] . '</td>';
            echo '<td>' . $row['rating2'] . '</td>';
            echo '<td>' . $row['feedback2'] . '</td>';
			echo '<td style="background-color:#E6E6FA">' . $row['product3'] . '</td>';
            echo '<td style="background-color:#E6E6FA">' . $row['rating3'] . '</td>';
            echo '<td style="background-color:#E6E6FA">' . $row['feedback3'] . '</td>';
			echo '<td>' . $row['product4'] . '</td>';
            echo '<td>' . $row['rating4'] . '</td>';
			echo '<td>' . $row['feedback4'] . '</td>';
			echo '<td style="background-color:#E6E6FA">' . $row['product5'] . '</td>';
			echo '<td style="background-color:#E6E6FA">' . $row['rating5'] . '</td>';
			echo '<td style="background-color:#E6E6FA">' . $row['feedback5'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';

		// Close database connection
		$dbh = null;
	?>
	</form>
</body>
</html>

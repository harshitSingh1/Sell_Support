<!DOCTYPE html>
<html>
  <head>
    <title>Product Ratings</title>
    <style>
		.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f0f0f0;
}

h1 {
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
}

th {
  background-color: #f2f2f2;
}

select, textarea {
  width: 100%;
  height: 100%;
  padding: 5px;
  border: 1px solid #ccc;
}

		</style>
  </head>
  <body>
    <div class="container">
      <h1>Product Ratings</h1>
	  <?php
    session_start();
        // Connect to database
        $custnum = htmlspecialchars($_SESSION["phone"]);
        $conn = mysqli_connect("localhost", "root", "", "sell_support");

        // Check connection
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        // Get form data and update database
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $rating1 = isset($_POST["rating1"]) ? $_POST["rating1"] : 0;
          $feedback1 = isset($_POST["feedback1"]) ? trim($_POST["feedback1"]) : "";
          $rating2 = isset($_POST["rating2"]) ? $_POST["rating2"] : 0;
          $feedback2 = isset($_POST["feedback2"]) ? trim($_POST["feedback2"]) : "";
          $rating3 = isset($_POST["rating3"]) ? $_POST["rating3"] : 0;
          $feedback3 = isset($_POST["feedback3"]) ? trim($_POST["feedback3"]) : "";
          $rating4 = isset($_POST["rating4"]) ? $_POST["rating4"] : 0;
          $feedback4 = isset($_POST["feedback4"]) ? trim($_POST["feedback4"]) : "";
          $rating5 = isset($_POST["rating5"]) ? $_POST["rating5"] : 0;
          $feedback5 = isset($_POST["feedback5"]) ? trim($_POST["feedback5"]) : "";

          // Update record table with new data
          $sql = "UPDATE record SET rating1='$rating1', feedback1='$feedback1', rating2='$rating2', feedback2='$feedback2', rating3='$rating3', feedback3='$feedback3', rating4='$rating4', feedback4='$feedback4', rating5='$rating5', feedback5='$feedback5' WHERE phone = '$custnum'";
          if (mysqli_query($conn, $sql)) {
            echo "<p>Rate your products:</p>";
          } else {
            echo "<p>Error updating record: " . mysqli_error($conn) . "</p>";
          }

          // Close connection
          mysqli_close($conn);
        }
      ?>
      <form method="post">
        <table>
          <tr>
            <th>Product</th>
            <th>Rating</th>
            <th>Feedback</th>
          </tr>
          <?php
            // Connect to database
            $conn = mysqli_connect("localhost", "root", "", "sell_support");

            // Check connection
            if (!$conn) {
              die("Connection failed: " . mysqli_connect_error());
            }

            // Select all records from the table
            $sql = "SELECT * FROM record WHERE phone = $custnum ORDER BY id DESC";
            $result = mysqli_query($conn, $sql);
            // Loop through the records and display them in a table
            while ($row = $result->fetch_assoc()) {
              if(!empty($row['product1']) && empty($row['rating1'])){
              echo "<tr>";
              echo "<td>" . $row['product1'] . "</td>";
              echo "<td>";
              echo "<select name='rating1'>";
              echo "<option value='1'>1</option>";
              echo "<option value='2'>2</option>";
              echo "<option value='3'>3</option>";
              echo "<option value='4'>4</option>";
              echo "<option value='5'>5</option>";
              echo "</select>";
              echo "</td>";
              echo "<td><textarea name='feedback1'></textarea></td>";
              echo "</tr>";
              }
              if(!empty($row['product2']) && empty($row['rating2'])){
              echo "<tr>";
              echo "<td>" . $row['product2'] . "</td>";
              echo "<td>";
              echo "<select name='rating2'>";
              echo "<option value='1'>1</option>";
              echo "<option value='2'>2</option>";
              echo "<option value='3'>3</option>";
              echo "<option value='4'>4</option>";
              echo "<option value='5'>5</option>";
              echo "</select>";
              echo "</td>";
              echo "<td><textarea name='feedback2'></textarea></td>";
              echo "</tr>";
              }
              if(!empty($row['product3']) && empty($row['rating3'])){
                echo "<tr>";
                echo "<td>" . $row['product3'] . "</td>";
                echo "<td>";
                echo "<select name='rating3'>";
                echo "<option value='1'>1</option>";
                echo "<option value='2'>2</option>";
                echo "<option value='3'>3</option>";
                echo "<option value='4'>4</option>";
                echo "<option value='5'>5</option>";
                echo "</select>";
                echo "</td>";
                echo "<td><textarea name='feedback3'></textarea></td>";
                echo "</tr>";
                }
                
                if(!empty($row['product4']) && empty($row['rating4'])){
                  echo "<tr>";
                  echo "<td>" . $row['product4'] . "</td>";
                  echo "<td>";
                  echo "<select name='rating4'>";
                  echo "<option value='1'>1</option>";
                  echo "<option value='2'>2</option>";
                  echo "<option value='3'>3</option>";
                  echo "<option value='4'>4</option>";
                  echo "<option value='5'>5</option>";
                  echo "</select>";
                  echo "</td>";
                  echo "<td><textarea name='feedback4'></textarea></td>";
                  echo "</tr>";
                  }
                  if(!empty($row['product5']) && empty($row['rating5'])){
                    echo "<tr>";
                    echo "<td>" . $row['product5'] . "</td>";
                    echo "<td>";
                    echo "<select name='rating5'>";
                    echo "<option value='1'>1</option>";
                    echo "<option value='2'>2</option>";
                    echo "<option value='3'>3</option>";
                    echo "<option value='4'>4</option>";
                    echo "<option value='5'>5</option>";
                    echo "</select>";
                    echo "</td>";
                    echo "<td><textarea name='feedback5'></textarea></td>";
                    echo "</tr>";
                    }
            }
            // Close connection
            mysqli_close($conn);
          ?>
        </table>
        <input type="submit" value="Submit">
      </form>
    </div>
  </body>
</html>

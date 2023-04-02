<?php
session_start();
require_once('tcpdf/tcpdf.php');

// Get the customer number from the query string
$custnum = htmlspecialchars($_SESSION["phone"]);
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'sell_support');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the record for the given customer number
$sql = "SELECT * FROM record WHERE phone = $custnum ORDER BY id DESC";
$result = $conn->query($sql);
if($result->num_rows !=0){
if ($result->num_rows > 0) {
    // Assign the values to variables
    while($row = $result->fetch_assoc()) {
        $custnum = $_SESSION["phone"];
        $id = $row['id']+102345;
        $name = $row['name'];
        $date = $row['date'];
        $product1 = $row['product1'];
        $product2 = $row['product2'];
        $product3 = $row['product3'];
        $product4 = $row['product4'];
        $product5 = $row['product5'];
        $cost1 = $row['cost1'];
        $cost2 = $row['cost2'];
        $cost3 = $row['cost3'];
        $cost4 = $row['cost4'];
        $cost5 = $row['cost5'];

        
// Set the filename for the PDF
$filename = 'Receipt_' . $id . '.pdf';

// Create a new TCPDF object
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set the document properties
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('The Shopkeeper');
$pdf->SetTitle('Purchase Receipt');
$pdf->SetSubject('Purchase Receipt');
$pdf->SetKeywords('Purchase, Receipt, Shopkeeper');
$pdf->setHeaderData('', 0, 'Purchase Receipt', '');
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 12);

// Add a new page to the PDF
$pdf->AddPage();

// Create a table to display the data
$total_cost = $cost1 + $cost2 + $cost3 + $cost4 + $cost5;
$formatted_cost = number_format($total_cost, 2);
$table = '<!DOCTYPE html>
<html>
<script><
    const product = ["'. $product1 .'", "'. $product2 .'", "'. $product3 .'", "'. $product4 .'","'. $product5 .'" ,""];
    let text1 = "";
    for (let i = 0; i < product.length-1; i++) {
        if(product[i+1]!=""){
        text1 += product[i] + ", ";}
        else{
            text1 += product[i]
            break;} 
      }
      document.getElementById("T_products").innerHTML = text1;
      const cost = ["'. $cost1 .'", "'. $cost2 .'", "'. $cost3 .'", "'. $cost4 .'","'. $cost5 .'" ,""];
    let text2 = "";
    for (let i = 0; i < cost.length-1; i++) {
        if(cost[i+1]!="0.000"){
        text2 += cost[i] + " , ";}
        else{
            text2 += cost[i];
            break;}
      }
      document.getElementById("T_cost").innerHTML = text2;
      let total = '. $cost1 .'+'. $cost2 .'+'. $cost3 .'+'. $cost4 .'+'. $cost5 .';
      document.getElementById("Total").innerHTML = total +" Rs.";
</script>
<style>
form {
    max-width: 700px;
    margin: 0 auto;
    padding: 20px;
    border: 5px solid #21037a;
    border-radius: 15px;
    background-color: #f2f2f2;
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
}
th {
    text-align: left;
  }
  @media screen and (max-width: 600px) {
    .col-25, .col-75, input[type=submit] {
        width: 50%;
        margin-top: 0;
    }
}
</style>
<body>
<form form action="" method="post">
<h1>Your Order Details</h1>
<h3>Receipt No. : ' . $id .'</h3>
<table style="width:100%">
            <tr>
                <th>Name</th>
                <td>' . $name . '</td>
            </tr>
            <tr>
                <th>Number</th>
                <td>' . $custnum . '</td>
            </tr>
            <tr>
                <th>Purchase date</th>
                <td>' . $date . '</td>
            </tr>
            <tr>
                <th>Product Name</th>
                <td>';

$product_array = array($product1, $product2, $product3, $product4, $product5);
$cost_array = array($cost1, $cost2, $cost3, $cost4, $cost5);
foreach ($product_array as $key => $product) {
    if (!empty($product)) {
        $table .= $product . '<br>';
    }
}
$table .= '</td>
            </tr>
            <tr>
                <th>Cost</th>
                <td>';

foreach ($cost_array as $key => $cost) {
    if (!empty($cost) && $cost != '0.000') {
        $table .= $cost . '<br>';
    }
}
$table .= '</td>
            </tr>
            <tr>
                <th>Total Cost</th>
                <td>' . $formatted_cost . ' Rs.</td>
            </tr>
        </table>
    </form>
</body>
</html>
';

// Write the table to the PDF
$pdf->WriteHTML($table);

// If the "download" parameter is set to "true", download the PDF file
if (isset($_GET['download']) && $_GET['download'] == true) {
    // Output the PDF file
    $pdf->Output($filename, 'D');

    // Connect to the database
    /*
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sellsupport";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the row from the "record" table where "number" is equal to $custnum
    $sql = "DELETE FROM record WHERE phone=$custnum";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
    */
} else {
    // Otherwise, display a link to download the PDF file
    echo $table;
    echo '<!DOCTYPE html>
    <html>
    <style>
    p{
        text-align: center;
    }
    </style>
    <body>
    <br>
    <p>You can download the Above E-receipt from here.
    <a href="?custnum=' . $custnum . '&prodname=' . $product1 . '&cost=' . $cost1 . '&download=true" >Download PDF</a></p>
    </body>
</html>';
    
}

    }
} else {
    echo "0 results";
}

}
else{
    echo "No data available";
}
// Close the database connection
$conn->close();
?>
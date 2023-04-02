<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $phone = $date = $more_products = "";
$product1 = $product2 = $product3 = $product4 = $product5 = "";
$cost1 = $cost2 = $cost3 = $cost4 = $cost5 = 0.0;

$name_err = $phone_err = $date_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter your name.";
    } else{
        $name = trim($_POST["name"]);
    }

    // Validate phone
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter a phone.";
    } elseif(!preg_match('/^[0-9+]+$/', trim($_POST["phone"]))){
        $phone_err = "Phone can only contain letters, numbers, and underscores.";
    } else{
        $phone = trim($_POST["phone"]);
    }

    // Validate date
    if(empty(trim($_POST["date"]))){
        $date_err = "Please enter a date.";
    } else{
        $date = trim($_POST["date"]);
    }

    // Get product and cost values
    $product1 = trim($_POST["product1"]);
    $cost1 = empty(trim($_POST["cost1"])) ? 0.0 : floatval($_POST["cost1"]);
    $product2 = trim($_POST["product2"]);
    $cost2 = empty(trim($_POST["cost2"])) ? 0.0 : floatval($_POST["cost2"]);
    $product3 = trim($_POST["product3"]);
    $cost3 = empty(trim($_POST["cost3"])) ? 0.0 : floatval($_POST["cost3"]);
    $product4 = trim($_POST["product4"]);
    $cost4 = empty(trim($_POST["cost4"])) ? 0.0 : floatval($_POST["cost4"]);
    $product5 = trim($_POST["product5"]);
    $cost5 = empty(trim($_POST["cost5"])) ? 0.0 : floatval($_POST["cost5"]);
    $more_products = trim($_POST["more_products"]);

    // Check input errors before inserting in database
    if(empty($name_err) && empty($phone_err) && empty($date_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO record (name, phone, date, product1, cost1, product2, cost2, product3, cost3, product4, cost4, product5, cost5, more_products) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssssss", $param_name, $param_phone, $param_date, $param_product1, $param_cost1, $param_product2, $param_cost2, $param_product3, $param_cost3, $param_product4, $param_cost4, $param_product5, $param_cost5, $param_more_products);
            // Set parameters
            $param_name = $name;
            $param_phone = $phone;
            $param_date = $date;
            $param_product1 = $product1;
            $param_cost1 = $cost1;
            $param_product2 = $product2;
            $param_cost2 = $cost2;
            $param_product3 = $product3;
            $param_cost3 = $cost3;
            $param_product4 = $product4;
            $param_cost4 = $cost4;
            $param_product5 = $product5;
            $param_cost5 = $cost5;
            $param_more_products = $more_products;
             // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: Shopkeeper.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Purchase Record Feedback Form</title>
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

		h2,p,label {
			color: #002bff;
			margin-top: 40px;
			margin-bottom: 10px;
		}

		input[type=text], textarea {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #fff;
			resize: vertical;
		}
		input[type=date], textarea {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #fff;
			resize: vertical;
		}
		input[type=file], textarea {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #fff;
			resize: vertical;
		}
		input[type=tel], textarea {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #fff;
			resize: vertical;
		}

		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}

		.container {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
		}
		
.glow-on-hover {
    width: 220px;
    height: 50px;
    border: none;
    outline: none;
    color: #fff;
    background: #111;
    cursor: pointer;
    position: relative;
    z-index: 0;
    border-radius: 10px;
	top : 0px;
	right : -240px;
}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #000
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #111;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
}
		.row:after {
			content: "";
			display: table;
			clear: both;
		}
		.col-20 {
			float: left;
			width: 30%;
			margin-top: 25px;
		}

		.col-25 {
			float: left;
			width: 10%;
			margin-top: 25px;
		}
		.col-70 {
			float: left;
			width: 50%;
			margin-top: 6px;
		}
		.col-71 {
			float: left;
			width: 60%;
			margin-top: 6px;
		}

		.col-75 {
			float: left;
			width: 25%;
			margin-top: 6px;
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
		<h1>Purchase Record</h1>
		<p>Fill this form so that customer can get the e-receipt of the products and payment option in his account.</p>
		<br>
		<div class="row">
			<div class="col-20">
				<label for="name">Customer Name</label>
			</div>
			<div class="col-70">
				<input type="text" id="name" name="name" placeholder="Enter name">
			</div>
		</div>

		<div class="row">
			<div class="col-20">
			<label for="name">UPI Pay</label>
			</div>
			<div class="col-70">
			<input type="file" id="photoInput" onchange="showPhoto()">
			<img id="photoPreview">
			</div>
		</div>
		<div class="row">
			<div class="col-20">
			<label for="name">Google Pay</label>
			</div>
			<div class="col-70">
			<input type="file" id="photoInput" onchange="showPhoto()">
			<img id="photoPreview">
			</div>
		</div>
		<div class="row">
			<div class="col-20">
			<label for="name">PayPal</label>
			</div>
			<div class="col-70">
			<input type="file" id="photoInput" onchange="showPhoto()">
			<img id="photoPreview">
			</div>
		</div>
		<div class="row">
			<div class="col-20">
			<label for="name">Apple Pay</label>
			</div>
			<div class="col-70">
			<input type="file" id="photoInput" onchange="showPhoto()">
			<img id="photoPreview">
			</div>
		</div>
		<div class="row">
			<div class="col-20">
				<label for="date">Date</label>
			</div>
			<div class="col-70">
				<input type="date" id="date" name="date" placeholder="Enter the date of purchase">
			</div>
		</div>

		<hr>

		<h2>5 or less Products</h2>

		<div class="row">
			<div class="col-25">
				<label for="product1">Product 1</label>
			</div>
			<div class="col-75">
				<input type="text" id="product1" name="product1" placeholder="Enter product name">
			</div>
			<div class="col-25">
				<label for="product1">&ensp;, Its Cost</label>
			</div>
			<div class="col-75">
				<input type="text" id="cost1" name="cost1" placeholder="Enter cost">
			</div>
		</div>

		<div class="row">
			<div class="col-25">
				<label for="product2">Product 2</label>
			</div>
			<div class="col-75">
				<input type="text" id="product2" name="product2" placeholder="Enter product name">
			</div>
			<div class="col-25">
				<label for="product2">&ensp;, Its cost</label>
			</div>
			<div class="col-75">
				<input type="text" id="cost2" name="cost2" placeholder="Enter cost">
			</div>
		</div>

		<div class="row">
			<div class="col-25">
				<label for="product3">Product 3</label>
			</div>
			<div class="col-75">
				<input type="text" id="product3" name="product3" placeholder="Enter product name">
			</div>
			<div class="col-25">
				<label for="product3">&ensp;, Its cost</label>
			</div>
			<div class="col-75">
				<input type="text" id="cost3" name="cost3" placeholder="Enter cost">
			</div>
		</div>

		<div class="row">
			<div class="col-25">
				<label for="product4">Product 4</label>
			</div>
			<div class="col-75">
				<input type="text" id="product4" name="product4" placeholder="Enter product name">
			</div>
			<div class="col-25">
				<label for="product4">&ensp;, Its cost</label>
			</div>
			<div class="col-75">
				<input type="text" id="cost4" name="cost4" placeholder="Enter cost">
			</div>
		</div>

		<div class="row">
			<div class="col-25">
				<label for="product5">Product 5</label>
			</div>
			<div class="col-75">
				<input type="text" id="product5" name="product5" placeholder="Enter product name">
			</div>
			<div class="col-25">
				<label for="product5">&ensp;, Its cost</label>
			</div>
			<div class="col-75">
				<input type="text" id="cost5" name="cost5" placeholder="Enter cost">
			</div>
		</div>

		<hr>

		<h2>More than 5 Products</h2>

		<div class="row">
			<div class="col-20">
				<label for="more-products">Type like this:<br></label>
				<label for="more-products">Product1 Name - its cost</label>
				<label for="more-products">Product2 Name - its cost</label>
			</div>
			<div class="col-71">
				<textarea id="more_products" name="more_products" placeholder="Enter product details" style="height:200px"></textarea>
			</div>
		</div>
		<br>
		<div class="row">
			<a href="Shopkeeper.php"><button onclick="myFunction()" class="glow-on-hover" type="submit">SUBMIT</button></a>
	</div>
	<script>
        function myFunction() {
            alert("Submitted Successfully");
        }
    </script>
	<script>
function showPhoto() {
  var preview = document.querySelector('#photoPreview');
  var file    = document.querySelector('#photoInput').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}
</script>
    </form>
  </body>
</html>


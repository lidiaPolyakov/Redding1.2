<?php 
include 'db.php';
include 'config.php';
session_start();
if(!isset($_SESSION["user_id"])) {
    header('Location: ' . URL . 'index.php');
}
$user_id = $_SESSION["user_id"];
$product_name = mysqli_real_escape_string($connection,$_GET['product']);
$amount = mysqli_real_escape_string($connection,$_GET['amount']);
$expDate = mysqli_real_escape_string($connection,$_GET['date']);

$query ="SELECT * FROM `dbShnkr22studWeb1`.`tbl_redding_products_210` WHERE product_name LIKE UPPER('%".$product_name."%');";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

if(!$result){
    die("1 Could not add ".$product_name."");
}
$insertQuery ="INSERT INTO `dbShnkr22studWeb1`.`tbl_redding_inventory_210` (`user_id`, `product_id`, `amount`, `exp_date`) VALUES ('".$user_id ."', '".$row["product_id"]."', '".$amount."', '".$expDate."');";
$insert = mysqli_query($connection,$insertQuery);
if(!$insert){
    die("2 Could not add ".$product_name."");
}

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awesome</title>
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</head>
<body>
<div class="alert alert-success" role="alert">
  Your Product Was Added Sucssefully 
</div>
</body>
</html>
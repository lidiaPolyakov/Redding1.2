<?php
    include 'config.php';
    include 'db.php';

    session_start();
    if(!isset($_SESSION["user_id"])) {
        header('Location: ' . URL . 'index.php');
    }
    $query = "DELETE FROM `dbShnkr22studWeb1`.`tbl_redding_inventory_210` WHERE product_id=".$_POST["prod_id"].";";
    $result = mysqli_query($connection , $query);
    if(!$result){
        die("Query Failed - could not delete product from inventory"); 
    }
  echo '{"prodId":"'.$_POST["item_id"].'",
        "userId":"'.$_SESSION["user_id"].'"}';
         mysqli_close($connection);
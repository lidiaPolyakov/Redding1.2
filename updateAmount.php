<?php
    include 'config.php';
    include 'db.php';
    session_start();
    $userId = $_SESSION["user_id"];
    if(!isset($userId)) {
        header('Location: ' . URL . 'index.php');
    }  
    $amount = $_POST["amount"];
    $prodId = $_POST["prodId"];
    $userId = $_SESSION["user_id"];

     $query = "UPDATE dbShnkr22studWeb1.tbl_redding_inventory_210 SET amount = ".$amount." WHERE (user_id = ".$userId.") and (product_id = ".$prodId.");";
     
     $result = mysqli_query($connection,$query);
     
     if(!isset($result)){
        die("{'status': 'failed'}");
     }
     echo "{'status': 'sucsseeded'}";
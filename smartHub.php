<?php
    include 'db.php';
    include 'config.php';
    session_start();

    if(!isset($_SESSION["user_id"])) {
        header('Location: ' . URL . 'index.php');
    }
    $query = "SELECT DISTINCT * FROM dbShnkr22studWeb1.tbl_redding_shoppingList_210 AS shopping
    JOIN dbShnkr22studWeb1.tbl_users_210 AS users
    ON shopping.user_id = users.user_id
    WHERE users.user_id = ".$_SESSION["user_id"].";";
   
    $result = mysqli_query($connection , $query);
    if(!$result){
        die("Query Failed - could not fetch Shopping list data");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Smart Hub</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="smart-hub">
    <header>
        <nav class="navbar sticky-top navbar-expand-lg navbar-light bg-primary">
         <div class="container-fluid">
             <a class="navbar-brand" href="index.html">Redding</a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
         <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav d-flex align-items-center">
                     <li class="nav-item">
                         <a class="nav-link" aria-current="page" href="myFridge.php">My Fridge</a>
                     </li>
                     <li class="wrapper nav-item">
                          <a class="bounce_button nav-link active" href="smartHub.php">Smart Hub</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="reciepes.php">Reciepes</a>
                      </li>
                      <li class="nav-item">
                      <?php  echo ' <a class="nav-link" href="#"><img src="  images/'.$_SESSION["user_id"].'.png" alt=""></a>';?>
                     </li>
                 </ul>
         </div>
     </div>
     </nav>
     </header>
        <section class="container container-fluid">
            <div class="container">
                <section class="row">
                    <section id="" class="col-lg-4 col-md-10 border-right">
                        <aside class="a-container">
                            <h1>Shopping List</h1>
                            <hr>
                            <table class="table align-middle mb-0 bg-white">         
                                <tbody id="grocery-list-table">                                               
                                <?php 
                                        class Item {
                                                 public function __construct($m_name, $m_price, $m_userId,$m_itemId) {
                                                        $this->name     = $m_name;
                                                        $this->price    = $m_price;
                                                        $this->user_id  = $m_userId;
                                                        $this->item_id  = $m_itemId;     
                                                }
                                        }
                                        $itemsArray = array();
                                        while($row = mysqli_fetch_assoc($result)){
                                                $name    = $row["item_name"];
                                                $price   = $row["price"];
                                                $user_id = $row["user_id"];
                                                $item_id = $row["item_id"];
                                                array_push($itemsArray, new Item($name,$price,$user_id,$item_id));
                                        }                                     
                                    $jsonArray = array();
                                    foreach ($itemsArray as $key=>$value){
                                        array_push($jsonArray,json_encode($value));                                                               
                                    }
                                    file_put_contents('json/shoppingListItems.json',json_encode($jsonArray));
                                ?>  
                                </tbody>
                                <form action="" method="post" id="form">
                                <tbody>
                                    <tr id="loader">
                                        <td>
                                            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span> </div>
                                        </td>
                                    </tr>
                                    <tr>
                                              <td>
                                                  <input id="new-item-input" class="form-control" type="text" name="item" placeholder="Add New Item" >  
                                              </td>                                  
                                              <td>
                                                  <input type="submit" for="form" class="btn btn-outline-primary" value="+" name="submit" id="submit">                                                                                      
                                              </td>
                                    </tr>
                                </tbody>
                                </form>
                            </table>
                    </section>
                    <section class="col-lg-8 col-md-12 border-right">
                        <div class="container">
                        <section class="row">     
                            <h1>Smart Suggestions</h1>
                            <section class="card">
                                 <section class="card-wrapper">
                                    <h2> New Smart Suggestions</h2>
                                    <p id ="smart-suggestion">
                                         Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                         Molestiae eaque consequatur suscipit similique cupiditate
                                         e.
                                   </p>
                                </section>
                            </section>

                        </section>
                          <section class="row">
                           <h1>Shopping</h1>
                           <section class="card">
                               <section class="card-wrapper justify-content-center">

                                   <h2>You Usually Buy</h2>
                                   <section id="usually-buy" class="d-flex align-items-center justify-content-around">
                                       <section class="make-column">
                                            <button name="item" value="Milk"   type="submit" for="form" class="add-item-btn btn btn-outline-primary "><img value="Milk" src="images/Milk.png" alt=""><i class="fa-solid fa-plus p-2" value="Milk"></i></button>
                                            <button name="item" value="Lemon"  type="submit" for="form" class="add-item-btn btn btn-outline-primary"><img src="images/Lemon.png" alt="" value="Lemon"><i class="fa-solid fa-plus p-2" value="Lemon"></i></button>
                                            <button name="item" value="Apples" type="submit" for="form" class="add-item-btn btn btn-outline-primary"><img src="images/Apple.png" alt="" value="Apples"><i class="fa-solid fa-plus p-2" value="Apples"></i></button>
                                            <button name="item" value="Bread"  type="submit" for="form" class="add-item-btn btn btn-outline-primary"><img src="images/Bread.png" alt="" value="Bread"><i class="fa-solid fa-plus p-2" value="Bread"></i></button>   
                                       </section>
                                     </section>
                               </section>
                            </section>
                          </section>
                            <h1>Statistics</h1>
                            <section >
                                    <section id="chart-background">
                                         <div id="chartContainer">
                                         </div>
                                    </section>
                                </section>
                            </section>
                        </div>
                    </section>
                </section>
            </div>
        </section>
    <script src="scripts/smartHub.js">
    </script>
       <?php 
         mysqli_close($connection);
        ?>
</body>
</html>
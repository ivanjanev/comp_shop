<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 05-Aug-17
 * Time: 15:17
 */
require ("dbconnect.php");
require ("functions.php");
require_once('./stripeConfig.php');


$logged = false;
$cartItemsNumber = 0;
$cartProducts = array();
$userId = 0;
$price=0;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['logged'])&&!empty($_SESSION['logged']))
{
    $logged = true;
    $cartItemsNumber = getCartItemsNumber($_SESSION['userId']);
    $userId = $_SESSION['userId'];
}
else
{
    echo "<script>alert('You must log in first!'); window.location.href=('home.php');</script>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>

    <!--Bootstrap js and css along with jquery-->
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!--Stripe js-->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.stripe.com/v2/"></script>

    <!--Custom css & script-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/ajaxcalls.js"></script>
    <script src="js/scripts.js"></script>

    <!--FontAwesome-->
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

    <!--JS Modal and CSS-->
    <script src="js/jquery.modal.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.modal.css">

    <script>
        var stripe = Stripe('pk_test_OUTSOD4dik3cfY2fWZffHfx7');
        Stripe.setPublishableKey('pk_test_OUTSOD4dik3cfY2fWZffHfx7');

        function stripeResponseHandler(status, response) { //token function
            if (response.error) {
                // re-enable the submit button
                $('.submit-button').removeAttr("disabled");
                // show hidden div
                document.getElementById('a_x200').style.display = 'block';
                // show the errors on the form
                $(".payment-errors").html(response.error.message);
            } else {
                var form$ = $("#payment-form");
                // token contains id, last4, and card type
                var token = response['id'];
                // insert the token into the form so it gets submitted to the server
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                // and submit
                form$.get(0).submit();
            }
        }
    </script>

</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <img src="images/logo.png" id="logo" style="cursor: pointer">
        </div>
        <span class="pull-right">
                <?php
                if($logged)
                {
                    $num = getCartItemsNumber($_SESSION['userId']);
                    echo '<img src="images/shopping_cart.png" id="shoppingCart" class="img-responsive">';
                    echo '<p id="shoppingcartNumber" class="img-rounded">'.$num.'</p>';
                    echo '<button class="btn btn-primary btnAuth" id="btnLogout">Log out</button>';
                }
                else
                {
                    echo '<button class="btn btn-primary btnAuth" id="btnSignUp">Sign Up</button>';
                    echo '<button class="btn btn-primary btnAuth" id="btnLogIn">Log In</button>';
                }
                ?>
        </span>
        <span>
            <ul class="nav navbar-nav pull-right">
                <li>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Pages &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="contact.php">Contacts</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Brands &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="asus.php">Asus ROG</a></li>
                        <li><a href="alienware.php">Alienware</a></li>
                        <li><a href="razer.php">Razer</a></li>
                    </ul>
                </li>
            </ul>
        </span>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            <h2>Your cart item</h2>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3" id="cartPreviewDiv">
            <?php
                if($cartItemsNumber == 0){
                    echo "<h3 class='text-center'>"."You have no items in cart..."."</h3>";
                }
                else {
                    $cartProducts = getCartItemsForUser($userId);
                    $total = 0;
                    echo "<table class='table'><thead><tr><th>Name</th><th>Price</th><th class='text-right'>Action</th></tr></thead><tbody>";
                    foreach ($cartProducts as $product) {
                        $name = $product['name'];
                        $price = $product['price'];
                        $id = $product['id'];
                        $total += $price;
                        echo "<tr><td>$name</td><td>$price</td><td><button type='button' id='$id' class='close btnRmvFromCart' aria-label='Close'><span aria-hidden='true'>&times;</span></button></td></tr>";
                    }
                    echo "<tr><td><b>Total:</b></td><td><b>$total</b></td><td>";
                    $price=$total;
                    $_SESSION['price']=$price;
                }
            ?>
            <form action="stripeCharge.php" method="post" class="pull-right" id="payment-form">
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?php  echo 'pk_test_OUTSOD4dik3cfY2fWZffHfx7'?>"
                        data-amount="<?php echo $price*100?>" data-description="Checkout From Game Gear"
                        data-currency="MKD"
                        data-email="<?php echo $_SESSION['email']?>"></script>
            </form>
            <?php
                echo "</td></tr>";
                echo "</tbody></table>";
            ?>

        </div>
    </div>
</div>

<div id="footerSection">
    <div class="container">
        <div class="row">
            <div id="socialMedia" class="col-md-4 pull-right">
                <h5>Social Networks </h5>
                <a href="#"><img width="60" height="60" src="images/facebook.png" title="facebook" alt="facebook"/></a>
                <a href="#"><img width="60" height="60" src="images/twitter.png" title="twitter" alt="twitter"/></a>
                <a href="#"><img width="60" height="60" src="images/youtube.png" title="youtube" alt="youtube"/></a>
                <br>
                <p>&copy; Game Gear 2017</p>
            </div>
            <div class="col-md-4">
                <h5>Links</h5>
                <a href="#">Home</a>
                <a href="#">Contact</a>
            </div>
            <div class="col-md-4">
                <h5>Brands</h5>
                <a href="#">Asus ROG</a>
                <a href="#">Alienware</a>
                <a href="#">Razor</a>
            </div>
        </div>
    </div>
</div>

<!--modal for user registration-->
<form action="home.php" method="post" id="registerForm" class="modal" style="display: none">
    <div class="form-group">
        <label for="email">Email:*</label>
        <input type="email" id="email" name="email" class="form-control" required autofocus>
        <label for="username">Username:*</label>
        <input type="text" id="username" name="username" class="form-control" required>
        <label for="password">Password:*</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary" id="btnRegisterUser">Sign Up</button>
</form>

<!--modal for user logging in-->
<form action="home.php" method="post" id="loginForm" class="modal" style="display: none">
    <div class="form-group">
        <label for="emailLog">Email:*</label>
        <input type="email" id="emailLog" name="emailLog" class="form-control" required autofocus>
        <label for="passwordLog">Password:*</label>
        <input type="password" id="passwordLog" name="passwordLog" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary" id="btnLogInUser">Log In</button>
</form>


<!--modal for responses from ajax-->
<form action="home.php" method="post" id="responses" class="modal" style="display: none">
    <p id="responseTag" class="text-center"></p>
    <div class="form-actions text-center">
        <button type="submit" class="btn btn-primary" id="btnResponseOK">OK</button>
    </div>

</form>

</body>
</html>

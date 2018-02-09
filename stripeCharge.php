<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 10-Aug-17
 * Time: 16:39
 */

require('stripeConfig.php');
require ('dbconnect.php');

$userId=0;
$email="";
$price=0;
$success=0;
$error1="";
$error2="";
$error3="";
$error4="";
$error5="";
$error6="";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['logged'])&&!empty($_SESSION['logged']))
{
    $logged = true;
    $email = $_SESSION['email'];
    $price = $_SESSION['price'];
    $userId = $_SESSION['userId'];
}
else
{
    echo "<script>alert('You must log in first!'); window.location.href=('home.php');</script>";
}
$token  = $_POST['stripeToken'];
$customer = \Stripe\Customer::create(array(
    'email' => $email,
    'card'  => $token
));

try {
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $price*100,
        'currency' => 'mkd'
    ));
    $success = 1;
}
 catch (Stripe\Error\InvalidRequest $e) {
    // Invalid parameters were supplied to Stripe's API
    $error2 = $e->getMessage();
} catch (Stripe\Error\Authentication $e) {
    // Authentication with Stripe's API failed
    $error3 = $e->getMessage();
} catch (Stripe\Error\ApiConnection $e) {
    // Network communication with Stripe failed
    $error4 = $e->getMessage();
} catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    $error6 = $e->getMessage();
}

if ($success!=1) {
    echo $error1;
    echo $error2;
    echo $error3;
    echo $error4;
    echo $error5;
    echo $error6;
}
else
{
    $con = mysqli_connect("localhost","root","","gshop");
    $sql = 'DELETE cartproducts FROM cartproducts JOIN cart ON cartproducts.cartId=cart.id WHERE cart.userId="'.$userId.'"';
    if(mysqli_query($con,$sql))
    {
        echo "<script> alert('Thank you for your purchase!'); window.location.href=('home.php');</script>";
    }
    else
    {
        echo "<script> alert('Your purchase has been made, but there is a problem with the database. Contact site owner!'); window.location.href=('home.php');</script>";
    }
}

?>
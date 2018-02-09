<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 04-May-17
 * Time: 10:41
 */
require("dbconnect.php");
session_start();


function Register($username,$password,$email){
    $con = mysqli_connect("localhost","root","","gshop");

    $usernm = mysqli_real_escape_string($con,$username);
    $pass = mysqli_real_escape_string($con,$password);
    $cryptPass = crypt($pass,$usernm);
    $hash = crypt($email,$usernm);

    $query='SELECT * FROM user WHERE email="'.$email.'"';
    $result=mysqli_query($con,$query);
    $rowcount=mysqli_num_rows($result);
    if($rowcount!=0)
    {
       return "The following user already exists!";
    }
    else
    {
        $sql="INSERT INTO user (username, password, email, hash) VALUES ('$usernm', '$cryptPass' , '$email', '$hash')";
        if(mysqli_query($con,$sql))
        {
            /*Conformation mail*/
            $from = "gamegear@gmail.com";
            $headers = "From:" . $from . "\n";
            $headers .= "Content-type: text/html; charset=UTF-8 \n";
            $message="Click the following link to activate your account! http://localhost/gshop/home.php?actId=$hash";
            mail($email,"Confirmation for Game Gear Store",wordwrap($message,70),$headers);

            return "You have successfully created an account. An e-mail has been sent for activating your account!";
        }
        else
        {
            return "Database connection error!";
        }
    }

}

function Confirmation($hash){
    $con = mysqli_connect("localhost","root","","gshop");
    $hashEscape = mysqli_real_escape_string($con,$hash);

    $sql = 'SELECT * FROM user WHERE hash="'.$hashEscape.'"';
    $result = mysqli_query($con,$sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount == 0)
    {
        return "Something went wrong please contact site administrator for further instructions!";
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
        if($row['active'] == 1)
        {
            return "Your account is already active!";
        }
        else
        {
            $updateActive = 'UPDATE user SET active=1 WHERE hash="'.$hashEscape.'"';
            if(mysqli_query($con,$updateActive))
            {
                $userId = $row['id'];
                $sqlCart = "INSERT INTO cart(userId) VALUES('$userId')";
                mysqli_query($con,$sqlCart);
                return "Your account has been successfully activated! You can log in now.";
            }
            else
            {
                return "Database problems try again later!";
            }
        }
    }

}

function Login($email,$password){
    $con = mysqli_connect("localhost","root","","gshop");

    $emailEscape = mysqli_real_escape_string($con,$email);
    $passwordEscape = mysqli_real_escape_string($con,$password);

    $sql = 'SELECT * FROM user WHERE email="'.$emailEscape.'"';
    $result = mysqli_query($con,$sql);
    $rowcount = mysqli_num_rows($result);
    if($rowcount == 0)
    {
        return "No such user,please sign up first!";
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
        $crypt = crypt($passwordEscape,$row["username"]);
        $usr = $row["username"];

        if($row["password"] == crypt($passwordEscape,$usr))
        {
            $_SESSION['logged']=true;
            $_SESSION['userId']=$row["id"];
            $_SESSION['email']=$emailEscape;
            return "You have successfully logged in!";
        }
        else
        {
            return "Password incorrect, please try again!";
        }
    }
}

function logout()
{
    unset($_SESSION['logged']);
    unset($_SESSION['userId']);
    session_destroy();

    return "You have been successfully logged out!";
}

/*gets how many items in cart user has*/
function getCartItemsNumber($userId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'SELECT cartproducts.productId FROM cartproducts JOIN cart ON cart.id = cartproducts.cartId WHERE cart.userId="'.$userId.'"';


    if($result = mysqli_query($con,$sql))
    {
        $numrow = mysqli_num_rows($result);

        return $numrow;
    }
    return mysqli_error($con);

}

function getLatestProduct()
{
    $con = mysqli_connect("localhost","root","","gshop");
    $sql = 'SELECT * FROM product ORDER BY dateCreated DESC';
    $result = mysqli_query($con,$sql);
    $array = array();
    while($resultArray=mysqli_fetch_assoc($result))
    {
        array_push($array,$resultArray);
    }
    if(!json_encode($array))
    {
        return json_last_error_msg();
    }
    return json_encode($array);
}

function addProduct($name,$description,$price,$url)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $nm = mysqli_real_escape_string($con,$name);
    $desc = mysqli_real_escape_string($con,$description);
    if(!is_numeric($price))
        return "The price must be numeric only!";

    $sqlCheck = 'SELECT * FROM product WHERE product.name="'.$nm.'"';
    $result = mysqli_query($con,$sqlCheck);
    $numRow = mysqli_num_rows($result);
    if($numRow>0)
        return "The product already exsists";

    $sql = "INSERT INTO product (name,description,price,img) VALUES('$nm','$desc','$price','$url')";

    if(mysqli_query($con,$sql))
        return "The product has been added";

    return mysqli_error($con);
}

function checkIfAdmin($userId)
{
    $con = mysqli_connect("localhost","root","","gshop");
    $sql = 'SELECT admin FROM user WHERE user.id="'.$userId.'"';
    $result = mysqli_query($con,$sql);
    $res = mysqli_fetch_assoc($result);
    if($res['admin']==1)
        return true;
    return false;
}

function getAllProducts()
{
    $con = mysqli_connect("localhost","root","","gshop");
    $sql = 'SELECT * FROM product';
    $result = mysqli_query($con,$sql);

    $array = array();
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($array,$row);
    }

    return json_encode($array);
}

function deleteProduct($productId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'DELETE FROM product WHERE product.id="'.$productId.'"';

    if(mysqli_query($con,$sql))
        return "Product deleted!";
    return "Error with database";
}

function updateProduct($id,$att,$val)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'UPDATE product SET '.$att.'="'.$val.'" WHERE product.id="'.$id.'"';

    if(mysqli_query($con,$sql))
        return "Product updated";
    return mysqli_error($con);
}

function reportByDate($dateFrom,$dateTo)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql='SELECT user.email AS user_email,product.name AS product_name,report.date AS date,report.profit AS profit FROM report JOIN user ON report.userId=user.id JOIN product ON report.productId=product.id WHERE report.date<"'.$dateTo.'" AND report.date>"'.$dateFrom.'"';

    $array = array();
    $result = mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result))
    {
        array_push($array,$row);
    }
    return json_encode($array);
}

function getAllUsers()
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'SELECT user.id, user.username FROM user';

    $result = mysqli_query($con,$sql);
    $array = array();

    while($row = mysqli_fetch_assoc($result))
    {
        array_push($array,$row);
    }

    return json_encode($array);
}

function reportByUser($userId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'SELECT product.name,report.date,report.profit FROM report JOIN product ON report.productId=product.id WHERE report.userId="'.$userId.'"';

    $result = mysqli_query($con,$sql);

    $array = array();

    while ($row = mysqli_fetch_assoc($result))
    {
        array_push($array,$row);
    }

    return json_encode($array);
}

function getCartItemsForUser($userId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'SELECT product.name,product.price,cartproducts.id FROM cartproducts
            JOIN cart ON cartproducts.cartId=cart.id
            JOIN product ON cartproducts.productId=product.id
            WHERE cart.userId="'.$userId.'"  
            ORDER BY product.price  DESC';

    $result = mysqli_query($con,$sql);

    $array = array();

    while ($row = mysqli_fetch_assoc($result))
    {
        array_push($array,$row);
    }

    return $array;
}

function removeFromCart($itemId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'DELETE FROM cartproducts WHERE id="'.$itemId.'"';

    if(mysqli_query($con,$sql))
    {
        return "OK";
    }

    return "NOK";
}

function addCartItem($itemId,$userId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql= 'INSERT INTO cartproducts (cartId,productId) VALUES ((SELECT cart.id FROM cart WHERE cart.userId="'.$userId.'"),"'.$itemId.'")';

    if(mysqli_query($con,$sql))
    {
        return "OK";
    }

    return "NOK";
}

function getProductDetails($productId)
{
    $con = mysqli_connect("localhost","root","","gshop");

    $sql = 'SELECT description FROM product WHERE id="'.$productId.'"';

    $result = mysqli_query($con,$sql);

    $row = mysqli_fetch_assoc($result);

    return $row["description"];
}

function getProductByBrand($brand)
{
    $con = mysqli_connect("localhost","root","","gshop");
    $sql = 'SELECT * FROM product WHERE name LIKE "%'.strtoupper($brand).'%" ORDER BY dateCreated DESC';
    $result = mysqli_query($con,$sql);
    $array = array();
    while($resultArray=mysqli_fetch_assoc($result))
    {
        array_push($array,$resultArray);
    }

    return json_encode($array);
}
?>
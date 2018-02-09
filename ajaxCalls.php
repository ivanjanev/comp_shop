<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 13-Jul-17
 * Time: 17:10
 */
require ("functions.php");

if(isset($_POST['data'])&&!empty($_POST['data']))
{
    $data = $_POST['data'];

    switch ($data){
        case "registerUser":
            echo Register($_POST['username'],$_POST['password'],$_POST['email']);
            break;
        case "loginUser":
            echo Login($_POST['email'],$_POST['password']);
            break;
        case "logoutUser":
            echo logout();
            break;
        case "latestProducts":
            echo getLatestProduct();
            break;
        case "getAllProducts":
            echo getAllProducts();
            break;
        case "deleteProduct":
            $id = $_POST['productId'];
            echo deleteProduct($id);
            break;
        case "updateProduct":
            $id = $_POST['productId'];
            $att = $_POST['attribute'];
            $val = $_POST['value'];
            echo updateProduct($id,$att,$val);
            break;
        case "reportByDate":
            $dateFrom = $_POST["dateFrom"];
            $dateTo = $_POST["dateTo"];
            echo reportByDate($dateFrom,$dateTo);
            break;
        case "getAllUsers":
            echo getAllUsers();
            break;
        case "reportByUser":
            $userId = $_POST["userId"];
            echo reportByUser($userId);
            break;
        case "removeFromCart":
            $itemId = $_POST["id"];
            echo removeFromCart($itemId);
            break;
        case "addCartItem":
            $itemId = $_POST["productId"];
            $userId = $_POST["userId"];
            echo addCartItem($itemId,$userId);
            break;
        case "ItemDetails":
            $productId = $_POST["productId"];
            echo getProductDetails($productId);
            break;
        case "getProductsByBrand":
            $brand = $_POST["brand"];
            echo getProductByBrand($brand);
            break;
    }

}
?>
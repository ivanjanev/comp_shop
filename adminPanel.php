<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 20-Jul-17
 * Time: 12:41
 */
require ("functions.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['userId'])&&!empty($_SESSION['userId']))
{
    $usrId = $_SESSION['userId'];
    if(!checkIfAdmin($usrId))
    {
        echo "<script>alert('You must be admin in order to view the page!'); window.location.href=('home.php');</script>";
    }
}
else
{
    echo "<script>alert('You must log in first!'); window.location.href=('home.php');</script>";
}

if(isset($_FILES)&&!empty($_FILES))
{
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];

    $sourcePath = $_FILES['picture']['tmp_name'];
    $targetDir="images/products/".$name.".jpeg";

    if(file_exists($targetDir))
    {
        unlink($targetDir);
    }
    if(move_uploaded_file($sourcePath,$targetDir))
    {
        $msg = addProduct($name,$desc,$price,$targetDir);
        echo $msg;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>

    <!--Bootstrap js and css along with jquery-->
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!--Custom Js-->
    <script src="js/adminPanel.js"></script>

</head>
<body style="margin-bottom: 10px;margin-top: 10px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <img src="images/datapanel-logo.png" class="img-responsive" style="margin: auto">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center uploadDiv">
                <h2>Adding a product</h2>
                <hr>
                <form action="adminPanel.php" method="post" enctype="multipart/form-data" class="form-group">
                    <label for="name">Product name: </label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <label for="description">Product description: </label>
                    <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                    <label for="price">Product price: </label>
                    <input type="number" id="price" name="price" class="form-control" required>
                    <label for="picture">Product picture: </label>
                    <input type="file" id="picture" name="picture" style="margin: auto"  required>
                    <br>
                    <input type="submit" value="Create" name="btnAddProduct" id="btnAddProduct" class="btn btn-primary">
                </form>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center uploadDiv">
                <h2>Delete a product</h2>
                <hr>
                <label for="selectProductForDelete">Select product: </label>
                <select class="form-control" id="selectProductForDelete">
                    <!--products are added dinamically-->
                </select>
                <br>
                <input type="submit" value="Delete" id="btnDeleteProduct" class="btn btn-primary">
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center uploadDiv">
                <h2>Update a product</h2>
                <hr>
                <label for="selectProductForUpdate">Select product: </label>
                <select class="form-control" id="selectProductForUpdate">
                    <!--products are added dinamically-->
                </select>
                <label for="selectAttForUpdate">Select attribute: </label>
                <select class="form-control" id="selectAttForUpdate">
                    <option value="name">Name</option>
                    <option value="description">Description</option>
                    <option value="price">Price</option>
                </select>
                <label for="valueToUpdate">Value:</label>
                <input type="text" class="form-control" id="valueToUpdate" name="valueToUpdate" required>
                <br>
                <input type="submit" value="Update" id="btnUpdateProduct" class="btn btn-primary">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center uploadDiv">
                <h2>Reports</h2>
                <hr>
                <h3>Reports By Date</h3>
                <label for="reportFromDate">From Date:</label>
                <input type="date" class="form-control" id="reportFromDate" name="reportFromDate" value="<?php echo date('Y-m-d');?>">
                <label for="reportToDate">To Date:</label>
                <input type="date" class="form-control" id="reportToDate" name="reportToDate" value="<?php echo date('Y-m-d');?>">
                <br>
                <input type="submit" value="Show Reports" id="btnShowReportsByDate" class="btn btn-primary">
                <br>
                <br>
                <h3>Reports By User</h3>
                <hr>
                <label for="selectReportByUser">Select User:</label>
                <select class="form-control" id="selectReportByUser">

                </select>
                <br>
                <input type="submit" value="Show Reports" id="btnShowReportsByUser" class="btn btn-primary">
                <br>
                <table class="table" id="reportTable">
                    <!--elements are added dinamically-->
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 10-Dec-17
 * Time: 17:18
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>

    <!--Bootstrap js and css along with jquery-->
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!--Custom css & script-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/ajaxcalls.js"></script>
    <script src="js/scripts.js"></script>

    <!--FontAwesome-->
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css">

    <!--JS Modal and CSS-->
    <script src="js/jquery.modal.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.modal.css">

</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <img src="images/logo.png" id="logo" style="cursor: pointer">
        </div>
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
        <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120717.91602026788!2d-122.09739532887222!3d37.337135089025544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb68ad0cfc739%3A0x7eb356b66bd4b50e!2sSilicon+Valley%2C+CA%2C+USA!5e0!3m2!1sen!2smk!4v1512922635495" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="col-md-offset-1 col-md-5">
            <div class="row">
                <div class="col-md-12">
                    <h3>Contact us:</h3>
                    <hr>
                    <p><i class="fa fa-phone" aria-hidden="true"></i> <b>Phone:</b> +888-8888-8888</p>
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> <b>E-mail:</b> gamegear@gmail.com</p>
                </div>
            </div>
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

</body>
</html>

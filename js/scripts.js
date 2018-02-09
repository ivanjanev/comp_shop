/**
 * Created by ivanj on 13-Jul-17.
 */
$(document).ready(function () {
    /*carousel interval time*/
    $('#myCarousel').carousel({
        interval: 3000
    });

    /*logo click relocates @ home page*/
    $('#logo').click( function () {
        window.location.href="home.php";
    });

    $("#shoppingCart").click(function () {
        window.location.href="cartPreview.php";
    });

});
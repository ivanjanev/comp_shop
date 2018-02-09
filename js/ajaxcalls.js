/**
 * Created by ivanj on 03-May-17.
 */
$(document).ready(function () {

     var url = window.location.pathname.toString();

    if(url.indexOf("home") != -1){
        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            async: false,
            data: {
                "data" : "latestProducts"
            },
            success : function (response) {
                console.log(response);
                try {
                    var array = jQuery.parseJSON(response);
                    $.each(array,function () {
                        var append = '<div class="col-md-3"> <div class="row"> <div class="col-md-10 col-md-offset-1 productPreviewBorder"> <img src="'+this.img+'" class="productPreview"> <hr> <p class="text-center"><b>'+this.name+'</b></p> <p class="text-center"><b>Price: '+this.price+'$</b></p> <a href="#" class="btn btn-default btn-block" id="d'+this.id+'"><i class="fa fa-info" aria-hidden="true"></i> Details</a> <button class="btn btn-success btn-block lnkAddToCart" id="'+this.id+'"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</button> </div> </div> </div>';
                        $("#rowOfProducts").append(append);
                    });
                }
                catch (e)
                {
                    console.log(e);
                }
            }

        });
    }



    /*closing all modals after clicking OK on response modal*/
    $('#btnResponseOK').click(function (event) {
        event.preventDefault();
        window.location.href="home.php";

    });

    /*calling modal for sign up*/
    $("#btnSignUp").click(function () {
        $("#registerForm").modal();
    });

    /*call to sign up user*/
    $("#btnRegisterUser").click(function (event) {
         event.preventDefault();

         if(emptyField($("#email").val()) && emptyField($("#password").val()) && emptyField($("#username").val()))
         {
             $.ajax({
                 url: "ajaxCalls.php",
                 type: "POST",
                 data: {
                     "data" : "registerUser",
                     "email" : $("#email").val(),
                     "password" : $("#password").val(),
                     "username" : $("#username").val()
                 },
                 success : function (response) {
                     $('#responseTag').text(response);
                     $('#responses').modal();

                 }
             });
         }
         else
         {
             alert("All fields are required!")
         }
    });

    /*calling log in modal*/
    $('#btnLogIn').click(function () {
        $('#loginForm').modal();
    });

    /*call to log in user*/
    $('#btnLogInUser').click(function (event) {
        event.preventDefault();

        var email = $('#emailLog').val();
        var pass = $('#passwordLog').val();

        if(emptyField(email) && emptyField(pass))
        {
            $.ajax({
                url: "ajaxCalls.php",
                type: "POST",
                data: {
                    "data" : "loginUser",
                    "email" :  email,
                    "password" : pass
                },
                success : function (response) {
                    $('#responseTag').text(response);
                    $('#responses').modal();

                }
            });
        }
        else
        {
            alert("All fields are required!");
        }
    });

    /*call to logout function*/
    $("#btnLogout").click(function () {
        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data" : "logoutUser"
            },
            success : function (response) {
                $('#responseTag').text(response);
                $('#responses').modal();

            }
        });
    });

    $(".btnRmvFromCart").click(function () {
        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data" : "removeFromCart",
                "id" : this.id
            },
            success : function (response) {
                if(response == "OK")
                {
                    window.location.reload();
                }
                else
                {
                    alert("Something wrong with the database,try again later!");
                }

            }
        });
    });

    $(".lnkAddToCart").click(function () {
        var id = this.id;
        var userId = $("#userId").val();
        var logged = $("#logged").val();
        if(!logged){
            alert("You must be logged in to do that!");
        }
        else
        {
            $.ajax({
                url: "ajaxCalls.php",
                type: "POST",
                data: {
                    "data" : "addCartItem",
                    "userId" : userId,
                    "productId" : id
                },
                success : function (response) {
                    if(response == "OK")
                    {
                        alert("Successfully added.");
                        $("#shoppingcartNumber").text(parseInt($("#shoppingcartNumber").text())+1);
                    }
                    else
                    {
                        alert("Something wrong with the database,try again later!");
                    }

                }
            });
        }

    });

    $(".productPreviewBorder a").click(function (event) {
        event.preventDefault();
        var id = this.id;
        id = id.split("d")[1];
        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            async: true,
            data: {
                "data" : "ItemDetails",
                "productId" : id
            },
            success : function (response) {
                $("#productDetailsTag").text(response);
                $("#productDetails").modal();
            }
        });
    });
});

function emptyField(field) {
    if(field.length > 0)
    {
        return true;
    }
    return false;
}
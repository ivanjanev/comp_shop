$(document).ready(function () {

    var brand = "";
    var url = window.location.pathname.toString();

    if(url.indexOf("asus") != -1){
        brand = "asus";
    }
    if(url.indexOf("alienware") != -1){
        brand = "alienware";
    }
    if(url.indexOf("razer") != -1){
        brand = "razer";
    }

    console.log(window.location.pathname);
    $.ajax({
        url: "ajaxCalls.php",
        type: "POST",
        async: false,
        data: {
            "data" : "getProductsByBrand",
            "brand" : brand
        },
        success : function (response) {
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
});
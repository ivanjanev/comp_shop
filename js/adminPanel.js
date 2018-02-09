/**
 * Created by ivanj on 20-Jul-17.
 */
$(document).ready(function () {

    addProductsToSelect();
    addUserToSelect();

    $('.uploadDiv form').submit(function (event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "adminPanel.php",
            type: "POST",
            data: formData,
            async: true,
            success: function (response) {
                alert(response.split('\n')[0]);
                window.location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $("#btnDeleteProduct").click(function () {
        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data" : "deleteProduct",
                "productId" : $('#selectProductForDelete').find(":selected").val()
            },
            success : function (response) {
                alert(response);
                addProductsToSelect();
            }
        });
    });

    $("#btnUpdateProduct").click(function () {
        var productId = $("#selectProductForUpdate").find(":selected").val();
        var atrribute = $("#selectAttForUpdate").find(":selected").val();
        var value = $("#valueToUpdate").val();

        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data" : "updateProduct",
                "productId" : productId,
                "attribute" : atrribute,
                "value" : value
            },
            success : function (response) {
                alert(response);
                addProductsToSelect();
            }
        });
    });
    $("#btnShowReportsByDate").click(function () {
        var dateFrom = $("#reportFromDate").val();
        var dateTo = $("#reportToDate").val();

        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data": "reportByDate",
                "dateFrom": dateFrom,
                "dateTo" : dateTo
            },
            success: function (response) {
                try{
                    var list = jQuery.parseJSON(response);
                    $("#reportTable").children().remove();
                    var appendThead = '<thead><tr><th>'+"User Email"+'</th><th>'+"Product Name"+'</th><th>'+"Date"+'</th><th>'+"Profit"+'</th></tr></thead>';
                    $("#reportTable").append(appendThead);
                    $.each(list,function () {
                        var appendTbody = '<tbody><tr><td>'+this.user_email+'</td><td>'+this.product_name+'</td><td>'+this.date+'</td><td>'+this.profit+'</td></tr></tbody>';
                        $("#reportTable").append(appendTbody);
                    });
                }
                catch (e)
                {
                    console.log(e);
                }
            }
        });
    });

    $("#btnShowReportsByUser").click(function () {
        var userId = $("#selectReportByUser").find(":selected").val();

        $.ajax({
            url: "ajaxCalls.php",
            type: "POST",
            data: {
                "data": "reportByUser",
                "userId" : userId
            },
            success: function (response) {
                try{
                    var list = jQuery.parseJSON(response);
                    $("#reportTable").children().remove();
                    var appendThead = '<thead><tr><th>'+"Product Name"+'</th><th>'+"Date"+'</th><th>'+"Profit"+'</th></tr></thead>';
                    $("#reportTable").append(appendThead);
                    $.each(list,function () {
                        var appendTbody = '<tbody><tr><td>'+this.name+'</td><td>'+this.date+'</td><td>'+this.profit+'</td></tr></tbody>';
                        $("#reportTable").append(appendTbody);
                    });
                }
                catch (e)
                {
                    console.log(e);
                }
            }
        });
    });
});

function addProductsToSelect() {
    $.ajax({
        url: "ajaxCalls.php",
        type: "POST",
        data: {
            "data" : "getAllProducts"
        },
        success : function (response) {
            try{
                var products = jQuery.parseJSON(response);
                $("#selectProductForDelete").children().remove();
                $("#selectProductForUpdate").children().remove();
                $.each(products,function () {

                    var append = '<option value="'+this.id+'">'+this.name+'</option>';
                    $("#selectProductForDelete").append(append);
                    $("#selectProductForUpdate").append(append);
                });
            }
            catch (e)
            {
                console.log(e);
            }
            console.log(response);
        }
    });
}

function addUserToSelect() {
    $.ajax({
        url: "ajaxCalls.php",
        type: "POST",
        data: {
            "data" : "getAllUsers"
        },
        success : function (response) {
            try{
                var users = jQuery.parseJSON(response);
                $("#selectReportByUser").children().remove();
                $.each(users,function () {
                    var append = '<option value="'+this.id+'">'+this.username+'</option>';
                    $("#selectReportByUser").append(append);

                });
            }
            catch (e)
            {
                console.log(e);
            }
            console.log(response);
        }
    });
}
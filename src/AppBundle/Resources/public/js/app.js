/**
 * Created by felipe on 25/11/15.
 */


function addItem (e){

    var $detalles = $("#appbundle_operation_items");
    var $index = $detalles.children().length;
    var $detalle = $detalles.attr("data-prototype").replace(/__name__/g, $index).replace(/__num__/g, $index);
    $detalles.append( $detalle);
};

function deleteItem(e){
    e.preventDefault();
    $(this).parent().parent().remove();
    $(".subtotal").trigger("keyup");

};

function style(){
    //$(".item_importe, .item_detalle").parent().addClass("form-group");
    //$(".item_importe").parent().addClass("form-group")
    $("li .form-group").css("float", "left");
    $("li .form-group:first-of-type").css("clear", "left");
    $(".item_importe").parent().addClass("col-lg-3");
    $(".item_bienes").parent().addClass("col-lg-4");
    $("ul li").css("list-style-type", "none");

}
jQuery(document).ready(function () {

    $("body").delegate("#addItem", "click", addItem);
    $("body").delegate(".delete_item", "click", deleteItem);
    //$("body").delegate("#addItem", "click", style);


    var path = window.location.pathname;

    var pos = path.search(/sale\/new|purchase\/new/);
    if (pos > 0) {
        $("#addItem").trigger("click");
    }



    $("body").delegate("#goBack", "click", function (e){
        var path = window.location.pathname;
        var pos = path.search(/\/new/);
        var newPath ;
        if (pos > 0) {
            newPath = path.replace(/\/new/, '');
            location.href=newPath;
            return;
        }
        pos = path.search(/\/\d+\/edit/);
        if (pos > 0) {
            newPath = path.replace(/\/\d+\/edit/, '');
            location.href=newPath;
            return;
        }

        pos = path.search(/\/edit/);
        if (pos > 0) {
            newPath = path.replace(/\/edit/, '');
            location.href=newPath;
            return;
        }
        pos = path.search(/\/change-password/);
        if (pos > 0) {
            newPath = path.replace(/\/change-password/, '');
            location.href=newPath;
            return;
        }

            newPath = path.replace(/\d+$/, '');
            location.href=newPath;
            return;

    });

    $("body").delegate("#newEntity", "click", function (e){
        var path = window.location.pathname;
        var newPath = path + "new" ;
        location.href=newPath;
        return;
    });

    $("body").delegate("#changePassword", "click", function (e){
        var path = window.location.pathname;
        path = path.replace(/\/edit/, '');

        var newPath = path + "/change-password" ;
        location.href=newPath;
        return;
    });

    $("body").delegate("#editEntity", "click", function (e){
        var path = window.location.pathname;
        var newPath = path + "/edit" ;
        location.href=newPath;
        return;
    });


    $("body").delegate("#saveEntity", "click", function (e){
        $("button[name='appbundle_category[submit]'], button[name='appbundle_person[submit]'], button[name='appbundle_product[submit]'],  button[name='appbundle_operation[submit]'] ,button[name='appbundle_user[submit]'], button[name='appbundle_tax[submit]'], button[name='appbundle_business[submit]']").click();
    });

    $("body").delegate("#deleteEntity", "click", function (e){
        $("button[name='form[submit]']").click();
    });

    $("body").delegate("#deleteOperation", "click", function (e){
        $("button[name='form[submit]']").click();
    });


    pos = path.search(/sale\/new|sale\/\d+\/edit/);
    if (pos > 0) {
        $("body").delegate(".qty", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var priceName = elementName.replace('qty', 'price');
            var taxName = elementName.replace('qty', 'tax');
            var discountName = elementName.replace('qty', 'discount');
            var subtotalName = elementName.replace('qty', 'subtotal');


            var priceElement = $("input[name='" + priceName + "']");
            var taxElement = $("input[name='" + taxName + "']");
            var discountElement = $("input[name='" + discountName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var qty = parseFloat( element.val() );
            var tax = parseFloat( taxElement.val() );
            var discount = parseFloat( discountElement.val() );
            var price = parseFloat( priceElement.val() );

            var taxValue = tax * price * qty ;
            var subSubtotal = qty * price;
            var subtotal = subSubtotal + taxValue;

            var discountAmount = discount * subtotal;
            if( ! isNaN(discountAmount)) {
                subtotal = subtotal - discountAmount;
            }
            subtotalElement.val(subtotal.toFixed(2));


        });
        $("body").delegate(".price", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var qtyName = elementName.replace('price', 'qty');
            var subtotalName = elementName.replace('price', 'subtotal');


            var qtyElement = $("input[name='" + qtyName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var price = parseFloat( element.val() );
            var qty = parseFloat( qtyElement.val() );

            if(isNaN(qty ))
                return;
            subtotalElement.val((qty * price).toFixed(2));


        });


        $("body").delegate(".discount, .tax", "keyup",  function (){

            $(".qty").trigger("keyup");

        });

        $("body").delegate(".subtotal", "keyup",  function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var qtyName = elementName.replace('subtotal', 'qty');
            var priceName = elementName.replace('subtotal', 'price');


            var qtyElement = $("input[name='" + qtyName + "']");
            var priceElement = $("input[name='" + priceName + "']");

            var subtotal = parseFloat( element.val() );
            var price = parseFloat( priceElement.val() );


            qtyElement.val((subtotal / price).toFixed(2));


        });

        $("body").delegate(".imgPreviewLink", "click", function () {
            if(jQuery(this).next().css("display") === "none") {
                jQuery(this).next().css("display", "block");
            }
            else{
               jQuery(this).next().css("display", "none");
            }
        });

        $("body").delegate(".product", "change", function () {

            var id = parseInt(jQuery(this).find("option:selected").attr("value"));

            var productName = (jQuery(this).attr("name"));
            var priceName = productName.replace("product", "price");
            var taxName = productName.replace("product", "tax");
            var discountName = productName.replace("product", "discount");


            var regex = new RegExp(/\d/);
            var number = regex.exec(productName)[0];

            if(isNaN(id ))
                return;
            $.get(Routing.generate('product_get',  { id: id }), function (data, status) {
                $("input[name='" + priceName + "']").val(data.price);
                $("input[name='" + taxName + "']").val(data.category.tax.value);
                $("input[name='" + discountName + "']").val(0);

                var selector = "#imgPreview" + number;
                if( data.image != undefined ){
                    $(selector).attr("src", '/images/' + data.image);
                }

            });

        });

        $("body").delegate(".qty,.cost,.subtotal,.discount", "keyup", function (e){
            var sum = 0;
            $(".subtotal").each(function () {
                if (!isNaN(this.value) && this.value.length !== 0) {
                    sum += parseFloat(this.value);
                }
            });
            $(".total").val(sum.toFixed(2));
        });
    }

    var pos = path.search(/purchase\/new|purchase\/\d+\/edit/);
    if (pos > 0) {

        $("body").delegate(".qty", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var priceName = elementName.replace('qty', 'cost');
            var taxName = elementName.replace('qty', 'tax');
            var discountName = elementName.replace('qty', 'discount');
            var subtotalName = elementName.replace('qty', 'subtotal');


            var priceElement = $("input[name='" + priceName + "']");
            var taxElement = $("input[name='" + taxName + "']");
            var discountElement = $("input[name='" + discountName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var qty = parseFloat( element.val() );
            var tax = parseFloat( taxElement.val() );
            var discount = parseFloat( discountElement.val() );
            var price = parseFloat( priceElement.val() );

            var taxValue = tax * price * qty ;
            var subSubtotal = qty * price;
            var subtotal = subSubtotal + taxValue;

            var discountAmount = discount * subtotal;
            if( ! isNaN(discountAmount)) {
                subtotal = subtotal - discountAmount;
            }
            subtotalElement.val(subtotal.toFixed(2));


        });
        $("body").delegate(".cost", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var qtyName = elementName.replace('cost', 'qty');
            var subtotalName = elementName.replace('cost', 'subtotal');


            var qtyElement = $("input[name='" + qtyName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var price = parseFloat( element.val() );
            var qty = parseFloat( qtyElement.val() );

            if(isNaN(qty ))
                return;
            subtotalElement.val((qty * price).toFixed(2));


        });


        $("body").delegate(".discount, .tax", "keyup",  function (){

            $(".qty").trigger("keyup");

        });

        $("body").delegate(".subtotal", "keyup",  function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var qtyName = elementName.replace('subtotal', 'qty');
            var priceName = elementName.replace('subtotal', 'cost');


            var qtyElement = $("input[name='" + qtyName + "']");
            var priceElement = $("input[name='" + priceName + "']");

            var subtotal = parseFloat( element.val() );
            var price = parseFloat( priceElement.val() );


            qtyElement.val((subtotal / price).toFixed(2));


        });

        $("body").delegate(".product", "change", function () {

            var id = parseInt(jQuery(this).find("option:selected").attr("value"));

            var productName = (jQuery(this).attr("name"));
            var costName = productName.replace("product", "cost");
            var taxName = productName.replace("product", "tax");
            var discountName = productName.replace("product", "discount");
            if(isNaN(id ))
                return;
            $.get(Routing.generate('product_get',  { id: id }), function (data, status) {
                $("input[name='" + costName + "']").val(data.cost);
                $("input[name='" + taxName + "']").val(data.category.tax.value);
                $("input[name='" + discountName + "']").val(0);


            });

        });

        $("body").delegate(".qty,.cost,.subtotal", "keyup", function (e){
            var sum = 0;
            $(".subtotal").each(function () {
                if (!isNaN(this.value) && this.value.length !== 0) {
                    sum += parseFloat(this.value);
                }
            });
            $(".total").val(sum.toFixed(2));
        });
    }






});

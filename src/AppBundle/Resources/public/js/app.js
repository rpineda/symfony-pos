/**
 * Created by felipe on 25/11/15.
 */


function addItem (e){

    var $detalles = $("ul.items");
    var $index = $detalles.data('index') || 0;
    var $detalle = $detalles.attr("data-prototype").replace(/__name__/g, $index );
    var $li = $('<li></li>').append($detalle);
    var $removeFormA = $('<div class="form-group"><a href="#" class="delete_item"> <span  class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a></div>');
    $li.children().append($removeFormA);
    $detalles.append( $li);

    $detalles.data('index', $index + 1);
};

function deleteItem(e){
    e.preventDefault();
    $(this).parent().parent().remove();
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

    $("#addItem").trigger("click");
    var path = window.location.pathname;

    var pos = path.search(/sale\/new/);
    if (pos > 0) {
        $("body").delegate(".qty", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var priceName = elementName.replace('qty', 'price');
            var subtotalName = elementName.replace('qty', 'subtotal');


            var priceElement = $("input[name='" + priceName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var qty = parseFloat( element.val() );
            var price = parseFloat( priceElement.val() );


            subtotalElement.val((qty * price).toFixed(2));


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


            subtotalElement.val((qty * price).toFixed(2));


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

        $("body").delegate(".product", "change", function () {

            var id = parseInt(jQuery(this).find("option:selected").attr("value"));

            var productName = (jQuery(this).attr("name"));
            var priceName = productName.replace("product", "price");

            if(isNaN(id ))
                return;
            $.get("app_dev.php/product/api/" + id, function (data, status) {
                $("input[name='" + priceName + "']").val(data.price);


            });

        });

        $("body").delegate(".qty,.cost,.subtotal", "change", function (e){
            var sum = 0;
            $(".subtotal").each(function () {
                if (!isNaN(this.value) && this.value.length !== 0) {
                    sum += parseFloat(this.value);
                }
            });
            $(".total").val(sum.toFixed(2));
        });
    }

    var pos = path.search(/purchase\/new/);
    if (pos > 0) {

        $("body").delegate(".qty", "keyup", function (){
            var element = jQuery(this);


            var elementName = element.attr("name");
            var priceName = elementName.replace('qty', 'cost');
            var subtotalName = elementName.replace('qty', 'subtotal');


            var priceElement = $("input[name='" + priceName + "']");
            var subtotalElement = $("input[name='" + subtotalName + "']");

            var qty = parseFloat( element.val() );
            var price = parseFloat( priceElement.val() );


            subtotalElement.val((qty * price).toFixed(2));


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


            subtotalElement.val((qty * price).toFixed(2));


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

            if(isNaN(id ))
                return;
            $.get("app_dev.php/product/api/" + id, function (data, status) {
                $("input[name='" + costName + "']").val(data.cost);


            });

        });

        $("body").delegate(".qty,.cost,.subtotal", "change", function (e){
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
// JavaScript Document
// --Scroll Back to Top //
$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
});
// Scroll Back to Top-- // 

// --Portfolio Item //
$(document).ready(function() {
    var quantity = 1;

    $('.quantity-right-plus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        $('#quantity').val(quantity + 1);
    });

    $('.quantity-left-minus').click(function(e) {
        e.preventDefault();
        var quantity = parseInt($('#quantity').val());
        if (quantity > 1) {
            $('#quantity').val(quantity - 1);
        }
    });

});
// Portfolio Item-- //

// --Shopping Cart //
$(document).ready(function() {

    /* Set rates + misc */
    var taxRate = $("#vat_percentage").val() / 100;
    var serviceRate = $("#service_fee").val();
    var fadeTime = 300;

    /* Assign actions */
    $('.product-quantity input').change(function() {
        updateQuantity(this);
    });

    $('.product-removal button').click(function() {
        removeItem(this);
    });

    /* Recalculate cart */
    function recalculateCart() {

        var subtotal = 0;

        /* Sum up row totals */
        $('.product').each(function() {
            subtotal += parseFloat($(this).children('.product-line-price').text());
        });

        /* Calculate totals */
        
        var shipping = (subtotal > 0 ? serviceRate : 0);
        shipping = parseInt(shipping);
        var total = subtotal  + shipping;
        var tax = total * taxRate;

        var grand = total - tax;





        /* Update totals display */
        $('.totals-value').fadeOut(fadeTime, function()  {
            $('#cart-subtotal').html(subtotal.toFixed(2).replace(".", ","));
            $('#cart-vat').html(tax.toFixed(2).replace(".", ","));
            $('#cart-total').html(total.toFixed(2).replace(".", ","));
            
            document.getElementById('cart-total1').value = total;
            
            $('#cart-grandtotal').html(grand.toFixed(2).replace(".", ","));
            if (total == 0) {
                $('.checkout').fadeOut(fadeTime);
            } else {
                $('.checkout').fadeIn(fadeTime);
            }
            
            $('.totals-value').fadeIn(fadeTime);

            $('#total_payment').html(total.toFixed(2).replace(".", ","));
            $('#total_payment1').val(total);
        });


    }

    /* Update quantity */
    function updateQuantity(quantityInput) {
        /* Calculate line price */
        var productRow = $(quantityInput).parent().parent();
        var price = parseFloat(productRow.children('.product-price').text());
        var quantity = $(quantityInput).val();
        var linePrice = price * quantity;

        /* Update line price display and recalc cart totals */
        productRow.children('.product-line-price').each(function() {
            $(this).fadeOut(fadeTime, function() {
                $(this).text(linePrice.toFixed(2).replace(".", ","));
                recalculateCart();
                $(this).fadeIn(fadeTime);
            });
        });
    }

    /* Remove item from cart */
    function removeItem(removeButton) {

        var value = $(removeButton).parent().attr('data-id');



        var subs = $('[data-main='+value+']').parent();

       
        /* Remove row from DOM and recalc cart total */
        var productRow = $(removeButton).parent().parent();
        productRow.slideUp(fadeTime, function() {
            productRow.remove();
            subs.remove();
            recalculateCart();
        });
    }

});
// Shopping Cart-- //
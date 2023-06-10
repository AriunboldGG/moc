jQuery(document).ready(function($) {
    "use strict";
    $(window).trigger('tw-wc-cart-total');
    jQuery(document).ajaxComplete(function() {
        $(window).trigger('tw-wc-cart-sync');
    });
});

jQuery(window).on('tw-wc-cart-sync',function () {
    "use strict";
    var $ = jQuery;
    var $cart=$('.cart-btn-widget');
    if($cart.length&&!$cart.hasClass('loading')){
        $cart.addClass('loading');
        $.ajax({
            type: "POST",
            url: window.location,
            success: function (response) {
                var $cartNew=jQuery(response).find('.cart-btn-widget');
                if($cartNew.length){
                    $cart.html($cartNew.first().html());
                    $(window).trigger('tw-wc-cart-total');
                }
                $cart.removeClass('loading');
            }
        });
    }
});
jQuery(window).on('tw-wc-cart-total',function () {
    "use strict";
    var $ = jQuery;
    var $cart=$('.cart-btn-widget');
    $cart.each(function(){
        var $cartBtn=$('>i>span',$(this).prev('.cart-btn'));
        var $cartQuantity=$('.cart-row .quantity',$(this));
        var $total=0;
        $cartQuantity.each(function(){
            var $crQnt=$(this).clone();
            if($('span',$crQnt).length){
                $('span',$crQnt).remove();
            }
            $total += parseInt($crQnt.text().replace(' × ', ''), 10);
        });
        if($total&&$cartBtn.length){
            $cartBtn.text($total).removeClass('hidden');
        }else{
            $cartBtn.addClass('hidden');
        }
    });
});
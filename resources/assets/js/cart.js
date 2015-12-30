(function( cart, $, undefined ) {
    var apiEndpoint = '/api/v1/cart';

    cart.add = function (productId, quantity) {
        console.log("Adding to cart");
        $.ajax({
            type: 'POST',
            url: apiEndpoint,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                'id': productId,
                'qty': quantity
            },
            success: updateMiniCart,
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                swal(err.message, null, "error");
            }
        });
    };

    cart.update = function(rowId, quantity) {
        $.ajax({
            type: 'PATCH',
            url: apiEndpoint + '/' + rowId,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                'qty': quantity
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    cart.delete = function(rowId) {
        console.log("Deleting", rowId);
        $.ajax({
            type: 'DELETE',
            url: apiEndpoint + '/' + rowId,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
            success: updateMiniCart,
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                alert(err.message);
            }
        });
    };

    cart.addToCartAnimation = function($productImage) {
        var $cartTarget = $('.navbar .cart-icon:visible').eq(0);

        if($productImage) {
            var $imgClone = $productImage.clone().offset({
                top: $productImage.offset().top,
                left: $productImage.offset().left
            }).css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            }).appendTo($('body')).animate({
                'top': $cartTarget.offset().top + 10,
                'left': $cartTarget.offset().left + 10,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            $imgClone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        }
    };

    function updateMiniCart() {
        $.pjax.reload('#mini-cart-container', {timeout: 1500}).done(function() {
            var subtotal = $('#cart-subtotal').text();
            $('.cart-subtotal').text(subtotal);
        });
    }
}( window.cart = window.cart || {}, jQuery ));
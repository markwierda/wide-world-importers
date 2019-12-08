$(document).ready(function () {
    let cartQuantity = $('.cartQuantity');

    cartQuantity.on('change', function() {
        updateCart(cartQuantity)
    });
});

function updateCart(cartQuantity) {
    let data = {'quantity': cartQuantity.val(), id: cartQuantity.attr('id')};

    $.ajax({
        type: 'POST',
        url: 'api/updateQuantity.php',
        data: data,
        success: function(response) {
            let product = response.product;
            let endPrice = response.endPrice;

            console.log($('#total' + cartQuantity.attr('id')).html('&euro;' + product['total']));

            $('#endPrice').html('<b>Total price excl</b><br />&euro;' + endPrice['EXCL'] + '<br />' +
                '<b>Tax</b><br />&euro;' + endPrice['TAX'] + '<br />\n' +
                '<b>Total price incl</b><br />&euro;' + endPrice['INCL'] + '<br /><br />\n' +
                '<a href="#" class="btn btn-success">Checkout</a>');
        }
    });
}

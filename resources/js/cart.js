$(document).ready(function () {
    let cartQuantity = $('.cartQuantity');

    cartQuantity.on('change', function() {
        let value = Number(this.value);
        let max = Number(this.max);

        this.value = Math.floor(value);

        if (value > max) {
            let cartAlert = $('#cartAlert');
            
            cartAlert.html('<span><b>' + this.dataset.title + '</b> has only <b>' + max + '</b> items left in stock</span>' +
                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
            cartAlert.removeClass('d-none');

            this.value = max;
        }

        if (value < 1)
            this.value = 1;

        updateCart(this)
    });
});

function updateCart(element) {
    let data = {'quantity': element.value, id: element.id};

    $.ajax({
        type: 'POST',
        url: 'api/updateQuantity.php',
        data: data,
        success: function(response) {
            let product = response.product;
            let endPrice = response.endPrice;

            $('#total' + data.id).html('&euro;' + product['total']);

            $('#endPrice').html('<b>Total price excl</b><br />&euro;' + endPrice['EXCL'] + '<br />' +
                '<b>Tax</b><br />&euro;' + endPrice['TAX'] + '<br />\n' +
                '<b>Total price incl</b><br />&euro;' + endPrice['INCL'] + '<br /><br />\n' +
                '<a href="#" class="btn btn-success">Checkout</a>');
        }
    });
}

function addToCart(id)
{
	var amount = $('#amount_'+id).val();
	var prod_id = $('#prod_'+id).val();
	var price   = Number($.trim($('#price_'+id).html()));
	
	$.ajax({
		url: '//www.ecommerce.com/cart/addToCart/'+prod_id+'/'+amount+'/'+price,
		success: function(data)
		{
			$('#cart_nav').html('Cart('+data+')');
		}
	});
}

function updateQty(id)
{
	var amount = $('#amount_'+id).val();
	var prod_id = $('#prod_'+id).val();
	var price   = $('#price_'+id).html();
	
	$.ajax({
		url: 'cart/updateQty/'+prod_id+'/'+amount+'/'+price,
		success: function(data)
		{
			if(data != 0)
			{
				$('#cart_nav').html('Cart('+data+')');
			}
			else
			{
				$('#cart_nav').html('Cart');
			}

			if(amount == 0)
			{
				$('#item_'+id).remove();

				if($('.item').length == 0)
				{
					$('#cart_div').html('<p>Looks like you don\'t have anything in your cart</p>');
				}
			}

		}
	});
}

function changeShipping()
{
    var same = $('#chkbox_same_as_billing');
    
    if($(same).is(':checked'))
    {
        $('input[name=shipping_first_name]').val($('input[name=billing_first_name]').val());
        $('input[name=shipping_last_name]').val($('input[name=billing_last_name]').val());
        $('input[name=shipping_address_1]').val($('input[name=billing_address_1]').val());
        $('input[name=shipping_address_2]').val($('input[name=billing_address_2]').val());
        $('input[name=shipping_city]').val($('input[name=billing_city]').val());
        $('select[name=shipping_state]').val($('select[name=billing_state]').val());
        $('select[name=shipping_country]').val($('select[name=billing_country]').val());
        $('input[name=shipping_zip_code]').val($('input[name=billing_zip_code]').val());
    }
}
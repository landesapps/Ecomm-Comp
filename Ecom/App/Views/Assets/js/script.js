function addToCart(id)
{
	var amount = $('#amount_'+id).val();
	var prod_id = $('#prod_'+id).val();
	$.ajax({
		url: '//ecommerce.com/cart/addToCart/'+prod_id+'/'+amount,
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
	$.ajax({
		url: 'cart/updateQty/'+prod_id+'/'+amount,
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
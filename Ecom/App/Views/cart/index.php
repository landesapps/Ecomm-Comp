<div id="cart_div">
<?php if(isset($_SESSION['cart']) and !empty($items)) : ?>
<table>
		<?php foreach($items as $item) : ?>
			<tr class="item" id="item_<?php echo $item['id']; ?>">
				<td><img src="<?php echo $item['location']; ?>" alt="<?php echo $item['name'].' image'; ?>"/></td>
				<td class="desc">
					<div class="name">
						<?php echo $item['name']; ?>
					</div>
					<div class="small-desc">
						<?php echo $item['desc']; ?>
					</div>
				</td>
				<td class="price">
					<?php echo $item['price']; ?>
				</td>
				<td class="checkout">
					<input type="text" value="<?php echo $_SESSION['cart'][$item['id']]['qty']; ?>" id="amount_<?php echo $item['id']; ?>" />
					<input type="hidden" value="<?php echo $item['id']; ?>" id="prod_<?php echo $item['id']; ?>" />
					<button onClick="updateQty(<?php echo $item['id']; ?>);">Update Qty</button>
				</td>
			</tr>
		<?php endforeach; ?>
</table>
<button onClick="window.location='cart/customer';">Continue</button>
<?php else : ?>
<p>Looks like you don't have anything in your cart</p>
<?php endif; ?>
</div>

<div id="cart_div">
	<table>
		<?php if(!empty($items)) : ?>
			<?php foreach($items as $item) : ?>
				<tr class="item">
					<td><img src="<?php echo $item['location']; ?>" alt="<?php echo $item['name'].' image'; ?>"/></td>
					<td class="desc">
						<div class="name">
							<a href="//<?php echo $_SERVER['HTTP_HOST'].'/product/index/'.$item['id']; ?>"<?php echo $item['name']; ?>
						</div>
						<div class="small-desc">
							<?php echo $item['desc']; ?>
						</div>
					</td>
					<td class="price">
						<?php echo $item['price']; ?>
					</td>
					<td class="checkout">
						<input type="text" value="1" id="amount_<?php echo $item['id']; ?>" />
						<input type="hidden" value="<?php echo $item['id']; ?>" id="prod_<?php echo $item['id']; ?>" />
						<button onClick="addToCart(<?php echo $item['id']; ?>);">Add To Cart</button>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
				<p>Sorry, there doesn't appear to be anything here</p>
		<?php endif; ?>
	</table>
</div>
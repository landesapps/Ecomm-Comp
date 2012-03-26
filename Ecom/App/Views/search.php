<div id="cart_div">
		<?php if(!empty($items)) : ?>
		<table>
			<?php foreach($items as $item) : ?>
				<tr class="item">
					<td><img src="<?php echo $item['location']; ?>" alt="<?php echo $item['name'].' image'; ?>"/></td>
					<td class="desc">
						<div class="name">
							<a href="//<?php echo $_SERVER['HTTP_HOST'].'/product/index/'.$item['id']; ?>"><?php echo $item['name']; ?></a>
						</div>
						<div class="small-desc">
							<?php echo $item['desc']; ?>
						</div>
					</td>
					<td class="price" id="price_<?php echo $item['prod_id']; ?>">
						<?php echo $item['price']; ?>
					</td>
					<td class="checkout">
						<input type="text" value="1" id="amount_<?php echo $item['prod_id']; ?>" />
						<input type="hidden" value="<?php echo $item['prod_id']; ?>" id="prod_<?php echo $item['prod_id']; ?>" />
						<button onClick="addToCart(<?php echo $item['prod_id']; ?>);">Add To Cart</button>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php else : ?>
				<p>Sorry, there doesn't appear to be anything here</p>
		<?php endif; ?>
</div>
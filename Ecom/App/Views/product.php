<div>
	<div class="left">
		<img src="//<?php echo $_SERVER['HTTP_HOST'].'/'.$location; ?>" alt="<?php echo $name.' image'; ?>"/>
	</div>
	<div class="left">
		<div class="name">
			<?php echo $name; ?>
		</div>
		<div class="small-desc">
			<?php echo $desc; ?>
		</div>
		<div class="long-desc">
			<?php echo $long_desc; ?>
		</div>
	</div>
	<div class="left">
		<?php echo $price; ?>
		<input type="text" value="1" class="quantity" id="amount_<?php echo $id; ?>" />
		<input type="hidden" value="<?php echo $id; ?>" id="prod_<?php echo $id; ?>" />
		<button onClick="addToCart(<?php echo $id; ?>);">Add To Cart</button>
	</div>
	<div class="clr"></div>
</div>

<form method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>/account/updateCustomer">
	<table>
		<thead>
			<tr>
				<th colspan="2">Billing Address</th>
				<th colspan="2">Shipping Address<br/><input type="checkbox" id="chkbox_same_as_billing" onclick="changeShipping();" /><label>Same as billing</label></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>First Name:</td>
				<td><input type="text" value="<?php echo (isset($billing['first_name'])) ? $billing['first_name'] : ''; ?>" name="billing_first_name" tabindex="1" /></td>
				<td>First Name:</td>
				<td><input type="text" value="<?php echo (isset($shipping['first_name'])) ? $shipping['first_name'] : ''; ?>" name="shipping_first_name" tabindex="9" /></td>
			</tr>
			<tr>
				<td>Last Name:</td>
				<td><input type="text" value="<?php echo (isset($billing['last_name'])) ? $billing['last_name'] : ''; ?>" name="billing_last_name" tabindex="2" /></td>
				<td>Last Name:</td>
				<td><input type="text" value="<?php echo (isset($shipping['last_name'])) ? $shipping['last_name'] : ''; ?>" name="shipping_last_name" tabindex="10" /></td>
			</tr>
			<tr>
				<td>Address Line 1:</td>
				<td><input type="text" value="<?php echo (isset($billing['address_1'])) ? $billing['address_1'] : ''; ?>" name="billing_address_1" tabindex="3" /></td>
				<td>Address Line 1:</td>
				<td><input type="text" value="<?php echo (isset($shipping['address_1'])) ? $shipping['address_1'] : ''; ?>" name="shipping_address_1" tabindex="11" /></td>
			</tr>
			<tr>
				<td>Address Line 2:</td>
				<td><input type="text" value="<?php echo (isset($billing['address_2'])) ? $billing['address_2'] : ''; ?>" name="billing_address_2" tabindex="4" /></td>
				<td>Address Line 2:</td>
				<td><input type="text" value="<?php echo (isset($shipping['address_2'])) ? $shipping['address_2'] : ''; ?>" name="shipping_address_2" tabindex="12" /></td>
			</tr>
			<tr>
				<td>City:</td>
				<td><input type="text" value="<?php echo (isset($billing['city'])) ? $billing['city'] : ''; ?>" name="billing_city" tabindex="5" /></td>
				<td>City:</td>
				<td><input type="text" value="<?php echo (isset($shipping['city'])) ? $shipping['city'] : ''; ?>" name="shipping_city" tabindex="13" /></td>
			</tr>
			<tr>
				<td>State:</td>
				<td>
					<select name="billing_state" tabindex="6" >
						<?php foreach($states as $state) : ?>
							<option <?php echo (isset($billing['state']) and $billing['state'] == $state) ? 'selected="selected"' : '' ?>><?php echo $state; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>State:</td>
				<td>
					<select name="shipping_state" tabindex="14" >
						<?php foreach($states as $state) : ?>
							<option <?php echo (isset($shipping['state']) and $shipping['state'] == $state) ? 'selected="selected"' : '' ?>><?php echo $state; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Country:</td>
				<td>
					<select name="billing_country" tabindex="7" >
						<?php foreach($countries as $country) : ?>
							<option <?php echo (isset($billing['country']) and $billing['country'] == $country) ? 'selected="selected"' : '' ?>><?php echo $country; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
				<td>Country:</td>
				<td>
					<select name="shipping_country" tabindex="15" >
						<?php foreach($countries as $country) : ?>
							<option <?php echo (isset($shipping['country']) and $shipping['country'] == $country) ? 'selected="selected"' : '' ?>><?php echo $country; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Zip Code:</td>
				<td><input type="text" value="<?php echo (isset($billing['zip_code'])) ? $billing['zip_code'] : ''; ?>" name="billing_zip_code" tabindex="8" /></td>
				<td>Zip Code:</td>
				<td><input type="text" value="<?php echo (isset($shipping['zip_code'])) ? $shipping['zip_code'] : ''; ?>" name="shipping_zip_code" tabindex="16" /></td>
			</tr>
		</tbody>
	</table>
	<div>
		<input type="hidden" value="<?php echo (isset($continue) ? $continue : '' ); ?>" name="continue" />
		<input type="submit" value="Update Account" tabindex="17" />
	</div>
</form>
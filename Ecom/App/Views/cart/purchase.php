<div>
	<?php if(!empty($error)) : ?>
	<div class="error">
		<?php echo $error; ?>
	</div>
	<?php endif; ?>
    <form method="post" action="//<?php echo $_SERVER['HTTP_HOST']; ?>/cart/purchase">
        <table>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="first_name" /></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="last_name" /></td>
            </tr>
            <tr>
                <td>Card Type:</td>
                <td>
					<select name="card_type">
						<option value="Visa">Visa</option>
						<option value="Discover">Discover</option>
						<option value="Amex">American Express</option>
						<option value="MasterCard">MasterCard</option>
					</select>
				</td>
            </tr>
            <tr>
                <td>Card Number:</td>
                <td><input type="text" name="card_num" /></td>
            </tr>
            <tr>
                <td>CVV:</td>
                <td><input type="text" name="card_cvv" /></td>
            </tr>
            <tr>
                <td>Expiration Month:</td>
                <td>
                    <select name="exp_month">
                        <option value="1">01 - January</option>
                        <option value="2">02 - February</option>
                        <option value="3">03 - March</option>
                        <option value="4">04 - April</option>
                        <option value="5">05 - May</option>
                        <option value="6">06 - June</option>
                        <option value="7">07 - July</option>
                        <option value="8">08 - August</option>
                        <option value="9">09 - September</option>
                        <option value="10">10 - October</option>
                        <option value="11">11 - November</option>
                        <option value="12">12 - December</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Expiration Year:</td>
                <td>
                    <select name="exp_year">
                        <?php for($iter = 0, $year = date('Y'); $iter < 10; $iter++) : ?>
                        <option value="<?php echo $iter + $year; ?>"><?php echo $iter + $year; ?></option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="Purchase" />
    </form>
</div>
<div id="login_div">
	<?php if(!empty($error)) : ?>
	<div class="error">
		<?php echo $error; ?>
	</div>
	<?php endif; ?>
	<form method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>/account/loginValidation" class="login">
		<table>
			<thead>
				<tr>
					<th colspan="2">Login</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>Email address:</label></td>
					<td><input type="text" name="email"/></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" name="pass"/></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit">Submit</button></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="return" value="<?php echo $continue; ?>" />
	</form>
	<form method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>/account/signup" class="login">
		<table>
			<thead>
				<tr>
					<th colspan="2">Sign-Up</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>Email address:</label></td>
					<td><input type="text" name="email"/></td>
				</tr>
				<tr>
					<td><label>Password</label></td>
					<td><input type="password" name="pass"/></td>
				</tr>
				<tr>
					<td><label>Retype Password</label></td>
					<td><input type="password" name="pass2"/></td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit">Submit</button></td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" name="return" value="<?php echo $continue; ?>" />
	</form>
</div>
<div class="clr"></div>
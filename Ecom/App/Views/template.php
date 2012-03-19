<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/assets/index/css/styles.css"/>
		<link href='http://fonts.googleapis.com/css?family=Seaweed+Script' rel='stylesheet' type='text/css'/>
        <title>Ecommerce</title>
    </head>
    <body>
		<header>
			<p>Shinin Enterprise</p>
		</header>
		<nav id="main-nav">
			<ul>
				<li>
					<a href="/home">
						<div id="home_nav" <?php echo (isset($selected) and $selected == 'home') ? 'class="selected"' : ''; ?>>Home</div>
					</a>
				</li>
				<li>
					<a href="/manga">
						<div id="manga_nav" <?php echo (isset($selected) and $selected == 'manga') ? 'class="selected"' : ''; ?>>Manga</div>
					</a>
				</li>
				<li>
					<a href="/anime">
						<div id="anime_nav" <?php echo (isset($selected) and $selected == 'anime') ? 'class="selected"' : ''; ?>>Anime</div>
					</a>
				</li>
				<li>
					<a href="/random">
						<div id="random_nav" <?php echo (isset($selected) and $selected == 'random') ? 'class="selected"' : ''; ?>>Random</div>
					</a>
				</li>
				<li>
					<a href="/account">
						<div id="account_nav" <?php echo (isset($selected) and $selected == 'account') ? 'class="selected"' : ''; ?>>Account</div>
					</a>
				</li>
				<li>
					<a href="/cart">
						<div id="cart_nav"
							<?php echo (isset($selected) and $selected == 'cart') ? 'class="selected"' : ''; ?>>
							Cart<?php echo (isset($_SESSION['cart']) and $_SESSION['cart_qty'] > 0) ? '('.$_SESSION['cart_qty'].')' : ''; ?>
						</div>
					</a>
				</li>
			</ul>
		</nav>
		<section>
			<?php echo $content; ?>
		</section>
		<footer>
			<script src="/assets/index/js/script.js"></script>
			<script src="/assets/index/js/jquery-1.7.1.min.js"></script>
		</footer>
    </body>
</html>
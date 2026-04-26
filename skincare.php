<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dillons Pharmacy | Skin Care</title>
	<style>
		:root {
			--bg: #f3f8f4;
			--primary: #1f6f4a;
			--primary-dark: #154e34;
			--accent: #f2b84b;
			--text: #1d2a22;
			--white: #ffffff;
			--shadow: 0 8px 24px rgba(24, 53, 39, 0.15);
		}

		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
			background: radial-gradient(circle at top left, #e9f4ec 0%, var(--bg) 60%);
			color: var(--text);
			min-height: 100vh;
		}

		header {
			position: sticky;
			top: 0;
			z-index: 100;
			background: var(--white);
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
			padding: 14px 18px;
		}

		.top-bar {
			max-width: 1100px;
			margin: 0 auto;
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			flex-wrap: wrap;
		}

		.logo {
			font-size: 1.2rem;
			font-weight: 700;
			color: var(--primary);
			letter-spacing: 0.3px;
		}

		.nav-links {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}

		.nav-links a {
			text-decoration: none;
			background: var(--primary);
			color: var(--white);
			padding: 10px 14px;
			border-radius: 8px;
			font-size: 0.95rem;
			font-weight: 600;
			transition: background 0.2s ease, transform 0.2s ease;
		}

		.nav-links a:hover {
			background: var(--primary-dark);
			transform: translateY(-1px);
		}

		main {
			max-width: 1100px;
			margin: 40px auto;
			padding: 0 20px 40px;
		}

		.hero {
			background: var(--white);
			border-left: 8px solid var(--accent);
			border-radius: 14px;
			padding: 34px;
			box-shadow: var(--shadow);
		}

		.back-link {
			display: inline-block;
			margin-bottom: 14px;
			color: var(--primary-dark);
			font-weight: 700;
			text-decoration: none;
		}

		.back-link:hover {
			text-decoration: underline;
		}

		.hero h1 {
			margin: 0 0 12px;
			color: var(--primary-dark);
			font-size: clamp(1.7rem, 3vw, 2.4rem);
		}

		.hero p {
			margin: 0;
			line-height: 1.6;
			font-size: 1.04rem;
			max-width: 780px;
		}

		.products-grid {
			margin-top: 22px;
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 14px;
		}

		.product-card {
			background: #f9fcfa;
			border: 1px solid #d7e7dc;
			border-radius: 10px;
			padding: 16px;
		}

		.product-card h2 {
			margin: 0 0 8px;
			font-size: 1.1rem;
			color: var(--primary-dark);
		}

		.product-card p {
			margin: 0;
			line-height: 1.5;
		}

		footer {
			padding: 14px 18px;
			text-align: center;
		}
	</style>
</head>
<body>

	<main>
		<section class="hero">
			<a class="back-link" href="index.php">&larr; Back to Home</a>
			<h1>Skin Care</h1>
			<p>Browse a few simple skincare products available in-store.</p>

			<div class="products-grid">
				<div class="product-card">
					<h2>Moisturising Cream</h2>
					<p>Daily hydration for soft, healthy-looking skin.</p>
				</div>
				<div class="product-card">
					<h2>Gentle Cleanser</h2>
					<p>A mild cleanser for everyday face washing and skin care.</p>
				</div>
				<div class="product-card">
					<h2>Sunscreen SPF 50</h2>
					<p>Protect your skin with a lightweight high-protection sunscreen.</p>
				</div>
				<div class="product-card">
					<h2>Hand Cream</h2>
					<p>Keep hands smooth and moisturised throughout the day.</p>
				</div>
			</div>
		</section>
	</main>

	<footer>
		<p>&copy; 2026 Dillons Pharmacy. All rights reserved.</p>
	</footer>
</body>
</html>

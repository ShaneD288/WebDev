<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dillons Pharmacy | Home</title>
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

		.offer-box {
			margin-top: 20px;
			background: #f9fcfa;
			border: 1px solid #d7e7dc;
			border-radius: 10px;
			padding: 16px 18px;
		}

		.offer-box h2 {
			margin: 0 0 10px;
			font-size: 1.1rem;
			color: var(--primary-dark);
		}

		.offer-box ul {
			margin: 0;
			padding-left: 20px;
			line-height: 1.6;
		}
	</style>
</head>
<body>

	<main>
		<section class="hero">
			<h1>Welcome to Dillons Pharmacy</h1>
			<p>
				Your neighborhood pharmacy for trusted care, prescription support, and wellness products.
				Use the buttons at the top of this page to quickly visit the rest of our website.
			</p>
			<div class="offer-box">
				<h2>What We Offer</h2>
				<ul>
					<li>Prescription Renewal: Quick refill and renewal request support.</li>
					<li>Gift: Health and wellness gifts for family and friends.</li>
					<li>Services: Details of our in-pharmacy care and support services.</li>
					<li>Skin Care: Trusted skincare products and recommendations.</li>
					<li>About Us: Learn more about Dillons Pharmacy and our team.</li>
					<li>Contact Us: Phone, location, and ways to reach us.</li>
				</ul>
			</div>
		</section>
	</main>
	<footer>
		<p>&copy; 2026 Dillons Pharmacy. All rights reserved.</p>
	</footer>
</body>
</html>

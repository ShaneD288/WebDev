
<!DOCTYPE html>
<html>
<head>
    <title>Dillons Pharmacy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="top-bar">
        <div class="logo">Dillons Pharmacy</div>

        <nav class="nav-links">
            <a href="index.php">Home</a>
            <a href="services.php">Services</a>
            <a href="skincare.php">Skin Care</a>
            <a href="gift.php">Gift</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>

            <?php if(isset($_SESSION['user'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
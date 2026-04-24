<?php
session_start();
include 'config.php';

$error = '';
$success = '';

if(isset($_POST['create_account'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if(empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required";
    } elseif(strlen($fullname) < 2) {
        $error = "Full name must be at least 2 characters";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } elseif(strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $error = "Email address already registered";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $password);
            
            if($stmt->execute()) {
                $_SESSION['user'] = $email;
                $success = "Account created successfully! Redirecting to login...";
                header("refresh:2;url=login.php");
            } else {
                $error = "Error creating account. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dillons Pharmacy | Create Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1f6f4a;
            --primary-dark: #154e34;
            --primary-light: #2d9d5d;
            --accent: #f2b84b;
            --bg: #eef6f0;
            --text: #183025;
            --muted: #5c6f62;
            --error: #8b1d1d;
            --success: #1f6f4a;
            --shadow: 0 18px 50px rgba(24, 53, 39, 0.16);
            --light-shadow: 0 4px 15px rgba(24, 53, 39, 0.08);
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: 
                radial-gradient(circle at top left, rgba(242, 184, 75, 0.25), transparent 28%),
                radial-gradient(circle at bottom right, rgba(31, 111, 74, 0.18), transparent 35%),
                linear-gradient(135deg, #f7fbf8 0%, var(--bg) 100%);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 60px rgba(24, 53, 39, 0.2);
        }

        .brand-section {
            background: linear-gradient(160deg, #1f6f4a 0%, #164f36 100%);
            color: #f8fcf8;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(242, 184, 75, 0.1), transparent);
            border-radius: 50%;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.15);
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.95rem;
        }

        .brand-badge i {
            font-size: 1.1rem;
        }

        .brand-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .brand-section p {
            font-size: 0.95rem;
            line-height: 1.7;
            color: rgba(248, 252, 248, 0.9);
            margin-bottom: 24px;
        }

        .features {
            list-style: none;
        }

        .features li {
            padding: 8px 0;
            line-height: 1.8;
            color: rgba(248, 252, 248, 0.92);
        }

        .features li::before {
            content: '✓ ';
            color: var(--accent);
            font-weight: 700;
            margin-right: 10px;
        }

        .form-section {
            padding: 48px;
            display: flex;
            flex-direction: column;
            max-height: 100vh;
            overflow-y: auto;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e8e8e8;
        }

        .back-link {
            color: var(--primary-dark);
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .form-section h2 {
            font-size: 2rem;
            color: var(--primary-dark);
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .form-section > p {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        label {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text);
        }

        label i {
            margin-right: 6px;
            color: var(--primary);
        }

        input {
            padding: 14px 16px;
            border: 1.5px solid #d0dcd4;
            border-radius: 12px;
            font-size: 1rem;
            background: #fcfefd;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input::placeholder {
            color: #a8b4af;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(31, 111, 74, 0.1);
        }

        .password-requirements {
            background: #f0f5f2;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .password-requirements strong {
            color: var(--text);
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        button {
            flex: 1;
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--light-shadow);
        }

        button:active {
            transform: translateY(0);
        }

        button i {
            font-size: 1.1rem;
        }

        .message {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error {
            background: #ffe5e5;
            color: var(--error);
            border: 1px solid #efb3b3;
        }

        .success {
            background: #e7f7ec;
            color: var(--success);
            border: 1px solid #b9e2c8;
        }

        .message i {
            font-size: 1.2rem;
        }

        .login-text {
            text-align: center;
            font-size: 0.9rem;
            color: var(--muted);
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e8e8e8;
        }

        .login-text a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .login-text a:hover {
            color: var(--primary-dark);
        }

        @media (max-width: 820px) {
            .container {
                grid-template-columns: 1fr;
            }

            .brand-section,
            .form-section {
                padding: 32px;
            }

            .top-nav {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }

            .brand-section h1 {
                font-size: 2rem;
            }

            .form-section h2 {
                font-size: 1.6rem;
            }

            button {
                padding: 12px 20px;
                font-size: 0.95rem;
            }

            .form-section {
                max-height: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-section">
            <div class="brand-content">
                <div class="brand-badge">
                    <i class="fas fa-user-plus"></i>
                    Dillons Pharmacy Member Registration
                </div>
                <h1>Join Our Community</h1>
                <p>Create your account to access prescription renewal services and manage your pharmacy information.</p>
                <ul class="features">
                    <li>Easy prescription renewal process</li>
                    <li>Access your prescription history</li>
                    <li>Secure account management</li>
                    <li>Fast checkout and ordering</li>
                    <li>Personalized health records</li>
                </ul>
            </div>
        </div>

        <div class="form-section">
            <div class="top-nav">
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>

            <h2>Create Account</h2>
            <p>Fill in your details to get started</p>

            <?php if($error): ?>
                <div class="message error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="message success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <div class="form-group">
                    <label for="fullname">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input 
                        id="fullname"
                        type="text" 
                        name="fullname" 
                        placeholder="John Doe"
                        required 
                        autocomplete="name"
                        value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input 
                        id="email"
                        type="email" 
                        name="email" 
                        placeholder="your.email@example.com"
                        required 
                        autocomplete="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    />
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <input 
                        id="password"
                        type="password" 
                        name="password" 
                        placeholder="Create a strong password"
                        required 
                        autocomplete="new-password"
                    />
                </div>

                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-lock"></i>
                        Confirm Password
                    </label>
                    <input 
                        id="confirm_password"
                        type="password" 
                        name="confirm_password" 
                        placeholder="Re-enter your password"
                        required 
                        autocomplete="new-password"
                    />
                </div>

                <div class="password-requirements">
                    <strong>Password Requirements:</strong><br>
                    • At least 6 characters long<br>
                    • Both passwords must match
                </div>

                <div class="button-group">
                    <button type="submit" name="create_account">
                        <i class="fas fa-user-check"></i>
                        Create Account
                    </button>
                </div>
            </form>

            <div class="login-text">
                Already have an account? <a href="login.php">Sign in here</a>
            </div>
        </div>
    </div>
</body>
</html>
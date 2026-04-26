<?php
session_start();
include 'config.php';

//Variables to store messages
$error = '';
$success = '';

//Check if the form is submitted 
if(isset($_POST['login'])) {
    $email = trim($_POST['email']); 
    $password = $_POST['password'];

    
    if(empty($email) || empty($password)) {
        $error = "Email and password are required";
    } else {

        //looks for users email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // check if a users email exists 
        if($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // compare passwords 
            if($password === $user['password']) {
                
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $user['id'];
                header("Location: prescription.php");
                exit();
                
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
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
    <title>Dillons Pharmacy | Login</title>
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
        /* page layout */
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

        /* main container */
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
        /* brings brand to front */
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
        /* adds checkmark */
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

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .checkbox-group label {
            margin: 0;
            font-weight: 500;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.2s ease;
            display: block;
            margin-bottom: 24px;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
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
            margin-top: 20px;
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

        .signup-text {
            text-align: center;
            font-size: 0.9rem;
            color: var(--muted);
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e8e8e8;
        }

        .signup-text a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .signup-text a:hover {
            color: var(--primary-dark);
        }

        /* adjust for screen size */
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-section">
            <div class="brand-content">
                <div class="brand-badge">
                    <i class="fas fa-lock"></i>
                    Dillons Pharmacy Secure Access
                </div>
                <h1>Welcome Back</h1>
                <p>Sign in to access your prescription renewal forms and manage your account securely.</p>
                <ul class="features">
                    <li>Secure prescription renewal access</li>
                    <li>View your prescription history</li>
                    <li>Fast and easy login process</li>
                    <li>Protected with industry-standard security</li>
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

            <h2>Sign In</h2>
            <p>Enter your credentials to access your account</p>

            <!-- displays error messages  -->
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
                        placeholder="Enter your password"
                        required 
                        autocomplete="current-password"
                    />
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember" />
                    <label for="remember">Remember me on this device</label>
                </div>

                <a href="#" class="forgot-link">Forgot your password?</a>

                <div class="button-group">
                    <button type="submit" name="login">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>
                </div>
            </form>

            <div class="signup-text">
                Don't have an account? <a href="createAcc.php">Create one here</a>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EZbuy</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/Ai_driven_ecommerce/assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/Ai_driven_ecommerce/assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/Ai_driven_ecommerce/assets/images/icons/favicon-16x16.png">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="/Ai_driven_ecommerce/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Ai_driven_ecommerce/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="/Ai_driven_ecommerce/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .page-content {
            padding: 60px 0;
            min-height: calc(100vh - 200px);
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .login-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 0 0.2rem rgba(74,144,226,0.25);
        }
        .btn-primary {
            height: 45px;
            background-color: #4A90E2;
            border-color: #4A90E2;
            font-weight: 500;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #357ABD;
            border-color: #357ABD;
        }
        .input-group-text {
            background: none;
            border: 1px solid #ddd;
            border-left: none;
            cursor: pointer;
        }
        .input-group-text:hover {
            color: #4A90E2;
        }
        .alert {
            border-radius: 5px;
            font-size: 14px;
        }
        .register-link {
            color: #4A90E2;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link:hover {
            color: #357ABD;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include('../includes/connect.php');

    $error_message = '';
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        if ($email && $password) {
            $users = $con->query('users', ['email' => $email]);
            
            if (!empty($users)) {
                $user = $users[0];
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Redirect based on intended destination
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
                    header("Location: $redirect");
                    exit();
                } else {
                    $error_message = 'Invalid password';
                }
            } else {
                $error_message = 'User not found';
            }
        } else {
            $error_message = 'Please fill in all fields';
        }
    }
    ?>

    <?php include('../includes/header.php'); ?>

    <main class="main">
        <div class="page-content">
            <div class="container">
                <div class="login-container">
                    <h2 class="login-title">Welcome Back</h2>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <?php if ($success_message): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                   required
                                   autocomplete="email"
                                   placeholder="Enter your email">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       required
                                       autocomplete="current-password"
                                       placeholder="Enter your password">
                                <span class="input-group-text" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary">
                                Login <i class="fas fa-sign-in-alt ms-2"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="user_registration.php" class="register-link">Register here</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include('../includes/footer.php'); ?>

    <!-- Scripts -->
    <script src="/Ai_driven_ecommerce/assets/js/jquery.min.js"></script>
    <script src="/Ai_driven_ecommerce/assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
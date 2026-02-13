<?php
session_start();

// Check if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email dan password harus diisi!';
    } else {
        // Check user in database
        $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ? AND is_active = TRUE");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_name'] = $user['name'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_role'] = $user['role'];
                
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Email tidak ditemukan atau akun tidak aktif!';
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - Ar Creative CMS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a1f2e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e0e0e0;
        }
        
        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 40px 30px;
            background-color: rgba(26, 31, 46, 0.95);
            border: 1px solid #333;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #569ae3, #4a8bc2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .login-header p {
            color: #b0b0b0;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            background-color: #0f1419;
            border: 2px solid #333;
            border-radius: 8px;
            color: #e0e0e0;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #569ae3;
            box-shadow: 0 0 15px rgba(86, 154, 227, 0.2);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-error {
            background-color: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #51cf66;
            border: 1px solid rgba(81, 207, 102, 0.3);
        }
        
        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #569ae3;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            background-color: #4a8bc2;
            box-shadow: 0 5px 20px rgba(86, 154, 227, 0.3);
            transform: translateY(-2px);
        }
        
        .remember {
            display: flex;
            align-items: center;
            margin: 1rem 0;
            font-size: 14px;
        }
        
        .remember input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .back-link a {
            color: #569ae3;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .back-link a:hover {
            color: #7cb5e8;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-key"></i> Admin Panel</h1>
            <p>Kelola konten Ar Creative</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="admin@arcreative.com" required />
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required />
            </div>
            
            <div class="remember">
                <input type="checkbox" id="remember" name="remember" />
                <label for="remember" style="margin: 0; font-weight: normal;">Ingat saya</label>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="back-link">
            <a href="../index.html"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
        </div>
    </div>
</body>
</html>

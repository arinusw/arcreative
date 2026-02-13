<?php
/**
 * PASSWORD HASH GENERATOR
 * 
 * File ini digunakan untuk generate hash password yang aman
 * Akses via: http://localhost/arcreative/admin/generate_password_hash.php
 * 
 * IMPORTANT: Jangan upload file ini ke production!
 * Gunakan hanya untuk development/testing
 */

// Security check - hanya izinkan di localhost development
$is_localhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost']);
if (!$is_localhost) {
    die('Access denied. This tool is only available on localhost.');
}

$hash = '';
$password = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    if (empty($password)) {
        $error = 'Password tidak boleh kosong!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator - Ar Creative</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .result-box {
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            display: none;
        }

        .result-box.show {
            display: block;
        }

        .result-label {
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .hash-output {
            background: white;
            border: 1px solid #e0e0e0;
            padding: 12px;
            border-radius: 5px;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        .copy-btn {
            width: 100%;
            margin-top: 12px;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .copy-btn:hover {
            background: #218838;
        }

        .instructions {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: #004085;
            line-height: 1.6;
        }

        .instructions h3 {
            margin-bottom: 10px;
            color: #003d82;
            font-size: 14px;
        }

        .instructions ol {
            margin-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .instructions code {
            background: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: #856404;
        }

        .warning strong {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Password Hash Generator</h1>
        <p class="subtitle">Generate bcrypt hash untuk password Ar Creative CMS</p>

        <?php if ($error): ?>
            <div class="alert alert-error">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($hash): ?>
            <div class="alert alert-success">
                ✅ Hash password berhasil di-generate!
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="password">Masukkan Password:</label>
                <input type="text" id="password" name="password" placeholder="Contoh: MyPassword123" 
                       value="<?php echo htmlspecialchars($password); ?>" autofocus>
            </div>
            <button type="submit">Generate Hash</button>
        </form>

        <?php if ($hash): ?>
            <div class="result-box show">
                <div class="result-label">📋 Password Hash Output:</div>
                <div class="hash-output" id="hashOutput"><?php echo htmlspecialchars($hash); ?></div>
                <button type="button" class="copy-btn" onclick="copyHash()">
                    📋 Copy Hash ke Clipboard
                </button>
            </div>
        <?php endif; ?>

        <div class="instructions">
            <h3>📖 Cara Menggunakan Hash ini:</h3>
            <ol>
                <li><strong>Update Password Admin:</strong>
                    <div style="margin-top: 8px;">
                        Buka PhpMyAdmin → Database <code>arcreative_cms</code> → Tabel <code>users</code>
                    </div>
                </li>
                <li><strong>Edit User Admin:</strong> Klik tombol edit pada user <code>admin@arcreative.com</code></li>
                <li><strong>Paste Hash:</strong> Paste hash di atas ke field <code>password</code></li>
                <li><strong>Save:</strong> Klik tombol Save/Update</li>
                <li><strong>Login:</strong> Gunakan password plaintext Anda untuk login ke admin panel</li>
            </ol>
        </div>

        <div class="warning">
            <strong>⚠️ SECURITY WARNING:</strong>
            <ul style="margin-left: 20px; margin-top: 8px;">
                <li>Jangan share hash password ini ke orang lain</li>
                <li>Jangan commit file ini atau hash password ke Git/GitHub</li>
                <li>Gunakan password yang kuat (minimal 12 karakter)</li>
                <li>File ini hanya untuk development (localhost)</li>
                <li>Jangan upload ke server production</li>
            </ul>
        </div>
    </div>

    <script>
        function copyHash() {
            const hashElement = document.getElementById('hashOutput');
            const hash = hashElement.textContent;
            
            navigator.clipboard.writeText(hash).then(() => {
                const btn = event.target;
                const originalText = btn.textContent;
                btn.textContent = '✅ Hash Copied!';
                setTimeout(() => {
                    btn.textContent = originalText;
                }, 2000);
            }).catch(() => {
                // Fallback untuk browser lama
                const textarea = document.createElement('textarea');
                textarea.value = hash;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                alert('Hash copied to clipboard!');
            });
        }
    </script>
</body>
</html>

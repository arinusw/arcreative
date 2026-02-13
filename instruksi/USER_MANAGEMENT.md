# 👤 MANAJEMEN USER & PASSWORD

## 1. DEFAULT ADMIN USER

Setelah import database.sql, Anda akan memiliki 1 user admin default:

| Field        | Value                |
| ------------ | -------------------- |
| **Nama**     | Admin                |
| **Email**    | admin@arcreative.com |
| **Password** | Ar@Creative123       |
| **Role**     | admin                |
| **Status**   | Active               |

---

## 2. MEMBUAT/MENGUBAH PASSWORD

### Cara 1: Gunakan PHP Script (RECOMMENDED)

**File:** `admin/generate_password_hash.php`

Buat file ini untuk generate hash password yang aman:

```php
<?php
// GENERATE PASSWORD HASH
// Jalankan di browser: http://localhost/arcreative/admin/generate_password_hash.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        echo '<div style="background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 20px;">';
        echo '<h3>Password Hash Generated:</h3>';
        echo '<p><strong>Password:</strong> ' . htmlspecialchars($password) . '</p>';
        echo '<p><strong>Hash:</strong></p>';
        echo '<code style="background: #f8f9fa; padding: 10px; display: block; word-break: break-all;">' . htmlspecialchars($hash) . '</code>';
        echo '</div>';
    } else {
        echo '<p style="color: red;">Password tidak boleh kosong!</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Password Hash</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; }
        input { padding: 8px; font-size: 14px; width: 300px; }
        button { padding: 8px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2>Generate Password Hash</h2>
    <form method="POST">
        <label>Masukkan Password Baru:</label><br><br>
        <input type="text" name="password" placeholder="Contoh: MyPassword123" required>
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>
```

**Cara Menggunakan:**

1. Jalankan di browser: `http://localhost/arcreative/admin/generate_password_hash.php`
2. Masukkan password baru
3. Copy hash yang dihasilkan
4. Gunakan hash tersebut untuk update user di PhpMyAdmin

### Cara 2: Update via PhpMyAdmin

1. Buka PhpMyAdmin: `http://localhost/phpmyadmin/`
2. Pilih database `arcreative_cms`
3. Buka tabel `users`
4. Edit row user yang ingin diubah
5. Di field `password`, paste hash dari Cara 1
6. Klik Save

### Cara 3: Update via SQL Query

1. Buka PhpMyAdmin → Database `arcreative_cms` → SQL
2. Jalankan query ini (ganti `YOUR_HASH_HERE` dengan hash dari Cara 1):

```sql
-- Update password untuk admin@arcreative.com
UPDATE users
SET password = 'YOUR_HASH_HERE'
WHERE email = 'admin@arcreative.com';

-- Verifikasi
SELECT id, name, email, role, is_active FROM users WHERE email = 'admin@arcreative.com';
```

---

## 3. MEMBUAT USER BARU

### Via SQL Query

```sql
-- Template untuk membuat user baru
INSERT INTO users (name, email, password, role, is_active)
VALUES (
    'Nama User',           -- Ganti dengan nama user
    'user@email.com',      -- Ganti dengan email
    'PASTE_HASH_HERE',     -- Ganti dengan hash (dari generate_password_hash.php)
    'editor',              -- Role: 'admin' atau 'editor'
    TRUE                   -- Status: TRUE (aktif) atau FALSE (tidak aktif)
);

-- Contoh:
INSERT INTO users (name, email, password, role, is_active)
VALUES (
    'John Editor',
    'john@arcreative.com',
    '$2y$10$X1234567890X1234567890X1234567890X1234567890X1234567890',
    'editor',
    TRUE
);

-- Verifikasi
SELECT * FROM users ORDER BY created_at DESC;
```

### Via Admin Dashboard (Jika Sudah Ada Feature)

1. Login ke `/admin/` dengan akun admin
2. Cari menu "Manajemen User" atau "Users"
3. Klik "Tambah User" atau "New User"
4. Isi form dan klik Save

---

## 4. MENGELOLA USER

### Lihat Semua User

```sql
SELECT id, name, email, role, is_active, created_at FROM users ORDER BY created_at DESC;
```

### Nonaktifkan User

```sql
UPDATE users
SET is_active = FALSE
WHERE email = 'user@email.com';
```

### Aktifkan User Kembali

```sql
UPDATE users
SET is_active = TRUE
WHERE email = 'user@email.com';
```

### Ubah Role User

```sql
-- Ubah dari editor ke admin
UPDATE users
SET role = 'admin'
WHERE email = 'user@email.com';

-- Ubah dari admin ke editor
UPDATE users
SET role = 'editor'
WHERE email = 'user@email.com';
```

### Hapus User

```sql
DELETE FROM users WHERE email = 'user@email.com';
```

---

## 5. RESET PASSWORD ADMIN

Jika lupa password admin:

1. **Generate password baru** menggunakan `generate_password_hash.php`
2. **Update di database:**
   ```sql
   UPDATE users
   SET password = 'PASTE_NEW_HASH_HERE'
   WHERE email = 'admin@arcreative.com';
   ```
3. **Login dengan password baru**

---

## 6. SECURITY BEST PRACTICES

### ✅ HARUS DILAKUKAN

- [ ] Ubah password default admin setelah first login
- [ ] Gunakan password yang kuat (minimal 12 karakter, mix case, angka, simbol)
- [ ] Hash password menggunakan `password_hash()` dengan PASSWORD_BCRYPT
- [ ] Jangan pernah commit password atau hash ke GitHub
- [ ] Backup database secara berkala

### ❌ JANGAN DILAKUKAN

- Jangan gunakan MD5 untuk hash password (tidak aman)
- Jangan share/simpan plaintext password
- Jangan gunakan password yang sama untuk multiple user
- Jangan hardcode password di code
- Jangan expose password di URL parameter

### 🔒 ENKRIPSI PASSWORD

PHP Code untuk hash password:

```php
// GENERATE HASH
$password = 'Ar@Creative123';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
echo $hash; // Output: $2y$10$...

// VERIFY PASSWORD (saat login)
$password = 'Ar@Creative123';      // Password yang user input
$hash = '...';                      // Hash dari database
if (password_verify($password, $hash)) {
    echo 'Password benar!';
} else {
    echo 'Password salah!';
}
```

---

## 7. TROUBLESHOOTING

### ❌ Error: "Password salah!" tapi saya yakin password benar

**Solusi:**

1. Pastikan hash sudah benar dengan regex test: `^$2[ayb]$[0-9]{2}$[./A-Za-z0-9]{53}$`
2. Update password menggunakan script `generate_password_hash.php`
3. Jangan copy-paste dari tempat yang salah (bisa ada space tersembunyi)

### ❌ Error: "Email tidak ditemukan"

**Solusi:**

1. Verifikasi di database: email harus match persis (case-sensitive)
2. Cek apakah user sudah aktif (`is_active = TRUE`)
3. Buat user baru dengan email yang benar

### ❌ Lupa email admin

**Solusi:**

```sql
SELECT email, role FROM users WHERE role = 'admin';
```

---

## 📞 QUICK REFERENCE

| Task             | Instruksi                                |
| ---------------- | ---------------------------------------- |
| Generate hash    | Buka: `admin/generate_password_hash.php` |
| Lihat semua user | PhpMyAdmin → `users` tabel               |
| Reset password   | Update password di PhpMyAdmin atau SQL   |
| Buat user baru   | Insert via SQL atau Dashboard            |
| Ubah role user   | UPDATE query di PhpMyAdmin SQL           |
| Nonaktifkan user | `UPDATE users SET is_active = FALSE`     |

---

**Last Updated:** Februari 2026

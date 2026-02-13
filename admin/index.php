<?php
/**
 * Admin Panel Index - Auto Redirect
 * 
 * File ini menangani akses ke folder /admin/
 * - Jika sudah login: redirect ke dashboard.php
 * - Jika belum login: redirect ke login.php
 */

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_name'])) {
    // User sudah login, redirect ke dashboard
    header('Location: dashboard.php');
    exit();
} else {
    // User belum login, redirect ke login page
    header('Location: login.php');
    exit();
}

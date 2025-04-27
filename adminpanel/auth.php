<?php
session_start();

const ADMIN_USER = 'admin';
const ADMIN_PASS = 'clinic123';

function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: index.php');
        exit();
    }
}

function login($user, $pass) {
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        $_SESSION['admin_logged_in'] = true;
        return true;
    }
    return false;
}

function logout() {
    session_unset();
    session_destroy();
} 
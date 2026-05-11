<?php
/**
 * Global helper functions available to all views.
 * Included once by index.php via autoloader path.
 */

/**
 * Output a hidden CSRF input field — call inside every <form>.
 */
function csrf_field() {
    $token = htmlspecialchars($_SESSION['csrf_token'] ?? '');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Return the current CSRF token string.
 */
function csrf_token() {
    return $_SESSION['csrf_token'] ?? '';
}

function getAboutSettings($conn) {
    static $settings = null;
    if ($settings === null) {
        $settingModel = new SettingModel($conn);
        $settings = $settingModel->getAllSettings();
    }
    return $settings;
}
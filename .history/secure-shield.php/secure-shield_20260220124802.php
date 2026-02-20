<?php
/**
 * Plugin Name: Secure Shield
 * Description: Enterprise-grade security hardening plugin.
 * Version: 1.0.0
 * Author: Atharva
 */

if (!defined('ABSPATH')) {
    exit; // Stop direct access
}

// Define constants
define('SECURE_SHIELD_PATH', plugin_dir_path(__FILE__));
define('SECURE_SHIELD_URL', plugin_dir_url(__FILE__));

// Load the main plugin class
require_once SECURE_SHIELD_PATH . 'src/Core/Plugin.php';
require_once SECURE_SHIELD_PATH . 'src/Database/Installer.php';

use SecureShield\Database\Installer;

register_activation_hook(__FILE__, [Installer::class, 'activate']);

use SecureShield\Core\Plugin;

function secure_shield_init() {
    $plugin = new Plugin();
    $plugin->init();
}

add_action('plugins_loaded', 'secure_shield_init');

<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Delete custom logs table
$table_name = $wpdb->prefix . 'secure_shield_logs';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// Remove plugin options
delete_option('secure_shield_max_attempts');
delete_option('secure_shield_lockout_time');
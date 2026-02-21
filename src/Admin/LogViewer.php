<?php

namespace SecureShield\Admin;

class LogViewer {

    public function init() {
        add_action('admin_menu', [$this, 'add_logs_page']);
    }

    public function add_logs_page() {
        add_submenu_page(
            'secure-shield',
            'Security Logs',
            'Logs',
            'manage_options',
            'secure-shield-logs',
            [$this, 'render_logs_page']
        );
    }

    public function render_logs_page() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'secure_shield_logs';

        $logs = $wpdb->get_results(
            "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 50"
        );
        ?>

        <div class="wrap">
            <h1>Secure Shield Logs</h1>

            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>IP Address</th>
                        <th>Action</th>
                        <th>Time</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if ($logs): ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo esc_html($log->id); ?></td>
                                <td><?php echo esc_html($log->user_id); ?></td>
                                <td><?php echo esc_html($log->ip_address); ?></td>
                                <td><?php echo esc_html($log->action); ?></td>
                                <td><?php echo esc_html($log->created_at); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No logs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

        <?php
    }
}
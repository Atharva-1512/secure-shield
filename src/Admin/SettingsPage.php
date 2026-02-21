<?php

namespace SecureShield\Admin;

class SettingsPage {

    public function init() {
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_menu() {
        add_menu_page(
            'Secure Shield',
            'Secure Shield',
            'manage_options',
            'secure-shield',
            [$this, 'render_page'],
            'dashicons-shield',
            80
        );
    }

    public function register_settings() {
        register_setting('secure_shield_settings_group', 'secure_shield_max_attempts');
        register_setting('secure_shield_settings_group', 'secure_shield_lockout_time');
    }

    public function render_page() {
        ?>
        <div class="wrap">
            <h1>Secure Shield Settings</h1>

            <form method="post" action="options.php">
                <?php settings_fields('secure_shield_settings_group'); ?>
                <?php do_settings_sections('secure_shield_settings_group'); ?>

                <table class="form-table">
                    <tr>
                        <th>Max Login Attempts</th>
                        <td>
                            <input type="number" name="secure_shield_max_attempts"
                                value="<?php echo esc_attr(get_option('secure_shield_max_attempts', 5)); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th>Lockout Time (seconds)</th>
                        <td>
                            <input type="number" name="secure_shield_lockout_time"
                                value="<?php echo esc_attr(get_option('secure_shield_lockout_time', 900)); ?>" />
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
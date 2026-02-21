<?php

namespace SecureShield\Security;

use SecureShield\Logger\Logger;

class LoginProtector {

    private function get_max_attempts() {
    return (int) get_option('secure_shield_max_attempts', 5);
}

    private function get_lockout_time() {
    return (int) get_option('secure_shield_lockout_time', 900);
}

    public function init() {
        add_action('wp_login_failed', [$this, 'handle_failed_login']);
        add_filter('authenticate', [$this, 'maybe_block_login'], 30, 3);
    }

    public function handle_failed_login($username) {

        $ip = $this->get_user_ip();

        $attempts = get_transient($this->get_transient_key($ip));
        $attempts = $attempts ? $attempts + 1 : 1;

        set_transient(
            $this->get_transient_key($ip),
            $attempts,
            $this->get_lockout_time()
        );

        Logger::log('login_failed');

    }

    public function maybe_block_login($user, $username, $password) {

        $ip = $this->get_user_ip();
        $attempts = get_transient($this->get_transient_key($ip));

        if ($attempts && $attempts >= $this->get_max_attempts()) {
            return new \WP_Error(
                'secure_shield_lockout',
                __('Too many failed login attempts. Try again later.')
            );
        }

        return $user;
    }

    private function get_transient_key($ip) {
        return 'secure_shield_failed_' . md5($ip);
    }

    private function get_user_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            return sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }
    }
}
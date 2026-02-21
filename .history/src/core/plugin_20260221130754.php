


<?php

use SecureShield\Logger\Logger;
use SecureShield\Security\LoginProtector;
use SecureShield\Admin\SettingsPage;

namespace SecureShield\Core;

class Plugin {

    public function init() {
        $this->register_hooks();
        

        $login_protector = new LoginProtector();
        $login_protector->init();
        $settings = new SettingsPage();
        $settings->init();
    }

    private function register_hooks() {
        add_action('init', [$this, 'on_init']);
    }

    public function on_init() {
        // Temporary test
        Logger::log('plugin_initialized');
    }
}

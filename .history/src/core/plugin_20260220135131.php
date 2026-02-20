


<?php

use SecureShield\Logger\Logger;
use SecureShield\Security\LoginProtector;

namespace SecureShield\Core;

class Plugin {

    public function init() {
        $this->register_hooks();
    }

    private function register_hooks() {
        add_action('init', [$this, 'on_init']);
    }

    public function on_init() {
        // Temporary test
        Logger::log('plugin_initialized');
    }
}

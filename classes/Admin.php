<?php
require_once __DIR__ . '/User.php';

class Admin extends User {
    private $permissions;

    public function __construct($email, $name) {
        parent::__construct($email, $name, 'admin');
        
        $this->permissions = [
            'view_traders',
            'manage_challenges',
            'view_messages',
            'view_payouts',
            'manage_users'
        ];
    }

    public function getPermissions() {
        return $this->permissions;
    }

    public function hasPermission($perm) {
        return in_array($perm, $this->permissions);
    }

    public function getDashboardTitle() {
        return 'Admin Control Panel';
    }

    public function getRoleBadge() {
        return '<span class="role-badge admin">Administrator</span>';
    }
}

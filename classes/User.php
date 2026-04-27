<?php

abstract class User {
    protected $email;
    protected $name;
    protected $role;
    protected $lastLogin;

    public function __construct($email, $name, $role) {
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
        $this->lastLogin = date('Y-m-d H:i:s');
    }

    public function getEmail() {
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }

    public function getRole() {
        return $this->role;
    }

    public function getLastLogin() {
        return $this->lastLogin;
    }

    public function getInitials() {
        $parts = explode(' ', trim($this->name));
        $initials = '';
        foreach ($parts as $p) {
            if (strlen($p) > 0) {
                $initials .= strtoupper($p[0]);
            }
            if (strlen($initials) >= 2) break;
        }
        return $initials;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    abstract public function getDashboardTitle();
    abstract public function getRoleBadge();
}

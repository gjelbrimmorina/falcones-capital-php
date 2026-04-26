<?php
require_once __DIR__ . '/User.php';

class Trader extends User {
    private $accountSize;
    private $profitSplit;
    private $totalPayout;
    private $status;
    private $profitTarget;

    public function __construct($email, $name, $accountSize = 50000, $profitSplit = 70, $totalPayout = 0, $status = 'funded') {
        parent::__construct($email, $name, 'trader');
        
        $this->accountSize = $accountSize;
        $this->profitSplit = $profitSplit;
        $this->totalPayout = $totalPayout;
        $this->status = $status;
        $this->profitTarget = 0.08 * $accountSize;
    }

    // GETTERS
    public function getAccountSize() {
        return $this->accountSize;
    }

    public function getProfitSplit() {
        return $this->profitSplit;
    }

    public function getTotalPayout() {
        return $this->totalPayout;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getProfitTarget() {
        return $this->profitTarget;
    }

    // SETTERS
    public function setAccountSize($size) {
        $this->accountSize = $size;
        $this->profitTarget = 0.08 * $size;
    }

    public function setProfitSplit($split) {
        $this->profitSplit = $split;
    }

    public function addPayout($amount) {
        $this->totalPayout += $amount;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getFormattedAccountSize() {
        return '$' . number_format($this->accountSize);
    }

    public function getFormattedPayout() {
        return '$' . number_format($this->totalPayout);
    }

    public function getDashboardTitle() {
        return 'My Trading Dashboard';
    }

    public function getRoleBadge() {
        $statusClass = $this->status === 'funded' ? 'funded' : 'evaluation';
        $statusText  = $this->status === 'funded' ? 'Funded Trader' : 'In Evaluation';
        return '<span class="role-badge ' . $statusClass . '">' . $statusText . '</span>';
    }
}

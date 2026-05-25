// Fetches live market exchange rates from an external API and provides fallback rates if the API is unavailable.
<?php
$pageTitle = 'Market Rates API';
require_once __DIR__ . '/../includes/header.php';

$rates = [];
$error = '';
$baseCurrency = 'USD';
try {
    $apiUrl = 'https://open.er-api.com/v6/latest/' . urlencode($baseCurrency);
    $json = @file_get_contents($apiUrl);
    if ($json === false) {
        throw new RuntimeException('Could not reach external API.');
    }
    $data = json_decode($json, true);
    if (!is_array($data) || ($data['result'] ?? '') !== 'success') {
        throw new RuntimeException('External API returned invalid data.');
    }
    $wanted = ['EUR', 'GBP', 'CHF', 'JPY', 'CAD'];
    foreach ($wanted as $code) {
        if (isset($data['rates'][$code])) $rates[$code] = $data['rates'][$code];
    }
} catch (Throwable $e) {
    error_log('Market API error: ' . $e->getMessage());
    $error = 'Live API could not be loaded. Showing fallback demo rates.';
    $rates = ['EUR' => 0.92, 'GBP' => 0.79, 'CHF' => 0.90, 'JPY' => 155.00, 'CAD' => 1.37];
}
?>
<section class="page-header"><div class="wrapper"><span class="tag">External Web API</span><h1>Live <span class="blue">Market Rates</span></h1><p>Phase 2 requirement: integrating an external Web API into the project domain.</p></div></section>
<section class="page-content"><div class="wrapper">
    <?php if ($error): ?><div class="alert info"><?php echo e($error); ?></div><?php endif; ?>
    <div class="dash-panel">
        <div class="dash-panel-head"><h3><i class="fas fa-globe"></i> Exchange rates for 1 <?php echo e($baseCurrency); ?></h3><span class="count-badge">External API</span></div>
        <div class="rates-grid">
            <?php foreach ($rates as $code => $rate): ?><div class="rate-card"><span><?php echo e($code); ?></span><strong><?php echo e(number_format((float)$rate, 4)); ?></strong></div><?php endforeach; ?>
        </div>
        <p class="form-info">Source in code: open.er-api.com. The page uses try/catch and fallback data so the project remains functional during local demos.</p>
    </div>
</div></section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
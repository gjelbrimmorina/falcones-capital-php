<?php
// Dummy data for challenges — replaces the React allChallenges array
require_once __DIR__ . '/../classes/Challenge.php';

// This is a NUMERIC ARRAY of Challenge objects
$allChallenges = [
    new Challenge('$5,000',   'Starter',  '$49',  '8%', '5%', '10%', '60-80%'),
    new Challenge('$10,000',  'Basic',    '$99',  '8%', '5%', '10%', '60-80%'),
    new Challenge('$25,000',  'Standard', '$199', '8%', '5%', '10%', '65-85%'),
    new Challenge('$50,000',  'Pro',      '$289', '8%', '5%', '10%', '70-90%', true),
    new Challenge('$100,000', 'Elite',    '$499', '8%', '5%', '10%', '80-100%'),
    new Challenge('$200,000', 'Master',   '$899', '8%', '5%', '10%', '80-100%'),
];

<?php
// --- Block bots by user agent ---
$blockedBots = [
  'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
  'yandex', 'sogou', 'exabot', 'facebot', 'ia_archiver'
];

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
foreach ($blockedBots as $bot) {
  if (strpos($ua, $bot) !== false) {
    header("HTTP/1.1 403 Forbidden");
    exit("Access Denied: Bot Detected");
  }
}

// --- Geo-block countries ---
$allowedCountries = ['US', 'CA'];
$ip = $_SERVER['REMOTE_ADDR'];

// Avoid multiple API calls in production (use caching ideally)
// $geo = @json_decode(file_get_contents("https://ipapi.co/{$ip}/json"));
// if (!$geo || !isset($geo->country_code) || !in_array($geo->country_code, $allowedCountries)) {
//   header("HTTP/1.1 403 Forbidden");
//   exit("Access Denied: Region Not Allowed");
// }
?>

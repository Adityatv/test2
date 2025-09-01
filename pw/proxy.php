<?php
// Target site
$target = "https://rolexcoderz.site";

// Build target URL
$path = $_SERVER['REQUEST_URI'];
$url = $target . $path;

// Init cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Capture headers + body
$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

// Fix headers (remove frame-blockers)
header("Content-Type: " . $info['content_type']);
header("Access-Control-Allow-Origin: *");
header_remove("X-Frame-Options");
header_remove("Content-Security-Policy");

// Rewrite site links → make them go through proxy
$response = str_replace(
    ["href=\"/", "src=\"/"],
    ["href=\"/proxy.php/", "src=\"/proxy.php/"],
    $response
);

echo $response;
?>

<?php

$domain = '';
$login = '';
$token = '';

$params = [];

$url = "https://{$domain}/rest/api/3/myself";
$url .= (strpos($url, '?') ? '&' : '?') . http_build_query($params);

$arCurlOptions = [
    CURLOPT_CONNECTTIMEOUT => 15,
    CURLOPT_TIMEOUT => 180,
    CURLOPT_SSL_VERIFYPEER => 1,
    CURLOPT_SSL_VERIFYHOST => 2,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_HEADER => false,
    CURLOPT_HTTPHEADER => [],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPGET => true
];
$arCurlOptions[CURLOPT_URL] = $url;
$arCurlOptions[CURLOPT_HTTPHEADER][] = 'Authorization: Basic ' . base64_encode("{$login}:{$token}");

$curl = curl_init();
curl_setopt_array($curl, $arCurlOptions);

$curlResult = curl_exec($curl);
if (!empty($curlResult)) {
    $curlResult = json_decode($curlResult);
    file_put_contents(__DIR__ . '/curl_result.txt', print_r($curlResult, true), FILE_APPEND);
    file_put_contents(__DIR__ . '/curl_result.txt', PHP_EOL, FILE_APPEND);
}

$curlInfo = curl_getinfo($curl);
if (!empty($curlInfo)) {
    file_put_contents(__DIR__ . '/curl_info.txt', print_r($curlInfo, true), FILE_APPEND);
    file_put_contents(__DIR__ . '/curl_info.txt', PHP_EOL, FILE_APPEND);
}

$curlError = curl_error($curl);
if (!empty($curlError)) {
    file_put_contents(__DIR__ . '/curl_errors.txt', print_r($curlError, true), FILE_APPEND);
    file_put_contents(__DIR__ . '/curl_errors.txt', PHP_EOL, FILE_APPEND);
}

curl_close($curl);

print 'Done';
print PHP_EOL;

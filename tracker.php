<?php

$BOT_TOKEN = "7980329401:AAExJxfGIP0_03hJ6odrNk6zRADtefePX-Q";
$CHAT_ID   = "7913911586";

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

$json = @file_get_contents("http://ip-api.com/json/$ip");
$data = json_decode($json, true);

$country = $data['country'] ?? 'Unknown';
$region  = $data['regionName'] ?? 'Unknown';
$city    = $data['city'] ?? 'Unknown';
$isp     = $data['isp'] ?? 'Unknown';

$record = [
    'time'    => date('Y-m-d H:i:s'),
    'ip'      => $ip,
    'country' => $country,
    'region'  => $region,
    'city'    => $city,
    'isp'     => $isp
];

file_put_contents(
    'visitors.log',
    json_encode($record, JSON_UNESCAPED_UNICODE) . PHP_EOL,
    FILE_APPEND
);

$message =
"📢 Pengunjung Baru\n\n" .
"🌍 Negara: $country\n" .
"📍 Provinsi: $region\n" .
"🏙 Kota: $city\n" .
"🏢 ISP: $isp\n" .
"🌐 IP: $ip";

$url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";

$postData = [
    'chat_id' => $CHAT_ID,
    'text'    => $message
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

echo "OK";
?>
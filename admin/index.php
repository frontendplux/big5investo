<?php
function sendPushNotification($title, $message, $imageUrl = null, $url = null) {
$app_id = "d6666635-279c-4462-87bd-4558e9d7b004";
$rest_api_key = "os_v2_app_2ztgmnjhtrcgfb55ivmotv5qarlo5zo5zn3edaeoemdkjjrkw5xfqrab323ugkoqyezyomxv4em26tcbljirw2zslm2wxwhxciqifai";

$data = [
    "app_id" => $app_id,
    "included_segments" => ["All"],
    "headings" => [
        "en" => $title
    ],
    "contents" => [
        "en" => $message
    ],
    "large_icon" => $imageUrl,
    "url" => $url
];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json; charset=utf-8",
    "Authorization: Basic {$rest_api_key}"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo curl_error($ch);
}

curl_close($ch);
return $response;
}

<?php
$app_id = "d6666635-279c-4462-87bd-4558e9d7b004";
$rest_api_key = "os_v2_app_2ztgmnjhtrcgfb55ivmotv5qarfaaogqee7u5kehwgeaugjuxzlkv5w5dn47amsqh5zcplt43fxrdxstt6obw6cnuckt5nrew7bewdi"; // from OneSignal dashboard

$content = array("en" => "Hello! This is a test push");

$fields = array(
    'app_id' => $app_id,
    'included_segments' => array('All'),
    'contents' => $content
);

$fields = json_encode($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charset=utf-8',
    'Authorization: Basic ' . $rest_api_key
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$response = curl_exec($ch);
curl_close($ch);

echo $response;

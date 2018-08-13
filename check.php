<?php

$api_token = "API_KEY_HERE";
$url = "https://api.hetzner.cloud/v1/servers";
$getImageUrl = "https://api.hetzner.cloud/v1/images?sort=id:desc";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_token,
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec($ch);

$response = json_decode($server_output, true);

curl_close($ch);

if (!empty($response) && !array_key_exists("error", $response)) {
    foreach ($response["servers"] as $server) {
        if ($server["status"] == 'error' || $server["status"] == 'off' && !(bool)preg_match('/"emergency-server"/i',
                json_encode($response["servers"]))) {

            $servGetImage = curl_init();
            curl_setopt($servGetImage, CURLOPT_URL, $getImageUrl);
            curl_setopt($servGetImage, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($servGetImage, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($servGetImage, CURLOPT_CUSTOMREQUEST, "GET");

            $responseImages = curl_exec($servGetImage);

            $images = json_decode($responseImages, true)["images"];
            $lastImage = $images[0];
            $type = $server['server_type']['name'];
            $location = $server['datacenter']['location']['name'];

            $body = [
                "name" => "emergency-server",
                "server_type" => "$type",
				"location" => "$location",
                "start_after_create" => true,
                "image" => (string)$lastImage["id"]
            ];

            $servFromImage = curl_init();
            curl_setopt($servFromImage, CURLOPT_URL, $url);
            curl_setopt($servFromImage, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($servFromImage, CURLOPT_POST, true);
            curl_setopt($servFromImage, CURLOPT_POSTFIELDS, json_encode($body));

            $server_output = curl_exec($servFromImage);

            curl_close($servGetImage);
            curl_close($servFromImage);

            echo 'Emergency server created';

        } elseif ($server["status"] == 'error' || $server["status"] == 'off' && $server['name'] !== 'emergency-server') {
            echo 'Still under error';
        }
    }
}

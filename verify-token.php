<?php
// Allow CORS for local testing (optional, remove for production)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['access_token']) || empty($input['access_token'])) {
    echo json_encode(['error' => 'Missing access_token']);
    exit;
}

$accessToken = $input['access_token'];

// Your MSG91 auth key
$authKey = "263591AyBwYWZx61768b1bP1";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://control.msg91.com/api/v5/widget/verifyAccessToken',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([
      "authkey" => $authKey,
      "access-token" => $accessToken
  ]),
  CURLOPT_HTTPHEADER => [
    'Content-Type: application/json',
    'Accept: application/json',
  ],
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo json_encode(['error' => curl_error($curl)]);
    curl_close($curl);
    exit;
}

curl_close($curl);

// Forward the response from MSG91 to frontend
echo $response;

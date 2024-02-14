<?php
// oauth_callback.php

// Set up your OAuth credentials
$oAuthClientId = '0c49790d1ee5aede'; // Insert Your Client ID taken from the app settings
$oAuthClientSecret = 'f4eeb9032541a75fc45713400fd2097645a30309'; // Insert Your Client secret taken from the app settings
$oAuthRedirectUri = 'https://china4you.by/oauth-callback-3.php'; // Replace with your actual Callback URI

// Step 1: Handle the authorization code
if (isset($_GET['code'])) {
    $authorizationCode = $_GET['code'];

    // Step 2: Exchange the authorization code for an access token
    // Prepare data for the POST requst to the Pipedrive OAuth server
    $tokenUrl = 'https://oauth.pipedrive.com/oauth/token';  
    $tokenParams = [
        'grant_type' => 'authorization_code',
        'client_id' => $oAuthClientId,
        'client_secret' => $oAuthClientSecret,
        'code' => $authorizationCode,
        'redirect_uri' => $oAuthRedirectUri
    ];

    // Make a POST request to the Pipedrive OAuth server
    $ch = curl_init($tokenUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tokenParams));
    $tokenResponse = curl_exec($ch);
    curl_close($ch);

    // Parse the token response (JSON)
    $tokenData = json_decode($tokenResponse, true);

    if (isset($tokenData['access_token'])) {
        $accessToken = $tokenData['access_token'];
        $refreshToken = $tokenData['refresh_token'];

        echo "accessToken is: " . $accessToken . "</br>";
        echo "refreshToken is: " . $refreshToken;

    }
}

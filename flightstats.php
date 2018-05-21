<?php

$curl1 = curl_init();
    
curl_setopt_array($curl1, array(


CURLOPT_URL => "https://login.windows.net/common/oauth2/token",


CURLOPT_RETURNTRANSFER => true,


CURLOPT_ENCODING => "",


CURLOPT_MAXREDIRS => 10,


CURLOPT_TIMEOUT => 30,


CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,


CURLOPT_CUSTOMREQUEST => "POST",


CURLOPT_POSTFIELDS => array(


grant_type => 'password',


scope => 'openid',


resource => 'https://analysis.windows.net/powerbi/api',


client_id => ' ', // Registered App ApplicationID


username => ' ', // Your Power BI Pro account. For example john.doe@yourdomain.com


password => ''  // Password for above user


)

));


$tokenResponse = curl_exec($curl1);


$tokenError = curl_error($curl1);


curl_close($curl1);


// decode result, and store the access_token in $embeddedToken variable:


$tokenResult = json_decode($tokenResponse, true);

$token = $tokenResult["access_token"];

$embeddedToken = "Bearer "  . ' ' .  $token;


/*      Use the token to get an embedded URL using a GET request */

$group_Id = ' ';

$curl2 = curl_init();

curl_setopt($curl2, CURLOPT_URL, 'https://api.powerbi.com/v1.0/myorg/groups/'.$group_Id.'/reports/');
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, trUE);
curl_setopt($curl2, CURLOPT_ENCODING, "");
curl_setopt($curl2, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl2, CURLOPT_TIMEOUT, 30);
curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl2, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt ($curl2, CURLOPT_HTTPHEADER,array(

        'Authorization:'.$embeddedToken,
        'Cache-Control: no-cache'
    ));

$embedResponse  = curl_exec($curl2);

$embedError = curl_error($curl2);

curl_close($curl2);

if ($embedError) {

echo "cURL Error #:" . $embedError;

} else {

$embedResponse = json_decode($embedResponse, true);

$embedUrl = $embedResponse['value'][1]['embedUrl'];


}

?>







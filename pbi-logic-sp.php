<?php

// CURL API call to get an active directory token
$curl1 = curl_init();
curl_setopt_array($curl1, array(
//Get a token: https://docs.microsoft.com/en-us/azure/active-directory/develop/v2-oauth2-client-creds-grant-flow#get-a-token
CURLOPT_URL => "https://login.microsoftonline.com/[tenant id]/oauth2/v2.0/token", //Microsoft identity platform
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS => array(
// Use Service principle to authenticate and recieve an AAD token.
//https://powerbi.microsoft.com/en-us/blog/use-power-bi-api-with-service-principal-preview/
grant_type => 'client_credentials',
scope => 'https://analysis.windows.net/powerbi/api/.default',
redirectUri => 'https://localhost:44322', //Optional
client_id => '', // Registered web App ApplicationID
client_secret => '',
tenant_id => '' // This is your active directory tenant ID. I don't think you need it, since it's part of the URL.
)
));

$tokenResponse = curl_exec($curl1);
$tokenError = curl_error($curl1);
curl_close($curl1);

// Decode result, and store the access_token in $embeddedToken variable:

$tokenResult = json_decode($tokenResponse, true);
$embeddedToken = "Bearer "  . ' ' .  $token;


/* Second step in the two-legged OAuth process is to send a request to PBI with the AAD Bearer token and recieve an embed token used in JS embed configuration */

$group_Id = ''; //PBI Workspace ID

$curl2 = curl_init();
curl_setopt($curl2, CURLOPT_URL,'https://api.powerbi.com/v1.0/myorg/groups/[group id]/reports/[report id]/GenerateToken');
curl_setopt($curl2, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl2, CURLOPT_ENCODING, "");
curl_setopt($curl2, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl2, CURLOPT_TIMEOUT, 30);
curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl2, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl2, CURLOPT_HTTPHEADER,array(

       'Authorization:'.$embeddedToken,
       'Content-type: application/json',
       'Cache-control: no-cache'
    )); 

$tokenbody= array(datasets => array ('id'=> ''),
     targetWorkspaces =>array ('id'=> ''));

//After having issues with encoding the correct JSON for the API request. I am using static JSON code for testing.  

$jsontokenstatic = "{

  \"datasets\": [
    {
      'id': '0555073a-1111-4cf0-b479-b7faf545f0f6'
    }  
  ],
  \"targetWorkspaces\": [
    {
      'id': '0555c677-4555-44a6-aa05-79abcdefg9a9978'
    }  
  ]

}";

curl_setopt($curl2, CURLOPT_POSTFIELDS,$jsontokenstatic);
$pbiembedResponse  = curl_exec($curl2);
$embedError = curl_error($curl2);
curl_close($curl2);
$pbitokenResult = json_decode($pbiembedResponse, true);
$pbitoken = $pbitokenResult["token"]; //Get the pbi token required for the embed config

?>

<?php
include './vendor/autoload.php';

use \TempMailAPI\TempMail;
use \TempMailAPI\Helpers\InstagramAccountConfirmationHelper;

$username = "cigdem_amidar";
$dmain = "";

$tempMail = new TempMail();

// $response = $tempMail->getDomains();
// var_dump($response);

// $response = $tempMail->getNewAddress("yesim_ali_1998", "@vektik.com");
// var_dump($response);
// $mail = $response;

// $response = $tempMail->getMails("xorohutet@vektik.com", "Insta");
// var_dump($response);


// $response = $tempMail->readMail("https://temp-mail.org/en/view/de556c8b00a3f68011b52c507c0c10c6/");
// $response = $tempMail->readMail("https://temp-mail.org/en/view/2e21ae9325a9e93c31e1948f68bdc794");
// var_dump($response);

// $data = file_get_contents("./test.txt");
// $instagram = new InstagramAccountConfirmationHelper($data);



$tempMail = new TempMail();
$tempMailResponse = $tempMail->getMails("mail@vektik.com", "Insta");
print_r($tempMailResponse);
$readMailResponse = $tempMail->readMail($tempMailResponse[0]["readUrl"]);
print_r($readMailResponse);
$instagramHelperResponse = new \TempMailAPI\Helpers\InstagramAccountConfirmationHelper($readMailResponse);
echo "\n\n\n";
print_r($instagramHelperResponse->getConfirmationUrl());
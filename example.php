<?php
include './vendor/autoload.php';

use \TempMailAPI\TempMail;

$username = "cigdem_amidar";
$dmain = "";

$tempMail = new TempMail();
// $response = $tempMail->getDomains();

$response = $tempMail->getNewAddress("yesim_ali_1998", "@vektik.com");
var_dump($response);
// $mail = $response;

$response = $tempMail->getMails("yesim_ali_1998@vektik.com");
var_dump($response);


// $response = $tempMail->readMail("canisi_kiz_ist_89@vektik.com");
// var_dump($response);
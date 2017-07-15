<?php

include './vendor/autoload.php';

use \TempMailAPI\TempMail;

$tempMail = new TempMail();
// $response = $tempMail->getDomains();

// $response = $tempMail->getNewAddress("banucan");
// // var_dump($response);
// $mail = $response;


$response = $tempMail->getMails("canisi_kiz_ist_89@vektik.com");
var_dump($response);

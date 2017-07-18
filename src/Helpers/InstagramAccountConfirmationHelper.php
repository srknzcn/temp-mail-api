<?php
namespace TempMailAPI\Helpers;

use Sunra\PhpSimple\HtmlDomParser;
use GuzzleHttp\Client;

class InstagramAccountConfirmationHelper {

    protected $confirmationLinkFinderKey = "accounts/confirm_email";
    protected $confirmationUrl = "";

    public function __construct($html) {
        $dom = HtmlDomParser::str_get_html($html);
        $links = $dom->find("a");

        foreach ($links as $link) {
            if (strstr($link->href, $this->confirmationLinkFinderKey)) {
                $this->confirmationUrl = trim($link->href);
                break;
            }
        }
        
        return $this->confirmationUrl;
    }

    public function getConfirmationUrl() {
        return $this->confirmationUrl;
    }

    public function confirmAccount() {

    }

}
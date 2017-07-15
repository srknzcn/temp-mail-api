<?php
namespace TempMailAPI;

use TempMailAPI\Exceptions;
use Sunra\PhpSimple\HtmlDomParser;
use GuzzleHttp\Cookie\CookieJar;

class TempMail {

    protected $domains = null;
    protected $cookieJar = null;
    protected $cookieJarDomain = ".temp-mail.org";
    protected $mainUrl = "https://temp-mail.org/en/";
    protected $refreshUrl = "https://temp-mail.org/en/option/refresh/";

    /**
     * Returns the available domains list on temp-mail.org
     * 
     * @return Array
     */
    public function getDomains() {
        $client = new \GuzzleHttp\Client();
        $response = $client->get("https://temp-mail.org/en/option/change/");
        $dom = HtmlDomParser::str_get_html($response->getBody());

        $domainSelectBoxOptions = $dom->find('#domain > option');
        foreach($domainSelectBoxOptions as $optionEl) {
            $this->domains[] = trim($optionEl->value);
        }
        return $this->domains;
    }

    /**
     * Creates new mail address
     * If $mail and $domain parameters not defined, generates a random mail with random domain.
     * If only $mail parameter defined, generates a new mail address with random domain.
     * 
     * $domain must be start with @(at) character and must be available on temp-mail.org.
     * Otherwise throws InvalidDomainException
     * 
     * @param string $mail
     * @param string $domain
     * @return string
     */
    public function getNewAddress($mail = null, $domain = null) {
        try {
            if (!$domain) {
                $domains = $this->getDomains();
                $domain = $domains[array_rand($domains)];
            }

            if (!strstr($domain, "@")) {
                throw new Exceptions\InvalidDomainException();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        $clientParameters = [];
        if ($mail && $domain) {
            $clientParameters["cookies"] = CookieJar::fromArray([
                "mail" => urlencode($mail . $domain)
            ], $this->cookieJarDomain);
        }

        $client = new \GuzzleHttp\Client($clientParameters);       
        $response = $client->get($this->refreshUrl);

        $dom = HtmlDomParser::str_get_html($response->getBody());
        $mail = $dom->find("#mail", 0);

        return trim($mail->value);
    }

    /**
     * Returns all mails as an array with given mail address
     * 
     * @param string $mailAddress
     * @param boolean $unread
     * @return array
     */
    public function getMails($mailAddress = null, $filter = null) {
        try {
            if (!$mailAddress) {
                throw new Exceptions\FullMailAddressException();
            }

        } catch(\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        $jar = CookieJar::fromArray([
            'mail' => urlencode($mailAddress)
        ], $this->cookieJarDomain);

        $client = new \GuzzleHttp\Client(['cookies' => $jar]);
        $response = $client->get($this->refreshUrl);
        $dom = HtmlDomParser::str_get_html($response->getBody());

        $mailRows = $dom->find("#mails tbody tr");
        unset($mailRows[0]);

        $mails = [];
        foreach($mailRows as $row) {
            $senderItem = $row->find("a", 0);
            $subjectItem = $row->find("a", 1);

            // filter mails
            if ($filter) {
                if (!stristr($subjectItem->plaintext, $filter)) {
                    continue;
                }
            }

            $mails[] = [
                "sender" => trim($senderItem->plaintext),
                "subject" => trim($subjectItem->plaintext),
                "readUrl" => trim($senderItem->href)
            ];
        }
        return $mails;
    }

    public function readMail($readMailUrl = null) {
        try {
            if (!$readMailUrl) {
                throw new InvalidMailUrlException();
            }
        } catch(\Exception $e) {
            echo $e->getMessage();
            return false;
        }
        
        $client = new \GuzzleHttp\Client();
        $response = $client->get($readMailUrl);
        $dom = HtmlDomParser::str_get_html($response->getBody());

    }
}
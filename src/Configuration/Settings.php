<?php

namespace SkillDisplay\PHPToolKit\Configuration;

class Settings{

    private string $user_secret = '';
    private string $apiKey = '';
    private int $verifierID = 0;
    private string $APIUrl = '';
    private string $mySkillDisplayUrl = '';

    /**
     * @return int
     */
    public function getVerifierID(): int
    {
        return $this->verifierID;
    }

    /**
     * @return string
     */
    public function getUserSecret(): string
    {
        return $this->user_secret;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getAPIUrl(): string
    {
        return $this->APIUrl;
    }

    /**
     * @return string
     */
    public function getMySkillDisplayUrl(): string
    {
        return $this->mySkillDisplayUrl;
    }

    /**
     * Settings constructor.
     * @param string $apiKey API Key to allow the application to use the endpoint
     * @param int $verifierID ID of the Verifier entry, necessary for Educational-Verification, Business-Verification or Certification
     * @param string $user_secret Secret Key of the Verifier - necessary for Educational-Verification, Business-Verification or Certification
     * @param string|null $domain URL of the SkillDisplay instance - usually this will be the public one on skilldisplay.eu
     */
    public function __construct(string $apiKey, int $verifierID = 0, string $user_secret = '', string $domain = null)
    {
        $this->apiKey = $apiKey;
        $this->verifierID = $verifierID;
        $this->user_secret = $user_secret;
        $this->APIUrl = (is_null($domain)) ? 'https://www.skilldisplay.eu' : 'https://'.$domain;
        $this->mySkillDisplayUrl = (is_null($domain)) ? 'https://my.skilldisplay.eu' : 'https://my.'.$domain;
    }
}


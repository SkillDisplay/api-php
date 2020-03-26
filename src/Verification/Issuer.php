<?php

namespace SkillDisplay\APIToolKit\Verification;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SkillDisplay\APIToolKit\Configuration\Settings;

class Issuer {
    private Settings $settings;

    /***
     * @param int $skillID ID of the Skill or SkillSet
     * @param string $useremail E-Mail of the User who should receive the verification
     * @param string $vtype one of VERIFICATION_SELF, VERIFICATION_EDUCATIONAL, VERIFICATION_BUSINESS, VERIFICATION_CERTIFICATION
     * @return array
     */
    private function generateSignedRequestData(int $skillID, string $useremail, string $vtype) : array {
        $requestData = [
            "SkillId" => $skillID,
            "Level" => $vtype,
            "VerifierId" => $this->settings->getVerifierID(),
            "Username" => $useremail,
            "AutoConfirm" => true,
            "Signature" => ''
        ];

        $json = json_encode($requestData);
        $signature = ($vtype==="self") ? 'sdself' : $this->settings->getUserSecret();
        $requestData['Signature'] = hash('sha256', $json . $signature);

        return $requestData;
    }

    /**
     * @param ResponseInterface $response Response of a performed request
     *
     * Outputs a response of a request directly on the page
     */
    private function outputResponse(ResponseInterface $response){
        // Get all of the response headers.
        foreach ($response->getHeaders() as $name => $values) {
            echo $name . ': ' . implode(', ', $values) . "\r\n";
        }
        $body = $response->getBody();
        echo $body;
    }

    /***
     * @param int $skillID SkillID of the skill for which the verification should be issued (can be read from URL after a search - eg.: https://my.dev.skilldisplay.eu/skill/4/0 has ID 4)
     * @param string $useremail E-Mail of the SkillDisplay user for whom you want to verify the skill
     * @param string $vtype Verification type, one of the constants in /src/Constants/VerificationTypes.php
     */
    public function issueVerification(int $skillID, string $useremail, string $vtype){
        $requestData = $this->generateSignedRequestData($skillID, $useremail, $vtype);

        $client = new \GuzzleHttp\Client();
        $request = new Request(
            'POST',
            $this->settings->getVerificationURL(),
            array(
                'Content-Type' => 'application/json',
                'x-api-key' => $this->settings->getApiKey()
            ),
            json_encode($requestData)
        );

        $response = $client->send($request);
        $this->outputResponse($response);
    }

    /**
     * Issuer constructor.
     * @param Settings $settings Pass the settings for the Verification API
     */
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
}
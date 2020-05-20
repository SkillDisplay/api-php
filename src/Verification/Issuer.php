<?php

namespace SkillDisplay\PHPToolKit\Verification;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SkillDisplay\PHPToolKit\Configuration\Settings;

class Issuer {
    private Settings $settings;
    private string $apislug = '/api/v1/verification/create';

    /***
     * @param int $skillID ID of the Skill or SkillSet
     * @param string $useremail E-Mail of the User who should receive the verification
     * @param string $vtype one of VERIFICATION_SELF, VERIFICATION_EDUCATIONAL, VERIFICATION_BUSINESS, VERIFICATION_CERTIFICATION
     * @return array
     */
    private function generateSignedRequestData(int $ID, string $useremail, string $vtype, bool $isSkillSet = false) : array {

        if($isSkillSet){
            $requestData['SkillSetId'] = $ID;
        }
        else{
            $requestData['SkillId'] = $ID;
        }

        $requestData = [
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
    public function outputResponse(ResponseInterface $response){
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
     * @param bool $isSkillSet is the passed ID that of a SkillSet (else it is a single skill, also default)
     * @return ResponseInterface
     */
    public function issueVerification(int $skillID, string $useremail, string $vtype, bool $isSkillSet = false) : ResponseInterface {
        $requestData = $this->generateSignedRequestData($skillID, $useremail, $vtype, $isSkillSet);

        $client = new \GuzzleHttp\Client();
        $request = new Request(
            'POST',
            $this->settings->getAPIUrl() . $this->apislug,
            array(
                'Content-Type' => 'application/json',
                'x-api-key' => $this->settings->getApiKey()
            ),
            json_encode($requestData)
        );

        return $client->send($request);

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
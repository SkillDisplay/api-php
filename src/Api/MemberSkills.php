<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use GuzzleHttp\Psr7\Request;
use SkillDisplay\PHPToolKit\Entity\Campaign;
use SkillDisplay\PHPToolKit\Entity\MemberSkill;
use SkillDisplay\PHPToolKit\Entity\MemberSkill as Entity;

class MemberSkills
{
    protected Settings $settings;

    protected Client $client;

    public function __construct(
        Settings $settings,
        Client $client
    ) {
        $this->settings = $settings;
        $this->client = $client;
    }

    public function getMemberSkillsById(int $id)
    {
        if ($id <= 0) {
            throw new \Exception('ID of Organisation has to be a positive integer.');
        }
        $url = $this->settings->getAPIUrl() . '/api/v1/organisation/' . $id . '/listVerifications/json';
        try {
            $result = $this->client->send(new Request(
                'GET',
                $url,
                [
                    'Content-Type' => 'application/json',
                    'x-api-key' => $this->settings->getApiKey()
                ]
            ));
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new \InvalidArgumentException('Given Organisation with id "' . $id . '" not available.', 1601881616);
            }
            throw $e;
        }

        if ($result->getStatusCode() !== 200) {
            throw new \Exception('Did not get proper response for Organisation.', 1600693562);
        }

        $body = (string) $result->getBody();

        if (strpos($body, 'Oops, an error occurred') !== false) {
            throw new \Exception('Did not get proper response for Organisation. Organisation with id "' . $id . '" does probably not exist.', 1600694312);
        }

        $body = json_decode((string) $result->getBody(), true);
        $skills = [];
        foreach ($body as $skill) {
            $skills[] = Entity::createFromJson(json_encode($skill), $this->settings);
        }
        return $skills;
    }
}

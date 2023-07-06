<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use GuzzleHttp\Psr7\Request;
use SkillDisplay\PHPToolKit\Entity\Organisation as Entity;

class Organisation
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

    public function getStatisticById(int $id)
    {
        if ($id <= 0) {
            throw new \Exception('ID of Organisation has to be a positive integer.');
        }
        $url = $this->settings->getAPIUrl() . '/api/v1/organisation/' . $id . '/statistic';
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
        return Entity::createFromJson($body, $this->settings);
    }
}

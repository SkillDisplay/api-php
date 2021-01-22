<?php

declare(strict_types=1);

/*
 * Copyright (C) 2020 Matthias Böhm <matthias.boehm@reelworx.at>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301, USA.
 */

namespace SkillDisplay\PHPToolKit\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\Campaign;

class Campaigns
{
    /**
     * @var Settings
     */
    protected $settings;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(
        Settings $settings,
        Client $client
    ) {
        $this->settings = $settings;
        $this->client = $client;
    }

    public function getForUser(): array
    {
        $url = $this->settings->getAPIUrl() . '/api/v1/campaigns';
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
            if ($e->getCode() === 400) {
                throw new \InvalidArgumentException($e->getMessage(), 1605877581);
            }
            throw $e;
        }

        if ($result->getStatusCode() !== 200) {
            throw new \Exception('API key or user invalid.', 1605878128);
        }
        $body = json_decode((string) $result->getBody(), true);
        $campaigns = [];
        foreach ($body['Campaigns'] as $campaign) {
            $campaigns[] = new Campaign($campaign, $this->settings);
        }
        return $campaigns;
    }
}

<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Api;

/*
 * Copyright (C) 2020 Daniel Siepmann <coding@daniel-siepmann.de>
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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use RuntimeException;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\SkillSet as Entity;

class SkillSet
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

    public function getById(int $id, bool $includeFullSkills = false): Entity
    {
        if ($id <= 0) {
            throw new \Exception('ID of SkillSet has to be a positive integer.', 1600764811);
        }

        $url = $this->settings->getAPIUrl() . '/api/v1/skillset/' . $id;
        if ($includeFullSkills) {
            $url .= '?includeFullSkills';
        }
        try {
            $result = $this->client->send(
                new Request(
                    'GET',
                    $url,
                    [
                        'Content-Type' => 'application/json',
                        'x-api-key' => $this->settings->getApiKey()
                    ]
                )
            );
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new InvalidArgumentException('Given SkillSet with id "' . $id . '" not available.', 1601881616);
            }
            throw $e;
        }

        if ($result->getStatusCode() !== 200) {
            throw new \Exception('Did not get proper response for SkillSet.', 1600694312);
        }

        $body = (string)$result->getBody();

        if (strpos($body, 'Oops, an error occurred') !== false) {
            throw new \Exception(
                'Did not get proper response for SkillSet. SkillSet with id "' . $id . '" does probably not exist.',
                1600694312
            );
        }

        return Entity::createFromJson($body, $this->settings);
    }

    /**
     * @param bool $includeFullSkills
     * @return Entity[]
     */
    public function getAll(bool $includeFullSkills = false): array
    {
        $url = $this->settings->getAPIUrl() . '/api/v1/skillsets';
        if ($includeFullSkills) {
            $url .= '?includeFullSkills';
        }
        try {
            $result = $this->client->send(
                new Request(
                    'GET',
                    $url,
                    [
                        'Content-Type' => 'application/json',
                        'x-api-key' => $this->settings->getApiKey()
                    ]
                )
            );
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                throw new InvalidArgumentException('Failed to fetch Skill Set data.', 1688726816);
            }
            throw $e;
        }

        if ($result->getStatusCode() !== 200) {
            throw new RuntimeException('Did not get proper response for SkillSets.', 1688726814);
        }

        $body = (string)$result->getBody();

        if (strpos($body, 'Oops, an error occurred') !== false) {
            throw new RuntimeException('Did not get proper response for SkillSets.', 1688726813);
        }

        $skillSetsJson = json_decode($body, true);
        $skillSets = [];
        foreach ($skillSetsJson as $skillSet) {
            $skillSets[] = Entity::createFromArray($skillSet, $this->settings);
        }

        return $skillSets;
    }
}

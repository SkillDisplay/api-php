<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Api;

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
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Api\SkillSet;
use PHPUnit\Framework\TestCase;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\SkillSet as Entity;

/**
 * @covers SkillDisplay\PHPToolKit\Api\SkillSet
 */
class SkillSetTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreated()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);

        $subject = new SkillSet(
            $settings->reveal(),
            $client->reveal()
        );

        static::assertInstanceOf(SkillSet::class, $subject);
    }

    /**
     * @test
     */
    public function fetchedEntityFromApi()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);
        $response = $this->prophesize(Response::class);

        $settings->getAPIUrl()->willReturn('https://example.com');
        $settings->getApiKey()->willReturn('none');

        $client->send(Argument::that(function (Request $request) {
            return (string) $request->getUri() === 'https://example.com/api/v1/skillset/10'
                && $request->getHeader('x-api-key') === ['none']
                && $request->getHeader('Content-Type') === ['application/json']
                && $request->getMethod() === 'GET'
                ;
        }))->willReturn($response->reveal());

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn(Utils::streamFor('{"uid":10}'));

        $subject = new SkillSet(
            $settings->reveal(),
            $client->reveal()
        );
        $result = $subject->getById(10);
        static::assertInstanceOf(Entity::class, $result);
    }

    /**
     * @test
     */
    public function throwsExceptionIfStatusCodeIsNot200()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);
        $response = $this->prophesize(Response::class);

        $settings->getAPIUrl()->willReturn('https://example.com');
        $settings->getApiKey()->willReturn('none');

        $client->send(Argument::any())->willReturn($response->reveal());

        $response->getStatusCode()->willReturn(500);

        $subject = new SkillSet(
            $settings->reveal(),
            $client->reveal()
        );

        $this->expectExceptionMessage('Did not get proper response for SkillSet.');
        $this->expectExceptionCode(1600694312);

        $result = $subject->getById(10);
    }

    /**
     * @test
     * @dataProvider nonePositiveIds
     */
    public function throwsExceptionIfSkillSetIdIsNotPositive(int $skillId)
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);

        $subject = new SkillSet(
            $settings->reveal(),
            $client->reveal()
        );

        $this->expectExceptionMessage('ID of SkillSet has to be a positive integer.');
        $this->expectExceptionCode(1600764811);

        $subject->getById($skillId);
    }

    public function nonePositiveIds(): array
    {
        return [
            'zero' => [
                'skillId' => 0,
            ],
            'negative' => [
                'skillId' => -1,
            ],
        ];
    }
}

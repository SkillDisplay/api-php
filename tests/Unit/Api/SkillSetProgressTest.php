<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Api;

/*
 * Copyright (C) 2023 Julian Zangl <julian.zangl@outlook.com>
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
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Api\SkillSetProgress;
use PHPUnit\Framework\TestCase;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\SkillSetProgress as Entity;

/**
 * @covers SkillDisplay\PHPToolKit\Api\SkillSetProgress
 */

class SkillSetProgressTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreated()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);

        $subject = new SkillSetProgress(
            $settings->reveal(),
            $client->reveal()
        );

        static::assertInstanceOf(SkillSetProgress::class, $subject);
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
            return (string) $request->getUri() === 'https://example.com/api/v1/skillset/10/progress'
                && $request->getHeader('x-api-key') === ['none']
                && $request->getHeader('Content-Type') === ['application/json']
                && $request->getMethod() === 'GET'
                ;
        }))->willReturn($response->reveal());

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn('{"tier3":44.44444444444444,"tier2":40.74074074074074,"tier1":0,"tier4":0}');

        $progress = new SkillSetProgress(
            $settings->reveal(),
            $client->reveal()
        );
        $result = $progress->getById(10);
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

        $progress = new SkillSetProgress(
            $settings->reveal(),
            $client->reveal()
        );

        $this->expectExceptionMessage('Did not get proper response for SkillSetProgress.');
        $this->expectExceptionCode(1688639840720);
        $progress->getById(10);
    }

    /**
     * @test
     * @dataProvider nonePositiveIds
     */
    public function throwsExceptionIfSkillSetIdIsNotPositive(int $skillId)
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);

        $progress = new SkillSetProgress(
            $settings->reveal(),
            $client->reveal()
        );

        $this->expectExceptionMessage('ID of SkillSet has to be a positive integer.');
        $this->expectExceptionCode(1688639724754);

        $progress->getById($skillId);
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

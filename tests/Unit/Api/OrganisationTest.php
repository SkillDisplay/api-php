<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Api;

use GuzzleHttp\Psr7\Request;
use Prophecy\Argument;
use SkillDisplay\PHPToolKit\Api\Organisation;
use SkillDisplay\PHPToolKit\Api\SkillSet;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use GuzzleHttp\Psr7\Response;
use SkillDisplay\PHPToolKit\Entity\Organisation as Entity;

/**
 * @covers SkillDisplay\PHPToolKit\Api\Organisation
 */
class OrganisationTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreated()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);
        $subject = new Organisation($settings->reveal(), $client->reveal());

        static::assertInstanceOf(Organisation::class, $subject);
    }

    /**
     * @test
     */
    public function fetchOrganisationStatistic()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);
        $response = $this->prophesize(Response::class);

        $settings->getAPIUrl()->willReturn('https://example.com');
        $settings->getApiKey()->willReturn('none');

        $client->send(Argument::that(function (Request $request) {
            return (string)$request->getUri() === 'https://example.com/api/v1/organisation/10/statistic'
                && $request->getHeader('x-api-key') === ['none']
                && $request->getHeader('Content-Type') === ['application/json']
                && $request->getMethod() === 'GET';
        }))->willReturn($response->reveal());

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn('{"uid":10}');

        $subject = new Organisation(
            $settings->reveal(),
            $client->reveal()
        );
        $result = $subject->getStatisticById(10);
        static::assertInstanceOf(Entity::class, $result);
    }
}

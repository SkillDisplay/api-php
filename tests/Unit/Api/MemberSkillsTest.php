<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Api;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils;
use Prophecy\Argument;
use SkillDisplay\PHPToolKit\Api\MemberSkills;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\MemberSkill;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * @covers SkillDisplay\PHPToolKit\Api\MemberSkills
 */
class MemberSkillsTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreated()
    {
        $settings = $this->prophesize(Settings::class);
        $client = $this->prophesize(Client::class);
        $subject = new MemberSkills($settings->reveal(), $client->reveal());
        static::assertInstanceOf(MemberSkills::class, $subject);
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
            return (string) $request->getUri() === 'https://example.com/api/v1/organisation/10/listVerifications/json'
                && $request->getHeader('x-api-key') === ['none']
                && $request->getHeader('Content-Type') === ['application/json']
                && $request->getMethod() === 'GET';
        }))->willReturn($response->reveal());

        $response->getStatusCode()->willReturn(200);
        $response->getBody()->willReturn(Utils::streamFor('[{"uid": 1},{"uid": 2}]'));

        $subject = new MemberSkills($settings->reveal(), $client->reveal());
        $skills = $subject->getMemberSkillsById(10);

        static::assertInstanceOf(MemberSkill::class, $skills[0]);
        static::assertEquals(1, $skills[0]->getId());
    }
}

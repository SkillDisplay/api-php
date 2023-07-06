<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Entity;

use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\Brand;
use SkillDisplay\PHPToolKit\Entity\Organisation;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\Organisation
 */
class OrganisationTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Organisation::createFromJson('{}', $settings->reveal());
        static::assertInstanceOf(Organisation::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Organisation::createFromJson('{"uid":90}', $settings->reveal());
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsName()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Organisation::createFromJson('{"name":"Example name"}', $settings->reveal());
        static::assertSame('Example name', $subject->getName());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Organisation::createFromJson('{"uid":90,"name":"Example name"}', $settings->reveal());
        static::assertSame(['uid' => 90, 'name' => 'Example name'], $subject->toArray());
    }
}

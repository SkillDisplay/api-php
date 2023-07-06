<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Entity;

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

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\Brand;
use SkillDisplay\PHPToolKit\Entity\SkillSet;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\SkillSet
 */
class SkillSetTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanNotBeCreatedViaConstructor()
    {
        $this->expectExceptionMessage('Call to private SkillDisplay\PHPToolKit\Entity\SkillSet::__construct() from scope SkillDisplay\PHPToolKit\Tests\Unit\Entity\SkillSetTest');
        new SkillSet();
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{}', $settings->reveal());
        static::assertInstanceOf(SkillSet::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"uid":90}', $settings->reveal());
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsName()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"name":"Example name"}', $settings->reveal());
        static::assertSame('Example name', $subject->getName());
    }

    /**
     * @test
     */
    public function instanceReturnsDescription()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"description":"<p>Example description</p>"}', $settings->reveal());
        static::assertSame('<p>Example description</p>', $subject->getDescription());
    }

    /**
     * @test
     */
    public function instanceReturnsProgressPercentage()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"progressPercentage":{"tier3":44.44444444444444,"tier2":40.74074074074074,"tier1":0,"tier4":23}}', $settings->reveal());
        $progress = \SkillDisplay\PHPToolKit\Entity\SkillSetProgress::createFromJson('{"tier3":44.44444444444444,"tier2":40.74074074074074,"tier1":0,"tier4":23}', $settings->reveal());
        static::assertEquals($progress, $subject->getProgressPercentage());
        static::assertSame(0.0, $subject->getProgressPercentage()->getTier1());
        static::assertSame(40.74074074074074, $subject->getProgressPercentage()->getTier2());
        static::assertSame(44.44444444444444, $subject->getProgressPercentage()->getTier3());
        static::assertSame(23.0, $subject->getProgressPercentage()->getTier4());
    }

    /**
     * @test
     */
    public function instanceReturnsBrand()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"brand":{"uid":"10"}}', $settings->reveal());
        static::assertInstanceOf(Brand::class, $subject->getBrand());
    }

    /**
     * @test
     */
    public function instanceReturnsEmptyStringAsMediaPublicUrlPrefixedWithConfiguredMySkillDisplayUrl()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://example.com');
        $subject = SkillSet::createFromJson('{"mediaPublicUrl":""}', $settings->reveal());
        static::assertSame('', $subject->getMediaPublicUrl());
    }

    /**
     * @test
     */
    public function instanceReturnsMediaPublicUrlPrefixedWithConfiguredMySkillDisplayUrl()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getAPIUrl()->willReturn('https://example.com');
        $subject = SkillSet::createFromJson('{"mediaPublicUrl":"fileadmin/SkillSets/Images/TYPO3/TCCD_10LTS.jpg"}', $settings->reveal());
        static::assertSame('https://example.com/fileadmin/SkillSets/Images/TYPO3/TCCD_10LTS.jpg', $subject->getMediaPublicUrl());
    }

    /**
     * @test
     */
    public function instanceReturnsSkills()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}', $settings->reveal());
        $skills = $subject->getSkills();

        static::assertCount(2, $skills);
        static::assertSame(90, $skills[0]->getId());
        static::assertSame(91, $skills[1]->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsSameSkillInstancesA2ndTime()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}', $settings->reveal());
        $skillsFirstCall = $subject->getSkills();
        $skillsSecondCall = $subject->getSkills();

        static::assertSame($skillsFirstCall, $skillsSecondCall);
    }

    /**
     * @test
     */
    public function twoDifferentInstancesProvideTheirOwnSkills()
    {
        $settings = $this->prophesize(Settings::class);
        $subject1 = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}', $settings->reveal());
        $subject2 = SkillSet::createFromJson('{"skills":[{"uid":80,"title":"Example title 10"},{"goals":"<p>Example goals</p>","uid":81,"title":"Example title 11"}]}', $settings->reveal());

        static::assertSame(90, $subject1->getSkills()[0]->getId());
        static::assertSame(80, $subject2->getSkills()[0]->getId());
    }

    /**
     * @test
     */
    public function canReturnAsArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"uid":90,"name":"Example name"}', $settings->reveal());
        static::assertSame([
            'uid' => 90,
            'name' => 'Example name',
        ], $subject->getAsArray());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = SkillSet::createFromJson('{"uid":90,"name":"Example name"}', $settings->reveal());
        static::assertSame([
            'uid' => 90,
            'name' => 'Example name',
        ], $subject->toArray());
    }
}

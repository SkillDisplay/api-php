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
use SkillDisplay\PHPToolKit\Entity\Skill;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\Skill
 */
class SkillTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanNotBeCreatedViaConstructor()
    {
        $this->expectExceptionMessage('Call to private SkillDisplay\PHPToolKit\Entity\Skill::__construct() from scope SkillDisplay\PHPToolKit\Tests\Unit\Entity\SkillTest');
        new Skill();
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{}', $settings->reveal());
        static::assertInstanceOf(Skill::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"uid":90}', $settings->reveal());
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsTitle()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"title":"Example title"}', $settings->reveal());
        static::assertSame('Example title', $subject->getTitle());
    }

    /**
     * @test
     */
    public function instanceReturnsDescription()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"description":"<p>Example description</p>"}', $settings->reveal());
        static::assertSame('<p>Example description</p>', $subject->getDescription());
    }

    /**
     * @test
     */
    public function instanceReturnsGoals()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"goals":"<p>Example goals</p>"}', $settings->reveal());
        static::assertSame('<p>Example goals</p>', $subject->getGoals());
    }

    /**
     * @test
     */
    public function instanceReturnsBrands()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"brands":[{"uid":10}]}', $settings->reveal());
        static::assertCount(1, $subject->getBrands());
        static::assertInstanceOf(Brand::class, $subject->getBrands()[0]);
    }

    /**
     * @test
     */
    public function canReturnAsArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"goals":"<p>Example goals</p>","uid":90,"title":"Example title"}', $settings->reveal());
        static::assertSame([
            'goals' => '<p>Example goals</p>',
            'uid' => 90,
            'title' => 'Example title',
        ], $subject->getAsArray());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Skill::createFromJson('{"goals":"<p>Example goals</p>","uid":90,"title":"Example title"}', $settings->reveal());
        static::assertSame([
            'goals' => '<p>Example goals</p>',
            'uid' => 90,
            'title' => 'Example title',
        ], $subject->toArray());
    }
}

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

use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\Brand;
use PHPUnit\Framework\TestCase;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\Brand
 */
class BrandTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanNotBeCreatedViaConstructor()
    {
        $this->expectErrorMessage('Call to private SkillDisplay\PHPToolKit\Entity\Brand::__construct() from context \'SkillDisplay\PHPToolKit\Tests\Unit\Entity\BrandTest\'');
        new Brand();
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Brand::createFromJson('{}', $settings->reveal());
        static::assertInstanceOf(Brand::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Brand::createFromJson('{"uid":90}', $settings->reveal());
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsName()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Brand::createFromJson('{"name":"Example name"}', $settings->reveal());
        static::assertSame('Example name', $subject->getName());
    }

    /**
     * @test
     */
    public function instanceReturnsUrl()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Brand::createFromJson('{"url":"https://example.com"}', $settings->reveal());
        static::assertSame('https://example.com', $subject->getUrl());
    }

    /**
     * @test
     */
    public function instanceReturnsEmptyStringAsLogoPublicUrlPrefixedWithConfiguredMySkillDisplayUrl()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://example.com');
        $subject = Brand::createFromJson('{"logoPublicUrl":""}', $settings->reveal());
        static::assertSame('', $subject->getLogoPublicUrl());
    }

    /**
     * @test
     */
    public function instanceReturnsLogoPublicUrlPrefixedWithConfiguredMySkillDisplayUrl()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://example.com');
        $subject = Brand::createFromJson('{"logoPublicUrl":"fileadmin/SkillSets/Images/TYPO3/TCCD_10LTS.jpg"}', $settings->reveal());
        static::assertSame('https://example.com/fileadmin/SkillSets/Images/TYPO3/TCCD_10LTS.jpg', $subject->getLogoPublicUrl());
    }

    /**
     * @test
     */
    public function canReturnAsArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = Brand::createFromJson('{"uid":90,"name":"Example name"}', $settings->reveal());
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
        $subject = Brand::createFromJson('{"goals":"<p>Example goals</p>","uid":90,"title":"Example title"}', $settings->reveal());
        static::assertSame([
            'goals' => '<p>Example goals</p>',
            'uid' => 90,
            'title' => 'Example title',
        ], $subject->toArray());
    }
}

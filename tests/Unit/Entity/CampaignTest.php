<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Entity;

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

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\Campaign;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\Campaign
 */
class CampaignTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Campaign([], $settings->reveal());
        static::assertInstanceOf(Campaign::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Campaign(['uid' => 1], $settings->reveal());
        static::assertSame(1, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsTitle()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Campaign(['title' => 'Example Campaign'], $settings->reveal());
        static::assertSame('Example Campaign', $subject->getTitle());
    }

    /**
     * @test
     */
    public function canReturnAsArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Campaign(['uid' => 1, 'title' => 'Example Campaign'], $settings->reveal());
        static::assertSame([
            'uid' => 1,
            'title' => 'Example Campaign',
        ], $subject->getAsArray());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Campaign(['uid' => 1, 'title' => 'Example Campaign'], $settings->reveal());
        static::assertSame([
            'uid' => 1,
            'title' => 'Example Campaign',
        ], $subject->toArray());
    }
}

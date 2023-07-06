<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Entity;

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

use Prophecy\PhpUnit\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Entity\SkillSetProgress;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\SkillSetProgress
 */
class SkillSetProgressTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $settings = $this->prophesize(Settings::class);
        $progress = SkillSetProgress::createFromJson('{}', $settings->reveal());
        static::assertInstanceOf(SkillSetProgress::class, $progress);
    }

    /**
     * @test
     */
    public function instanceReturnsTier1()
    {
        $settings = $this->prophesize(Settings::class);
        $progress = SkillSetProgress::createFromJson('{"tier1": 44.444444}', $settings->reveal());
        static::assertSame(44.444444, $progress->getTier1());
    }

    /**
     * @test
     */
    public function instanceReturnsTier2()
    {
        $settings = $this->prophesize(Settings::class);
        $progress = SkillSetProgress::createFromJson('{"tier2": 44.444444}', $settings->reveal());
        static::assertSame(44.444444, $progress->getTier2());
    }

    /**
     * @test
     */
    public function instanceReturnsTier3()
    {
        $settings = $this->prophesize(Settings::class);
        $progress = SkillSetProgress::createFromJson('{"tier3": 44}', $settings->reveal());
        static::assertSame(44.0, $progress->getTier3());
    }

    /**
     * @test
     */
    public function instanceReturnsTier4()
    {
        $settings = $this->prophesize(Settings::class);
        $progress = SkillSetProgress::createFromJson('{"tier4": 0}', $settings->reveal());
        static::assertSame(0.0, $progress->getTier4());
    }
}

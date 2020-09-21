<?php

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
use SkillDisplay\PHPToolKit\Entity\Skill;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\Skill
 */
class SkillTest extends TestCase
{
    /**
     * @test
     */
    public function instanceCanNotBeCreatedViaConstructor()
    {
        $this->expectErrorMessage('Call to private SkillDisplay\PHPToolKit\Entity\Skill::__construct() from context \'SkillDisplay\PHPToolKit\Tests\Unit\Entity\SkillTest\'');
        new Skill();
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $subject = Skill::createFromJson('{}');
        static::assertInstanceOf(Skill::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $subject = Skill::createFromJson('{"uid":90}');
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsTitle()
    {
        $subject = Skill::createFromJson('{"title":"Example title"}');
        static::assertSame('Example title', $subject->getTitle());
    }

    /**
     * @test
     */
    public function instanceReturnsDescription()
    {
        $subject = Skill::createFromJson('{"description":"<p>Example description</p>"}');
        static::assertSame('<p>Example description</p>', $subject->getDescription());
    }

    /**
     * @test
     */
    public function instanceReturnsGoals()
    {
        $subject = Skill::createFromJson('{"goals":"<p>Example goals</p>"}');
        static::assertSame('<p>Example goals</p>', $subject->getGoals());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $subject = Skill::createFromJson('{"goals":"<p>Example goals</p>","uid":90,"title":"Example title"}');
        static::assertSame([
            'goals' => '<p>Example goals</p>',
            'uid' => 90,
            'title' => 'Example title',
        ], $subject->toArray());
    }
}

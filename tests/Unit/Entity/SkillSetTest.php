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
use SkillDisplay\PHPToolKit\Entity\SkillSet;

/**
 * @covers SkillDisplay\PHPToolKit\Entity\SkillSet
 */
class SkillSetTest extends TestCase
{
    /**
     * @test
     */
    public function instanceCanNotBeCreatedViaConstructor()
    {
        $this->expectErrorMessage('Call to private SkillDisplay\PHPToolKit\Entity\SkillSet::__construct() from context \'SkillDisplay\PHPToolKit\Tests\Unit\Entity\SkillSetTest\'');
        new SkillSet();
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedFromJson()
    {
        $subject = SkillSet::createFromJson('{}');
        static::assertInstanceOf(SkillSet::class, $subject);
    }

    /**
     * @test
     */
    public function instanceReturnsId()
    {
        $subject = SkillSet::createFromJson('{"uid":90}');
        static::assertSame(90, $subject->getId());
    }

    /**
     * @test
     */
    public function instanceReturnsName()
    {
        $subject = SkillSet::createFromJson('{"name":"Example name"}');
        static::assertSame('Example name', $subject->getName());
    }

    /**
     * @test
     */
    public function instanceReturnsDescription()
    {
        $subject = SkillSet::createFromJson('{"description":"<p>Example description</p>"}');
        static::assertSame('<p>Example description</p>', $subject->getDescription());
    }

    /**
     * @test
     */
    public function instanceReturnsSkills()
    {
        $subject = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}');
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
        $subject = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}');
        $skillsFirstCall = $subject->getSkills();
        $skillsSecondCall = $subject->getSkills();

        static::assertSame($skillsFirstCall, $skillsSecondCall);
    }

    /**
     * @test
     */
    public function twoDifferentInstancesProvideTheirOwnSkills()
    {
        $subject1 = SkillSet::createFromJson('{"skills":[{"uid":90,"title":"Example title 1"},{"goals":"<p>Example goals</p>","uid":91,"title":"Example title 2"}]}');
        $subject2 = SkillSet::createFromJson('{"skills":[{"uid":80,"title":"Example title 10"},{"goals":"<p>Example goals</p>","uid":81,"title":"Example title 11"}]}');

        static::assertSame(90, $subject1->getSkills()[0]->getId());
        static::assertSame(80, $subject2->getSkills()[0]->getId());
    }

    /**
     * @test
     */
    public function canBeConvertedToArray()
    {
        $subject = SkillSet::createFromJson('{"uid":90,"name":"Example name"}');
        static::assertSame([
            'uid' => 90,
            'name' => 'Example name',
        ], $subject->toArray());
    }
}

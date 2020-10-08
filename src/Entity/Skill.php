<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Entity;

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

class Skill
{
    /**
     * @var array
     */
    private $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->data['uid'];
    }

    public function getTitle(): string
    {
        return $this->data['title'] ?? '';
    }

    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    public function getGoals(): string
    {
        return $this->data['goals'] ?? '';
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public static function createFromJson(string $json): Skill
    {
        return new Skill(json_decode($json, true));
    }
}

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

use SkillDisplay\PHPToolKit\Configuration\Settings;

class Skill
{
    private array $data;

    private Settings $settings;

    private array $brands = [];

    private function __construct(array $data, Settings $settings)
    {
        $this->data = $data;
        $this->settings = $settings;
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

    /**
     * @return Brand[]
     */
    public function getBrands(): array
    {
        if ($this->brands !== []) {
            return $this->brands;
        }

        foreach ($this->data['brands'] as $brand) {
            $this->brands[] = Brand::createFromJson(json_encode($brand), $this->settings);
        }

        return $this->brands;
    }

    // In order to support frameworks / APIs that expect "getter".
    public function getAsArray(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public static function createFromJson(string $json, Settings $settings): Skill
    {
        return new Skill(json_decode($json, true), $settings);
    }
}

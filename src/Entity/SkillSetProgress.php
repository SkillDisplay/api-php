<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Entity;

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

use SkillDisplay\PHPToolKit\Configuration\Settings;

class SkillSetProgress {
    private array $data;

    private Settings $settings;

    private function __construct(array $data, Settings $settings)
    {
        $this->data = $data;
        $this->settings = $settings;
    }

    public function getTier1(): float
    {
        return $this->data['tier1'] ?? 0;
    }

    public function getTier2(): float
    {
        return $this->data['tier2'] ?? 0;
    }

    public function getTier3(): float
    {
        return $this->data['tier3'] ?? 0;
    }

    public function getTier4(): float
    {
        return $this->data['tier4'] ?? 0;
    }

    public static function createFromJson(string $json, Settings $settings): SkillSetProgress
    {
        return new SkillSetProgress(json_decode($json, true), $settings);
    }
}

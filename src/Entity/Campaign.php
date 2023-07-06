<?php

declare(strict_types=1);

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

namespace SkillDisplay\PHPToolKit\Entity;

use SkillDisplay\PHPToolKit\Configuration\Settings;

class Campaign
{
    private array $data;

    private Settings $settings;

    public function __construct(array $data, Settings $settings)
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
    // In order to support frameworks / APIs that expect "getter".
    public function getAsArray(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->data;
    }
}

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

class Brand
{
    private array $data;

    private Settings $settings;

    private function __construct(array $data, Settings $settings)
    {
        $this->data = $data;
        $this->settings = $settings;
    }

    public function getId(): int
    {
        return $this->data['uid'];
    }

    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    public function getUrl(): string
    {
        return $this->data['url'] ?? '';
    }

    public function getLogoPublicUrl(): string
    {
        $mediaUrl = $this->data['logoPublicUrl'] ?? '';
        if ($mediaUrl === '') {
            return '';
        }

        return $this->settings->getAPIUrl() . '/' . $mediaUrl;
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

    public static function createFromJson(string $json, Settings $settings): Brand
    {
        return new Brand(json_decode($json, true), $settings);
    }
}

<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Entity;

use SkillDisplay\PHPToolKit\Configuration\Settings;

class Organisation
{
    private array $data = [];

    private Settings $settings;

    private ?Brand $brand = null;

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

    public function getBrand(): Brand
    {
        if ($this->brand instanceof Brand) {
            return $this->brand;
        }

        $this->brand = Brand::createFromJson(json_encode($this->data['brand']), $this->settings);

        return $this->brand;
    }

    public function getComposition(): string
    {
        return $this->data['composition'] ?? '';
    }

    public function getCurrentMonthIssued(): int
    {
        return $this->data['currentMonthIssued'] ?? 0;
    }

    public function getCurrentMonthUsers(): int
    {
        return $this->data['currentMonthUsers'] ?? 0;
    }

    public function getCurrentMonthVerifications(): int
    {
        return $this->data['currentMonthVerifications'] ?? 0;
    }

    public function getInterestSets(): array
    {
        return $this->data['interestSets'] ?? [];
    }

    public function getLastMonthIssued(): int
    {
        return $this->data['lastMonthIssued'] ?? 0;
    }

    public function getLastMonthUsers(): int
    {
        return $this->data['lastMonthUsers'] ?? 0;
    }

    public function getLastMonthVerifications(): int
    {
        return $this->data['lastMonthVerifications'] ?? 0;
    }

    public function getMonthlyScores(): array
    {
        return $this->data['monthlyScores'] ?? [];
    }

    public function getPotential(): array
    {
        return $this->data['potential'] ?? [];
    }

    public function getSumIssued(): int
    {
        return $this->data['sumSkills'] ?? 0;
    }

    public function getSumSkills(): int
    {
        return $this->data['sumSkills'] ?? 0;
    }

    public function getSumSupportedSkills(): int
    {
        return $this->data['sumSupportedSkills'] ?? 0;
    }

    public function getSumVerifications(): int
    {
        return $this->data['sumVerifications'] ?? 0;
    }

    public function getTotalScore(): int
    {
        return $this->data['totalScore'] ?? 0;
    }

    public static function createFromJson(string $json, Settings $settings): self
    {
        return new Organisation(json_decode($json, true), $settings);
    }

    public function getAsArray(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return $this->data;
    }
}

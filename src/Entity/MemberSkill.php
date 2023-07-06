<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Entity;

class MemberSkill
{
    private int $id = 0;
    private string $created = '';
    private string $granted = '';
    private int $skillUid = 0;
    private string $skillUUid = '';
    private string $skill = '';
    private string $domainTag = '';
    private string $level = '';
    private string $user = '';
    private string $firstName = '';
    private string $lastName = '';
    private string $certifier = '';

    private string $organisation = '';
    private string $campaign = '';
    private int $skillSetUid = 0;
    private string $skillSetName = '';

    public static function createFromJson(string $json_encode, \SkillDisplay\PHPToolKit\Configuration\Settings $settings)
    {
        $json = json_decode($json_encode, true);
        $entity = new self();
        $entity->id = $json['uid'] ?? 0;
        $entity->created = $json['created'] ?? '';
        $entity->granted = $json['granted'] ?? '';
        $entity->skillUid = $json['skillUid'] ?? 0;
        $entity->skillUUid = $json['skillUUid'] ?? '';
        $entity->skill = $json['skill'] ?? '';
        $entity->domainTag = $json['domainTag'] ?? '';
        $entity->level = $json['level'] ?? '';
        $entity->user = $json['user'] ?? '';
        $entity->firstName = $json['firstName'] ?? '';
        $entity->lastName = $json['lastName'] ?? '';
        $entity->certifier = $json['certifier'] ?? '';
        $entity->organisation = $json['organisation'] ?? '';
        $entity->campaign = $json['campaign'] ?? '';
        $entity->skillSetUid = $json['skillSetUid'] ?? 0;
        $entity->skillSetName = $json['skillSetName'] ?? '';

        return $entity;
    }


    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getGranted(): string
    {
        return $this->granted;
    }

    /**
     * @return int
     */
    public function getSkillUid(): int
    {
        return $this->skillUid;
    }

    /**
     * @return string
     */
    public function getSkillUUid(): string
    {
        return $this->skillUUid;
    }

    /**
     * @return string
     */
    public function getSkill(): string
    {
        return $this->skill;
    }

    /**
     * @return string
     */
    public function getDomainTag(): string
    {
        return $this->domainTag;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getCertifier(): string
    {
        return $this->certifier;
    }

    /**
     * @return string
     */
    public function getOrganisation(): string
    {
        return $this->organisation;
    }

    /**
     * @return string
     */
    public function getCampaign(): string
    {
        return $this->campaign;
    }

    /**
     * @return int
     */
    public function getSkillSetUid(): int
    {
        return $this->skillSetUid;
    }

    /**
     * @return string
     */
    public function getSkillSetName(): string
    {
        return $this->skillSetName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}

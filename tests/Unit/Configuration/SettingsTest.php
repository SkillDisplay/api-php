<?php

namespace SkillDisplay\PHPToolKit\Tests\Unit\Configuration;

use SkillDisplay\PHPToolKit\Configuration\Settings;
use PHPUnit\Framework\TestCase;

/**
 * @covers SkillDisplay\PHPToolKit\Configuration\Settings
 */
class SettingsTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithoutAnyValues()
    {
        $subject = new Settings('none');
        static::assertInstanceOf(
            Settings::class,
            $subject
        );
    }

    /**
     * @test
     */
    public function returnsExpectedValuesWhenCreatedWithoutAnyValues()
    {
        $subject = new Settings('none');

        static::assertSame('none', $subject->getApiKey());
        static::assertSame(0, $subject->getVerifierID());
        static::assertSame('', $subject->getUserSecret());
        static::assertSame('https://www.skilldisplay.eu', $subject->getAPIUrl());
        static::assertSame('https://my.skilldisplay.eu', $subject->getMySkillDisplayUrl());
    }

    /**
     * @test
     */
    public function canBeCreatedWithApiKey()
    {
        $subject = new Settings('---YOUR-API-KEY---');
        static::assertInstanceOf(
            Settings::class,
            $subject
        );
    }

    /**
     * @test
     */
    public function returnsExpectedValuesWhenCreatedWithApiKey()
    {
        $subject = new Settings('---YOUR-API-KEY---');

        static::assertSame('---YOUR-API-KEY---', $subject->getApiKey());
        static::assertSame(0, $subject->getVerifierID());
        static::assertSame('', $subject->getUserSecret());
        static::assertSame('https://www.skilldisplay.eu', $subject->getAPIUrl());
        static::assertSame('https://my.skilldisplay.eu', $subject->getMySkillDisplayUrl());
    }

    /**
     * @test
     */
    public function returnsVerifierIdWhenProvided()
    {
        $subject = new Settings('none', 10);

        static::assertSame(10, $subject->getVerifierID());
    }

    /**
     * @test
     */
    public function returnsUserSecretWhenProvided()
    {
        $subject = new Settings('none', 0, '---USER-SECRET---');

        static::assertSame('---USER-SECRET---', $subject->getUserSecret());
    }

    /**
     * @test
     */
    public function returnsUrlsWithProvidedDomain()
    {
        $subject = new Settings('none', 0, '', 'example.com');

        static::assertSame('https://example.com', $subject->getAPIUrl());
        static::assertSame('https://my.example.com', $subject->getMySkillDisplayUrl());
    }
}

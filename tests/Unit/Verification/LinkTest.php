<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Tests\Unit\Verification;

use Prophecy\PhpUnit\ProphecyTrait;
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Verification\Link;
use PHPUnit\Framework\TestCase;

/**
 * @covers SkillDisplay\PHPToolKit\Verification\Link
 */
class LinkTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function instanceCanBeCreated()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Link(
            $settings->reveal(),
            10
        );
        static::assertInstanceOf(Link::class, $subject);
    }

    /**
     * @test
     */
    public function instanceCanBeCreatedWithoutSkillId()
    {
        $settings = $this->prophesize(Settings::class);
        $subject = new Link($settings->reveal());
        static::assertInstanceOf(Link::class, $subject);
    }

    /**
     * @test
     */
    public function canReturnSkillVerificationLinkForEducationalWithCampaign()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skill/10/0/2/678',
            $subject->getVerificationLink('education', null, Link::SKILL, 678)
        );
    }

    /**
     * @test
     */
    public function canReturnSkillVerificationLinkForBusiness()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skill/10/0/4',
            $subject->getVerificationLink('business')
        );
    }

    /**
     * @test
     */
    public function canReturnSkillVerificationLinkForCertification()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skill/10/0/1',
            $subject->getVerificationLink('certification')
        );
    }

    /**
     * @test
     */
    public function canReturnSkillVerificationLinkForSelf()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skill/10/0/3',
            $subject->getVerificationLink('self')
        );
    }

    /**
     * @test
     */
    public function canReturnSkillSetVerificationLinkForEducational()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skillset/0/10/2',
            $subject->getVerificationLink('education', null, Link::SKILL_SET)
        );
    }

    /**
     * @test
     */
    public function canReturnSkillSetVerificationLinkForBusiness()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skillset/0/10/4',
            $subject->getVerificationLink('business', null, Link::SKILL_SET)
        );
    }

    /**
     * @test
     */
    public function canReturnSkillSetVerificationLinkForCertification()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skillset/0/10/1',
            $subject->getVerificationLink('certification', null, Link::SKILL_SET)
        );
    }

    /**
     * @test
     */
    public function canReturnSkillSetVerificationLinkForSelf()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal(), 10);

        static::assertSame(
            'https://my.example.com/verify/skillup/skillset/0/10/3',
            $subject->getVerificationLink('self', null, Link::SKILL_SET)
        );
    }
 
    /**
     * @test
     */
    public function throwsExceptionIfNoSkillIdIsProvided()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal());

        $this->expectExceptionMessage('No ID provided.');
        $this->expectExceptionCode(1599723825);
        $subject->getVerificationLink('education');
    }

    /**
     * @test
     */
    public function throwsExceptionIfInvalidTypeIsProvided()
    {
        $settings = $this->prophesize(Settings::class);
        $settings->getMySkillDisplayUrl()->willReturn('https://my.example.com/verify');

        $subject = new Link($settings->reveal());

        $this->expectExceptionMessage('$type has to be "skill" or "skillset" but "invalid" given.');
        $this->expectExceptionCode(1600774955);

        $subject->getVerificationLink('education', null, 'invalid');
    }
}

<?php

namespace SkillDisplay\PHPToolKit\Example\NoSettingsRequired;

require '../../../vendor/autoload.php';

// We don't need an APIKey or Verifier Credentials, just create some empty settings
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Verification\Link;

$mySettings = new Settings('none');

// we want to create a link for "Choosing a secure password" and style it ourselves
// A click on a link created this way will trigger the Verification interface on the SkillDisplay platform.
// The user will be invited to choose a verifier for the according level and submit a request for skill verification which can be granted or denied.
$myLink = new Link($mySettings, 7);

echo <<<LINK
    <a href="{$myLink->getVerificationLink(VERIFICATION_SELF)}" target="_blank">Self-Verification Link</a><br />
LINK;

echo <<<LINK
    <a href="{$myLink->getVerificationLink(VERIFICATION_EDUCATIONAL)}" target="_blank">Educational-Verification Link</a><br />
LINK;

echo <<<LINK
    <a href="{$myLink->getVerificationLink(VERIFICATION_BUSINESS)}" target="_blank">Business-Verification Link</a><br />
LINK;

echo <<<LINK
    <a href="{$myLink->getVerificationLink(VERIFICATION_CERTIFICATION)}" target="_blank">Certification Link</a><br />
LINK;
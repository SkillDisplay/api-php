<?php
declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Example\NoSettingsRequired;

require '../../../vendor/autoload.php';

// We don't need an APIKey or Verifier Credentials, just create some empty settings
use SkillDisplay\PHPToolKit\Configuration\Settings;
use SkillDisplay\PHPToolKit\Verification\Link;

$mySettings = new Settings('none');

// we want to create Verification Buttons styled in the standard SkillDisplay Design for "Choosing a secure password"
// A click on a link created this way will trigger the Verification interface on the SkillDisplay platform.
// The user will be invited to choose a verifier for the according level and submit a request for skill verification which can be granted or denied.
$myLink = new Link($mySettings, 7);

echo $myLink->getVerificationButton(VERIFICATION_SELF);
echo '<br /><br />';
echo $myLink->getVerificationButton(VERIFICATION_EDUCATIONAL);
echo '<br /><br />';
echo $myLink->getVerificationButton(VERIFICATION_BUSINESS);
echo '<br /><br />';
echo $myLink->getVerificationButton(VERIFICATION_CERTIFICATION);

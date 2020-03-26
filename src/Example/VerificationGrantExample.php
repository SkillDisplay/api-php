<?php

namespace SkillDisplay\APIToolKit\Example;

require '../../vendor/autoload.php';

use SkillDisplay\APIToolKit\Configuration\Settings;
use SkillDisplay\APIToolKit\Verification\Issuer;

$mySettings = new Settings(
    '---YOUR-API-KEY---',
    0,
    '',
    ''
);

$myVerificationTool = new Issuer($mySettings);
$myVerificationTool->issueVerification(193,'--skilldisplay-user-email--', VERIFICATION_SELF);
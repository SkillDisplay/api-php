<?php

namespace SkillDisplay\PHPToolKit\Example\APIKeyRequired;

require '../../../vendor/autoload.php';
require '../Includes/ExampleSettings.php';

use SkillDisplay\PHPToolKit\Verification\Issuer;

// Automatically grant a Self-Verification (e.g.: after completing a Learning Chapter) if the SkillDisplay username is known
$myVerificationTool = new Issuer($mySettings);
$myVerificationTool->issueVerification(193,'--skilldisplay-user-email--', VERIFICATION_SELF);
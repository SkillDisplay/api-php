<?php

declare(strict_types=1);

namespace SkillDisplay\PHPToolKit\Example\APIKeyRequired;

require '../../../vendor/autoload.php';
require '../Includes/ExampleSettings.php';

use SkillDisplay\PHPToolKit\Verification\Issuer;

// Automatically grant a Business-Verification (e.g.: after completing an exam) if the SkillDisplay username is known.
// The number 567 is the optional campaignId the verification is attributed to.
// In order to grant an Educational Verification you just need to exchange the constant to VERIFICATION_EDUCATIONAL
// (your Verifier Account needs the according permissions)
$myVerificationTool = new Issuer($mySettings);
$myVerificationTool->outputResponse($myVerificationTool->issueVerification(175, '--skilldisplay-user-email--', VERIFICATION_BUSINESS, false, 567, true));

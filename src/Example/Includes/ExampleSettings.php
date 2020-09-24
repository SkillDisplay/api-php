<?php
declare(strict_types=1);

use SkillDisplay\PHPToolKit\Configuration\Settings;

// In order to make the examples in the folders "APIKeyRequied" and "FullSettingsRequired" work, insert your settings here
// Check the ReadMe.md in order to find out how to obtain an APIKey and or Verifier Credentials
$mySettings = new Settings(
    '---YOUR-API-KEY---',
    0,
    '',
    'www.skilldisplay.eu'
);

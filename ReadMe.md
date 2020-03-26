# SkillDisplay PHP ToolKit

## About SkillDisplay
The European SkillDisplay is a web portal created by the NPO Verein Business Angels and allows Learners worldwide to claim verification for their skills on a European level. The skills are based on industry certifications which are broken down into dependent skills by the certification authorities themselves.

You can find more information at: https://www.skilldisplay.eu

## About the PHP ToolKit
The PHP Toolkit is designed to help you connecting your own PHP application with SkillDisplay functionality. Examples:
- You write a blog and let people track what they learned with the help of your article
- You have an exam system want to grant Skill verification to users based on the results
- You have a task system and want to award Skill verification on completion of a task

## Verification Types
### Self-Verifications
Self-Verifications are a users way to say "I can do this". This is like writing it in a resumée, but instead of an arbitrary text the claim is put into context of Skills on European level.

You'll want to include Self-Verification in your application for all matters of self-study. (Completing a tech article, Progressing in a Tutorial, etc.)
 
### External Verifications
 These Verifications require a second party - a person or organization who is tasked with verifying Skills of users in a specific context.
 - Automatic Educational-Verification: Grant skill verification via an exam system in a school, an automated review after a coaching, etc.
 - Business-Verification: Grant skill verification via a task system or project management tool which tracks work completed by employees
 - Certification: Grant skill certification via a test system for official Certification exams

## Requirements
In order to work with the PHP Toolkit you need the following:
### Rendering of Verification Links and/or Buttons
If you don't want to automate the process of skill verification for users and just want to render links they can follow to manually request verification you do not need any special settings.

Included examples:
- Render verification buttons in the SkillDisplay design (src/Example/NoSettingsRequired/RenderVerificationButtons.php)
- Render verification links without a design if you want to use a custom look (src/Example/NoSettingsRequired/RenderCustomVerificationLinks.php)

### Automatic Self-Verifications
 In order to implement Self-Verification for Skills you need:
 - An API Key
 
 Obtaining an API Key is easy. Just write us an E-Mail to [partners@skilldisplay.eu], and let us know your use-case. We'll then send you an API Key.
 
Included examples:
- grant automatic Self-Verification of a skill to a user for whom you know the SkillDisplay E-Mail Account  (src/Example/APIKeyRequired/AutoGrantSelfVerification.php)
  
 ### Automatic External-Verification

 In order to implement these types of Verification for Skills you need:
 - An API Key
 - A VerifierID
 - A Verifier secret key
 
 We grant a VerifierID and a Verifier secret key to our partners.
 - Business Representatives: https://www.skilldisplay.eu/en/platform-guide/skilldisplay-for-business-persons/
 - Educators: https://www.skilldisplay.eu/en/platform-guide/skilldisplay-for-educators/
 - Certifiers: https://www.skilldisplay.eu/en/platform-guide/skilldisplay-for-certifiers/

Included examples:
- grant automatic Business-Verification of a skill to a user for whom you know the SkillDisplay E-Mail Account (src/Example/FullSettingsRequired/AutoGrantBusinessVerification.php)

 [partners@skilldisplay.eu]:(mailto:partners@skilldisplay.eu?subject=APIKey)

<?php

use SilverStripe\Security\PasswordValidator;
use SilverStripe\Security\Member;

// remove PasswordValidator for SilverStripe 5.0
$validator = PasswordValidator::create();
// Settings are registered via Injector configuration - see passwords.yml in framework
Member::set_password_validator($validator);

//Heroku ClearDB support
if(isset($_ENV['CLEARDB_DATABASE_URL'])) {
	global $databaseConfig;
	$parts = parse_url($_ENV['CLEARDB_DATABASE_URL']);
	$databaseConfig['type'] = 'MySQLPDODatabase';
	$databaseConfig['server'] = $parts['host'];
	$databaseConfig['username'] = $parts['admin'];
	$databaseConfig['password'] = $parts['password'];
	$databaseConfig['database'] = trim($parts['path'], '/');
	Security::setDefaultAdmin('heroku', 'yesletmeinplease');
} else {
	//Default SilverStripe environement support
	require_once('conf/ConfigureFromEnv.php');
}

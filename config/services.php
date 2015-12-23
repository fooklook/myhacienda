<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => 'sandbox8c691d2a9ac147fb9d43cece8954a766.mailgun.org',
		'secret' => 'key-fa421efa0ecaa96031e8fae5374fe3b5',
	],

	'mandrill' => [
		'secret' => 'key-fa421efa0ecaa96031e8fae5374fe3b5',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'App\User',
		'secret' => '',
	],

];

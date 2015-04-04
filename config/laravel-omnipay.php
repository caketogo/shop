<?php

return [

	// The default gateway to use
	'default' => 'paypal',

	// Add in each gateway here
	'gateways' => [
		'paypal' => [
			'driver'  => 'PayPal_Express',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => '',
				'returnUrl' => 'localhost',
				'password' => 'D5D3B6CEDDYC62TD',
				'signature' => 'AuXjZMMIG7xbqRLNfdF1J-KpnfKIA3Nf3ZrBZWWwfFxKoXicwSzC9WFG'

				
			]
		],
		'stripe' =>	[
			'driver'  => 'Stripe',
			'options' => [
				'APIKey' => 'sk_test_mpHOcobqO3PW98fMEcZb0cpA',
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => '',
				'currency' =>  'USD',


			]
		],

		'sagepay' => [
			'driver'  => 'SagePay_Direct',
			'options' => [
				'solutionType'   => '',
				'landingPage'    => '',
				'headerImageUrl' => '',
				'currency' => 'USD',
				'returnUrl' => 'localhost',
				'vendor' => 'customcurtains',
				'description' => 'some product'
				
			]
		]

	]


];
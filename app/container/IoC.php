<?php

/**
 * IoC of iTruemartClient.
 */
App::singleton('itruemart', function()
{
    $config = Config::get('endpoints.itruemart');

    return new ItruemartClient\ItruemartClient($config);
});

/**
 * PCMS Api Client.
 */
App::singleton('pcms', function()
{
	$config = Config::get('endpoints.pcms');

    //return new NewPcmsClient($config);

	return new PcmsClient($config);
});

/**
 * True SSO Client.
 */
App::singleton('sso', function()
{
    $config = Config::get('endpoints.sso');

    return new TrueSSO($config);
});

/**
 * True You Card.
 */
App::singleton('truecard', function()
{
    $config = Config::get('endpoints.truecard');

    return new TrueCard\TrueCard($config);
});

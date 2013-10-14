<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\Oauth\Oauth2\Client;

/**
 * GitHub Authentication
 *
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Auth extends Client
{
    const REQUEST_URL = 'https://github.com/login/oauth/authorize';
    const ACCESS_URL = 'https://github.com/login/oauth/access_token';
    const USER_AGENT = 'github-php-3.1';

    /**
     * Sets the application's key, secret and redirect uri.
     *
     * @param string $key      the application's key
     * @param string $secret   the application's secret
     * @param string $redirect the application's redirect uri
     * @return void
     */
    public function __construct($key, $secret, $redirect)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'url');

        parent::__construct($key, $secret, $redirect, self::REQUEST_URL, self::ACCESS_URL);
    }
}

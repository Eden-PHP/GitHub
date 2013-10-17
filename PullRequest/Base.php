<?php //-->
/*
 * This file is part of the Utility package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\PullRequest;

use Eden\GitHub\Base as GitHubBase;

/**
 * The base class for all classes wishing to integrate with Eden.
 * Extending this class will allow your methods to seemlessly be
 * overloaded and overrided as well as provide some basic class
 * loading patterns.
 *
 * @vendor Eden
 * @package GitHub\PullRequest
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Base extends GitHubBase
{
    const INSTANCE = 0; // set to multiton
}

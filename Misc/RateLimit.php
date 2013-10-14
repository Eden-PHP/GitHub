<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Data;

use Eden\Type\StringType;

/**
 * GitHub API - Miscellaneous: RateLimit
 * 
 * @vendor Eden
 * @package GitHub\Misc
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class RateLimit extends Base
{
    protected $link = array(
        'RATE_LIMIT' => 'rate_limit'
    );
    
    /**
     * Gets your current rate limit status.
     * 
     * @return array
     */
    public function getRateLimitStatus()
    {
        // search and replace
        $link = StringType::i($this->link['RATE_LIMIT'])
                ->get();
        
        return $this->getResponse($link);
    }
}

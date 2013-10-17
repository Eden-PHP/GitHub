<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\GitHub\Misc\Emojis;
use Eden\GitHub\Misc\Gitignore;
use Eden\GitHub\Misc\Markdown;
use Eden\GitHub\Misc\Meta;
use Eden\GitHub\Misc\RateLimit;

/**
 * GitHub API - Misc
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Misc extends Base
{
    /**
     * Returns a new instance of Emojis.
     * 
     * @return \Eden\GitHub\Misc\Emojis
     */
    public function emojis()
    {
        return Emojis::i();
    }
    
    /**
     * Returns a new instance of Gitignore.
     * 
     * @return \Eden\GitHub\Misc\Gitignore
     */
    public function gitignore()
    {
        return Gitignore::i();
    }
    
    /**
     * Returns a new instance of Markdown.
     * 
     * @return \Eden\GitHub\Misc\Markdown
     */
    public function markdown()
    {
        return Markdown::i();
    }
    
    /**
     * Returns a new instance of Meta.
     * 
     * @return \Eden\GitHub\Misc\Meta
     */
    public function meta()
    {
        return Meta::i();
    }
    
    /**
     * Returns a new instance of RateLimit.
     * 
     * @return \Eden\GitHub\Misc\RateLimit
     */
    public function rateLimit()
    {
        return RateLimit::i();
    }
}

<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Gist;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Gist: Comment
 * You can read public gists and create them for anonymous users without a token;
 * however, to read or write gists on a user’s behalf the gist OAuth scope is required.
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Comment extends Base
{
    protected $link = array(
        'GIST' => 'gists/:gist_id/comments'
    );
    
    /**
     * Gets the comments on a gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function getComments($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['GIST'])
                ->str_replace(':gist_id', $gistId)
                ->get();
        
        return $this->patchResponse($link);
    }
}

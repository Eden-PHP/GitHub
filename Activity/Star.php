<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Activity;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Activity: Star
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Star extends Base
{
    protected $link = array(
        'STARGAZER' => 'repos/:owner/:repo/stargazers',
        'USER_STARRED' => 'users/:user/starred',
        'USER_STAR' => 'user/starred/:owner/:repo'
    );
    
    /**
     * Gets all the users who starred the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getRepoStargazers($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['STARGAZER'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * List repositories being starred by a user.
     * If user is defined, list repositories being starred by the authenticated user.
     * 
     * @param string $user
     * @param string $sort      valid values are created and updated
     * @param string $direction valid values are asc and desc
     * @return array
     */
    public function getUserStarred($user = null, $sort = 'created', $direction = 'desc')
    {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $post = array(
            'sort' => $sort,
            'direction' => $direction
        );
        
        // checks if user is not defined
        if (!$user) {
            $user = ''; // empty the user
        }
        
        // search and replace
        $link = StringType::i($this->link['USER_STARRED'])
                ->str_replace(':user', $user)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Checks if you are a stargazer of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function isStargazer($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_STAR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Stars the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function starRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_STAR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->putResponse($link);
    }
    
    /**
     * Unstars the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function unstarRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_STAR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->deleteResponse($link);
    }
}

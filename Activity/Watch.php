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
 * GitHub API - Activity: Watch
 * Watching a Repository registers the user to receive notifications on new discussions,
 * as well as events in the user’s activity feed.
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Watch extends Base
{
    protected $link = array(
        'WATCHER' => 'repos/:owner/:repo/subscribers',
        'WATCHED' => 'users/:user/subscriptions',
        'REPO_SUBSCRIPTION' => 'repos/:owner/:repo/subscription',
        'USER_SUBSCRIPTION' => 'user/subscriptions/:owner/:repo'
    );
    
    /**
     * List all the users who watched the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getRepoWatchers($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['WATCHER'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * List repositories being watched by a user.
     * If user is not defined, list repositories being watched by the authenticated user.
     * 
     * @param string|null $user
     * @return array
     */
    public function getUserWatched($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        // checks if user is not defined
        if (!$user) {
            $user = ''; // empty the user
        }
        
        // search and replace
        $link = StringType::i($this->link['WATCHED'])
                ->str_replace(':user', $user)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the repository subscriptions.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getRepositorySubscription($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['REPO_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Sets the repository subscription.
     * 
     * @param string $owner
     * @param string $repo
     * @param bool $subscribed
     * @param bool $ignored
     * @return array
     */
    public function setRepositorySubscription($owner, $repo, $subscribed, $ignored)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'bool')
                ->test(4, 'bool');
        
        $post = array(
            'subscribed' => $subscribed,
            'ignored' => $ignored
        );
        
        // search and replace
        $link = StringType::i($this->link['REPO_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Delets the repository subscription.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function deleteRepositorySubscription($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['REPO_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * (LEGACY)
     * Checks if you are watching the repository.
     * Requires for the user to be authenticated.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function isWatching($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * (LEGACY)
     * Watches the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function watchRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->putResponse($link);
    }
    
    /**
     * (LEGACY)
     * Unwatches the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function unwatchRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['USER_SUBSCRIPTION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->deleteResponse($link);
    }
}

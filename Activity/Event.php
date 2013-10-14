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
 * GitHub API - Activity: Event
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Event extends Base
{
    protected $link = array(
        'EVENTS' => 'events',
        'REPOSITORY' => 'repos/:owner/:repo/events',
        'ISSUE' => 'repos/:owner/:repo/issues/events',
        'NETWORK' => 'networks/:owner/:repo/events',
        'ORGANIZATION' => 'orgs/:org/events',
        'RECEIVED_EVENTS' => 'users/:user/received_events',
        'USER_EVENTS' => 'users/:user/events',
        'USER_ORG_EVENTS' => 'users/:user/events/orgs/:org',
    );
    
    /**
     * Gets the public events.
     * 
     * @return array
     */
    public function getPublicEvents()
    {
        return $this->getResponse($this->link['EVENTS']);
    }
    
    /**
     * Gets the issue events for a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getRepositoryEvents($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['REPOSITORY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the issue events for a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getIssueEvents($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ISSUE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the public events for a network of repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getNetworkEvents($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['NETWORK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the received events of the user.
     * These are events that you’ve received by watching repos and following users.
     * If you are authenticated as the given user, you will see private events.
     * Otherwise, you’ll only see public events.
     * 
     * @param string $user
     * @param bool   $public
     * @return array
     */
    public function getReceivedEvents($user, $public = false)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'bool');
        
        // search and replace
        $link = StringType::i($this->link['RECEIVED_EVENTS'])
                ->str_replace(':user', $user)
                ->get();
        
        return $this->getResponse($link . ($public ? '/public' : ''));
    }
    
    /**
     * Gets the user events. If you are authenticated as the given user,
     * you will see your private events. Otherwise, you’ll only see public events.
     * 
     * @param string $user
     * @param bool   $public
     * @return array
     */
    public function getUserEvents($user, $public = false)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'bool');
        
        // search and replace
        $link = StringType::i($this->link['USER_EVENTS'])
                ->str_replace(':user', $user)
                ->get();
        
        return $this->getResponse($link . ($public ? '/public' : ''));
    }
    
    /**
     * Gets the organization events.
     * If user is defined, it is an user’s organization dashboard. 
     * You must be authenticated as the user to view this.
     * 
     * @param string      $org
     * @param string|null $user
     * @return array
     */
    public function getOrganizationEvents($org, $user = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string', 'null');
        
        // checks if user is defined
        if ($user) {
            $link = StringType::i($this->link['USER_ORG_EVENTS']);
        } else {
            $link = StringType::i($this->link['ORGANIZATION']);
        }
        
        // search and replace
        $link = $link
                ->str_replace(':user', $user)
                ->str_replace(':org', $org)
                ->get();
        
        return $this->getResponse($link);
    }
}

<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Repository;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Repository: Hook
 * The Repository Hooks API allows repository admins to manage the post-receive
 * web and service hooks for a repository.
 * 
 * Active hooks can be configured to trigger for one or more events. The default event is push. The available events are:
 * - push:                        Any git push to a Repository.
 * - issues:                      Any time an Issue is opened or closed.
 * - issue_comment:               Any time an Issue is commented on.
 * - commit_comment:              Any time a Commit is commented on.
 * - pull_request:                Any time a Pull Request is opened, closed, or synchronized (updated due to a new push in the
 *                                branch that the pull request is tracking).
 * - pull_request_review_comment: Any time a Commit is commented on while inside a Pull Request review (the Files Changed tab).
 * - gollum:                      Any time a Wiki page is updated.
 * - watch:                       Any time a User watches the Repository.
 * - release:                     Any time a Release is published in the Repository.
 * - fork:                        Any time a Repository is forked.
 * - member:                      Any time a User is added as a collaborator to a non-Organization Repository.
 * - public:                      Any time a Repository changes from private to public.
 * - team_add:                    Any time a team is added or modified on a Repository.
 * - status:                      Any time a Repository has a status update from the API
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Hook extends Base
{
    protected $link = array(
        'HOOK' => 'repos/:owner/:repo/hooks'
    );
    
    /**
     * Lists all the hooks of a repository.
     * 
     * @param HOOK $owner
     * @param string $repo
     * @return array
     */
    public function getHooks($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified hook of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $hookId
     * @return array
     */
    public function getHook($owner, $repo, $hookId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $hookId;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a hook.
     * 
     * @param string    $owner
     * @param string    $repo
     * @param string    $name  the name of the service that is being called
     * @param array     $config a hash containing key/value pairs to provide settings for this hook
     * @param array     $events Default: ['push'] determines what events the hook is triggered for
     * @param bool|null $active
     * @return array
     */
    public function createHook(
            $owner,
            $repo,
            $name,
            array $config = array(),
            array $events = array('push'),
            $active = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'array')
                ->test(5, 'array')
                ->test(6, 'bool', 'null');
        
        $post = array(
            'name' => $name,
            'config' => $config,
            'events' => $events
        );
        
        // check and set
        if ($active) {
            $post['active'] = $active;
        }
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * 
     * @param string    $owner
     * @param string    $repo
     * @param string    $hookId
     * @param array     $config       a hash containing key/value pairs to provide settings for this hook
     * @param array     $events       Default: ['push']. Determines what events the hook is triggered for. This replaces the entire array of events.
     * @param array     $addEvents    determines a list of events to be added to the list of events that the Hook triggers for
     * @param array     $removeEvents determines a list of events to be removed from the list of events that the Hook triggers for
     * @param bool|null $active       determines whether the hook is actually triggered on pushes
     * @return array
     * @see Eden\GitHub\Repository\Hook::createHook()
     */
    public function editHook(
            $owner,
            $repo,
            $hookId,
            array $config = array(),
            array $events = array('push'),
            array $addEvents = array(),
            array $removeEvents = array(),
            $active = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'array')
                ->test(5, 'array')
                ->test(6, 'array')
                ->test(7, 'array')
                ->test(8, 'bool', 'null');
        
        $post = array();
        
        // check and set
        if ($active) {
            $post['active'] = $active;
        }
        
        if (count($config)) {
            $post['config'] = $config;
        }
        
        if (count($events)) {
            $post['events'] = $events;
        }
        
        if (count($addEvents)) {
            $post['add_events'] = $addEvents;
        }
        
        if (count($removeEvents)) {
            $post['remove_events'] = $removeEvents;
        }
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $hookId;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Tests a hook. This will trigger the hook with the latest push to the current
     * repository if the hook is subscribed to push events.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $hookId
     * @return array
     */
    public function testHook($owner, $repo, $hookId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $hookId . '/tests';
        
        return $this->getResponse($link);
    }
    
    public function deleteHook($owner, $repo, $hookId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['HOOK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $hookId;
        
        return $this->deleteResponse($link);
    }
}

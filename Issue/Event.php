<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Issue;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Issue: Event
 * Records various events that occur around an Issue or Pull Request. 
 * This is useful both for display on issue/pull request information pages and 
 * also to determine who should be notified of comments.
 * 
 * Attributes
 * - actor:     (array) Always the User that generated the event. It contains login, id, avatar_url, gravatar_id and url.
 * - commit_id: (string) The String SHA of a commit that referenced this Issue
 * - event:     (string) Identifies the actual type of Event that occurred. See below for listing
 * 
 * Events
 * - closed:     The issue was closed by the actor. When the commit_id is present,
 *               it identifies the commit that closed the issue using “closes / fixes #NN” syntax.
 * - reopened:   The issue was reopened by the actor.
 * - subscribed: The actor subscribed to receive notifications for an issue.
 * - merged:     The issue was merged by the actor. The commit_id attribute is the SHA1 of the HEAD commit that was merged.
 * - referenced: The issue was referenced from a commit message. The commit_id attribute is the commit SHA1 of where that happened.
 * - mentioned:  The actor was @mentioned in an issue body.
 * - assigned:   The issue was assigned to the actor.
 * 
 * @vendor Eden
 * @package GitHub\Issue
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Event extends Base
{
    protected $link = array(
        'ISSUE_EVENTS' => 'repos/:owner/:repo/issues/:issue_number/events',
        'EVENTS' => 'repos/:owner/:repo/issues/events'
    );
    
    /**
     * Lists the events for an issue.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param array  $actor
     * @param string $commitId
     * @param string $event
     * @return array
     */
    public function getIssueEvent(
            $owner,
            $repo, 
            $number, 
            array $actor, 
            $commitId, 
            $event
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'array')
                ->test(5, 'string')
                ->test(6, 'string');
        
        $post = array(
            'actor' => $actor,
            'commit_id' => $commitId,
            'event' => $event
        );
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_EVENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists the events for a repository.
     * If eventId is defined, a single event will return instead.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $eventId
     * @param array       $actor
     * @param string      $commitId
     * @param string      $event
     * @return array
     */
    public function getRespositoryEvent(
            $owner, 
            $repo, 
            $eventId = null, 
            array $actor, 
            $commitId, 
            $event
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null')
                ->test(4, 'array')
                ->test(5, 'string')
                ->test(6, 'string');
        
        $post = array();
        
        // search and replace
        $link = StringType::i($this->link['EVENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        if ($eventId) {
            $link .= '/' . $eventId;
        } else {
            $post['actor'] = $actor;
            $post['commit_id'] = $commitId;
            $post['event'] = $event;
        }
        
        return $this->getResponse($link, $post);
    }
}

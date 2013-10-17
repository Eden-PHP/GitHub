<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\GitHub\Argument;
use Eden\Type\StringType;
use Eden\GitHub\Issue\Assignee;
use Eden\GitHub\Issue\Comment;
use Eden\GitHub\Issue\Event;
use Eden\GitHub\Issue\Label;
use Eden\GitHub\Issue\Milestone;

/**
 * GitHub API - Issue
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Issue extends Base
{
    protected $link = array(
        'ISSUES' => 'issues',
        'USER_ISSUES' => 'user/issues',
        'ORG_ISSUES' => 'orgs/:org/issues',
        'REPO_ISSUES' => 'repos/:owner/:repo/issues',
        'REPO_ISSUE' => 'repos/:owner/:repo/issues/:number'
    );
    
    /**
     * Lists the issues.
     * 
     * @param bool        $user       if true, list the issues of the user instead
     * @param string|null $org        if defined, list the issues of the org instead and disregard user
     * @param string      $filter     Default: assigned. assigned, craeted, mentioned, subscribed or all
     * @param string      $state      Default: open. open or closed
     * @param array       $labels
     * @param string      $sort       Default: created. created or updated
     * @param string      $direction  Default: desc. asc or desc
     * @param string|null $since must be in <ISO 8601> format
     * @return array
     */
    public function getIssues(
            $user = true,
            $org = null,
            $filter = 'assigned',
            $state = 'open',
            array $labels = array(),
            $sort = 'created',
            $direction = 'desc',
            $since = null
    ) {
        Argument::i()
                ->test(1, 'bool')
                ->test(2, 'string', 'null')
                ->test(3, 'string', 'null')
                ->test(4, 'string')
                ->test(5, 'array')
                ->test(6, 'string')
                ->test(7, 'string')
                ->test(8, 'string', 'null');
        
        $post = array(
            'filter' => $filter,
            'state' => $state,
            'labels' => join(',', $labels),
            'sort' => $sort,
            'direction' => $direction
        );
        
        // check and set
        if ($since) {
            $post['since'] = $since;
        }
        
        if ($org) {
            $link = StringType::i($this->link['ORG_ISSUES'])
                    ->str_replace(':org', $org)
                    ->get();
        } else if ($user) {
            $link = StringType::i($this->link['USER_ISSUES'])
                    ->get();
        } else {
            $link = StringType::i($this->link['ISSUES'])
                    ->get();
        }
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Gets the specified repository issue.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getRepoIssue($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::i($this->link['REPO_ISSUE'])
                    ->str_replace(':owner', $owner)
                    ->str_replace(':repo', $repo)
                    ->str_replace(':number', $number)
                    ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists the repository issues.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $milestone String Milestone number
     *                               none for Issues with no Milestone.
     *                               * for Issues with any Milestone.
     * @param string      $state     Default: *. open or closed
     * @param string      $assignee  'String' User login,
     *                               'none' for Issues with no assigned User.
     *                               '*' for Issues with any assigned User.
     * @param string|null $creator
     * @param string|null $mentioned
     * @param array       $labels
     * @param string      $sort       Default: created. created or updated
     * @param string      $direction  Default: desc. asc or desc
     * @param string|null $since must be in <ISO 8601> format
     * @return array
     */
    public function getRepoIssues(
            $owner,
            $repo,
            $milestone = '*',
            $state = 'open',
            $assignee = '*',
            $creator = null,
            $mentioned = null,
            array $labels = array(),
            $sort = 'created',
            $direction = 'desc',
            $since = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null')
                ->test(7, 'string', 'null')
                ->test(8, 'array')
                ->test(9, 'string')
                ->test(10, 'string')
                ->test(11, 'string', 'null');
        
        $post = array(
            'milestone' => $milestone,
            'state' => $state,
            'assignee' => $assignee,
            'labels' => join(',', $labels),
            'sort' => $sort,
            'direction' => $direction
        );
        
        // check and set
        if ($creator) {
            $post['creator'] = $creator;
        }
        if ($mentioned) {
            $post['mentioned'] = $mentioned;
        }
        if ($since) {
            $post['since'] = $since;
        }
        
        $link = StringType::i($this->link['REPO_ISSUES'])
                    ->str_replace(':owner', $owner)
                    ->str_replace(':repo', $repo)
                    ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates an issue.
     * 
     * @param string          $owner
     * @param string          $repo
     * @param string          $title
     * @param string          $body
     * @param string|null     $assignee
     * @param string|int|null $milestone
     * @param array           $labels
     * @return array
     */
    public function createIssue(
            $owner,
            $repo,
            $title,
            $body,
            $assignee = null,
            $milestone = null,
            array $labels = array()
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'int', 'null')
                ->test(7, 'array');
        
        $post = array(
            'title' => $title,
            'body' => $body,
            'labels' => $labels,
        );
        
        // check and set
        if ($assignee) {
            $post['assignee'] = $assignee;
        }
        if ($milestone) {
            $post['milestone'] = $milestone;
        }
        
        $link = StringType::i($this->link['REPO_ISSUES'])
                    ->str_replace(':owner', $owner)
                    ->str_replace(':repo', $repo)
                    ->get();
                
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits an issue.
     * 
     * @param string          $owner
     * @param string          $repo
     * @param string          $number
     * @param string          $title
     * @param string          $body
     * @param string|null     $assignee
     * @param string          $state     Default: open. open or closed
     * @param string|int|null $milestone
     * @param array           $labels
     * @return array
     * @return array
     */
    public function editIssue(
            $owner,
            $repo,
            $number,
            $title,
            $body,
            $assignee = null,
            $state = 'open',
            $milestone = null,
            array $labels = array()
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null')
                ->test(7, 'string')
                ->test(8, 'string', 'int', 'null')
                ->test(9, 'array');
        
        $post = array(
            'title' => $title,
            'body' => $body,
            'labels' => $labels,
        );
        
        // check and set
        if ($assignee) {
            $post['assignee'] = $assignee;
        }
        if ($milestone) {
            $post['milestone'] = $milestone;
        }
        if ($state) {
            $post['state'] = $state;
        }
        
        $link = StringType::i($this->link['REPO_ISSUE'])
                    ->str_replace(':owner', $owner)
                    ->str_replace(':repo', $repo)
                    ->str_replace(':number', $number)
                    ->get();
                
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Returns new instance of Assignee.
     * 
     * @return Eden\GitHub\Issue\Assignee
     */
    public function assignee()
    {
        return Assignee::i();
    }
    
    /**
     * Returns new instance of Comment.
     * 
     * @return Eden\GitHub\Issue\Comment
     */
    public function comment()
    {
        return Comment::i();
    }
    
    /**
     * Returns new instance of Event.
     * 
     * @return Eden\GitHub\Issue\Event
     */
    public function Event()
    {
        return Event::i();
    }
    
    /**
     * Returns new instance of Label.
     * 
     * @return Eden\GitHub\Issue\Label
     */
    public function label()
    {
        return Label::i();
    }
    
    /**
     * Returns new instance of Milestone.
     * 
     * @return Eden\GitHub\Issue\Milestone
     */
    public function milestone()
    {
        return Milestone::i();
    }
}

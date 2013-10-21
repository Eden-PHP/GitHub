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
 * GitHub API - Issue: Milestone
 * 
 * @vendor Eden
 * @package GitHub\Issue
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Milestone extends Base
{
    protected $link = array(
        'MILESTONES' => 'repos/:owner/:repo/milestones'
    );
    
    /**
     * Gets a list of milestones for a repository.
     * If number is defined, return single milestone instead.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $number
     * @param string      $state     open, closed, default: open
     * @param string      $sort      due_date, completeness, default: due_date
     * @param string      $direction asc or desc, default: desc.
     * @return array
     */
    public function getMilestones(
            $owner, 
            $repo, 
            $number = null,
            $state = 'open', 
            $sort = 'due_date', 
            $direction = 'desc'
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string');
        
        $post = array();
        
        // search and replace
        $link = StringType::i($this->link['MILESTONES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        if ($number) {
            $link .= '/' . $number;
        } else {
            $post['state'] = $state;
            $post['sort'] = $sort;
            $post['direction'] = $direction;
        }
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a milestone.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $title
     * @param string $state open or closed. Default is open
     * @param string $desc  (Optional)
     * @param string $dueOn (Optional) <ISO 8601> format
     * @return array
     */
    public function createMilestone(
            $owner, 
            $repo, 
            $title, 
            $state = 'open', 
            $desc = null, 
            $dueOn = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null');
        
        $post = array(
            'title' => $title,
            'state' => $state
        );
        
        if ($desc) {
            $post['description'] = $desc;
        }
        
        if ($dueOn) {
            $post['due_on'] = $dueOn;
        }
        
        // search and replace
        $link = StringType::i($this->link['MILESTONES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Updates a milestone.
     * 
     * @param string $owner
     * @param string $repo
     * @param string number
     * @param string $title
     * @param string $state open or closed. Default is open
     * @param string $desc  (Optional)
     * @param string $dueOn (Optional) <ISO 8601> format
     * @return array
     */
    public function updateMilestone(
            $owner, 
            $repo, 
            $number, 
            $title, 
            $state = 'open', 
            $desc = null, 
            $dueOn = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null')
                ->test(7, 'string', 'null');
        
        $post = array(
            'title' => $title,
            'state' => $state
        );
        
        if ($desc) {
            $post['description'] = $desc;
        }
        
        if ($dueOn) {
            $post['due_on'] = $dueOn;
        }
        
        // search and replace
        $link = StringType::i($this->link['MILESTONES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $number;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes a milestone.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function deleteMilestone($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['MILESTONES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $number;
        
        return $this->deleteResponse($link);
    }
}

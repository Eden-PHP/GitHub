<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Data;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Issue: Assignee
 * 
 * @vendor Eden
 * @package GitHub\Issue
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Assignee extends Base
{
    protected $link = array(
        'ASSIGNEE' => 'repos/:owner/:repo/assignees'
    );
    
    /**
     * Gets the list of all available assignees to which issues may be assigned.
     * If assignee is defined, checks the user if the particulat user is an assignee for a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $assignee
     * @return array
     */
    public function getAssignees($owner, $repo, $assignee = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        // search and replace
        $link = StringType::i($this->link['ASSIGNEE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        // checks if assignee is defined
        if ($assignee) {
            $link .= '/' . $assignee;
        }
        
        return $this->getResponse($link);
    }
}

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

/**
 * GitHub API - Activity: EventType
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class EventType extends Base
{
    
    /**
     * Represents a created repository, branch, or tag.
     * 
     * @param string      $refType
     * @param string      $masterBranch
     * @param string      $desc
     * @param string|null $ref
     * @return array
     */
    public function createEvent($refType, $masterBranch, $desc, $ref = null)
    {
       Argument::i()
               ->test(1, 'string')
               ->test(2, 'string')
               ->test(3, 'string')
               ->test(4, 'string');
       
       $post = array(
           'ref_type' => $refType,
           'master_branch' => $masterBranch,
           'description' => $desc,
           'ref' => $ref
       );
       
       return $this->postResponse('', $post);
    }
}

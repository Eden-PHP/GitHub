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
 * GitHub API - Repository: Status
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Status extends Base
{
    protected $link = array(
        'STATUS' => 'repos/:owner/:repo/statuses/:data'
    );
    
    /**
     * Lists the contributors.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $ref   ref to list the statuses from. It can be a SHA, a branch name, or a tag name.
     * @return array
     */
    public function getStatuses($owner, $repo, $ref)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $post = array(
            'ref' => $ref
        );
        
        // search and replace
        $link = StringType::i($this->link['STATUS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':data', $ref)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a status. Users with push access can create commit statuses for a given ref.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $sha
     * @param string      $state
     * @param string|null $targetUrl
     * @param string|null $description
     * @return array
     */
    public function createStatus(
            $owner, 
            $repo, 
            $sha, 
            $state, 
            $targetUrl = null, 
            $description = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null');
        
        $post = array(
            'state' => $state
        );
        
        // check and set
        if ($targetUrl) {
            $post['target_url'] = $targetUrl;
        }
        
        if ($description) {
            $post['description'] = $description;
        }
        
        // search and replace
        $link = StringType::i($this->link['STATUS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':data', $sha)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

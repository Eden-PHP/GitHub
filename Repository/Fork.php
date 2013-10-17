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
 * GitHub API - Repository: Fork
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Fork extends Base
{
    protected $link = array(
        'FORK' => 'repos/:owner/:repo/forks'
    );
    
    /**
     * Links the fork of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $sort  Default: newest. newest, oldest and watchers
     * @return array
     */
    public function getForks($owner, $repo, $sort = 'newest')
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $post = array(
            'sort' => $sort
        );
        
        // search and replace
        $link = StringType::i($this->link['FORK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a fork.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $organization organization login. The repository will be forked into this organization.
     * @return array
     */
    public function createFork($owner, $repo, $organization = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($organization) {
            $post['organization'] = $organization;
        }
        
        // search and replace
        $link = StringType::i($this->link['FORK'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

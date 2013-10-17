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
 * GitHub API - Repository: Key
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Key extends Base
{
    protected $link = array(
        'KEY' => 'repos/:owner/:repo/keys'
    );
    
    /**
     * Lists the keys of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getKeys($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the key of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $keyId
     * @return array
     */
    public function getKey($owner, $repo, $keyId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $keyId;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a key on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $title
     * @param string $key
     * @return array
     */
    public function createKey($owner, $repo, $title, $key)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'title' => $title,
            'key' => $key
        );
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits a key on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $title
     * @param string $key
     * @return array
     */
    public function editKey($owner, $repo, $keyId, $title, $key)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string');
        
        $post = array(
            'title' => $title,
            'key' => $key
        );
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $keyId;
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Deletes the key of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $keyId
     * @return array
     */
    public function deleteKey($owner, $repo, $keyId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $keyId;
        
        return $this->deleteResponse($link);
    }
}

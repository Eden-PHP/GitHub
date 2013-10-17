<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\User;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - User: Follower
 * 
 * @vendor Eden
 * @package GitHub\User
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Follower extends Base
{
    protected $link = array(
        'USER_KEY' => 'users/:user/keys',
        'KEY' => 'user/keys'
    );
    
    /**
     * Gets the public keys for a user. If user is not defined, get the authenticated
     * user public keys.
     * 
     * @param string|null $user
     * @return array
     */
    public function getPublicKeys($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        // search and replace
        if ($user) {
            $link = StringType::i($this->link['USER_KEY'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['KEY'])
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified public key for a user.
     * 
     * @param string $id
     * @return array
     */
    public function getPublicKey($id)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->get();
        
        $link .= '/' . $id;
        
        return $this->getResponse($link);
    }
    
    /**
     * Craetes public keys.
     * 
     * @param string $title
     * @param string $key
     * @return array
     */
    public function createPublicKey($title, $key)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $post = array(
            'title' => $title,
            'key' => $key
        );
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Updates the public keys.
     * 
     * @param string $id
     * @param string $title
     * @param string $key
     * @return array
     */
    public function updatePublicKey($id, $title, $key)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $post = array(
            'title' => $title,
            'key' => $key
        );
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->get();
        
        $link .= '/' . $id;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes the public keys.
     * 
     * @param string $id
     * @return array
     */
    public function deletePublicKey($id)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['KEY'])
                ->get();
        
        $link .= '/' . $id;
        
        return $this->deleteResponse($link);
    }
}

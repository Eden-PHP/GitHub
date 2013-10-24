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
        'USER_FOLLOWER' => 'users/:user/followers',
        'FOLLOWER' => 'user/followers',
        'USER_FOLLOWING' => 'users/:user/following',
        'FOLLOWING' => 'user/following',
        'FOLLOW_USER' => 'user/following/:user',
        'CHECK_FOLLOW' => 'users/:user/following/:target_user',
    );
    
    /**
     * Gets the followers of user. If user is not defined, gets the followers of
     * authenticated user.
     * 
     * @param string|null $user
     * @return array
     */
    public function getFollowers($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        // search and replace
        if ($user) {
            $link = StringType::i($this->link['USER_FOLLOWER'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['FOLLOWER'])
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the users followed. If user is not defined, gets the users followed of
     * authenticated user.
     * 
     * @param string|null $user
     * @return array
     */
    public function getFollowings($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        // search and replace
        if ($user) {
            $link = StringType::i($this->link['USER_FOLLOWING'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['FOLLOWING'])
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Checks if user is following the target user. If user is not defined,
     * checks if the authenticated user following the target user.
     * 
     * @param string      $targetUser
     * @param string|null $user
     * @return array
     */
    public function isFollowing($targetUser, $user = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string', 'null');
        
        // search and replace
        if ($user) {
            $link = StringType::i($this->link['CHECK_FOLLOW'])
                    ->str_replace(':user', $user)
                    ->str_replace(':target_user', $targetUser)
                    ->get();
        } else {
            $link = StringType::i($this->link['FOLLOW_USER'])
                    ->str_replace(':user', $targetUser)
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Follows the target user.
     * 
     * @param string $targetUser
     * @return array
     */
    public function follow($targetUser)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['FOLLOW_USER'])
                ->str_replace(':user', $targetUser)
                ->get();
        
        return $this->putResponse($link);
    }
    
    /**
     * Unfollow the target user.
     * 
     * @param string $targetUser
     * @return array
     */
    public function unfollow($targetUser)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['FOLLOW_USER'])
                ->str_replace(':user', $targetUser)
                ->get();
        
        return $this->deleteResponse($link);
    }
}

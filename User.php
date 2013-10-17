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
use Eden\GitHub\Organization\Member;
use Eden\GitHub\Organization\Team;

/**
 * GitHub API - User
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class User extends Base
{
    protected $link = array(
        'USERS_USER' => 'users/:user',
        'USER' => 'user',
        'USERS' => 'users'
    );
    
    /**
     * Gets the specified user information. If user is not defined, gets the
     * information of the authenticated user.
     * 
     * @param string|null $user
     * @return array
     */
    public function getUser($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        if ($user) {
            $link = StringType::i($this->link['USERS_USER'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['USER'])
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists the users.
     * 
     * @param $string $since must be <ISO 8601> format
     * @return array
     */
    public function getUsers($since)
    {
        Argument::i()->test(1, 'string');
        
        $post = array(
            'since' => $since
        );
        
        $link = StringType::i($this->link['USERS'])
                   ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Updates the information of the authenticated user.
     * 
     * @param string|null $name
     * @param string|null $email
     * @param string|null $blog
     * @param string|null $company
     * @param string|null $location
     * @param bool|null   $hireable
     * @param string|null $bio
     * @return array
     */
    public function updateUser(
            $name = null,
            $email = null,
            $blog = null,
            $company = null,
            $location = null,
            $hireable = null,
            $bio = null
    ) {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string', 'null')
                ->test(3, 'string', 'null')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'bool', 'null')
                ->test(7, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($name) {
            $post['name'] = $name;
        }
        if ($email) {
            $post['email'] = $email;
        }
        if ($blog) {
            $post['blog'] = $blog;
        }
        if ($company) {
            $post['company'] = $company;
        }
        if ($location) {
            $post['location'] = $location;
        }
        if ($hireable) {
            $post['hireable'] = $hireable;
        }
        if ($bio) {
            $post['bio'] = $bio;
        }
        
        $link = StringType::i($this->link['USER'])
                ->get();
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Returns a new instance of Member.
     * 
     * @return \Eden\GitHub\Organization\Member
     */
    public function member()
    {
        return Member::i();
    }
    
    /**
     * Returns a new instance of Team.
     * 
     * @return \Eden\GitHub\Organization\Team
     */
    public function team()
    {
        return Team::i();
    }
}

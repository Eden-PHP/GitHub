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
 * GitHub API - Organization
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Organization extends Base
{
    protected $link = array(
        'USER_ORGS' => 'users/:user/orgs',
        'ORGS' => 'user/orgs',
        'ORG' => 'orgs/:org'
    );
    
    /**
     * Lists the organization of an user. If user is not defined, list the organizations
     * of the authenticated user.
     * 
     * @param string|null $user
     * @return array
     */
    public function getOrganizations($user = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        if ($user) {
            $link = StringType::i($this->link['USER_ORGS'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['ORGS'])
                    ->get();
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Edits an organization.
     * 
     * @param string      $org
     * @param string|null $billingEmail
     * @param string|null $company
     * @param string|null $email
     * @param string|null $location
     * @param string|null $name
     * @return array
     */
    public function editOrganization(
            $org,
            $billingEmail = null,
            $company = null,
            $email = null,
            $location = null,
            $name = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string', 'null')
                ->test(3, 'string', 'null')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($billingEmail) {
            $post['billing_email'] = $billingEmail;
        }
        if ($company) {
            $post['company'] = $company;
        }
        if ($email) {
            $post['email'] = $email;
        }
        if ($location) {
            $post['location'] = $location;
        }
        if ($name) {
            $post['name'] = $name;
        }
        
        $link = StringType::i($this->link['ORG'])
                ->str_replace(':org', $org)
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

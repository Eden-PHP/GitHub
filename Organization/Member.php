<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Organization;

use Eden\Type\StringType;

/**
 * GitHub API - Organization: Member
 * 
 * @vendor Eden
 * @package GitHub\Organization
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Member extends Base
{
    protected $link = array(
        'MEMBERS' => 'orgs/:org/members',
        'PUBLIC_MEMBERS' => 'orgs/:org/public_members'
    );
    
    /**
     * Lists all users who are members of an organization. A member is a user that
     * belongs to at least 1 team in the organization. If the authenticated user
     * is also an owner of this organization then both concealed and public members
     * will be returned. If the requester is not an owner of the organization
     * the query will be redirected to the public members list.
     * 
     * @param string $org
     * @return array
     */
    public function getMembers($org)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['MEMBERS'])
                ->str_replace(':org', $org)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Checks if a user is, publicly or privately, a member of the organization.
     * 
     * @param string $org
     * @param string $user
     * @return array
     */
    public function checkMember($org, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['MEMBERS'])
                ->str_replace(':org', $org)
                ->get();
        
        $link .= '/' . $user;
        
        return $this->getResponse($link);
    }
    
    /**
     * Removing a user from this list will remove them from all teams and they
     * will no longer have any access to the organization’s repositories.
     * 
     * @param string $org
     * @param string $user
     * @return array
     */
    public function removeMember($org, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['MEMBERS'])
                ->str_replace(':org', $org)
                ->get();
        
        $link .= '/' . $user;
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Publicize or conceal their own membership.
     * (A user cannot pulicize the membership for another user)
     * 
     * @param string $org
     * @param string $user
     * @param bool   $conceal Default: false
     * @return array
     */
    public function setMembership($org, $user, $publicize = false)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'bool');
        
        // search and replace
        $link = StringType::i($this->link['PUBLIC_MEMBERS'])
                ->str_replace(':org', $org)
                ->get();
        
        $link .= '/' . $user;
        
        if ($publicize) {
            return $this->deleteResponse($link);
        } else {
            return $this->putResponse($link);
        }
    }
}

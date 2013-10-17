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
 * GitHub API - Repository: Collaborator
 * When authenticating as an organization owner of an organization-owned repository,
 * all organization owners are included in the list of collaborators.
 * Otherwise, only users with access to the repository are returned in the collaborators list.
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Collaborator extends Base
{
    protected $link = array(
        'COLLABORATOR' => 'repos/:owner/:repo/collaborators'
    );
    
    /**
     * Lists all the repository collaborators.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getCollaborators($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COLLABORATOR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Checks if the user is repository collaborator.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $user
     * @return array
     */
    public function isCollaborator($owner, $repo, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COLLABORATOR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        $link .= '/' . $user;
        
        return $this->getResponse($link);
    }
    
    /**
     * Adds the user as repository collaborator.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $user
     * @return array
     */
    public function addCollaborator($owner, $repo, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COLLABORATOR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        $link .= '/' . $user;
        
        return $this->putResponse($link);
    }
    
    /**
     * Removes the user as repository collaborator.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $user
     * @return array
     */
    public function removeCollaborator($owner, $repo, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COLLABORATOR'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        $link .= '/' . $user;
        
        return $this->deleteResponse($link);
    }
}

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
 * GitHub API - Organization: Team
 * 
 * @vendor Eden
 * @package GitHub\Organization
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Team extends Base
{
    protected $link = array(
        'ORG_TEAMS' => 'orgs/:org/teams',
        'TEAMS' => 'teams/:id',
        'TEAM_REPOS' => 'teams/:id/repos/:owner/:repo',
        'USER_TEAMS' => 'user/teams'
    );
    
    /**
     * Lists the teams of the organization.
     * 
     * @param string $org
     * @return array
     */
    public function getTeams($org)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ORG_TEAMS'])
                ->str_replace(':org', $org)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified team.
     * 
     * @param string $teamId
     * @return array
     */
    public function getTeam($teamId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a team. In order to create a team, the authenticated user must be
     * an owner of organization.
     * 
     * @param string      $org
     * @param string      $name
     * @param array       $reponames
     * @param string      $permission pull - team members can pull, but not push to or administer these repositories. (Default)
     *                                push - team members can pull and push, but not administer these repositories.
     *                                admin - team members can pull, push and administer these repositories.
     * @return array
     */
    public function createTeam($org, $name, array $reponames = array(), $permission = 'pull')
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'array')
                ->test(4, 'string');
        
        $post = array(
            'name' => $name,
            'repo_names' => $reponames,
            'permission' => $permission
        );
        
        // search and replace
        $link = StringType::i($this->link['ORG_TEAMS'])
                ->str_replace(':org', $org)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits the team's name and permissions. In order to edit a team, the authenticated 
     * user must be an owner of the org that the team is associated with.
     * 
     * @param string      $teamId
     * @param string      $name
     * @param string|null $permission
     * @return array
     * @see \Eden\GitHub\Organization\Team::createTeam()
     */
    public function editTeam($teamId, $name, $permission = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        $post = array(
            'name' => $name
        );
        
        if ($permission) {
            $post['permission'] = $permission;
        }
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Deletes the team on the organization. In order to delete a team, the authenticated 
     * user must be an owner of the org that the team is associated with.
     * 
     * @param string $teamId
     * @return array
     */
    public function deleteTeam($teamId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Lists the team members. In order to list members in a team,
     * the authenticated user must be a member of the team.
     * 
     * @param string $teamId
     * @return array
     */
    public function getTeamMembers($teamId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        $link .= '/members';
        
        return $this->getResponse($link);
    }
    
    /**
     * Get the team member. In order to get if a user is a member of a team,
     * the authenticated user must be a member of the team.
     * 
     * @param string $teamId
     * @param string $user
     * @return array
     */
    public function getTeamMember($teamId, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        $link .= '/members/' . $user;
        
        return $this->getResponse($link);
    }
    
    /**
     * Adds a member on a team. In order to add a user to a team, the authenticated
     * user must have ‘admin’ permissions to the team or be an owner of the org
     * that the team is associated with.
     * 
     * @param string $teamId
     * @param string $user
     * @return array
     */
    public function addTeamMember($teamId, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        $link .= '/members/' . $user;
        
        return $this->putResponse($link);
    }
    
    /**
     * Removes a team member. In order to remove a user from a team, the authenticated
     * user must have ‘admin’ permissions to the team or be an owner of the org that
     * the team is associated with. NOTE: This does not delete the user, 
     * it just remove them from the team.
     * 
     * @param string $teamId
     * @param string $user
     * @return array
     */
    public function removeTeamMember($teamId, $user)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        $link .= '/members/' . $user;
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Lists the repositories of the team.
     * 
     * @param string $teamId
     * @return array
     */
    public function getTeamRepos($teamId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAMS'])
                ->str_replace(':id', $teamId)
                ->get();
        
        $link .= '/repos';
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets team repository.
     * 
     * @param string $teamId
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getTeamRepo($teamId, $owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAM_REPOS'])
                ->str_replace(':id', $teamId)
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Adds team a repository. In order to add a repo to a team, the authenticated
     * user must be an owner of the org that the team is associated with.
     * Also, the repo must be owned by the organization, or a direct fork of a repo owned by the organization.
     * 
     * @param string $teamId
     * @param string $org
     * @param string $repo
     * @return array
     */
    public function addTeamRepo($teamId, $org, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAM_REPOS'])
                ->str_replace(':id', $teamId)
                ->str_replace(':owner', $org)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->putResponse($link);
    }
    
    /**
     * Removes team repository. In order to remove a repo from a team, the authenticated
     * user must be an owner of the org that the team is associated with.
     * NOTE: This does not delete the repo, it just removes it from the team.
     * 
     * @param string $teamId
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function removeTeamRepo($teamId, $owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TEAM_REPOS'])
                ->str_replace(':id', $teamId)
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Lists all of the teams across all of the organizations to which the authenticated
     * user belongs. This method requires user or repo scope.
     * 
     * @return array
     */
    public function getUserTeams()
    {
        // search and replace
        $link = StringType::i($this->link['USER_TEAMS'])
                ->get();
        
        return $this->getResponse($link);
    }
}

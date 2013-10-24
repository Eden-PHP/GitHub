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
use Eden\GitHub\Repository\Collaborator;
use Eden\GitHub\Repository\Comment;
use Eden\GitHub\Repository\Commit;
use Eden\GitHub\Repository\Content;
use Eden\GitHub\Repository\Download;
use Eden\GitHub\Repository\Fork;
use Eden\GitHub\Repository\Hook;
use Eden\GitHub\Repository\Key;
use Eden\GitHub\Repository\Merge;
use Eden\GitHub\Repository\Release;
use Eden\GitHub\Repository\Statistic;
use Eden\GitHub\Repository\Status;

/**
 * GitHub API - Repository
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Repository extends Base
{
    protected $link = array(
        'USERS_REPOS' => 'user/repos',
        'USER_REPO' => 'users/:user/repos',
        'ORG_REPOS' => 'orgs/:org/repos',
        'REPOS' => 'repositories',
        'REPO' => 'repos/:owner/:repo',
        'CONTRIBUTORS' => 'repos/:owner/:repo/contributors',
        'LANGUAGES' => 'repos/:owner/:repo/languages',
        'TEAMS' => 'repos/:owner/:repo/teams',
        'TAGS' => 'repos/:owner/:repo/tags',
        'BRANCHES' => 'repos/:owner/:repo/branches',
        'BRANCH' => 'repos/:owner/:repo/branches/:branch'
    );
    
    /**
     * Lists all user's repositories. If user is not defined, lists all the repositories
     * of the authenticated user.
     * 
     * @param string|null $user
     * @param string      $type      Default: all. all, owner, public, private or member
     * @param string      $sort      Default: full_name. create, updated, pushed or full_name
     * @param string      $direction Default: desc. asc or desc
     * @return array
     */
    public function getRepositories(
            $user = null,
            $type = 'all',
            $sort = 'full_name',
            $direction = 'asc'
    ) {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction
        );
        
        if ($user) {
            $link = StringType::i($this->link['USER_REPO'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['USERS_REPOS'])
                    ->get();
        }
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists all the organization's repositories.
     * 
     * @param string $org
     * @param string $type Default: all. all, public, private, forks, sources or member
     * @return array
     */
    public function getorganizationRepositories($org, $type= 'all')
    {
        Argument::i()->test(1, 'string');
        
        $post = array(
            'type' => $type
        );
        
        $link = StringType::i($this->link['ORG_REPOS'])
                ->str_replace(':org', $org)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists all the public repositories. This provides a dump of every public
     * repository, in the order that they were created.
     * 
     * @return array
     */
    public function getPublicRepositories()
    {
        Argument::i()->test(1, 'string');
        
        $link = StringType::i($this->link['REPOS'])
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a repository. If org is defined, creates a repository for an organization.
     * 
     * @param string|null     $org               (Optional)
     * @param string          $name
     * @param string          $description
     * @param string|null     $homepage          (Optional)
     * @param bool            $private           Default: false. Create a private repository
     * @param bool            $hasIssues         Default: true. Enable issues for this repository
     * @param bool            $hasWiki           Default: true. Enable the wiki for this repository
     * @param bool            $hasDownloads      Default: true. Enable downloads for this repository
     * @param string|int|null $teamId            the id of the team that will be granted access to this repository
     * @param bool            $autoInit          Default: false. Create an initial commit with empty README
     * @param string|null     $gitignoreTemplate
     * @return array
     */
    public function createRepository(
            $org = null,
            $name,
            $description,
            $homepage = null,
            $private = false,
            $hasIssues = true,
            $hasWiki = true,
            $hasDownloads = true,
            $teamId = null,
            $autoInit = false,
            $gitignoreTemplate = null
    ) {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'bool')
                ->test(6, 'bool')
                ->test(7, 'bool')
                ->test(8, 'bool')
                ->test(9, 'string', 'int', 'null')
                ->test(10, 'bool')
                ->test(11, 'string', 'null');
        
        $post = array(
            'name' => $name,
            'description' => $description,
            'private' => $private,
            'has_issues' => $hasIssues,
            'has_wiki' => $hasWiki,
            'has_downloads' => $hasDownloads,
            'auto_init' => $autoInit
        );
        
        // check and set
        if ($homepage) {
            $post['homepage'] = $homepage;
        }
        
        if ($teamId) {
            $post['team_id'] = $teamId;
        }
        if ($gitignoreTemplate) {
            $post['gitignore_Template'] = $gitignoreTemplate;
        }
        
        if ($org) {
            $link = StringType::i($this->link['ORG_REPOS'])
                    ->str_replace(':org', $org)
                    ->get();
        } else {
            $link = StringType::i($this->link['USERS_REPOS'])
                    ->get();
        }
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Gets the specified repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $link = StringType::i($this->link['REPO'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Edits a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $name
     * @param string|null $description   (Optional)
     * @param string|null $homepage      (Optional)
     * @param bool|null   $private       (Optional)
     * @param bool        $hasIssues     Default: true
     * @param bool        $hasWiki       Default: true
     * @param bool        $hasDownloads  Default: true
     * @param string|null $defaultBranch (Optional) update the default branch for this repository
     * @return array
     */
    public function editRepository(
            $owner,
            $repo,
            $name,
            $description = null,
            $homepage = null,
            $private = null,
            $hasIssues = true,
            $hasWiki = true,
            $hasDownloads = true,
            $defaultBranch = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'bool', 'null')
                ->test(7, 'bool')
                ->test(8, 'bool')
                ->test(9, 'bool')
                ->test(10, 'string', 'null');
        
        $post = array(
            'name' => $name,
            'has_issues' => $hasIssues,
            'has_wiki' => $hasWiki,
            'has_downloads' => $hasDownloads
        );
        
        // check and set
        if ($homepage) {
            $post['homepage'] = $homepage;
        }
        
        if (!is_null($private)) {
            $post['private'] = $private;
        }
        
        if ($defaultBranch) {
            $post['default_branch'] = $defaultBranch;
        }
        
        if ($description) {
            $post['description'] = $description;
        }
        
        $link = StringType::i($this->link['REPO'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Lists all the repository contributors.
     * 
     * @param string $owner
     * @param string $repo
     * @param bool   $anon  Default: false. Includes anonymous contributors
     * @return array
     */
    public function getContributors($owner, $repo, $anon = false)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'bool');
        
        $post = array(
            'anon' => $anon
        );
        
        $link = StringType::i($this->link['CONTRIBUTORS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists all the languages for the specified repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getLanguages($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $link = StringType::i($this->link['CONTRIBUTORS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists all the tags of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getTags($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $link = StringType::i($this->link['TAGS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists all the branches of a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getBranches($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $link = StringType::i($this->link['BRANCHES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified branch for the specified repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $branch
     * @return array
     */
    public function getBranch($owner, $repo, $branch)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::i($this->link['BRANCH'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':branch', $branch)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Deletes a repository. Required delete_repo scope.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function deleteRepository($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $link = StringType::i($this->link['REPO'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Returns a new instance of Collaborator.
     * 
     * @return \Eden\GitHub\Repository\Collaborator
     */
    public function collaborator()
    {
        return Collaborator::i();
    }
    
    /**
     * Returns a new instance of Comment.
     * 
     * @return \Eden\GitHub\Repository\Comment
     */
    public function comment()
    {
        return Comment::i();
    }
    
    /**
     * Returns a new instance of Commit.
     * 
     * @return \Eden\GitHub\Repository\Commit
     */
    public function commit()
    {
        return Commit::i();
    }
    
    /**
     * Returns a new instance of Content.
     * 
     * @return \Eden\GitHub\Repository\Content
     */
    public function content()
    {
        return Content::i();
    }
    
    /**
     * Returns a new instance of Download.
     * 
     * @return \Eden\GitHub\Repository\Download
     */
    public function download()
    {
        return Download::i();
    }
    
    /**
     * Returns a new instance of Fork.
     * 
     * @return \Eden\GitHub\Repository\Fork
     */
    public function fork()
    {
        return Fork::i();
    }
    
    /**
     * Returns a new instance of Hook.
     * 
     * @return \Eden\GitHub\Repository\Hook
     */
    public function hook()
    {
        return Hook::i();
    }
    
    /**
     * Returns a new instance of Key.
     * 
     * @return \Eden\GitHub\Repository\Key
     */
    public function key()
    {
        return Key::i();
    }
    
    /**
     * Returns a new instance of Merge.
     * 
     * @return \Eden\GitHub\Repository\Merge
     */
    public function merge()
    {
        return Merge::i();
    }
    
    /**
     * Returns a new instance of Release.
     * 
     * @return \Eden\GitHub\Repository\Release
     */
    public function release()
    {
        return Release::i();
    }
    
    /**
     * Returns a new instance of Statistic.
     * 
     * @return \Eden\GitHub\Repository\Statistic
     */
    public function statistic()
    {
        return Statistic::i();
    }
    
    /**
     * Returns a new instance of Status.
     * 
     * @return \Eden\GitHub\Repository\Status
     */
    public function status()
    {
        return Status::i();
    }
}

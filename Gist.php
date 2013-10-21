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
use Eden\GitHub\Gist\Comment;

/**
 * GitHub API - Gist
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Search extends Base
{
    protected $link = array(
        'USER_GISTS' => 'users/:user/gists',
        'GISTS' => 'gists',
        'GISTS_ID' => 'gists/:id',
        'PUBLIC_GISTS' => 'gists/public',
        'STARRED_GISTS' => 'gists/starred',
        'STAR_GISTS' => 'gists/:id/star',
        'FORK_GISTS' => 'gists/:id/forks'
    );
    
    /**
     * Lists the gists of the user. If user is not defined, lists the gists of the
     * authenticated user.
     * 
     * @param string|null $user
     * @param string|null $since must be in <ISO 8601> format
     * @return array
     */
    public function getGists($user = null, $since = null)
    {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($since) {
            $post['since'] = $since;
        }
        
        // search and replace
        if ($user) {
            $link = StringType::i($this->link['USER_GISTS'])
                    ->str_replace(':user', $user)
                    ->get();
        } else {
            $link = StringType::i($this->link['GISTS'])
                    ->get();
        }
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists the public gists.
     * 
     * @param string|null $since must be in <ISO 8601> format
     * @return array
     */
    public function getPublicGists($since = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($since) {
            $post['since'] = $since;
        }
        
        // search and replace
        $link = StringType::i($this->link['PUBLIC_GISTS'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists the starred gists.
     * 
     * @param string|null $since must be in <ISO 8601> format
     * @return array
     */
    public function getStarredGists($since = null)
    {
        Argument::i()->test(1, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($since) {
            $post['since'] = $since;
        }
        
        // search and replace
        $link = StringType::i($this->link['STARRED_GISTS'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Gets the specified gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function getGist($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['GISTS_ID'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * 
     * @param string $content
     * @param string $description
     * @param bool   $public      Default: false
     * @param array  $files       files that make up this gist.
     * @return array
     */
    public function createGist($content, $description, $public = false, array $files = array())
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'bool')
                ->test(4, 'array');
        
        $post = array(
            'content' => $content,
            'description' => $description,
            'public' => $public,
            'files' => $files
        );
        
        // search and replace
        $link = StringType::i($this->link['GISTS'])
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits the gist.
     * 
     * @param string|null $gistId
     * @param string|null $content
     * @param string|null $description
     * @param array|null  $files
     * @return array
     */
    public function editGist($gistId, $content = null, $description = null, $files = null)
    {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string', 'null')
                ->test(3, 'string', 'null')
                ->test(4, 'array', 'null');
        
        $post = array();
        
        // check and set
        if ($content) {
            $post['content'] = $content;
        }
        
        if ($description) {
            $post['description'] = $description;
        }
        
        if ($files) {
            $post['files'] = $files;
        }
        
        // search and replace
        $link = StringType::i($this->link['GISTS_ID'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Checks if the gist is already starred.
     * 
     * @param string $gistId
     * @return array
     */
    public function isStarred($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['STAR_GISTS'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Stars a gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function starGist($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['STAR_GISTS'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->putResponse($link);
    }
    
    /**
     * Unstars the gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function unstarGist($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['STAR_GISTS'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Forks the gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function forkGist($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['FORK_GISTS'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->postResponse($link);
    }
    
    /**
     * Deletes the gist.
     * 
     * @param string $gistId
     * @return array
     */
    public function deleteGist($gistId)
    {
        Argument::i()->test(1, 'string');
        
        // search and replace
        $link = StringType::i($this->link['GISTS_ID'])
                ->str_replace(':id', $gistId)
                ->get();
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Returns new instance of Comment.
     * 
     * @return \Eden\GitHub\Gist\Comment
     */
    public function comment()
    {
        return Comment::i();
    }
}

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
 * GitHub API - Repository: Comment
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Comment extends Base
{
    protected $link = array(
        'COMMENT' => 'repos/:owner/:repo/comments',
        'SHA_COMMENT' => 'repos/:owner/:repo/commits/:sha/comments'
    );
    
    /**
     * Lists the repository comments. If sha is defined, lists comments for
     * a single commit.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $sha
     * @return array
     */
    public function getCommitComments($owner, $repo, $sha = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // set the $link based on $sha initial value
        if ($sha) {
            $link = StringType::i($this->link['SHA_COMMENT']);
        } else {
            $link = StringType::i($this->link['COMMENT']);
        }
        
        // search and replace
        $link->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo);
        
        // checks if sha is defined
        if ($sha) {
            $link->str_replace(':sha', $sha); // search and replace
        }
        
        // get the full string
        $link = $link->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a commit comment.
     * 
     * @param string   $owner
     * @param string   $repo
     * @param strnig   $sha      sha of the commit to comment on
     * @param string   $body
     * @param int|null $path     relative path of the file to comment on
     * @param int|null $position line index in the diff to comment on
     * @return array
     */
    public function createCommitComment(
            $owner, 
            $repo, 
            $sha, 
            $body, 
            $path = null, 
            $position = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'int', 'null')
                ->test(6, 'int', 'null');
        
        $post = array(
            'body' => $body
        );
        
        // check and set
        if ($path) {
            $post['path'] = $path;
        }
        if ($position) {
            $post['position'] = $position;
        }
        
        // search and replace
        $link = StringType::i($this->link['SHA_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':sha', $sha)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Gets a single commit comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $id
     * @return array
     */
    public function getCommitComment($owner, $repo, $id)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->getResponse($link);
    }
    
    /**
     * Updates a commit comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $id
     * @param string $body
     * @return array
     */
    public function updateCommitComment($owner, $repo, $id, $body)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'body' => $body
        );
        
        // search and replace
        $link = StringType::i($this->link['COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes a commit comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $id
     * @return array
     */
    public function deleteCommitComment($owner, $repo, $id)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->deleteResponse($link);
    }
}

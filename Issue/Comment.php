<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Issue;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Issue: Comment
 * 
 * @vendor Eden
 * @package GitHub\Issue
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Comment extends Base
{
    protected $link = array(
        'ISSUE_COMMENT' => 'repos/:owner/:repo/issues/:number/comments',
        'REPO_COMMENT' => 'repos/:owner/:repo/issues/comments'
    );
    
    /**
     * Gets the comments on an issue.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getIssueComment($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the list of comments of the repository.
     * If commentId is defined, gets the single comment instead.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $commentId (Optional) the id of the comment
     * @param string      $sort      sort by created or updated
     * @param string      $direction asc or desc. Ignored wihtou sort argument.
     * @param string|null $since     timestamp in <ISO 8601> format.
     */
    public function getRepositoryComment(
            $owner, 
            $repo, 
            $commentId = null,
            $sort = 'created', 
            $direction = 'desc', 
            $since = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null');
        
        $post = array();
        
        // search and replace
        $link = StringType::i($this->link['REPO_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        // checks if comment id is defined
        if ($commentId) {
            $link .= '/' . $commentId;
        } else {
            $post['sort'] = $sort;
            $post['direction'] = $direction;

            if ($since) {
                $post['since'] = $since;
            }
        }

        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a comment of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $body
     * @return array
     */
    public function createComment($owner, $repo, $number, $body)
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
        $link = StringType::i($this->link['ISSUE_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits a comment of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $commentId
     * @param string $body
     * @return array
     */
    public function editComment($owner, $repo, $commentId, $body)
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
        $link = StringType::i($this->link['REPO_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $commentId;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes a comment of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $commentId
     * @return array
     */
    public function deleteComment($owner, $repo, $commentId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['REPO_COMMENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $commentId;
        
        return $this->putResponse($link);
    }
}

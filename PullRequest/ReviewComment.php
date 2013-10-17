<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\PullRequest;

use Eden\Type\StringType;

/**
 * GitHub API - PullRequest: ReviewComment
 * Pull Request Review Comments are comments on a portion of the unified diff.
 * These are separate from Commit Comments (which are applied directly to a commit,
 * outside of the Pull Request view), and Issue Comments (which do not reference a
 * portion of the unified diff).
 * 
 * @vendor Eden
 * @package GitHub\PullRequest
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class ReviewComment extends Base
{
    protected $link = array(
        'NUMBER_COMMENTS' => 'repos/:owner/:repo/pulls/:number/comments',
        'COMMENTS' =>        'repos/:owner/:repo/pulls/comments'
    );
    
    /**
     * Lists the comments on a pull request.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getComments($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['NUMBER_COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists the comments in a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $sort      Default: created. Sort by created or updated.
     * @param string      $direction Default: desc. Direction of sort by asc or desc.
     * @param string|null $since     Must be in <ISO 8601> format.
     * @return array
     */
    public function getRepositoryComments(
            $owner,
            $repo,
            $sort ='created',
            $direction = 'desc',
            $since = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string', 'null');
        
        $post = array(
            'sort' => $sort,
            'direction' => $direction
        );
        
        if ($since) {
            $post['since'] = $since;
        }
        
        // search and replace
        $link = StringType::i($this->link['COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Gets the single comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getComment($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $number;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $body
     * @param string $commitId sha of the commit to comment on
     * @param string $path     relative path of the file to comment on
     * @param int    $position line index in the diff to comment on
     * @return array
     */
    public function createComment(
            $owner,
            $repo,
            $number,
            $body,
            $commitId,
            $path,
            $position
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'int');
        
        $post = array(
            'body' => $body,
            'commit_id' => $commitId,
            'path' => $path,
            'position' => $position
        );
        
        // search and replace
        $link = StringType::i($this->link['NUMBER_COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Replies to an existing pull request comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $body
     * @param int    $inReplyTo
     * @return array
     */
    public function replyComment($owner, $repo, $number, $body, $inReplyTo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'int');
        
        $post = array(
            'body' => $body,
            'in_reply_to' => $inReplyTo
        );
        
        // search and replace
        $link = StringType::i($this->link['NUMBER_COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits a comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $body
     * @return array
     */
    public function editComment($owner, $repo, $number, $body)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'body' => $body,
        );
        
        // search and replace
        $link = StringType::i($this->link['COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $number;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes a comment.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function deleteComment($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMENTS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $number;
        
        return $this->deleteResponse($link);
    }
}

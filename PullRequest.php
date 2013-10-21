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
use Eden\GitHub\PullRequest\ReviewComment;

/**
 * GitHub API - PullRequest
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class PullRequest extends Base
{
    protected $link = array(
        'PULLS' => 'repos/:owner/:repo/pulls',
        'PULL' => 'repos/:owner/:repo/pulls/:number',
        'COMMITS' => 'repos/:owner/:repo/pulls/:number/commits',
        'FILES' => 'repos/:owner/:repo/pulls/:number/files',
        'MERGE' => 'repos/:owner/:repo/pulls/:number/merge'
    );
    
    /**
     * Lists all the pull requests.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $state Default: open. open or closed
     * @param string|null $head
     * @param string|null $base
     * @return array
     */
    public function getPullRequests(
            $owner,
            $repo,
            $state = 'open',
            $head = null,
            $base = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null');
        
        $post = array('state' => $state);
        
        // check and set
        if ($head) {
            $post['head'] = $head;
        }
        if ($base) {
            $post['base'] = $base;
        }
        
        $link = StringType::i($this->link['PULLS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Gets the specified pulll request.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getPullRequest($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::i($this->link['PULL'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a pull request. You can also create a pull request from an existing issue
     * by passing an issue instead of title and body.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $issue Default: null
     * @param string      $title
     * @param string      $body
     * @param string      $base  can be either brance name or sha
     * @param string      $head  can be either brance name or sha
     * @return array
     */
    public function createPullRequest(
            $owner,
            $repo,
            $issue = null,
            $title,
            $body,
            $base,
            $head
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'string');
        
        $post = array(
            'base' => $base,
            'head' => $head
        );
        
        if ($issue) {
            $post['issue'] = $issue;
        } else {
            $post['title'] = $title;
            $post['body'] = $body;
        }
        
        $link = StringType::i($this->link['PULLS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Updates the existing pull request.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $number
     * @param string|null $title
     * @param string|null $body
     * @param string|null $state  open or closed
     * @return array
     */
    public function updatePullRequest(
            $owner,
            $repo,
            $number,
            $title = null,
            $body = null,
            $state = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($title) {
            $post['title'] = $title;
        }
        
        if ($body) {
            $post['body'] = $body;
        }
        
        if ($state) {
            $post['state'] = $state;
        }
        
        $link = StringType::i($this->link['PULL'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Lists all the commits.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getCommits($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::o($this->link['COMMITS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists all the files.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getFiles($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::o($this->link['FILES'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Lists all the merges.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getMerges($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        $link = StringType::o($this->link['MERGE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Merges a pull reqeust.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $commitMessage
     * @return array
     */
    public function mergePullRequest($owner, $repo, $number, $commitMessage)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'commit_message' => $commitMessage
        );
        
        $link = StringType::o($this->link['MERGE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Returns new instance of ReviewComment.
     * 
     * @return \Eden\GitHub\PullRequest\ReviewComment
     */
    public function reviewComment() {
        return ReviewComment::i();
    }
}

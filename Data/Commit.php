<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Data;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Git Data: Commit
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Commit extends Base
{
    protected $link = array(
        'COMMIT' => 'repos/:owner/:repo/git/commits'
    );
    
    /**
     * Gets a commit.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $sha
     * @return array
     */
    public function getCommit($owner, $repo, $sha)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMIT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $sha;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a commit.
     * 
     * @param string      $owner          name of owner
     * @param string      $repo           name of repository
     * @param string      $message        the commit message
     * @param string      $tree           sha of the tree object this commit points to
     * @param array       $parents        array of the SHAs of the commits that were the parents of this commit.
     *                                    If omitted or empty, the commit will be written as a root commit. 
     *                                    For a single parent, an array of one SHA should be provided,
     *                                    for a merge commit, an array of more than one should be provided.
     * @param string|null $authorName     name of the author
     * @param string|null $authorEmail    email of the author
     * @param string|null $authorDate     timestamp date
     * @param string|null $committerName  name of the committer
     * @param string|null $committerEmail email of the committer
     * @param string|null $committerDate  timestamp date
     * @return array
     */
    public function createCommit(
            $owner, 
            $repo, 
            $message, 
            $tree, 
            array $parents,
            $authorName = null,
            $authorEmail = null,
            $authorDate = null,
            $committerName = null,
            $committerEmail = null,
            $committerDate = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'array')
                ->test(6, 'string', 'null')
                ->test(7, 'string', 'null')
                ->test(8, 'string', 'null')
                ->test(9, 'string', 'null')
                ->test(10, 'string', 'null')
                ->test(11, 'string', 'null');
        
        $post = array(
            'message' => $message,
            'tree' => $tree,
            'parents' => join(',', $parents)
        );
        
        // checks the authors
        if ($authorName) {
            $post['author']['name'] = $authorName;
        }
        if ($authorEmail) {
            $post['author']['email'] = $authorEmail;
        }
        if ($authorDate) {
            $post['author']['date'] = $authorDate;
        }
        
        // checks the commiters
        if ($committerName) {
            $post['committer']['name'] = $committerName;
        }
        if ($committerEmail) {
            $post['committer']['email'] = $committerEmail;
        }
        if ($committerDate) {
            $post['committer']['date'] = $committerDate;
        }
        
        // search and replace
        $link = StringType::i($this->link['COMMIT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

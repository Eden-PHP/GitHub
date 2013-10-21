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
 * GitHub API - Repository: Commit
 * Repo Commits API supports listing, viewing, and comparing commits in a repository.
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Commit extends Base
{
    protected $link = array(
        'COMMIT' => 'repos/:owner/:repo/commits',
        'COMPARE' => 'repos/:owner/:repo/compare/:base...:head'
    );
    
    /**
     * Lists all the commit of the repository. Pagination is based on SHA instead
     * of page number.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $sha    sha or branch to start listing commits from
     * @param string|null $path   only commits containing this file path will be returned
     * @param string|null $author login, name, or email by which to filter by commit author
     * @param string|null $since  must be in <ISO 8601> format
     * @param string|null $until  must be in <ISO 8601> format
     * @return array
     */
    public function getCommits(
            $owner, 
            $repo, 
            $sha = null,
            $path = null,
            $author = null,
            $since = null,
            $until = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'string');
        
        $post = array();
        
        // check and set
        if ($sha) {
            $post['sha'] = $sha;
        }
        
        if ($path) {
            $post['path'] = $path;
        }
        
        if ($author) {
            $post['author'] = $author;
        }
        
        if ($since) {
            $post['since'] = $since;
        }
        
        if ($until) {
            $post['until'] = $until;
        }
        
        // search and replace
        $link = StringType::i($this->link['COMMIT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Gets a single commit.
     * Note: Diffs with binary data will have no ‘patch’ property.
     * Pass the appropriate media type to fetch diff and patch formats.
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
     * Compares the two commits.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $base
     * @param string $head
     * @return array
     */
    public function compareCommits($owner, $repo, $base, $head)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMPARE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':base', $base)
                ->str_replace(':head', $head)
                ->get();
        
        return $this->getResponse($link);
    }
}

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
 * GitHub API - Repository: Merge
 * The Repo Merging API supports merging branches in a repository.
 * This accomplishes essentially the same thing as merging one branch into another
 * in a local repository and then pushing to GitHub. The benefit is that the merge is
 * done on the server side and a local repository is not needed. This makes it more
 * appropriate for automation and other tools where maintaining local repositories
 * would be cumbersome and inefficient.
 * 
 * The authenticated user will be the author of any merges done through this endpoint.
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Merge extends Base
{
    protected $link = array(
        'MERGE' => 'repos/:owner/:repo/merges'
    );
    
    /**
     * Performs a merge.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $base    the name of the base branch that the head will be merged into
     * @param string      $head    the head to merge. This can be a branch name or a commit SHA1
     * @param string|null $message commit message to use for the merge commit. If omitted, a default message will be used
     * @return array
     */
    public function merge($owner, $repo, $base, $head, $message = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string', 'null');
        
        $post = array(
            'base' => $base,
            'head' => $head
        );
        
        if ($message) {
            $post['commit_message'] = $message;
        }
        
        // search and replace
        $link = StringType::i($this->link['MERGE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

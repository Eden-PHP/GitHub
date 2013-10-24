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
 * GitHub API - Repository: Content
 * These API methods let you retrieve the contents of files within a repository as Base64 encoded content
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Content extends Base
{
    protected $link = array(
        'README' => 'repos/:owner/:repo/readme',
        'CONTENT' => 'repos/:owner/:repo/contents/:path',
        'ARCHIVE' => 'repos/:owner/:repo/:archive_format/:ref'
    );
    
    /**
     * Gets the README of the repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $ref  the name of the Commit/Branch/Tag. If not provided,
     *                          uses the repository’s default branch (usually master).
     * @return array
     */
    public function getReadme($owner, $repo, $ref = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        $post = array();
        
        // check and set
        if ($ref) {
            $post['ref'] = $ref;
        }
        
        // search and replace
        $link = StringType::i($this->link['README'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Lists the contents of a file or directory in a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $path
     * @param string|null $ref
     * @return string
     */
    public function getContents($owner, $repo, $path = '', $ref = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null');
        
        $post = array(
            'path' => $path
        );
        
        // check and set
        if ($ref) {
            $post['ref'] = $ref;
        }
        
        // search and replace
        $link = StringType::i($this->link['CONTENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':path', $path)
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Creates a new file in a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $path           the content path
     * @param string      $message        the commit message
     * @param string      $content        the new file content, base64 encoded
     * @param string|null $branch         the branch name
     * @param string|null $authorName     if defined, author email must be defined also
     * @param string|null $authorEmail    if defined, author name must be defined also
     * @param string|null $committerName  if defined, committer email must be defined also
     * @param string|null $committerEmail if defined, committer name must be defined also
     * @return array
     */
    public function createFile(
            $owner,
            $repo,
            $path,
            $message,
            $content,
            $branch = null,
            $authorName = null,
            $authorEmail = null,
            $committerName = null,
            $committerEmail = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null')
                ->test(7, 'string', 'null')
                ->test(8, 'string', 'null')
                ->test(9, 'string', 'null')
                ->test(10, 'string', 'null');
        
        $post = array(
            'path' => $path,
            'message' => $message,
            'content' => $content
        );
        
        // check and set
        if ($branch) {
            $post['branch'] = $branch;
        }
        
        // check and sets
        if ($authorName) {
            $post['author']['name'] = $authorName;
            $post['author']['email'] = $authorEmail;
        }
        
        if ($committerName) {
            $post['committer']['name'] = $committerName;
            $post['committer']['email'] = $committerEmail;
        }
        
        // search and replace
        $link = StringType::i($this->link['CONTENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':path', $path)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Updates a file in a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $path           the content path
     * @param string      $message        the commit message
     * @param string      $content        the new file content, base64 encoded
     * @param string      $sha            the blob sha of the file being replaced
     * @param string|null $branch         the branch name
     * @param string|null $authorName     if defined, author email must be defined also
     * @param string|null $authorEmail    if defined, author name must be defined also
     * @param string|null $committerName  if defined, committer email must be defined also
     * @param string|null $committerEmail if defined, committer name must be defined also
     * @return array
     */
    public function updateFile(
            $owner,
            $repo,
            $path,
            $message,
            $content,
            $sha,
            $branch = null,
            $authorName = null,
            $authorEmail = null,
            $committerName = null,
            $committerEmail = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'string', 'null')
                ->test(8, 'string', 'null')
                ->test(9, 'string', 'null')
                ->test(10, 'string', 'null')
                ->test(11, 'string', 'null');
        
        $post = array(
            'path' => $path,
            'message' => $message,
            'content' => $content,
            'sha' => $sha
        );
        
        // check and set
        if ($branch) {
            $post['branch'] = $branch;
        }
        
        // check and sets
        if ($authorName) {
            $post['author']['name'] = $authorName;
            $post['author']['email'] = $authorEmail;
        }
        
        if ($committerName) {
            $post['committer']['name'] = $committerName;
            $post['committer']['email'] = $committerEmail;
        }
        
        // search and replace
        $link = StringType::i($this->link['CONTENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':path', $path)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Deleters a file in a repository.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $path           the content path
     * @param string      $message        the commit message
     * @param string      $sha            the blob sha of the file being replaced
     * @param string|null $branch         the branch name
     * @param string|null $authorName     if defined, author email must be defined also
     * @param string|null $authorEmail    if defined, author name must be defined also
     * @param string|null $committerName  if defined, committer email must be defined also
     * @param string|null $committerEmail if defined, committer name must be defined also
     * @return array
     */
    public function deleteFile(
            $owner,
            $repo,
            $path,
            $message,
            $sha,
            $branch = null,
            $authorName = null,
            $authorEmail = null,
            $committerName = null,
            $committerEmail = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string', 'null')
                ->test(7, 'string', 'null')
                ->test(8, 'string', 'null')
                ->test(9, 'string', 'null')
                ->test(10, 'string', 'null');
        
        $post = array(
            'path' => $path,
            'message' => $message,
            'sha' => $sha
        );
        
        // check and set
        if ($branch) {
            $post['branch'] = $branch;
        }
        
        // check and sets
        if ($authorName) {
            $post['author']['name'] = $authorName;
            $post['author']['email'] = $authorEmail;
        }
        
        if ($committerName) {
            $post['committer']['name'] = $committerName;
            $post['committer']['email'] = $committerEmail;
        }
        
        // search and replace
        $link = StringType::i($this->link['CONTENT'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':path', $path)
                ->get();
        
        return $this->deleteResponse($link, $post);
    }
    
    /**
     * This method will return a 302 to a URL to download a tarball or zipball
     * archive for a repository. Please make sure your HTTP framework is configured
     * to follow redirects or you will need to use the Location header to make a
     * second GET request.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $format the archive format. Either tarball or zipball
     * @param string $ref    valid Git reference, defaults to master
     * @return array
     */
    public function getAchiveLink($owner, $repo, $format, $ref = 'master')
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ARCHIVE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':archive_format', $format)
                ->str_replace(':ref', $ref)
                ->get();
        
        return $this->getResponse($link);
    }
}

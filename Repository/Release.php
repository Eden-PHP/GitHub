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
 * GitHub API - Repository: Release
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Release extends Base
{
    protected $link = array(
        'RELEASE' => 'repos/:owner/:repo/releases',
        'ASSETS' => 'repos/:owner/:repo/releases/:id/assets',
        'ASSET' => 'repos/:owner/:repo/releases/assets'
    );
    
    /**
     * Lists the release of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getReleases($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['RELEASE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified release of the repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $releaseId
     * @return array
     */
    public function getRelease($owner, $repo, $releaseId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['RELEASE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $releaseId;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a release. Users with push access to the repository can create a release.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $tagName
     * @param string|null $targetCommitish specifies the commitish value that determines where
     *                                     the Git tag is created from. Can be any branch or
     *                                     commit SHA. Defaults to the repository’s default branch
     *                                     (usually “master”). Unused if the Git tag already exists
     * @param string|null $name            (Optional)
     * @param string|null $body            (Optional)
     * @param bool        $draft           true - to create a draft (unpublished) release,
     *                                     false - to create a published one. Default is false
     * @param bool        $prerelease      true - to identify the release as a prerelease.
     *                                     false - to identify the release as a full release
     *                                     Default is false
     * @return array
     */
    public function createRelease(
            $owner,
            $repo,
            $tagName,
            $targetCommitish = null,
            $name = null,
            $body = null,
            $draft = false,
            $prerelease = false
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null')
                ->test(7, 'bool')
                ->test(8, 'bool');
        
        $post = array(
            'tag_name' => $tagName,
            'draft' => $draft,
            'prerelease' => $prerelease
        );
        
        // check and set
        if ($targetCommitish) {
            $post['target_commitish'] = $targetCommitish;
        }
        if ($name) {
            $post['name'] = $name;
        }
        if ($body) {
            $post['body'] = $body;
        }
        
        // search and replace
        $link = StringType::i($this->link['RELEASE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Edits a release. Users with push access to the repository can create a release.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string      $tagName
     * @param string|null $targetCommitish specifies the commitish value that determines where
     *                                     the Git tag is created from. Can be any branch or
     *                                     commit SHA. Defaults to the repository’s default branch
     *                                     (usually “master”). Unused if the Git tag already exists
     * @param string|null $name            (Optional)
     * @param string|null $body            (Optional)
     * @param bool        $draft           true - to create a draft (unpublished) release,
     *                                     false - to create a published one. Default is false
     * @param bool        $prerelease      true - to identify the release as a prerelease.
     *                                     false - to identify the release as a full release
     *                                     Default is false
     * @return array
     */
    public function editRelease(
            $owner,
            $repo,
            $id,
            $tagName = null,
            $targetCommitish = null,
            $name = null,
            $body = null,
            $draft = false,
            $prerelease = false
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string', 'null')
                ->test(5, 'string', 'null')
                ->test(6, 'string', 'null')
                ->test(7, 'bool')
                ->test(8, 'bool');
        
        $post = array(
            'tag_name' => $tagName,
            'draft' => $draft,
            'prerelease' => $prerelease
        );
        
        // check and set
        if ($targetCommitish) {
            $post['target_commitish'] = $targetCommitish;
        }
        if ($name) {
            $post['name'] = $name;
        }
        if ($body) {
            $post['body'] = $body;
        }
        
        // search and replace
        $link = StringType::i($this->link['RELEASE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes a release.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $releaseId
     * @return array
     */
    public function deleteRelease($owner, $repo, $releaseId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['RELEASE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $releaseId;
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Lists the release assets.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $releaseId
     * @return array
     */
    public function getAssets($owner, $repo, $releaseId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ASSETS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':id', $releaseId)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the specified release asset.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $assetId
     * @return array
     */
    public function getAsset($owner, $repo, $assetId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ASSET'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $assetId;
        
        return $this->getResponse($link);
    }
    
    /**
     * Edits the specified release asset.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $assetId
     * @param string $name
     * @param string $label
     * @return array
     */
    public function editAsset($owner, $repo, $assetId, $name, $label)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string');
        
        $post = array(
            'name' => $name,
            'label' => $label
        );
        
        // search and replace
        $link = StringType::i($this->link['ASSET'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $assetId;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes the specified release asset.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $assetId
     * @return array
     */
    public function deleteAsset($owner, $repo, $assetId)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ASSET'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $assetId;
        
        return $this->deleteResponse($link);
    }
}

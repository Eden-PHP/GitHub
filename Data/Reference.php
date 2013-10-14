<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Data;

use Eden\Type\StringType;

/**
 * GitHub API - Git Data: Reference
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Reference extends Base
{
    protected $link = array(
        'REFERENCE' => 'repos/:owner/:repo/git/refs'
    );
    
    /**
     * Gets a reference.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param string|null $ref  (Optional) if is not defined, get all reference of the repository.
     *                          the URL must be formatted as heads/branch, not just branch.
     * @return array
     */
    public function getReference($owner, $repo, $ref = null)
    {
        Argument:i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        // search and replace
        $link = StringType::i($this->link['REFERENCE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        // checks if ref is defined
        if ($ref) {
            $link .= '/' . $ref;
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Create a reference.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $ref   the name of the fully qualified reference (ie: refs/heads/master).
     *                      If it doesn’t start with ‘refs’ and have at least two slashes, it will be rejected.
     * @param string $sha  the SHA1 value to set this reference to
     * @return array
     */
    public function createReference($owner, $repo, $ref, $sha)
    {
        Argument:i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'ref' => $ref,
            'sha' => $sha
        );
        
        // search and replace
        $link = StringType::i($this->link['REFERENCE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Updates a reference.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $ref
     * @param string $sha   the SHA1 value to set this reference to
     * @param bool   $force Default: false. Indicating whether to force the update or to make sure the update is a fast-forward update
     * @return array
     * @see \Eden\GitHub\Data\Reference::createReference()
     */
    public function updateReference($owner, $repo, $ref, $sha, $force = false)
    {
        Argument:i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'bool');
        
        $post = array(
            'sha' => $sha,
            'force' => $force
        );
        
        // search and replace
        $link = StringType::i($this->link['REFERENCE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        $link .= '/' . $ref;
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Deletes a reference. It can be a brance or a tag.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $ref
     * @return array
     */
    public function deleteReference($owner, $repo, $ref)
    {
        Argument:i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['REFERENCE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        $link .= '/' . $ref;
        
        return $this->deleteResponse($link);
    }
}

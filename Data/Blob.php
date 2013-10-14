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
 * GitHub API - Git Data: Blob
 * Since blobs can be any arbitrary binary data, the input and responses for the 
 * blob API takes an encoding parameter that can be either utf-8 or base64. 
 * If your data cannot be losslessly sent as a UTF-8 string, you can base64 encode it.
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Blob extends Base
{
    protected $link = array(
        'BLOB' => 'repos/:owner/:repo/git/blobs'
    );
    
    /**
     * Gets a blob.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $sha
     * @return array
     */
    public function getBlob($owner, $repo, $sha)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['BLOB'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $sha;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a blob.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function createBlob($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['BLOB'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link);
    }
}

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
 * GitHub API - Repository: Download
 * The downloads API is for package downloads only. If you want to get source
 * tarballs you should use \Eden\GitHub\Repository\Content::getArchiveLink() instead.
 * 
 * @see \Eden\GitHub\Repository\Content
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Download extends Base
{
    protected $link = array(
        'DOWNLOAD' => 'repos/:owner/:repo/downloads'
    );
    
    /**
     * Lists the downloads for a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getDownloads($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['DOWNLOAD'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the single download for a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $id
     * @return array
     */
    public function getDownload($owner, $repo, $id)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['DOWNLOAD'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->getResponse($link);
    }
    
    /**
     * Deletes a download for a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $id
     * @return array
     */
    public function deleteDownload($owner, $repo, $id)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['DOWNLOAD'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $id;
        
        return $this->deleteResponse($link);
    }
}

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
 * GitHub API - Git Data: Tag
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Tag extends Base
{
    protected $link = array(
        'TAG' => 'repos/:owner/:repo/git/tags'
    );
    
    /**
     * Gets a tag.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $sha
     * @return array
     */
    public function getTag($owner, $repo, $sha)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['TAG'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $sha;
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a tag.
     * Note that creating a tag object does not create the reference that makes a tag in Git.
     * If you want to create an annotated tag in Git, you have to do this call to create the tag object,
     * and then create the refs/tags/[tag] reference. If you want to create a lightweight tag,
     * you only have to create the tag reference - this call would be unnecessary
     * 
     * @param string $owner
     * @param string $repo
     * @param string $tag         the tag
     * @param string $message     the tag message
     * @param string $sha         the sha of the git object this is tagging
     * @param string $type        type of object we're tagging. Valid values are commit, tree or blob
     * @param string $taggerName  the name of the author of the tag
     * @param string $taggerEmail the email of the author of the tag
     * @param string $taggerDate  when this object was tagged
     * @return array
     */
    public function createTag(
            $owner, 
            $repo, 
            $tag, 
            $message, 
            $sha, 
            $type, 
            $taggerName, 
            $taggerEmail, 
            $taggerDate
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'string')
                ->test(8, 'string')
                ->test(9, 'string');
        
        $post = array(
            'tag' => $tag,
            'message' => $message,
            'object' => $sha,
            'type' => $type,
            'tagger' => array(
                'name' => $taggerName,
                'email' => $taggerEmail,
                'date' => $taggerDate
            )
        );
        
        // search and replace
        $link = StringType::i($this->link['TAG'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

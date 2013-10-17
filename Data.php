<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\GitHub\Data\Blob;
use Eden\GitHub\Data\Commit;
use Eden\GitHub\Data\Reference;
use Eden\GitHub\Data\Tag;
use Eden\GitHub\Data\Tree;

/**
 * GitHub API - Data
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Data extends Base
{
    /**
     * Returns a new instance of Blob.
     * 
     * @return \Eden\GitHub\Data\Blob
     */
    public function blob()
    {
        return Blob::i();
    }
    
    /**
     * Returns a new instance of Commit.
     * 
     * @return \Eden\GitHub\Data\Commit
     */
    public function commit()
    {
        return Commit::i();
    }
    
    /**
     * Returns a new instance of Reference.
     * 
     * @return \Eden\GitHub\Data\Reference
     */
    public function reference()
    {
        return Reference::i();
    }
    
    /**
     * Returns a new instance of Tag.
     * 
     * @return \Eden\GitHub\Data\Tag
     */
    public function tag()
    {
        return Tag::i();
    }
    
    /**
     * Returns a new instance of Tree.
     * 
     * @return \Eden\GitHub\Data\Tree
     */
    public function tree()
    {
        return Tree::i();
    }
}

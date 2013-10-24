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
 * GitHub API - Git Data: Tree
 * 
 * @vendor Eden
 * @package GitHub\Data
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Tree extends Base
{
    protected $link = array(
        'TREE' => 'repos/:owner/:repo/git/trees'
    );
    
    /**
     * Gets a tree.
     * 
     * @param string   $owner
     * @param string   $repo
     * @param string   $sha
     * @param int|null $recursive
     * @return array
     */
    public function getTree($owner, $repo, $sha, $recursive = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'int', 'null');
        
        // search and replace
        $link = StringType::i($this->link['TREE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $sha;
        
        if ($recursive) {
            $link .= '?recursive=' . $recursive;
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a tree.
     * 
     * @param string      $owner
     * @param string      $repo
     * @param array       $treePath    the reference in the tree
     * @param string      $treeMode    file mode, 100644 for file (blob), 100755 for executable (blob),
     *                                 040000 for subdirectory (tree), 160000 for submodule (commit) or
     *                                 120000 for a blob that specifies the path of a symlink.
     * @param string      $treeType    blob, tree or commit
     * @param string      $treeSha     the SHA1 checksum id of the objet in the tree
     * @param string      $treeContent content you want this file to have. Use either this or $treeSha
     * @param string|null $baseTree    (Optional) the SHA1 of the tree you want to update with new data.
     *                                 If you don’t set this, the commit will be created on top of everything, however,
     *                                 it will only contain your change, the rest of your files will show up as deleted.
     * @return array
     */
    public function createTree(
            $owner, 
            $repo, 
            $treePath, 
            $treeMode, 
            $treeType, 
            $treeSha, 
            $treeContent, 
            $baseTree = null
    ) {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'array')
                ->test(4, 'string')
                ->test(5, 'string')
                ->test(6, 'string')
                ->test(7, 'string')
                ->test(8, 'string')
                ->test(9, 'string', 'null');
        
        $post = array(
            'tree' => array(
                'path' => $treePath,
                'mode' => $treeMode,
                'type' => $treeType,
                'sha' => $treeSha,
                'content' => $treeContent
            )
        );
        
        // checks if base tree is defined
        if ($baseTree) {
            $post['base_tree'] = $baseTree;
        }
        
        // search and replace
        $link = StringType::i($this->link['TREE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
}

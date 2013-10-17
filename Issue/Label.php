<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Issue;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Issue: Label
 * 
 * @vendor Eden
 * @package GitHub\Issue
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Label extends Base
{
    protected $link = array(
        'LABELS' => 'repos/:owner/:repo/labels',
        'ISSUE_LABELS' => 'repos/:owner/:repo/issues/:number/labels',
        'ISSUE_LABELS_MILESTONE' => 'repos/:owner/:repo/milestones/:number/labels'
    );
    
    /**
     * Gets the list of labels of the repository.
     * If name is defined, get the single result instread.
     * 
     * @param string $owner
     * @param string $repo
     * @param string|null $name
     * @return array
     */
    public function getLabels($owner, $repo, $name = null)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string', 'null');
        
        // search and replace
        $link = StringType::i($this->link['LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        if ($name) {
            $link .= '/' . $name;
        }
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a label on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $name
     * @param string $color 6 character hex code, without a leading #.
     * @return array
     */
    public function createLabel($owner, $repo, $name, $color)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        $post = array(
            'name' => $name,
            'color' => $color
        );
        
        // search and replace
        $link = StringType::i($this->link['LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Updates the label on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $name    old name of the label
     * @param string $newName new name of the label
     * @param string $color   6 character hex code, without a leading #
     * @return array
     */
    public function updateLabel($owner, $repo, $name, $newName, $color)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        $post = array(
            'name' => $newName,
            'color' => $color
        );
        
        // search and replace
        $link = StringType::i($this->link['LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $name;
        
        return $this->patchResponse($link, $post);
    }
    
    /**
     * Deletes the label on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $name
     * @return array
     */
    public function deleteLabel($owner, $repo, $name)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        $link .= '/' . $name;
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Gets the list of issued labels on a repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getIssueLabels($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Creates a labels on an issue.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param array  $labels array of string labels
     * @return array
     */
    public function createIssueLabel($owner, $repo, $number, array $labels)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'array');
        
        $post = $labels; // clone labels
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Removes a label on an issued repository.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param string $name
     * @return array
     */
    public function removeIssueLabel($owner, $repo, $number, $name)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        $link .= '/' . $name;
        
        return $this->deleteResponse($link);
    }
    
    /**
     * Replaces all labels for an issued.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @param array  $labels sending an empty array ([]) will remove all Labels from the Issue
     * @return array
     */
    public function replaceIssueLabel($owner, $repo, $number, array $labels)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string')
                ->test(4, 'array');
        
        $post = $labels; // clone labels
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_LABELS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Gets the list of labels for every issue in a milestone.
     * 
     * @param string $owner
     * @param string $repo
     * @param string $number
     * @return array
     */
    public function getIssueLabelMilestone($owner, $repo, $number)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'string');
        
        // search and replace
        $link = StringType::i($this->link['ISSUE_LABELS_MILESTONE'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->str_replace(':number', $number)
                ->get();
        
        return $this->getResponse($link);
    }
}

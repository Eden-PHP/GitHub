<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Search
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Search extends Base
{
    protected $link = array(
        'REPOSITORY' => 'search/repositories',
        'CODE' => 'search/code',
        'ISSUE' => 'search/issues',
        'USER' => 'search/users',
    );
    
    /**
     * Searches a repositories.
     * 
     * @param string|array $query
     * @param string|null  $sort  sort field. One of stars, forks, or updated. If not provided, results are sorted by best match
     * @param string       $order  Default: desc. Sort order if sort parameter is provided. One of asc or desc
     * @return array
     */
    public function searchRepository($query, $sort = null, $order = 'desc')
    {
        Argument::i()
                ->test(1, 'array', 'string')
                ->test(2, 'string', 'null')
                ->test(3, 'string');
        
        $post = array(
            'q' => $query,
            'order' => $order
        );
        
        // check and set
        if ($sort) {
            $post['sort'] = $sort;
        }
        
        // search and replace
        $link = StringType::i($this->link['REPOSITORY'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Searches a codes.
     * 
     * @param string|array $query
     * @param string|null  $sort  sort field. One of stars, forks, or updated. If not provided, results are sorted by best match
     * @param string       $order  Default: desc. Sort order if sort parameter is provided. One of asc or desc
     * @return array
     */
    public function searchCode($query, $sort = null, $order = 'desc')
    {
        Argument::i()
                ->test(1, 'array', 'string')
                ->test(2, 'string', 'null')
                ->test(3, 'string');
        
        $post = array(
            'q' => $query,
            'order' => $order
        );
        
        // check and set
        if ($sort) {
            $post['sort'] = $sort;
        }
        
        // search and replace
        $link = StringType::i($this->link['CODE'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Searches a codes.
     * 
     * @param string|array $query
     * @param string|null  $sort  sort field. One of stars, forks, or updated. If not provided, results are sorted by best match
     * @param string       $order  Default: desc. Sort order if sort parameter is provided. One of asc or desc
     * @return array
     */
    public function searchIssue($query, $sort = null, $order = 'desc')
    {
        Argument::i()
                ->test(1, 'array', 'string')
                ->test(2, 'string', 'null')
                ->test(3, 'string');
        
        $post = array(
            'q' => $query,
            'order' => $order
        );
        
        // check and set
        if ($sort) {
            $post['sort'] = $sort;
        }
        
        // search and replace
        $link = StringType::i($this->link['ISSUE'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Searches a users.
     * 
     * @param string|array $query
     * @param string|null  $sort  sort field. One of stars, forks, or updated. If not provided, results are sorted by best match
     * @param string       $order  Default: desc. Sort order if sort parameter is provided. One of asc or desc
     * @return array
     */
    public function searchUser($query, $sort = null, $order = 'desc')
    {
        Argument::i()
                ->test(1, 'array', 'string')
                ->test(2, 'string', 'null')
                ->test(3, 'string');
        
        $post = array(
            'q' => $query,
            'order' => $order
        );
        
        // check and set
        if ($sort) {
            $post['sort'] = $sort;
        }
        
        // search and replace
        $link = StringType::i($this->link['USER'])
                ->get();
        
        return $this->getResponse($link, $post);
    }
}

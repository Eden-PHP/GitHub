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
 * GitHub API - Repository: Statistic
 * 
 * @vendor Eden
 * @package GitHub\Repository
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Statistic extends Base
{
    protected $link = array(
        'CONTRIBUTORS' => 'repos/:owner/:repo/stats/contributors',
        'COMMIT_ACTIVITY' => 'repos/:owner/:repo/stats/commit_activity',
        'CODE_FREQUENCY' => 'repos/:owner/:repo/stats/code_frequency',
        'PARTICIPATION' => 'repos/:owner/:repo/stats/participation',
        'PUNCH_CARD' => 'repos/:owner/:repo/stats/punch_card',
    );
    
    /**
     * Lists the contributors.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getContributors($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['CONTRIBUTORS'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the last year of commit activity data.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getCommitActivity($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['COMMIT_ACTIVITY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the number of additions and deletions per week.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getCodeFrequency($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['CODE_FREQUENCY'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the weekly commit count for the repo owner and everyone else.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getParticipations($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['PARTICIPATION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Gets the number of commits per hour in each day.
     * 
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getPunchCards($owner, $repo)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string');
        
        // search and replace
        $link = StringType::i($this->link['PUNCH_CARD'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        
        return $this->getResponse($link);
    }
}

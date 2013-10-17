<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Eden\GitHub;

/**
 * GitHub API factory. This is a factory class with
 * methods that will load up different GitHub classes.
 *
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Factory extends Base
{
    const INSTANCE = 1; // set to singleton

    /**
     * Returns the instance of Auth.
     *
     * @param string $key          the application's key
     * @param string $secret       the application's secret
     * @param string $redirect     the application's redirect uri
     * @return \Eden\GitHub\Auth
     */
    public function auth($key, $secret, $redirect)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'string')
                ->test(3, 'url');

        return Auth::i($key, $secret, $redirect);
    }
    
    /**
     * Returns new instance of Activity.
     * 
     * @return \Eden\GitHub\Activity
     */
    public function activity()
    {
        return Activity::i();
    }
    
    /**
     * Returns new instance of Data.
     * 
     * @return \Eden\GitHub\Data
     */
    public function data()
    {
        return Data::i();
    }
    
    /**
     * Returns new instance of Gist.
     * 
     * @return \Eden\GitHub\Gist
     */
    public function gist()
    {
        return Gist::i();
    }
    
    /**
     * Returns new instance of Issue.
     * 
     * @return \Eden\GitHub\Issue
     */
    public function issue()
    {
        return Issue::i();
    }
    
    /**
     * Returns new instance of Misc.
     * 
     * @return \Eden\GitHub\Misc
     */
    public function misc()
    {
        return Misc::i();
    }
    
    /**
     * Returns new instance of Organization.
     * 
     * @return \Eden\GitHub\Misc
     */
    public function organization()
    {
        return Organization::i();
    }
    
    /**
     * Returns new instance of PullRequest.
     * 
     * @return \Eden\GitHub\PullRequest
     */
    public function pullRequest()
    {
        return PullRequest::i();
    }
    
    /**
     * Returns new instance of Repository.
     * 
     * @return \Eden\GitHub\Repository
     */
    public function repository()
    {
        return Repository::i();
    }
    
    /**
     * Returns new instance of User.
     * 
     * @return \Eden\GitHub\User
     */
    public function user()
    {
        return User::i();
    }
    
    /**
     * Returns new instance of Search.
     * 
     * @return \Eden\GitHub\Search
     */
    public function search()
    {
        return Search::i();
    }
}

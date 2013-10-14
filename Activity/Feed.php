<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Activity;

/**
 * GitHub API - Activity: Feed
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Feed extends Base
{
    protected $connection = 'feeds';
    protected $link = array(
        'USER_ORG_EVENTS' => 'users/:user/events/orgs/:org',
    );
    
    /**
     * Lists all the feeds available to the authenticating user in Atom format:
     * - Timeline:                  The GitHub global public timeline
     * - User:                      The public timeline for any user, using URI template
     * - Current user public:       The public timeline for the authenticated user
     * - Current user:              The private timeline for the authenticated user
     * - Current user actor:        The private timeline for activity created by the authenticated user
     * - Current user organization: The private timeline for the authenticated user for a given organization, using URI template
     * 
     * @return array
     */
    public function getFeed()
    {
        return $this->getResponse();
    }
}

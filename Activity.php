<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub;

use Eden\GitHub\Activity\Event;
use Eden\GitHub\Activity\Feed;
use Eden\GitHub\Activity\Notification;
use Eden\GitHub\Activity\Star;
use Eden\GitHub\Activity\Watch;

/**
 * GitHub API - Activity
 * 
 * @vendor Eden
 * @package GitHub
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Activity extends Base
{
    /**
     * Returns a new instance of Event.
     * 
     * @return \Eden\GitHub\Activity\Event
     */
    public function event()
    {
        return Event::i();
    }
    
    /**
     * Returns a new instance of Feed.
     * 
     * @return \Eden\GitHub\Activity\Feed
     */
    public function feed()
    {
        return Feed::i();
    }
    
    /**
     * Returns a new instance of Notification.
     * 
     * @return \Eden\GitHub\Activity\Notification
     */
    public function notification()
    {
        return Notification::i();
    }
    
    /**
     * Returns a new instance of Star.
     * 
     * @return \Eden\GitHub\Activity\Star
     */
    public function star()
    {
        return Star::i();
    }
    
    /**
     * Returns a new instance of Watch.
     * 
     * @return \Eden\GitHub\Activity\Watch
     */
    public function watch()
    {
        return Watch::i();
    }
}

<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Activity;

use Eden\GitHub\Argument;
use Eden\Type\StringType;

/**
 * GitHub API - Activity: Notification
 * Notifications of new comments are delivered to users.
 * The Notifications API lets you view these notifications, and mark them as read.
 * 
 * @vendor Eden
 * @package GitHub\Activity
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Notification extends Base
{
    protected $link = array(
        'NOTIFICATION' => 'notifications',
        'USER_NOTIFICATION' => 'repos/:owner/:repo/notifications',
        'SINGLE_THREAD' => 'notifications/threads/:id',
        'SUBSCRIPTION' => 'notifications/threads/:id/subscription'
    );
    
    /**
     * List all notifications for the current user, grouped by repository.
     * If owner is defined, list all notifications for the current user instead.
     * 
     * @param string|null $owner         (Optional) If repo is defined, owner must be defined also.
     * @param string|null $repo          (Optional) If owner is defined, repo must be defined also.
     * @param bool        $all           (Optional) Default: true. Show notifications marked as read.
     * @param bool        $participating (Optional) Default: true. Show only notifications in which
     *                                   the user is directly participating or mentioned.
     * @param string|null $since         (Optional) filters out any notifications updated before the given time.
     *                                   The time should be passed in as UTC in the <ISO 8601> format: YYYY-MM-DDTHH:MM:SSZ.
     * @return array
     */
    public function getNotifications(
            $owner = null, 
            $repo = null, 
            $all = true, 
            $participating = true, 
            $since = null
    ) {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string', 'null')
                ->test(3, 'bool')
                ->test(4, 'bool')
                ->test(5, 'string', 'null');
        
        $post = array(
            'all' => $all,
            'participating' => $participating
        );
        
        // if since is defined
        if ($since) {
            $post['since'] = $since;
        }
        
        // checks if owner and repo is defined
        if ($owner && $repo) {
            $link = StringType::i($this->link['USER_NOTIFICATION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        } else {
            $link = $this->link['NOTIFICATION'];
        }
        
        return $this->getResponse($link, $post);
    }
    
    /**
     * Marks a notification as “read” removes it from the default view on GitHub.com.
     * 
     * @param string|null $owner      (Optional) If repo is defined, owner must be defined also.
     * @param string|null $repo       (Optional) If owner is defined, repo must be defined also.
     * @param string|null $lastReadAt Default: Now. Describes the last point that notifications were checked.
     *                                Anything updated since this time will not be updated.
     *                                Expected in <ISO 8601> format: YYYY-MM-DDTHH:MM:SSZ
     * @return array
     */
    public function markAsRead($owner = null, $repo = null, $lastReadAt = null)
    {
        Argument::i()
                ->test(1, 'string', 'null')
                ->test(2, 'string', 'null')
                ->test(3, 'string', 'null');
        
        $post = array();
        
        // if lastReadAt is defined
        if ($lastReadAt) {
            $post['last_read_at'] = $lastReadAt;
        }
        
        // checks if owner and repo is defined
        if ($owner && $repo) {
            $link = StringType::i($this->link['USER_NOTIFICATION'])
                ->str_replace(':owner', $owner)
                ->str_replace(':repo', $repo)
                ->get();
        } else {
            $link = $this->link['NOTIFICATION'];
        }
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Marks the thread as read.
     * 
     * @param string $id
     * @return array
     */
    public function markThreadAsRead($id)
    {
        Argument::i()->test(1, 'string');
        
        $link = StringType::i($this->link['SINGLE_THREAD'])
                ->str_replace(':id', $id)
                ->get();
        
        return $this->patchResponse($link);
    }
    
    /**
     * This checks to see if the current user is subscribed to a thread.
     * You can also get a Repository subscription.
     * 
     * @param string $id id of the thread
     * @return array
     */
    public function getThreadSubscription($id)
    {
        Argument::i()->test(1, 'string');
        
        $link = StringType::i($this->link['SUBSCRIPTION'])
                ->str_replace(':id', $id)
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * This lets you subscribe to a thread, or ignore it.
     * Subscribing to a thread is unnecessary if the user is already subscribed to the repository.
     * Ignoring a thread will mute all future notifications (until you comment or get @mentioned).
     * 
     * @param string $id
     * @param bool   $subscribed determines if notifications should be received from this thread
     * @param bool   $ignored    determines if all notifications should be blocked from this thread
     * @return array
     */
    public function setThreadSubscription($id, $subscribed, $ignored)
    {
        Argument::i()
                ->test(1, 'string')
                ->test(2, 'bool')
                ->test(3, 'bool');
        
        $post = array(
            'subscribed' => $subscribed,
            'ignored' => $ignored
        );
        
        $link = StringType::i($this->link['SUBSCRIPTION'])
                ->str_replace(':id', $id)
                ->get();
        
        return $this->putResponse($link, $post);
    }
    
    /**
     * Deletes the subscription from the thread.
     * 
     * @param string $id
     * @return array
     */
    public function deleteThreadSubscription($id)
    {
        Argument::i()->test(1, 'string');
        
        $link = StringType::i($this->link['SUBSCRIPTION'])
                ->str_replace(':id', $id)
                ->get();
        
        return $this->deleteResponse($link);
    }
}

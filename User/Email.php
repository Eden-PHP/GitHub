<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\User;

use Eden\Type\StringType;

/**
 * GitHub API - User: Email
 * 
 * @vendor Eden
 * @package GitHub\User
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Email extends Base
{
    protected $link = array(
        'EMAIL' => 'user/emails'
    );
    
    /**
     * Searches a codes.
     * 
     * @return array
     */
    public function getEmails()
    {
        // search and replace
        $link = StringType::i($this->link['EMAIL'])
                ->get();
        
        return $this->getResponse($link);
    }
    
    /**
     * Adds emails.
     * 
     * @param array $emails
     * @return array
     */
    public function addEmails(array $emails)
    {
        $post = $emails;
        
        // search and replace
        $link = StringType::i($this->link['EMAIL'])
                ->get();
        
        return $this->postResponse($link, $post);
    }
    
    /**
     * Deletes emails.
     * 
     * @param array $emails
     * @return array
     */
    public function deleteEmails(array $emails)
    {
        $post = $emails;
        
        // search and replace
        $link = StringType::i($this->link['EMAIL'])
                ->get();
        
        return $this->deleteResponse($link, $post);
    }
}

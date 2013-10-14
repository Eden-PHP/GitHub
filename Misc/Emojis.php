<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Data;

use Eden\Type\StringType;

/**
 * GitHub API - Miscellaneous: Emojis
 * 
 * @vendor Eden
 * @package GitHub\Misc
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Emojis extends Base
{
    protected $link = array(
        'EMOJIS' => 'emojis'
    );
    
    /**
     * Lists all the emojis available to use on GitHub.
     * 
     * @return array
     */
    public function getMilestones()
    {
        // search and replace
        $link = StringType::i($this->link['EMOJIS'])
                ->get();
        
        return $this->getResponse($link);
    }
}

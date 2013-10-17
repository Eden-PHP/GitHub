<?php //-->
/*
 * This file is part of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\GitHub\Misc;

use Eden\Type\StringType;

/**
 * GitHub API - Miscellaneous: Meta
 * The Meta API gives some information about GitHub.com, the service.
 * 
 * @vendor Eden
 * @package GitHub\Misc
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Meta extends Base
{
    protected $link = array(
        'META' => 'meta'
    );
    
    /**
     * Gets the meta data.
     * 
     * @return array
     */
    public function getMeta()
    {
        // search and replace
        $link = StringType::i($this->link['META'])
                ->get();
        
        return $this->getResponse($link);
    }
}

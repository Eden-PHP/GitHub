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
 * GitHub API - Miscellaneous: Gitignore
 * The Gitignore API gives you access to the available gitignore templates.
 * 
 * @vendor Eden
 * @package GitHub\Misc
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Gitignore extends Base
{
    protected $link = array(
        'TEMPLATE' => 'gitignore/templates'
    );
    
    /**
     * Lists all templates available to pass as an option when creating a repository.
     * If template is defined, return the single template instead.
     * 
     * @param string|null $template
     * @return array
     */
    public function getTemplates($template = null)
    {
        // search and replace
        $link = StringType::i($this->link['TEMPLATE'])
                ->get();
        
        if ($template) {
            $link .= '/' . $template;
        }
        
        return $this->getResponse($link);
    }
}

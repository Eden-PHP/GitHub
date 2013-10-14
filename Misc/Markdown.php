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
 * GitHub API - Miscellaneous: Markdown
 * 
 * @vendor Eden
 * @package GitHub\Misc
 * @author Ian Mark Muninio <ianmuninio@openovate.com>
 */
class Markdown extends Base
{
    protected $link = array(
        'MARKDOWN' => 'markdown'
    );
    
    /**
     * Renders a markdown document in raw mode or non-raw mode.
     * 
     * @param string      $raw      (Optional) Default: false. In raw mode. If true, disregard $mode and $context argument.
     * @param string      $text     the markdown text to render
     * @param string|null $mode     (Optional) markdown - to render a document as plain Markdown, just like README files are rendered.
     *                              gfm - to render a document as user-content, e.g. like user comments or issues are rendered. 
     *                              In GFM mode, hard line breaks are always taken into account, and issue and user mentions are linked accordingly.
     * @param string|null $context (Optional) the repository context, only taken into account when rendering as gfm
     * @return array
     */
    public function renderMarkdown($raw = false, $text, $mode = null, $context = null)
    {
        Argument::i()
                ->test(1, 'bool')
                ->test(2, 'string')
                ->test(3, 'string', 'null')
                ->test(4, 'string', 'null');
        
        $post = array();
        
        // search and replace
        $link = StringType::i($this->link['MARKDOWN'])
                ->get();
        
        $post['text'] = $text;
        
        // checks if raw is true
        if ($raw) {
            $link .= '/raw';
        } else {
            if ($mode) {
                $post['mode'] = $mode;
            }
            
            if ($context) {
                $post['context'] = $context;
            }
        }
        
        return $this->postResponse($link, $post);
    }
}

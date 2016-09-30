<?php
/**
 * DokuWiki Plugin mailtoall (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Matthias Grutzeck <mailtoall@acc.grutzeck.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_mailtoall extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'substition';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'normal';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 300;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\[MailToAll\]',$mode,'plugin_mailtoall');
    }

    /**
     * Handle matches of the mailtoall syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler &$handler){
        $data = array();
        return $data;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer &$renderer, $data) {
        if($mode != 'xhtml') return false;
       
        global $conf;
        //simple setup
        $link           = array();
        $link['target'] = '';
        $link['pre']    = '';
        $link['suf']    = '';
        $link['style']  = '';
        $link['more']   = '';

        // $name = $renderer->_getLinkTitle($name, '', $isImage);
        //if(!$isImage) {
            $link['class'] = 'mail';
        //} else {
        //    $link['class'] = 'media';
        //}


        $title   = "Mail to all mail addresses on page";

        // if(empty($name)) {
        //    $name = $title;
        // }
        
        $addresses = implode(',', $data['addresses']);
        $addresses = $renderer->_xmlEntities($addresses);
        $addresses = 'BCC=' . obfuscate($addresses);
        if($conf['mailguard'] == 'visible') $addresses = rawurlencode($addresses);

        $link['url']   = 'mailto:?'.$addresses;
        $link['name']  = $title;
        $link['title'] = $title;

        //output formatted
         $renderer->doc .= $renderer->_formatLink($link);
        return true;
    }
}

// vim:ts=4:sw=4:et:

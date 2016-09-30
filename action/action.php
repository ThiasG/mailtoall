<?php
/**
 * DokuWiki Plugin test (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  test <test@acc.grutzeck.net>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_mailtoall_action extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {
       $controller->register_hook('PARSER_HANDLER_DONE', 'BEFORE', $this, 'handle_parser_handler_done');
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_parser_handler_done(Doku_Event &$event, $param) {
        $emails = array();
        $mailtocall = null;
        foreach ($event->data->calls as &$call) {
                if ($call[0] == 'emaillink') {
                    array_push($emails, $call[1][0]);
                } elseif ($call[0] == 'plugin' &&  $call[1][0] == 'mailtoall' ) {
                    $mailtocall = & $call[1];
                }
        }
        unset($call);
        if ($mailtocall != null) {
           $mailtocall[1]['addresses'] = $emails;
           unset($mailtocall);
        }
    }

}

// vim:ts=4:sw=4:et:

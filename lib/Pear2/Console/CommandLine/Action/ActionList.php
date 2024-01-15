<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This file is part of the Pear2\Console\CommandLine package.
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT license that is available
 * through the world-wide-web at the following URI:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category  Console
 *
 * @author    David JEAN LOUIS <izimobil@gmail.com>
 * @copyright 2007-2009 David JEAN LOUIS
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 *
 * @version   CVS: $Id: List.php,v 1.2 2009/02/27 08:03:17 izi Exp $
 *
 * @link      http://pear2.php.net/Pear2_Console_CommandLine
 * @since     File available since release 0.1.0
 *
 * @filesource
 */

namespace Pear2\Console\CommandLine\Action;

use Pear2\Console\CommandLine\Action;

/**
 * Class that represent the List action, a special action that simply output an
 * array as a list.
 *
 * @category  Console
 *
 * @author    David JEAN LOUIS <izimobil@gmail.com>
 * @copyright 2007-2009 David JEAN LOUIS
 * @license   http://opensource.org/licenses/mit-license.php MIT License
 *
 * @link      http://pear2.php.net/Pear2_Console_CommandLine
 * @since     Class available since release 0.1.0
 */
class ActionList extends Action
{
    // execute() {{{

    /**
     * Executes the action with the value entered by the user.
     * Possible parameters are:
     * - message: an alternative message to display instead of the default
     *   message,
     * - delimiter: an alternative delimiter instead of the comma,
     * - post: a string to append after the message (default is the new line
     *   char).
     *
     * @param  mixed  $value  The option value
     * @param  array  $params An optional array of parameters
     * @return string
     */
    public function execute($value = false, $params = [])
    {
        $list = isset($params['list']) ? $params['list'] : [];
        $msg = isset($params['message'])
            ? $params['message']
            : $this->parser->message_provider->get('LIST_DISPLAYED_MESSAGE');
        $del = isset($params['delimiter']) ? $params['delimiter'] : ', ';
        $post = isset($params['post']) ? $params['post'] : "\n";
        $this->parser->outputter->stdout($msg.implode($del, $list).$post);
        exit(0);
    }
    // }}}
}

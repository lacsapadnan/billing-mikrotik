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
 * @version   0.2.3
 *
 * @link      http://pear2.php.net/Pear2_Console_CommandLine
 * @since     File available since release 0.1.0
 *
 * @filesource
 */

namespace Pear2\Console\CommandLine\Action;

use Pear2\Console\CommandLine;

/**
 * Class that represent the Version action, a special action that displays the
 * version string of the program.
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
class Version extends CommandLine\Action
{
    // execute() {{{

    /**
     * Executes the action with the value entered by the user.
     *
     * @param  mixed  $value  The option value
     * @param  array  $params An array of optional parameters
     * @return string
     */
    public function execute($value = false, $params = [])
    {
        return $this->parser->displayVersion();
    }
    // }}}
}

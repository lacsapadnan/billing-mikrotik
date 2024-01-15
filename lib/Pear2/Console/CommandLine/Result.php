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

namespace Pear2\Console\CommandLine;

/**
 * A lightweight class to store the result of the command line parsing.
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
class Result
{
    // Public properties {{{

    /**
     * The result options associative array.
     * Key is the name of the option and value its value.
     *
     * @var array Result options array
     */
    public $options = [];

    /**
     * The result arguments array.
     *
     * @var array Result arguments array
     */
    public $args = [];

    /**
     * Name of the command invoked by the user, false if no command invoked.
     *
     * @var string Result command name
     */
    public $command_name = false;

    /**
     * A result instance for the subcommand.
     *
     * @var static Result instance for the subcommand
     */
    public $command = false;

    // }}}
}

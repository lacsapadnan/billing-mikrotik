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
 * Renderers common interface, all renderers must implement this interface.
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
interface Renderer
{
    // usage() {{{

    /**
     * Returns the full usage message.
     *
     * @return string The usage message
     */
    public function usage();

    // }}}
    // error() {{{

    /**
     * Returns a formatted error message.
     *
     * @param  string  $error The error message to format
     * @return string The error string
     */
    public function error($error);

    // }}}
    // version() {{{

    /**
     * Returns the program version string.
     *
     * @return string The version string
     */
    public function version();

    // }}}
}

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

use Exception as E;

/**
 * Class for exceptions raised by the Pear2\Console\CommandLine package.
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
class Exception extends E
{
    // Codes constants {{{

    /**#@+
     * Exception code constants.
     */
    const OPTION_VALUE_REQUIRED = 1;

    const OPTION_VALUE_UNEXPECTED = 2;

    const OPTION_VALUE_TYPE_ERROR = 3;

    const OPTION_UNKNOWN = 4;

    const ARGUMENT_REQUIRED = 5;

    const INVALID_SUBCOMMAND = 6;
    /**#@-*/

    // }}}
    // factory() {{{

    /**
     * Convenience method that builds the exception with the array of params by
     * calling the message provider class.
     *
     * @param  string  $code     The string identifier of the
     *                                            exception.
     * @param  array  $params   Array of template vars/values
     * @param  Pear2\Console\CommandLine  $parser   An instance of the parser
     * @param  array  $messages An optional array of messages
     *                                            passed to the message provider.
     * @return Pear2\Console\CommandLine\Exception The exception instance
     */
    public static function factory(
        $code, $params, $parser, array $messages = []
    ) {
        $provider = $parser->message_provider;
        if ($provider instanceof CommandLine\CustomMessageProvider) {
            $msg = $provider->getWithCustomMessages(
                $code,
                $params,
                $messages
            );
        } else {
            $msg = $provider->get($code, $params);
        }
        $const = '\Pear2\Console\CommandLine\Exception::'.$code;
        $code = defined($const) ? constant($const) : 0;

        return new static($msg, $code);
    }

    // }}}
}

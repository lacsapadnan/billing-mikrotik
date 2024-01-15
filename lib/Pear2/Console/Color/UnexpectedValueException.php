<?php

/**
 * Exception class for Pear2_Console_Color.
 *
 * PHP version 5.3
 *
 * @category Console
 *
 * @author   Vasil Rangelov <boen.robot@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 *
 * @version  1.0.0
 *
 * @link     http://pear2.php.net/Pear2_Console_Color
 */

namespace Pear2\Console\Color;

use UnexpectedValueException as U;

/**
 * Exception class for Pear2_Console_Color.
 *
 * @category  Console
 *
 * @author    Vasil Rangelov <boen.robot@gmail.com>
 * @copyright 2011 Ivo Nascimento
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 *
 * @link      http://pear2.php.net/Pear2_Console_Color
 */
class UnexpectedValueException extends U implements Exception
{
    /**
     * Used when an unexpected font value is supplied.
     */
    const CODE_FONT = 1;

    /**
     * Used when an unexpected background value is supplied.
     */
    const CODE_BACKGROUND = 2;
}

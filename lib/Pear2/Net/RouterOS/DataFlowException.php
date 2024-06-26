<?php

/**
 * RouterOS API client implementation.

 *
 * RouterOS is the flag product of the company MikroTik and is a powerful router software. One of its many abilities is to allow control over it via an API. This package provides a client for that API, in turn allowing you to use PHP to control RouterOS hosts.
 *
 * PHP version 5
 *
 * @category  Net
 *
 * @author    Vasil Rangelov <boen.robot@gmail.com>
 * @copyright 2011 Vasil Rangelov
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 *
 * @version   1.0.0b6
 *
 * @link      http://pear2.php.net/Pear2_Net_RouterOS
 */
/**
 * The namespace declaration.
 */

namespace Pear2\Net\RouterOS;

/**
 * Base of this class.
 */
use RuntimeException;

/**
 * Exception thrown when the request/response cycle goes an unexpected way.
 *
 * @category Net
 *
 * @author   Vasil Rangelov <boen.robot@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 *
 * @link     http://pear2.php.net/Pear2_Net_RouterOS
 */
class DataFlowException extends RuntimeException implements Exception
{
    const CODE_INVALID_CREDENTIALS = 10000;

    const CODE_TAG_REQUIRED = 10500;

    const CODE_TAG_UNIQUE = 10501;

    const CODE_UNKNOWN_REQUEST = 10900;

    const CODE_CANCEL_FAIL = 11200;
}

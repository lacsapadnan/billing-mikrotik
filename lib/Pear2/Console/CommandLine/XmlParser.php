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

use DOMDocument;
use DOMNode;
use Pear2\Console\CommandLine;
use Phar;

/**
 * Parser for command line xml definitions.
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
class XmlParser
{
    // parse() {{{

    /**
     * Parses the given xml definition file and returns a
     * Pear2\Console\CommandLine instance constructed with the xml data.
     *
     * @param  string  $xmlfile The xml file to parse
     * @return Pear2\Console\CommandLine A parser instance
     */
    public static function parse($xmlfile)
    {
        if (! is_readable($xmlfile)) {
            CommandLine::triggerError(
                'invalid_xml_file',
                E_USER_ERROR,
                ['{$file}' => $xmlfile]
            );
        }
        $doc = new DOMDocument();
        $doc->load($xmlfile);
        self::validate($doc);
        $nodes = $doc->getElementsByTagName('command');
        $root = $nodes->item(0);

        return self::_parseCommandNode($root, true);
    }

    // }}}
    // parseString() {{{

    /**
     * Parses the given xml definition string and returns a
     * Pear2\Console\CommandLine instance constructed with the xml data.
     *
     * @param  string  $xmlstr The xml string to parse
     * @return Pear2\Console\CommandLine A parser instance
     */
    public static function parseString($xmlstr)
    {
        $doc = new DOMDocument();
        $doc->loadXml($xmlstr);
        self::validate($doc);
        $nodes = $doc->getElementsByTagName('command');
        $root = $nodes->item(0);

        return self::_parseCommandNode($root, true);
    }

    // }}}
    // validate() {{{

    /**
     * Validates the xml definition using Relax NG.
     *
     * @param  DOMDocument  $doc The document to validate
     * @return bool Whether the xml data is valid or not.
     *
     * @throws Pear2\Console\CommandLine\Exception
     *
     * @todo use exceptions only
     */
    public static function validate(DOMDocument $doc)
    {
        $paths = [];
        if (! class_exists('Phar', false) || ! Phar::running()) {
            // Pyrus
            $paths[]
                = 'D:\Vasko\WEB\PHP\_shared\Pear2\data/pear2.php.net/Pear2_Console_CommandLine/xmlschema.rng';
            // PEAR
            $pearDataDirEnv = getenv('PHP_PEAR_DATA_DIR');
            if ($pearDataDirEnv) {
                $paths[] = $pearDataDirEnv.
                    '/Pear2_Console_CommandLine/xmlschema.rng';
            }
            $paths[] = 'D:\Vasko\WEB\PHP\_shared\Pear2\data/Pear2_Console_CommandLine/xmlschema.rng';
        }
        $pkgData = __DIR__.'/../../../../data/';
        // PHAR dep
        $paths[] = $pkgData.
            'pear2.php.net/Pear2_Console_CommandLine/xmlschema.rng';
        $paths[] = $pkgData.'Pear2_Console_CommandLine/xmlschema.rng';
        $paths[] = $pkgData.'pear2/console_commandline/xmlschema.rng';
        // Git/Composer
        $paths[] = $pkgData.'xmlschema.rng';
        $paths[] = 'xmlschema.rng';

        foreach ($paths as $path) {
            if (is_readable($path)) {
                return $doc->relaxNGValidate($path);
            }
        }
        CommandLine::triggerError(
            'invalid_xml_file',
            E_USER_ERROR,
            ['{$file}' => $path]
        );
    }

    // }}}
    // _parseCommandNode() {{{

    /**
     * Parses the root command node or a command node and returns the
     * constructed Pear2\Console\CommandLine or Pear2\Console\CommandLine_Command
     * instance.
     *
     * @param  DOMNode  $node       The node to parse
     * @param  bool  $isRootNode Whether it is a root node or not
     * @return CommandLine|CommandLine\Command An instance of CommandLine for
     *     root node, CommandLine\Command otherwise.
     */
    private static function _parseCommandNode(DOMNode $node, $isRootNode = false)
    {
        if ($isRootNode) {
            $obj = new CommandLine();
        } else {
            $obj = new CommandLine\Command();
        }
        foreach ($node->childNodes as $cNode) {
            $cNodeName = $cNode->nodeName;
            switch ($cNodeName) {
                case 'name':
                case 'description':
                case 'version':
                    $obj->$cNodeName = trim($cNode->nodeValue);
                    break;
                case 'add_help_option':
                case 'add_version_option':
                case 'force_posix':
                    $obj->$cNodeName = self::_bool(trim($cNode->nodeValue));
                    break;
                case 'option':
                    $obj->addOption(self::_parseOptionNode($cNode));
                    break;
                case 'argument':
                    $obj->addArgument(self::_parseArgumentNode($cNode));
                    break;
                case 'command':
                    $obj->addCommand(self::_parseCommandNode($cNode));
                    break;
                case 'aliases':
                    if (! $isRootNode) {
                        foreach ($cNode->childNodes as $subChildNode) {
                            if ($subChildNode->nodeName == 'alias') {
                                $obj->aliases[] = trim($subChildNode->nodeValue);
                            }
                        }
                    }
                    break;
                case 'messages':
                    $obj->messages = self::_messages($cNode);
                    break;
                default:
                    break;
            }
        }

        return $obj;
    }

    // }}}
    // _parseOptionNode() {{{

    /**
     * Parses an option node and returns the constructed
     * Pear2\Console\CommandLine_Option instance.
     *
     * @param  DOMNode  $node The node to parse
     * @return Pear2\Console\CommandLine\Option The built option
     */
    private static function _parseOptionNode(DOMNode $node)
    {
        $obj = new CommandLine\Option($node->getAttribute('name'));
        foreach ($node->childNodes as $cNode) {
            $cNodeName = $cNode->nodeName;
            switch ($cNodeName) {
                case 'choices':
                    foreach ($cNode->childNodes as $subChildNode) {
                        if ($subChildNode->nodeName == 'choice') {
                            $obj->choices[] = trim($subChildNode->nodeValue);
                        }
                    }
                    break;
                case 'messages':
                    $obj->messages = self::_messages($cNode);
                    break;
                default:
                    if (property_exists($obj, $cNodeName)) {
                        $obj->$cNodeName = trim($cNode->nodeValue);
                    }
                    break;
            }
        }
        if ($obj->action == 'Password') {
            $obj->argument_optional = true;
        }

        return $obj;
    }

    // }}}
    // _parseArgumentNode() {{{

    /**
     * Parses an argument node and returns the constructed
     * Pear2\Console\CommandLine_Argument instance.
     *
     * @param  DOMNode  $node The node to parse
     * @return Pear2\Console\CommandLine\Argument The built argument
     */
    private static function _parseArgumentNode(DOMNode $node)
    {
        $obj = new CommandLine\Argument($node->getAttribute('name'));
        foreach ($node->childNodes as $cNode) {
            $cNodeName = $cNode->nodeName;
            switch ($cNodeName) {
                case 'description':
                case 'help_name':
                case 'default':
                    $obj->$cNodeName = trim($cNode->nodeValue);
                    break;
                case 'multiple':
                    $obj->multiple = self::_bool(trim($cNode->nodeValue));
                    break;
                case 'optional':
                    $obj->optional = self::_bool(trim($cNode->nodeValue));
                    break;
                case 'messages':
                    $obj->messages = self::_messages($cNode);
                    break;
                default:
                    break;
            }
        }

        return $obj;
    }

    // }}}
    // _bool() {{{

    /**
     * Returns a boolean according to true/false possible strings.
     *
     * @param  string  $str The string to process
     * @return bool
     */
    private static function _bool($str)
    {
        return in_array((string) $str, ['true', '1', 'on', 'yes']);
    }

    // }}}
    // _messages() {{{

    /**
     * Returns an array of custom messages for the element
     *
     * @param  DOMNode  $node The messages node to process
     * @return array an array of messages
     *
     * @see Pear2\Console\CommandLine::$messages
     * @see Pear2\Console\CommandLine_Element::$messages
     */
    private static function _messages(DOMNode $node)
    {
        $messages = [];

        foreach ($node->childNodes as $cNode) {
            if ($cNode->nodeType == XML_ELEMENT_NODE) {
                $name = $cNode->getAttribute('name');
                $value = trim($cNode->nodeValue);

                $messages[$name] = $value;
            }
        }

        return $messages;
    }

    // }}}
}

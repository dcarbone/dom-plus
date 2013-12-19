<?php namespace DCarbone\DOMPlus;

/**
 * This class was heavily inspired by Artem Russakovskii's SmartDOMDocument class
 *
 * @link http://beerpla.net/projects/smartdomdocument-a-smarter-php-domdocument-class/
 */

/**
 * Class DOMDocumentPlus
 * @package DCarbone\DOMPlus
 */
class DOMDocumentPlus extends \DOMDocument implements INodePlus
{
    /** @var array */
    protected $loadErrors = array();

    /**
     * Constructor
     */
    public function __construct($version = '1.0', $encoding = 'UTF-8')
    {
        parent::__construct($version, $encoding);

        $this->registerNodeClass('DOMNode', '\DCarbone\DOMPlus\DOMNodePlus');
        $this->registerNodeClass('DOMElement', '\DCarbone\DOMPlus\DOMElementPlus');
        $this->registerNodeClass('DOMCharacterData', '\DCarbone\DOMPlus\DOMCharacterDataPlus');
        $this->registerNodeClass('DOMText', '\DCarbone\DOMPlus\DOMTextPlus');

        libxml_use_internal_errors(true);
    }

    /**
     * Get the last errors thrown when loading HTML/XML
     *
     * @return array
     */
    public function getLastLoadErrors()
    {
        return $this->loadErrors;
    }

    /**
     * Load HTML with a proper encoding fix/hack.
     * Borrowed from the link below.
     *
     * @link http://www.php.net/manual/en/domdocument.loadhtml.php
     *
     * @param string $html
     * @param string $encoding
     * @return bool
     */
    public function loadHTML($html, $encoding = 'UTF-8')
    {
        libxml_clear_errors();

        $html = mb_convert_encoding($html, 'HTML-ENTITIES', $encoding);
        $return = parent::loadHTML($html);

        $this->loadErrors = libxml_get_errors();

        return $return;
    }

    /**
     * If we are using an older version PHP, the DOMDocument object does not support
     * the ability to export a specific Element's HTML.
     *
     * This little hack allows us to do just that.
     *
     * @param \DOMNode $node
     * @param bool $windowsLineEndings
     * @return string
     */
    public function saveHTML(\DOMNode $node = null, $windowsLineEndings = false)
    {
        $this->formatOutput = true;
        if (defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 50306)
        {
            if ($windowsLineEndings === true)
                return str_replace(array("\n", "\r\r\n"), "\r\n", parent::saveHTML($node));
            else
                return parent::saveHTML($node);
        }
        else if ($node !== null && (!defined('PHP_VERSION_ID') || (defined('PHP_VERSION_ID') && PHP_VERSION_ID < 50306)))
        {
            $newDom = new DOMDocumentPlus();
            $newDom->appendChild($newDom->importNode($node->cloneNode(true), true));

            if ($windowsLineEndings === true)
                return str_replace(array("\n", "\r\r\n"), "\r\n", $newDom->saveHTML());
            else
                return $newDom->saveHTML();
        }
        else
        {
            if ($windowsLineEndings === true)
                return str_replace(array("\n", "\r\r\n"), "\r\n", parent::saveHTML());
            else
                return parent::saveHTML();
        }
    }

    /**
     * Return HTML while stripping the annoying auto-added <html>, <body>, and doctype.
     *
     * @link http://php.net/manual/en/migration52.methods.php
     *
     * @param \DOMNode $node
     * @param bool $windowsLineEndings
     * @return string
     */
    public function saveHTMLExact(\DOMNode $node = null, $windowsLineEndings = false)
    {
        $this->formatOutput = true;

        if ($node !== null && defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 50306)
        {
            if ($windowsLineEndings === true)
                return str_replace(array("\n", "\r\r\n"), "\r\n", parent::saveHTML($node));
            else
                return parent::saveHTML($node);
        }
        else
        {
            return preg_replace(array("/^\<\!DOCTYPE.*?<body>/si",
                    "!</body>.*</html>$!si"),
                "",
                ($windowsLineEndings === true ? str_replace(array("\n", "\r\r\n"), "\r\n", $this->saveHTML($node)) : $this->saveHTML($node)));
        }
    }

    /**
     * @param array $seek
     * @param array $stop
     * @param null|string $nodeValueRegex
     * @return \DOMNode|null
     */
    public function getNextSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null)
    {
        return DOMStatic::getNextSiblingNode($this, $seek, $stop, $nodeValueRegex);
    }

    /**
     * @param array $seek
     * @param array $stop
     * @param null|string $nodeValueRegex
     * @return \DOMNode|null
     */
    public function getPreviousSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null)
    {
        return DOMStatic::getPreviousSiblingNode($this, $seek, $stop, $nodeValueRegex);
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null
     */
    public function appendTo(\DOMNode $node)
    {
        return DOMStatic::appendTo($this, $node);
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null
     */
    public function appendChild(\DOMNode $node)
    {
        if ($node->ownerDocument === $this)
            return parent::appendChild($node);

        return DOMStatic::appendTo($node, $this);
    }

    /**
     * @param \DOMNodeList $nodes
     * @return bool
     */
    public function appendChildren(\DOMNodeList $nodes)
    {
        return DOMStatic::appendChildrenTo($nodes, $this);
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneTo(\DOMNode $node)
    {
        return DOMStatic::appendTo($node, $this->cloneNode(true));
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChild(\DOMNode $node)
    {
        return DOMStatic::appendTo($node->cloneNode(true), $this);
    }

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChildren(\DOMNodeList $nodes)
    {
        return DOMStatic::cloneAndAppendChildrenTo($nodes, $this);
    }
}
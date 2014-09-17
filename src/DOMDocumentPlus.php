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
    /**
     * Constructor
     */
    public function __construct($version = '1.0', $encoding = 'UTF-8')
    {
        parent::__construct($version, $encoding);

        // @link http://www.php.net/manual/en/domdocument.registernodeclass.php
        $this->registerNodeClass('DOMNode',          '\DCarbone\DOMPlus\DOMNodePlus');
        $this->registerNodeClass('DOMElement',       '\DCarbone\DOMPlus\DOMElementPlus');
        $this->registerNodeClass('DOMCharacterData', '\DCarbone\DOMPlus\DOMCharacterDataPlus');
        $this->registerNodeClass('DOMText',          '\DCarbone\DOMPlus\DOMTextPlus');
    }

    /**
     * Utilizes http://php.net/manual/en/function.mb-convert-encoding.php prior to loading html
     *
     * @param string $html
     * @param string $targetEncoding
     * @param null|string $sourceEncoding
     * @return DOMDocumentPlus
     */
    public static function htmlDocumentFromStringWithConversion($html, $targetEncoding = 'UTF-8', $sourceEncoding = null)
    {
        /** @var DOMDocumentPlus $dom */
        $dom = new static;

        $dom->loadHTML(
            mb_convert_encoding($html, $targetEncoding, $sourceEncoding), 'UTF-8');

        return $dom;
    }

    /**
     * If we are using an older version PHP, the DOMDocument object does not support
     * the ability to export a specific Element's HTML.
     *
     * This little hack allows us to do just that.
     *
     * @param \DOMNode $node
     * @return string
     */
    public function saveHTML(\DOMNode $node = null)
    {
        $this->formatOutput = true;

        if (defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 50306)
            return parent::saveHTML($node);

        if ($node !== null && (!defined('PHP_VERSION_ID') || (defined('PHP_VERSION_ID') && PHP_VERSION_ID < 50306)))
        {
            /** @var self $newDom */
            $newDom = new static(); // Allow for extension
            $newDom->appendChild($newDom->importNode($node->cloneNode(true), true));

            return $newDom->saveHTML();
        }

        return parent::saveHTML();
    }

    /**
     * Return HTML while stripping the annoying auto-added <html>, <body>, and doctype.
     *
     * @link http://php.net/manual/en/migration52.methods.php
     *
     * @param \DOMNode $node
     * @return string
     */
    public function saveHTMLExact(\DOMNode $node = null)
    {
        $this->formatOutput = true;

        if ($node !== null && defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 50306)
            return parent::saveHTML($node);

        return preg_replace(array('/^\<\!DOCTYPE.*?<body>/si', '!</body>.*</html>$!si'), '', $this->saveHTML($node));
    }

    /**
     * @param string $name
     * @param string $value
     * @return DOMElementPlus
     */
    public function createElement($name, $value = null)
    {
        return parent::createElement($name, $value);
    }

    /**
     * @param string $namespaceURI
     * @param string $qualifiedName
     * @param string $value
     * @return DOMElementPlus
     */
    public function createElementNS($namespaceURI, $qualifiedName, $value = null)
    {
        return parent::createElementNS($namespaceURI, $qualifiedName, $value);
    }

    /**
     * @param string $content
     * @return DOMTextPlus
     */
    public function createTextNode($content)
    {
        return parent::createTextNode($content);
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
     * @param \DOMNode $destinationNode
     * @return \DOMNode|null
     */
    public function appendTo(\DOMNode $destinationNode)
    {
        return DOMStatic::appendTo($this, $destinationNode);
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
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function cloneAndAppendTo(\DOMNode $destinationNode)
    {
        return DOMStatic::appendTo($destinationNode, $this->cloneNode(true));
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

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function prependTo(\DOMNode $destinationNode)
    {
        return DOMStatic::prependTo($this, $destinationNode);
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function prependChild(\DOMNode $node)
    {
        return DOMStatic::prependTo($node, $this);
    }

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function prependChildren(\DOMNodeList $nodes)
    {
        return DOMStatic::prependChildrenTo($nodes, $this);
    }

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function cloneAndPrependTo(\DOMNode $destinationNode)
    {
        return DOMStatic::prependTo($this->cloneNode(true), $destinationNode);
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneAndPrependChild(\DOMNode $node)
    {
        return DOMStatic::prependTo($node->cloneNode(true), $this);
    }

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function cloneAndPrependChildren(\DOMNodeList $nodes)
    {
        return DOMStatic::cloneAndPrependChildrenTo($nodes, $this);
    }

    /**
     * @return \DOMNode|void
     * @throws \BadMethodCallException
     */
    public function remove()
    {
        throw new \BadMethodCallException('Cannot remove DOMDocument object from itself');
    }
}
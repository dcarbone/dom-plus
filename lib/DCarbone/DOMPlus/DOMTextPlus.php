<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMTextPlus
 * @package DCarbone\DOMPlus
 */
class DOMTextPlus extends \DOMText implements INodePlus
{
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
     * @throws \BadMethodCallException
     * @return \DOMNode|null
     */
    public function appendChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMText');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return bool
     */
    public function appendChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMText');
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
     * @throws \BadMethodCallException
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMText');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMText');
    }
}
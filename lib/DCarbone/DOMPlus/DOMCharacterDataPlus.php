<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMCharacterDataPlus
 * @package DCarbone\DOMPlus
 */
class DOMCharacterDataPlus extends \DOMCharacterData implements INodePlus
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
     * @param \DOMNode $destinationNode
     * @return \DOMNode|null
     */
    public function appendTo(\DOMNode $destinationNode)
    {
        return DOMStatic::appendTo($this, $destinationNode);
    }

    /**
     * @param \DOMNode $node
     * @throws \BadMethodCallException
     * @return \DOMNode|null
     */
    public function appendChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMCharacterData');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return bool
     */
    public function appendChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMCharacterData');
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
     * @throws \BadMethodCallException
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMCharacterData');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return \DOMNode|null|bool
     */
    public function cloneAndAppendChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot append a child to a node of type DOMCharacterData');
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
     * @throws \BadMethodCallException
     * @return \DOMNode
     */
    public function prependChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot prepend a child to a node of type DOMCharacterData');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return \DOMNode
     */
    public function prependChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot prepend a child to a node of type DOMCharacterData');
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
     * @throws \BadMethodCallException
     * @return \DOMNode
     */
    public function cloneAndPrependChild(\DOMNode $node)
    {
        throw new \BadMethodCallException('Cannot prepend a child to a node of type DOMCharacterData');
    }

    /**
     * @param \DOMNodeList $nodes
     * @throws \BadMethodCallException
     * @return \DOMNode
     */
    public function cloneAndPrependChildren(\DOMNodeList $nodes)
    {
        throw new \BadMethodCallException('Cannot prepend a child to a node of type DOMCharacterData');
    }

    /**
     * @return \DOMNode|null
     */
    public function remove()
    {
        return DOMStatic::removeNode($this);
    }
}
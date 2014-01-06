<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMNodePlus
 * @package DCarbone\DOMPlus
 */
class DOMNodePlus extends \DOMNode implements INodePlus
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
     * @return \DOMNode|null
     */
    public function appendChild(\DOMNode $node)
    {
        if ($node->ownerDocument === $this->ownerDocument)
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
     * @return \DOMNode|null
     */
    public function remove()
    {
        return DOMStatic::removeNode($this);
    }
}
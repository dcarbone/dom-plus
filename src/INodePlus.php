<?php namespace DCarbone\DOMPlus;

/**
 * Interface INodePlus
 * @package DCarbone\DOMPlus
 */
interface INodePlus
{
    /**
     * @param array $seek
     * @param array $stop
     * @param null|string $nodeValueRegex
     * @return \DOMNode
     */
    public function getNextSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null);

    /**
     * @param array $seek
     * @param array $stop
     * @param null|string $nodeValueRegex
     * @return \DOMNode
     */
    public function getPreviousSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null);

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function appendTo(\DOMNode $destinationNode);

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function prependTo(\DOMNode $destinationNode);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function appendChild(\DOMNode $node);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function prependChild(\DOMNode $node);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function appendChildren(\DOMNodeList $nodes);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function prependChildren(\DOMNodeList $nodes);

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function cloneAndAppendTo(\DOMNode $destinationNode);

    /**
     * @param \DOMNode $destinationNode
     * @return \DOMNode
     */
    public function cloneAndPrependTo(\DOMNode $destinationNode);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneAndAppendChild(\DOMNode $node);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneAndPrependChild(\DOMNode $node);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function cloneAndAppendChildren(\DOMNodeList $nodes);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function cloneAndPrependChildren(\DOMNodeList $nodes);

    /**
     * @return \DOMNode
     */
    public function remove();
}
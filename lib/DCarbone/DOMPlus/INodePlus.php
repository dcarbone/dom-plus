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
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function appendTo(\DOMNode $node);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function appendChild(\DOMNode $node);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function appendChildren(\DOMNodeList $nodes);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneTo(\DOMNode $node);

    /**
     * @param \DOMNode $node
     * @return \DOMNode
     */
    public function cloneAndAppendChild(\DOMNode $node);

    /**
     * @param \DOMNodeList $nodes
     * @return \DOMNode
     */
    public function cloneAndAppendChildren(\DOMNodeList $nodes);
}
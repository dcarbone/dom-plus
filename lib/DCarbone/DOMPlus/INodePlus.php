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
     * @return \DOMNode|null
     */
    public function getNextSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null);

    /**
     * @param array $seek
     * @param array $stop
     * @param null|string $nodeValueRegex
     * @return \DOMNode|null
     */
    public function getPreviousSiblingNode(array $seek, array $stop = array(), $nodeValueRegex = null);

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null
     */
    public function appendTo(\DOMNode $node);

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null
     */
    public function appendChild(\DOMNode $node);

    /**
     * @param \DOMNodeList $nodes
     * @return bool
     */
    public function appendChildren(\DOMNodeList $nodes);
}
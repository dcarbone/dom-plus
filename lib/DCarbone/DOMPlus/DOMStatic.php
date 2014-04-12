<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMStatic
 * @package DCarbone\DOMPlus
 */
abstract class DOMStatic
{
    /**
     * @param \DOMNode $scope
     * @param array $seek
     * @param array $stop
     * @param null $nodeValueRegex
     * @return \DOMNode|null
     */
    public static function getNextSiblingNode(\DOMNode $scope, array $seek, array $stop = array(), $nodeValueRegex = null)
    {
        $element = $scope->nextSibling;
        while ($element !== null)
        {
            if (in_array($element->nodeName, $stop))
                return null;

            if (in_array($element->nodeName, $seek))
            {
                if ($nodeValueRegex !== null && preg_match($nodeValueRegex, $element->nodeValue))
                    return $element;
                else if ($nodeValueRegex === null)
                    return $element;
            }

            $element = $element->nextSibling;
        }

        return null;
    }

    /**
     * @param \DOMNode $scope
     * @param array $seek
     * @param array $stop
     * @param null $nodeValueRegex
     * @return \DOMNode|null
     */
    public static function getPreviousSiblingNode(\DOMNode $scope, array $seek, array $stop = array(), $nodeValueRegex = null)
    {
        $element = $scope->previousSibling;
        while ($element !== null)
        {
            if (in_array($element->nodeName, $stop))
                return null;

            if (in_array($element->nodeName, $seek))
            {
                if ($nodeValueRegex !== null && preg_match($nodeValueRegex, $element->nodeValue))
                    return $element;
                else if ($nodeValueRegex === null)
                    return $element;
            }

            $element = $element->previousSibling;
        }

        return null;
    }

    /**
     * @param \DOMNode $sourceNode
     * @param \DOMNode $destinationNode
     * @return \DOMNode|null
     */
    public static function appendTo(\DOMNode $sourceNode, \DOMNode $destinationNode)
    {
        if ($destinationNode instanceof \DOMDocument)
        {
            if ($sourceNode->ownerDocument === $destinationNode)
                return $destinationNode->appendChild($sourceNode);

            $ret = $destinationNode->appendChild($destinationNode->importNode($sourceNode, true));
            if ($sourceNode->parentNode !== null)
                $sourceNode->parentNode->removeChild($sourceNode);

            return $ret;
        }

        if ($sourceNode->ownerDocument === $destinationNode->ownerDocument)
            return $destinationNode->appendChild($sourceNode);

        $ret = $destinationNode->appendChild($destinationNode->ownerDocument->importNode($sourceNode, true));
        if ($sourceNode->parentNode !== null)
            $sourceNode->parentNode->removeChild($sourceNode);

        return $ret;
    }

    /**
     * @param \DOMNode $sourceNode
     * @param \DOMNode $destinationNode
     * @return \DOMNode|null
     */
    public static function prependTo(\DOMNode $sourceNode, \DOMNode $destinationNode)
    {
        // If the destination does not have any child nodes
        if (!($destinationNode->childNodes instanceof \DOMNodeList) || $destinationNode->childNodes->length === 0)
            return static::appendTo($sourceNode, $destinationNode);

        if ($destinationNode->firstChild !== null)
        {
            if ($destinationNode instanceof \DOMDocument)
            {
                if ($sourceNode->ownerDocument === $destinationNode)
                    return $destinationNode->insertBefore($sourceNode, $destinationNode->firstChild);

                $ret = $destinationNode->insertBefore($destinationNode->importNode($sourceNode, true), $destinationNode->firstChild);
                if ($sourceNode->parentNode !== null)
                    $sourceNode->parentNode->removeChild($sourceNode);

                return $ret;
            }


            if ($sourceNode->ownerDocument === $destinationNode->ownerDocument)
                return $destinationNode->insertBefore($sourceNode, $destinationNode->firstChild);

            $ret = $destinationNode->insertBefore($destinationNode->ownerDocument->importNode($sourceNode, true), $destinationNode->firstChild);
            if ($sourceNode->parentNode !== null)
                $sourceNode->parentNode->removeChild($sourceNode);

            return $ret;
        }

        // If we make this far, something odd has happened.
        return null;
    }

    /**
     * @param \DOMNodeList $sourceNodeList
     * @param \DOMNode $destinationNode
     * @return \DOMNode|bool
     */
    public static function appendChildrenTo(\DOMNodeList $sourceNodeList, \DOMNode $destinationNode)
    {
        $initial = $sourceNodeList->length;
        for($i = 0, $loop = 1; $i < $sourceNodeList->length; $loop ++)
        {
            $ret = static::appendTo($sourceNodeList->item($i), $destinationNode);

            if (!($ret instanceof \DOMNode))
                return false;

            if ($loop > 1 && $sourceNodeList->length === $initial)
                $i++;
        }

        return $destinationNode;
    }

    /**
     * @param \DOMNodeList $sourceNodeList
     * @param \DOMNode $destinationNode
     * @return bool|\DOMNode
     */
    public static function prependChildrenTo(\DOMNodeList $sourceNodeList, \DOMNode $destinationNode)
    {
        $initial = $sourceNodeList->length;
        for($i = 0, $loop = 1; $i < $sourceNodeList->length; $loop ++)
        {
            $ret = static::prependTo($sourceNodeList->item($i), $destinationNode);

            if (!($ret instanceof \DOMNode))
                return false;

            if ($loop > 1 && $sourceNodeList->length === $initial)
                $i++;
        }

        return $destinationNode;
    }

    /**
     * @param \DOMNodeList $sourceNodeList
     * @param \DOMNode $destinationNode
     * @return bool|\DOMNode
     */
    public static function cloneAndAppendChildrenTo(\DOMNodeList $sourceNodeList, \DOMNode $destinationNode)
    {
        for($i = 0; $i < $sourceNodeList->length; $i++)
        {
            $ret = static::appendTo($sourceNodeList->item($i)->cloneNode(true), $destinationNode);

            if (!($ret instanceof \DOMNode))
                return false;
        }

        return $destinationNode;
    }

    /**
     * @param \DOMNodeList $sourceNodeList
     * @param \DOMNode $destinationNode
     * @return bool|\DOMNode
     */
    public static function cloneAndPrependChildrenTo(\DOMNodeList $sourceNodeList, \DOMNode $destinationNode)
    {
        for($i = 0; $i < $sourceNodeList->length; $i++)
        {
            $ret = static::prependTo($sourceNodeList->item($i)->cloneNode(true), $destinationNode);

            if (!($ret instanceof \DOMNode))
                return false;
        }

        return $destinationNode;
    }

    /**
     * @param \DOMNode $node
     * @return \DOMNode|null
     */
    public static function removeNode(\DOMNode $node)
    {
        if ($node->parentNode !== null)
            return $node->parentNode->removeChild($node);

        return null;
    }
}
<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMStatic
 * @package DCarbone\DOMPlus
 */
class DOMStatic
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
     * @param \DOMNode $source
     * @param \DOMNode $destination
     * @return \DOMNode|null
     */
    public static function appendTo(\DOMNode $source, \DOMNode $destination)
    {
        if ($destination instanceof \DOMDocument)
        {
            if ($source->ownerDocument === $destination)
                return $destination->appendChild($source);

            $ret = $destination->appendChild($destination->importNode($source, true));
            if ($source->parentNode !== null)
                $source->parentNode->removeChild($source);

            return $ret;
        }

        if ($source->ownerDocument === $destination->ownerDocument)
            return $destination->appendChild($source);

        $ret = $destination->appendChild($destination->ownerDocument->importNode($source, true));
        if ($source->parentNode !== null)
            $source->parentNode->removeChild($source);

        return $ret;
    }

    /**
     * @param \DOMNodeList $sourceList
     * @param \DOMNode $destination
     * @return \DOMNode|bool
     */
    public static function appendChildrenTo(\DOMNodeList $sourceList, \DOMNode $destination)
    {
        $initial = $sourceList->length;
        for($i = 0, $loop = 1; $i < $sourceList->length; $loop ++)
        {
            if ($loop > 1 && $sourceList->length === $initial)
                $i++;

            $ret = static::appendTo($sourceList->item($i), $destination);
            if (!($ret instanceof \DOMNode))
                return false;
        }

        return $destination;
    }

    /**
     * @param \DOMNodeList $sourceList
     * @param \DOMNode $destination
     * @return bool|\DOMNode
     */
    public static function cloneAndAppendChildrenTo(\DOMNodeList $sourceList, \DOMNode $destination)
    {
        $initial = $sourceList->length;
        for($i = 0, $loop = 1; $i < $sourceList->length; $loop ++)
        {
            if ($loop > 1 && $sourceList->length === $initial)
                $i++;

            $ret = static::appendTo($sourceList->item($i)->cloneNode(true), $destination);
            if (!($ret instanceof \DOMNode))
                return false;
        }

        return $destination;
    }
}
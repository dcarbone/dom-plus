<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMElementPlus
 * @package DCarbone\DOMPlus
 */
class DOMElementPlus extends \DOMElement implements INodePlus
{
    /** @var array */
    protected $_attributeArray = array();

    /** @var array */
    protected $_propertyArray = array();

    /** @var bool */
    protected $_attributesParsed = false;

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

    /**
     *
     *
     * General Attribute Methods
     *
     *
     */

    /**
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        $this->_parseAttributes();

        return parent::hasAttribute($name);
    }

    /**
     * Now typecasts value to string before calling parent setAttribute method
     *
     * @param string $name
     * @param string $value
     * @return \DOMAttr
     */
    public function setAttribute($name, $value)
    {
        $name = (string)$name;
        $value = (string)$value;

        $attr = new \DOMAttr($name, $value);
        parent::setAttributeNode($attr);

        $this->_updateAttributeArray($attr);

        return $attr;
    }

    /**
     * @param \DOMAttr $attrDOMAttr
     * @return \DOMAttr
     */
    public function setAttributeNode(\DOMAttr $attrDOMAttr)
    {
        $this->_updateAttributeArray($attrDOMAttr);
        return parent::setAttributeNode($attrDOMAttr);
    }

    /**
     * Returns index of attribute or false if value does not exist.
     *
     * @param string $attrName
     * @param string $attValue
     * @return int|bool
     */
    protected function _hasAttributeValue($attrName, $attValue)
    {
        $this->_parseAttributes();

        if (!array_key_exists($attrName, $this->_attributeArray))
            $this->_attributeArray[$attrName] = array();

        return array_search($attValue, $this->_attributeArray[$attrName], true);
    }

    /**
     * @param string $attName
     * @param string $attValue
     * @param string $glue
     * @param bool $returnAttr
     * @throws \InvalidArgumentException
     * @return DOMElementPlus|\DOMAttr
     */
    protected function _addAttributeValue($attName, $attValue, $glue, $returnAttr = false)
    {
        $attName = (string)$attName;
        $attValue = (string)$attValue;

        if ($attName === '')
            throw new \InvalidArgumentException(__METHOD__.' - "$attName" cannot be empty string');

        if ($this->_hasAttributeValue($attName, $attValue) !== false)
            return ($returnAttr ? $this->getAttribute($attName) : $this);

        $this->_attributeArray[$attName][] = $attValue;
        $this->_attributeArray[$attName] = array_unique($this->_attributeArray[$attName]);

        return $this->_setAttributeValue($attName, $glue, $returnAttr);
    }

    /**
     * @param string $attName
     * @param string $valueToRemove
     * @param string $glue
     * @param bool $returnAttr
     * @throws \InvalidArgumentException
     * @return \DOMAttr|string
     */
    protected function _removeAttributeValue($attName, $valueToRemove, $glue, $returnAttr = false)
    {
        $attName = (string)$attName;
        $valueToRemove = (string)$valueToRemove;

        if ($attName === '')
            throw new \InvalidArgumentException(__METHOD__.' - "$attName" cannot be empty string');

        if ($valueToRemove === '')
            throw new \InvalidArgumentException(__METHOD__.' - "$valueToRemove" cannot be empty string');

        $idx = $this->_hasAttributeValue($attName, $valueToRemove);

        if ($idx === false)
            return ($returnAttr ? $this->getAttribute($attName) : $this);

        unset($this->_attributeArray[$attName][$idx]);
        $this->_attributeArray[$attName] = array_unique($this->_attributeArray[$attName]);

        return $this->_setAttributeValue($attName, $glue, $returnAttr);
    }

    /**
     * @param string $attrName
     * @param string|null $glue
     * @param bool $returnAttr
     * @return \DOMAttr
     */
    protected function _setAttributeValue($attrName, $glue, $returnAttr = false)
    {
        if ($this->hasAttribute($attrName))
        {
            $attr = $this->getAttributeNode($attrName);
            $attr->value = (is_string($glue) ? implode($glue, $this->_attributeArray[$attrName]) : $this->_attributeArray[$attrName]);
        }
        else
        {
            $attr = new \DOMAttr($attrName, (is_string($glue) ? implode($glue, $this->_attributeArray[$attrName]) : $this->_attributeArray[$attrName]));
            parent::setAttributeNode($attr);
        }

        return ($returnAttr ? $attr : $this);
    }

    /**
     * This method is only intended to run once, the first time any "attribute" method is called on this element.
     *
     * Otherwise the individual attribute methods handle parsing and setting of values
     *
     * @return void
     */
    protected function _parseAttributes()
    {
        if ($this->_attributesParsed)
            return;

        foreach($this->attributes as $attribute)
        {
            /** @var $attribute \DOMAttr */
            $this->_updateAttributeArray($attribute);
        }

        $this->_attributesParsed = true;
    }

    /**
     * @param \DOMAttr $attrDOMAttr
     * @return void
     */
    protected function _updateAttributeArray(\DOMAttr $attrDOMAttr)
    {
        $name = strtolower($attrDOMAttr->name);

        switch(true)
        {
            // Styles require additional parsing
            case ($name === 'style') :
                $this->_attributeArray['style'] = $this->_parseStyleAttributeValue($attrDOMAttr->value);
                $attrDOMAttr->value = $this->_getStyleAttributeString();
                break;

            // Classes are stored as an index array
            case ($name === 'class') :
                $this->_attributeArray['class'] = explode(' ', $attrDOMAttr->value);
                break;

            // Everything else is just stored as a string for now
            // @TODO Increase granularity
            default :
                $this->_attributeArray[$attrDOMAttr->name] = $attrDOMAttr->value;
                break;
        }
    }


    /**
     *
     *
     * HTML Class Methods
     *
     *
     */


    /**
     * Checks to see if "class" html element attribute has been set and has the passed-in value
     *
     * @param string $className
     * @return bool
     */
    public function hasHtmlClass($className)
    {
        return ($this->_hasAttributeValue('class', (string)$className) !== false);
    }

    /**
     * Add an html class to the "class" attribute on this element
     *
     * @param string $className
     * @param bool $returnAttr
     * @return DOMElementPlus|\DOMAttr
     */
    public function addHtmlClass($className, $returnAttr = false)
    {
        return $this->_addAttributeValue('class', $className, ' ', $returnAttr);
    }

    /**
     * Remove an html class from the "class" attribute on this element
     *
     * @param string $className
     * @param bool $returnAttr
     * @return DOMElementPlus|\DOMAttr
     */
    public function removeHtmlClass($className, $returnAttr = false)
    {
        return $this->_removeAttributeValue('class', $className, ' ', $returnAttr);
    }


    /**
     *
     *
     * CSS Style Methods
     *
     * Styles require quite a bit more logic as they are more complex than simple attributes
     *
     *
     */


    /**
     * @param $styleName
     * @return bool
     */
    public function hasCssStyle($styleName)
    {
        $this->_parseAttributes();

        if (!array_key_exists('style', $this->_attributeArray))
            $this->_attributeArray['style'] = array();

        return array_key_exists((string)$styleName, $this->_attributeArray['style']);
    }

    /**
     * @param string $styleName
     * @param string $styleValue
     * @param bool $returnAttr
     * @throws \InvalidArgumentException
     * @return DOMElementPlus
     */
    public function setCssStyle($styleName, $styleValue, $returnAttr = false)
    {
        $styleName = (string)$styleName;
        $styleValue = (string)$styleValue;

        if ($styleValue === '')
            return $this->removeCssStyle($styleName);

        if ($styleName === '')
            throw new \InvalidArgumentException('DOMElementPlus::addCssStyle - "$styleName" cannot be an empty string');

        $this->_attributeArray['style'][$styleName] = $styleValue;

        return $this->_setStyleAttributeValue($returnAttr);
    }

    /**
     * @param string $styleName
     * @param bool $returnAttr
     * @return DOMElementPlus
     */
    public function removeCssStyle($styleName, $returnAttr = false)
    {
        $styleName = (string)$styleName;

        if (!$this->hasCssStyle($styleName))
            return ($returnAttr ? $this->getAttributeNode('style') : $this);

        unset($this->_attributeArray['style'][$styleName]);

        return $this->_setStyleAttributeValue($returnAttr);
    }

    /**
     * @param string $value
     * @param bool $returnAttr
     * @return DOMElementPlus|\DOMAttr
     */
    public function setCssStyles($value, $returnAttr = false)
    {
        $value = $this->_parseStyleAttributeValue((string)$value);

        $this->_attributeArray['style'] = $value + $this->_attributeArray['style'];

        return $this->_setStyleAttributeValue($returnAttr);
    }

    /**
     * Style attribute gets it's own setter as it's more complex than typical
     *
     * @param bool $returnAttr
     * @return DOMElementPlus|\DOMAttr
     */
    protected function _setStyleAttributeValue($returnAttr = false)
    {
        if ($this->hasAttribute('style'))
        {
            $attr = $this->getAttributeNode('style');
            $attr->value = $this->_getStyleAttributeString();
        }
        else
        {
            $attr = new \DOMAttr('style', $this->_getStyleAttributeString());
            parent::setAttributeNode($attr);
        }

        return ($returnAttr ? $attr : $this);
    }

    /**
     * @param string $styleValue
     * @return array
     */
    protected function _parseStyleAttributeValue($styleValue)
    {
        $styles = array();
        foreach(explode(';', $styleValue) as $style)
        {
            $exp = explode(':', $style);
            if (count($exp) !== 2)
                continue;
            $styles[trim($exp[0])] = trim($exp[1]);
        }

        return $styles;
    }

    /**
     * @return string
     */
    protected function _getStyleAttributeString()
    {
        $strValue = '';
        foreach($this->_attributeArray['style'] as $style=>$value)
        {
            if ($strValue !== '')
                $strValue .= ';';

            $strValue .= $style.':'.$value;
        }
        return $strValue;
    }
}
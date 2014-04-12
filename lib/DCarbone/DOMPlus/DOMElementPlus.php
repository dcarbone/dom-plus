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
     * @param string $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        $this->parseAttributes();

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
        $this->parseAttributes();

        return $this->_setAttributeNode((string)$name, (string)$value);
    }

    /**
     * @param string $name
     * @param string $value
     * @return \DOMAttr
     */
    protected function _setAttributeNode($name, $value)
    {
        switch(strtolower($name))
        {
            case 'class' :
                return $this->addHtmlClass($value, true);

            case 'style' :
                return $this->setCssStyles($value, true);
        }

        $attr = new \DOMAttr($name, $value);
        parent::setAttributeNode($attr);
        return $attr;
    }

    /**
     * @param \DOMAttr $attrDOMAttr
     * @return \DOMAttr
     */
    public function setAttributeNode(\DOMAttr $attrDOMAttr)
    {
        return $this->_setAttributeNode($attrDOMAttr->name, $attrDOMAttr->value);
    }

    /**
     * Checks to see if "class" html element attribute has been set and has the passed-in value
     *
     * @param string $className
     * @return bool
     */
    public function hasHtmlClass($className)
    {
        $this->parseAttributes();

        return in_array((string)$className, $this->_attributeArray['class'], true);
    }

    /**
     * Add an html class to the "class" attribute on this element
     *
     * @param $className
     * @param bool $returnAttr
     * @throws \InvalidArgumentException
     * @return DOMElementPlus|\DOMAttr
     */
    public function addHtmlClass($className, $returnAttr = false)
    {
        $this->parseAttributes();

        $className = (string)$className;

        if ($className === '')
            throw new \InvalidArgumentException('DOMElementPlus::addHtmlClass - "$className" cannot be empty string');

        if ($this->hasHtmlClass($className))
            return ($returnAttr ? $this->getAttributeNode('class') : $this);

        $this->_attributeArray['class'][] = $className;
        $this->_attributeArray['class'] = array_unique($this->_attributeArray['class']);

        $attr = $this->_setAttributeValue('class');

        if ($returnAttr)
            return $attr;

        return $this;
    }

    /**
     * Remove an html class from the "class" attribute on this element
     *
     * @param string $className
     * @param bool $returnAttr
     * @throws \InvalidArgumentException
     * @return DOMElementPlus|\DOMAttr
     */
    public function removeHtmlClass($className, $returnAttr = false)
    {
        $this->parseAttributes();

        $className = (string)$className;

        if ($className === '')
            throw new \InvalidArgumentException('DOMElementPlus::removeHtmlClass - "$className" cannot be empty string');

        if (!$this->hasHtmlClass($className))
            return ($returnAttr ? $this->getAttributeNode('class') : $this);

        $idx = array_search($className, $this->_attributeArray['class'], true);
        unset($this->_attributeArray['class'][$idx]);
        $this->_attributeArray['class'] = array_unique($this->_attributeArray['class']);

        $attr = $this->_setAttributeValue('class');

        if ($returnAttr)
            return $attr;

        return $this;
    }

    /**
     * @param $styleName
     * @return bool
     */
    public function hasCssStyle($styleName)
    {
        $this->parseAttributes();
        return array_key_exists((string)$styleName, $this->_attributeArray['style']);
    }

    /**
     * @param string $styleName
     * @param string $styleValue
     * @throws \InvalidArgumentException
     * @return DOMElementPlus
     */
    public function addCssStyle($styleName, $styleValue)
    {
        $styleName = (string)$styleName;
        $styleValue = (string)$styleValue;

        if ($styleValue === '')
            return $this->removeCssStyle($styleName);

        if ($styleName === '')
            throw new \InvalidArgumentException('DOMElementPlus::addCssStyle - "$styleName" cannot be an empty string');

        $this->_attributeArray['style'][$styleName] = $styleValue;

        $this->_setStyleAttributeValue();

        return $this;
    }

    /**
     * @param string $styleName
     * @return DOMElementPlus
     */
    public function removeCssStyle($styleName)
    {
        $styleName = (string)$styleName;

        if (!$this->hasCssStyle($styleName))
            return $this;

        unset($this->_attributeArray['style'][$styleName]);

        $this->_setStyleAttributeValue();

        return $this;
    }

    /**
     * @param string $value
     * @param bool $returnAttr
     * @return DOMElementPlus|\DOMAttr
     */
    public function setCssStyles($value, $returnAttr = false)
    {
        $value = $this->parseStyleAttributeValue((string)$value);

        $this->_attributeArray['style'] = $value + $this->_attributeArray['style'];

        $attr = $this->_setStyleAttributeValue();

        if ($returnAttr)
            return $attr;

        return $this;
    }

    /**
     * Style attribute gets it's own setter as it's more complex than typical
     *
     * @return \DOMAttr
     */
    protected function _setStyleAttributeValue()
    {
        if ($this->hasAttribute('style'))
        {
            $attr = $this->getAttributeNode('style');
            $attr->value = $this->getStyleAttributeString();
        }
        else
        {
            $attr = new \DOMAttr('style', $this->getStyleAttributeString());
            parent::setAttributeNode($attr);
        }

        return $attr;
    }

    /**
     * @param string $attrName
     * @param string $glue
     * @return \DOMAttr
     */
    protected function _setAttributeValue($attrName, $glue = ' ')
    {
        if ($this->hasAttribute($attrName))
        {
            $attr = $this->getAttributeNode($attrName);
            $attr->value = implode($glue, $this->_attributeArray[$attrName]);
        }
        else
        {
            $attr = new \DOMAttr($attrName, implode($glue, $this->_attributeArray[$attrName]));
            parent::setAttributeNode($attr);
        }

        return $attr;
    }

    /**
     * @return void
     */
    protected function parseAttributes()
    {
        if ($this->_attributesParsed)
            return;

        foreach($this->attributes as $attribute)
        {
            /** @var $attribute \DOMAttr */
            switch(strtolower($attribute->name))
            {
                case 'class' :
                    $this->_attributeArray['class'] = explode(' ', $attribute->value);
                    break;

                case 'style' :
                    $this->_attributeArray['style'] = $this->parseStyleAttributeValue($attribute->value);
                    break;
            }
        }

        $this->_attributesParsed = true;
    }

    /**
     * @param string $styleValue
     * @return array
     */
    protected function parseStyleAttributeValue($styleValue)
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
    protected function getStyleAttributeString()
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
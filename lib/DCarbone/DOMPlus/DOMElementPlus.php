<?php namespace DCarbone\DOMPlus;

/**
 * Class DOMElementPlus
 * @package DCarbone\DOMPlus
 */
class DOMElementPlus extends \DOMElement implements INodePlus
{
    /** @var array */
    protected $htmlClasses = array();

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
     * Now typecasts value to string before calling parent setAttribute method
     *
     * @param string $name
     * @param string $value
     * @return \DOMAttr
     */
    public function setAttribute($name, $value)
    {
        switch(strtolower($name))
        {
            case 'class' :
                return $this->addHtmlClass($value);

            default :
                return parent::setAttribute($name, (string)$value);
        }
    }

    /**
     * Checks to see if "class" html element attribute has been set and has the passed-in value
     *
     * @param string $className
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function hasHtmlClass($className)
    {
        if (!is_string($className))
            throw new \InvalidArgumentException('DOMElementPlus::hasClass - "$className" expected to be string, got "'.gettype($className).'"');

        if ($className === '')
            throw new \InvalidArgumentException('DOMElementPlus::hasClass - "$className" cannot be empty string');

        if ($this->hasAttribute('class') && count($this->htmlClasses) === 0)
            $this->htmlClasses = explode(' ', $this->getAttribute('class'));

        return in_array($className, $this->htmlClasses, true);
    }

    /**
     * Add an html class to the "class" attribute on this element
     *
     * @param $className
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function addHtmlClass($className)
    {
        if (!is_string($className))
            throw new \InvalidArgumentException('DOMElementPlus::hasClass - "$className" expected to be string, got "'.gettype($className).'"');

        if ($className === '' || $this->hasHtmlClass($className))
            return $this;

        $this->htmlClasses[] = $className;
        $this->htmlClasses = array_unique($this->htmlClasses);

        parent::setAttribute('class', implode(' ', $this->htmlClasses));

        return $this;
    }

    /**
     * Remove an html class from the "class" attribute on this element
     *
     * @param $className
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function removeHtmlClass($className)
    {
        if (!is_string($className))
            throw new \InvalidArgumentException('DOMElementPlus::hasClass - "$className" expected to be string, got "'.gettype($className).'"');

        if ($className === '' || !$this->hasHtmlClass($className))
            return $this;

        $idx = array_search($className, $this->htmlClasses, true);
        unset($this->htmlClasses[$idx]);
        $this->htmlClasses = array_unique($this->htmlClasses);

        parent::setAttribute('class', implode(' ', $this->htmlClasses));

        return $this;
    }
}
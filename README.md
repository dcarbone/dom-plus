dom-plus
========

A simple DOMDocument class wrapper that adds some simple improvements

This class utilizes the PHP DOMDocument method <a href="http://www.php.net/manual/en/domdocument.registernodeclass.php" target="_blank">registerNodeClass<a> to extend several classes.

What this means is that whenever create a new instance of  ``` DCarbone\DOMPlus\DOMDocumentPlus ```, all DOMNode, DOMElement, DOMText, and DOMCharacterData objects contained within the document are
instantiated as the modified classes I have included in this library.

So if you execute:
```php
$dom = new DOMDocumentPlus;

$div = $dom->createElement('div');

echo get_class($div);
```

Instead of seeing **DOMElement**, you will see **DCarbone\DOMPlus\DOMElementPlus**.  Same goes for:

```php
$text = $dom->createTextNode('text!'); // returns DCarbone\DOMPlus\DOMTextPlus
```

Additionally, these methods will also exist if you try to consume XML with this class.  However **I have not done any testing with XML documents!**.
If you use this with XML and find issues, please report them

# Classes
### DOMNodePlus
### DOMCharacterDataPlus
### DOMElementPlus
### DOMTextPlus

Each of these classes implements the following new or changed methods:

```php
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
```

**Additionally**, DOMDocumentPlus has some enhancements inspired by
<a href="http://beerpla.net/projects/smartdomdocument-a-smarter-php-domdocument-class/" target="_blank">Artem Russakovskii's SmartDOMDocument Class</a>.

In versions of PHP prior to 5.3.6, one of the most annoying issues with the DOMDocument class is that you cannot export
to html from a specific node.

This class allows you to not only do that for older versions of PHP, but also adds a method which strips all of the non-important
elements from the output string (doctype, html, header, body).

It is an extension of the base DOMDocument class, so it has all of the same methods the base class does.  What is available depends on the version of PHP you are running.

If you have a version of PHP >= 5.3.6, it uses base method functionality.

```php
$dom = new DOMDocumentPlus();
$dom->loadHTML('your html string');

echo $dom->saveHTMLExact();

$element = $dom->getElementById('id of element');

echo $dom->saveHTMLExact($element);
```

**DOMElement Added Features**

In an effort to make DOMElement objects easier to work with, I have added some very simple helper methods.

```php
/**
 * Now typecasts value to string before calling parent setAttribute method
 *
 * @param string $name
 * @param string $value
 * @return \DOMAttr
 */
public function setAttribute($name, $value);

/**
 * Checks to see if "class" html element attribute has been set and has the passed-in value
 *
 * @param string $className
 * @throws \InvalidArgumentException
 * @return bool
 */
public function hasHtmlClass($className);

/**
 * Add an html class to the "class" attribute on this element
 *
 * @param $className
 * @throws \InvalidArgumentException
 * @return $this
 */
public function addHtmlClass($className);

/**
 * Remove an html class from the "class" attribute on this element
 *
 * @param $className
 * @return $this
 * @throws \InvalidArgumentException
 */
public function removeHtmlClass($className);

/**
 * Does this element already have this style defined?
 *
 * @param string $styleName
 * @return bool
 */
public function hasCssStyle($styleName);

/**
 * Explicitly define a specific CSS style for this element
 *
 * @param string $styleName
 * @param string $styleValue
 * @param bool $returnAttr
 * @throws \InvalidArgumentException
 * @return DOMElementPlus|\DOMAttr
 */
public function setCssStyle($styleName, $styleValue, $returnAttr = false);

/**
 * Remove a CSS Style definition from this element
 *
 * @param string $styleName
 * @param bool $returnAttr
 * @return DOMElementPlus|\DOMAttr
 */
public function removeCssStyle($styleName, $returnAttr = false);

/**
 * Explicitly override any/all existing "style" attribute values with the passed in value
 *
 * @param string $value
 * @param bool $returnAttr
 * @return DOMElementPlus|\DOMAttr
 */
public function setCssStyles($value, $returnAttr = false);
```

If you have existing code which uses the standard *DOMElement::setAttribute* or *DOMElement::setAttributeNode*, DOMElementPlus has been designed gracefully consume your existing code and shouldn't require any changes on your end.
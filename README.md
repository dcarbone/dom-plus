dom-plus
========

A simple DOMDocument class wrapper that adds some simple improvements

This class utilizes the PHP DOMDocument method <a href="http://www.php.net/manual/en/domdocument.registernodeclass.php" target="_blank">registerNodeClass<a> to extend several classes.

What this means is that whenever you initialize a new ```php DOMDocumentPlus ``` object, all DOMNode, DOMElement, DOMText, and DOMCharacterData objects contained within the document are
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
## DOMNodePlus
## DOMCharacterDataPlus
## DOMElementPlus
## DOMTextPlus

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

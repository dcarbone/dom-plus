dom-plus
========

A simple DOMDocument class wrapper that adds some simple improvements

This class was inspired by <a href="http://beerpla.net/projects/smartdomdocument-a-smarter-php-domdocument-class/" target="_blank">Artem Russakovskii's SmartDOMDocument Class</a>.

In versions of PHP prior to 5.3.6, one of the most annoying issues with the DOMDocument class is that you cannot export
to html from a specific node.

This class allows you to not only do that for older versions of PHP, but also adds a method which strips all of the non-important
elements from the output string (doctype, html, header, body).

It is an extension of the base DOMDocument class, so it has all of the same methods the base class does.  What is available depends on the version of PHP you are running.

If you have a version of PHP >= 5.3.6, it uses base method functionality.

```php
$dom = new DOMPlus();
$dom->loadHTML('your html string');

echo $dom->saveHTMLExact();

$element = $dom->getElementById('id of element');

echo $dom->saveHTMLExact($element);
```

I have also added two convenience methods:

```php
public function getNextSiblingElement(\DOMNode &$element = null, array $seek, array $stop = array(), $nodeValueRegex = null)

public function getPreviousSiblingElement(\DOMNode &$element = null, array $seek, array $stop = array(), $nodeValueRegex = null)
```

The above two methods will iterate through $element's siblings until:

1. The sibling's node name is found in the $seek array (returns sibling)
  * If the $nodeValueRegex parameter is defined, the sibling element will only be returned if it's nodeValue is matched
2. The sibling's node name is found in the $stop array (returns null)
3. The next/previousSibling parameter is found to be null

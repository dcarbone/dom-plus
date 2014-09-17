dom-plus
========

A simple DOMDocument class wrapper that adds some simple improvements

## Inclusion in your Composer application

```json
"require" : {
    "dcarbone/dom-plus" : "1.3.*"
}
```

This class utilizes the PHP DOMDocument method <a href="http://www.php.net/manual/en/domdocument.registernodeclass.php" target="_blank">registerNodeClass</a> to extend several classes.

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

## [INodePlus](INODEPLUS.md)

This interface is applied to all concrete classes provided by this library.  Click the link above to peruse the provided methods.

## [DOMDocumentPlus](DOMDOCUMENTPLUS.md)

DOMDocumentPlus has some enhancements inspired by <a href="http://beerpla.net/projects/smartdomdocument-a-smarter-php-domdocument-class/" target="_blank">Artem Russakovskii's SmartDOMDocument Class</a>.

## [DOMElementPlus](DOMELEMENTPLUS.md)

DOMElementPlus contains some additional HTML-specific features, such as style and class attribut helper methods
# DOMDocumentPlus

DOMDocumentPlus is a simple extension of the base PHP (DOMDocument)[http://php.net/manual/en/class.domdocument.php] class.
As such, it has all the same methods available and works in much the same way.  I have, however, provided a few helper
methods to make usage a bit more flexible / easier.

## saveHTML

The ` saveHTML() ` method is very useful, obviously.  If, however, you are using versions of PHP prior to 5.3.6 you are unable to
receive the HTML for a specific node.  To that end, this method has been overloaded to accept a \DOMNode argument.

When passing a \DOMNode that is a member of the document you are calling this method on, you will receive just the HTML for the
specified node.

If you have a version of PHP >= 5.3.6, it uses base method functionality.

## saveHTMLExact

In addition to the changes presented above, saveHTMLExact is a method that will allow you receive ONLY the HTML contained
within the <body> element.  No data outside of <body /> will be included in the response.

```php
$dom = new DOMDocumentPlus();
$dom->loadHTML('your html string');

echo $dom->saveHTMLExact();

$element = $dom->getElementById('id of element');

echo $dom->saveHTMLExact($element);
```

## htmlDocumentFromStringWithConversion

` htmlDocumentFromStringWithConversion ` is a new static initializer method that accepts 3 arguments:

- $html
    - HTML string, required
- $targetEncoding
    - Encoding you wish to convert $html to, defaults to UTF-8
- $sourceEncoding
    - The current encoding of $html, if known.  Defaults to NULL.

This method will return a new DOMDocumentPlus object and load the passed HTML after converting
character encoding using [mb_convert_encoding](http://php.net/manual/en/function.mb-convert-encoding.php)


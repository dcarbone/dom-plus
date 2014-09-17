# DOMElementPlus

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
 * @return bool
 */
public function hasHtmlClass($className);

/**
 * Add an html class to the "class" attribute on this element
 *
 * @param string $className
 * @param bool $returnAttr
 * @return DOMElementPlus|\DOMAttr
 */
public function addHtmlClass($className, $returnAttr = false);

/**
 * Remove an html class from the "class" attribute on this element
 *
 * @param string $className
 * @param bool $returnAttr
 * @return DOMElementPlus|\DOMAttr
 */
public function removeHtmlClass($className, $returnAttr = false);

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

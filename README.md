# puja-breadcrumb
Puja-Breadcrumb is a simple class to manage the breadcrumbs

Installation
------------

Just run this on the command line:
```
composer require jinnguyen/puja-breadcrumb
```

Usage
-----
```php
include '/path/to/vendor/autoload.php';
use Puja\Breadcrumb\Breadcrumb;
```

Examples:
-----
<strong>Simple</strong>
<pre>
$breadcrumb = new Breadcrumb;
$breadcrumb->add('Subpage 2', '/subpage2');
echo $breadcrumb->render();
</pre>

<strong>new breadcrumb with a array</strong>
<pre>
$breadcrumb = new Breadcrumb(array(
    array('title' => 'Home', 'link' => '/'),
    array('title' => 'Page', 'link' => '/page'),
    array('title' => 'Subpage', 'link' => '/subpage/?a=5&b[]=7&b[]=8'),
));
$breadcrumb->add('Subpage 2', '/subpage2');
echo $breadcrumb->render();
</pre>

The rest of the documentation will assume you have a `$breadcrumb` instance on which you are making calls.

### Adding a crumb
```php
$breadcrumb->add('Home', '/');
```

### Delete all crumb
```php
$breadcrumb->deleteAll();
```
### Delete last crumb
```php
$breadcrumb->deleteLastItem();
```

### Count breadcrumb elements
```php
$breadcrumb->count();
```

### Check empty
```php
$breadcrumb->isEmpty(); // same with $breadcrumb->count() == 0
```
### Get data:
```php
$breadcrumb->getData(); // get all breadcrumb nodes
```

### First and Last CSS classes
<pre>
    <ul>
        <li class="brcClassName first"><a href="/">Home</a></li> // First Breadcrumb element
        <li class="brcClassName "><a href="/page">Page</a></li>
        <li class="brcClassName "><a href="/subpage/?a=5&b[]=7&b[]=8">Subpage</a></li>
        <li class="brcClassName last">Subpage 2</li> // Last Breadcrumb Element
    </ul>
</pre>
The first/last css classes are the class of first/last Breadcrumb element

```php
$breadcrumb->setFirstCssClassName($className);
$breadcrumb->setLastCssClassName($className);
```

### The Element

The default breadcrumb element is `<li class="{FirstLastCss}">%s{Divider}</li>`. To change it, use the setElement method like so:

```php
$breadcrumb->setElement('<span class="{FirstLastCss}">%s{Divider}</span>');
```

<strong>Note:</strong>
<pre>
"%s" is required for Breadcrumb::$element
{FirstLastCss}: will be replaced by Breadcrumb::$firstCssClassName for first element and Breadcrumb::$lastCssClassName for last element
{Divider}: will be replaced by Breadcrumb::$divider
</pre>

### The List Element

The default list element used to wrap the breadcrumbs, is `<ul>%s</ul>`. To change it, use the setListElement method like so:

```php
$breadcrumbs->setListElement('<ol class="ol-breadcrumb">%s</ol>');
```

<strong>Note:</strong>
<pre>"%s" is required for Breadcrumb::$listElement</pre>

### Divider
The default breadcrumb divider is `` (empty). This will be replace to placeholder {Divider} in property Breadcrumb::$element. If you'd like to change it to, for example, `/`, you can just do:

```php
$breadcrumb->setDivider('/');
```

### Output

Finally, when you actually want to display your breadcrumbs, all you need to do is call the `render()` method on the instance:

```php
echo $breadcrumb->render();
```

Note that by default crumb titles are rendered with escaping HTML characters, if you'd like to ignore it just do  like so:

```php
$breadcrumb->setSafeHtml(false);
```

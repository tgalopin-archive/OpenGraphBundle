Getting Started With TgaOpenGraphBundle
=======================================

The TgaOpenGraphBundle is a simple way to improve how you manage OpenGraph
into your Symfony2 application.

> **Note**: OpenGraph is a standard protocol used by many websites (Facebook,
> Twitter, Google, ...) to obtain more precise informations about your content.
>
> [Learn more about OpenGraph](http://ogp.me/)

The idea of this bundle it to associate each entity of your app with an **OpenGraph
map**, a service able to create the OpenGraph document for your entity.

Installation
------------

Installation is very quick:

### 1. Download it with Composer

Add the bundle to your `composer.json` file:

``` json
{
    "require": {
        "tga/opengraph-bundle": "~1.0"
    }
}
```

And run `composer install tga/opengraph-bundle`.

### 2. Enable it in your kernel

Enable the bundle in your `app/AppKernel.php` file;

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tga\OpenGraphBundle\TgaOpenGraphBundle(),
    );
}
```


Usage
-----

The TgaOpenGraphBundle will associate:

- **Entities** of your application with ...
- **OpenGrap maps**, definitions of these entities in an OpenGraph way


Let's take an example for a better understanding: a blog post.

### Your entity

For a blog post, you could have an entity like this one:

``` php
<?php

namespace Acme\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class BlogPost
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;
}
```

### Its OpenGraph map

The map associated with your entity will be a class implementing
`Tga\OpenGraphBundle\Map\OpenGraphMapInterface` and the two required methods of this interface :
`map(OpenGraphDocument $document, $entity)` and `supports($entity)`.

The recomanded way to store these maps is under the `OpenGraph` directory of your bundle.

For instance, our map could look like this :

``` php
<?php

namespace Acme\DemoBundle\OpenGraph;

use Acme\DemoBundle\Entity\BlogPost;
use Tga\OpenGraphBundle\Document\OpenGraphDocument;
use Tga\OpenGraphBundle\Map\OpenGraphMapInterface;
use Tga\OpenGraphBundle\OpenGraph;

class BlogPostMap implements OpenGraphMapInterface
{
    /**
     * @param OpenGraphDocument $document
     * @param BlogPost $blogPost
     */
    public function map(OpenGraphDocument $document, $blogPost)
    {
        $document->append(OpenGraph::OG_SITE_NAME, 'MyBlog');
        $document->append(OpenGraph::OG_TYPE, OpenGraph::TYPE_ARTICLE);
        $document->append(OpenGraph::OG_TITLE, $blogPost->getTitle());
    }

    /**
     * @param object $entity
     * @return bool
     */
    public function supports($entity)
    {
        return $entity instanceof BlogPost;
    }
}
```

The `supports` method declares with what kind of entities this map is able to deal.
The `map` method create an OpenGraph document representing the given entity.

Once created, we still have to register our class into the OpenGraph registry. To do so,
we will have to use the tag `open_graph.map`:

``` xml
<!-- services.yml -->

<?xml version="1.0" ?>

<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <parameters>
        <parameter key="acme_demo.open_graph.blog_post_map.class">Acme\DemoBundle\OpenGraph\BlogPostMap</parameter>
    </parameters>

    <services>
        <service id="acme_demo.open_graph.blog_post_map" class="%acme_demo.open_graph.blog_post_map.class%">
            <tag name="open_graph.map" />
        </service>
    </services>
</container>
```

### Using the map

Our map is registered, so we can use it anywhere we want to render our <meta>.
For instance, with Twig:


``` html
<html>
    <head>
        <title>Blog post</title>

        {{ tga_render_opengraph(blogPost) }}
    </head>
    <body>
        ...
    </body>
</html>
```

> **Note**: if no map is able to deal with the entity given in `tga_render_opengraph`,
> an `EntityNotSupported` exception will be thrown.


Inject the router
-----------------

You will need very often the router in your maps to generate URL.

As your maps are services, you can easily pass the router to them using the service definition.

However, the TgaOpenGraphBundle provides a more convenient way to use the router
in your maps: if your map extends the `RouterAware` class, the bundle will pass the router
to it automatically:

``` php
<?php

namespace Acme\DemoBundle\OpenGraph;

use Acme\DemoBundle\Entity\BlogPost;
use Tga\OpenGraphBundle\Document\OpenGraphDocument;
use Tga\OpenGraphBundle\Map\OpenGraphMapInterface;
use Tga\OpenGraphBundle\OpenGraph;
use Tga\OpenGraphBundle\Routing\RouterAware;

class BlogPostMap extends RouterAware implements OpenGraphMapInterface
{
    /**
     * @param OpenGraphDocument $document
     * @param BlogPost $blogPost
     */
    public function map(OpenGraphDocument $document, $blogPost)
    {
        // ...
        $document->append(OpenGraph::OG_URL, $this->router->generate('blog_view', [ 'id' => $blogPost->getId() ]));
        // ...
    }

    // ...
}
```

As our map `BlogPostMap` extends `Tga\OpenGraphBundle\Routing\RouterAware`,
we can automatically access the router using `$this->router` (**without** any
modification of our service definition).
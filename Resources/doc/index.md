Getting Started With TgaOpenGraphBundle
=======================================

The TgaOpenGraphBundle is a simple way to improve how you manage OpenGraph
into your Symfony2 application.

> **Note**: OpenGraph is a standard protocol used by many websites around the world
> (Facebook, Twitter, Google, ...) to obtain more precise informations about your
> content.
>
> [Learn more about OpenGraph](http://ogp.me/)

The idea of this bundle it to associate each content entity in your app (a blog post,
a static page or any other content) with spacific service, called the `OpenGraphMap`.
This service will be able to render your content in an OpenGraph way so you will be
able to display it in your HTML.


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
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User", inversedBy="posts")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Acme\DemoBundle\Entity\Category", inversedBy="posts")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $image;

    /**
     * @ORM\Column(type="array")
     */
    private $tags;
}
```

### The OpenGraph map

Now, you just have to define an **OpenGraph map** associated with this entity.
To do so, you have to create a class implementing `Tga\OpenGraphBundle\Map\OpenGraphMapInterface`
and the two required methods : `map(OpenGraphDocument $document, $entity)` and `supports($entity)`.

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

Here, we are saying with the method `supports` that this map only supports instances of `BlogPost`.
And in the method `map`, we are creating our document using the `$blogPost` entity (as we are sure
this object is an isntance of `BlogPost`).

This map is now available and usable. However, we still need to declare it to the maps registry.
We will use the service container for that, using the tag `open_graph.map` :

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


Using the router
----------------

You will very often need the router into your OpenGraph maps to fill the `og:url` property.
To ease your job, the TgaOpenGraphBundle inject the router in your maps if they extends the
`RouterAware` class:

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

If the class extends `Tga\OpenGraphBundle\Routing\RouterAware`, the bundle will automatically
inject the router in it so you will be able to use it with `$this->router`.
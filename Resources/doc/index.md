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


And on the page to view this blog post, you could want to display some OpenGraph data, as:

    ``` html
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<my_blog_post_title>" />
    <meta property="og:url" content="<URL_to_my_blog_post>" />
    <meta property="og:image" content="<image_illustrating_my_blog_post>" />
    ...
    ```

But let's imagine that you have many pages where you display the blog post. You would have to copy-paste
these HTML meta, dans reuse them on the other page, with a router call you didn't externalized.
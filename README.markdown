TgaOpenGraphBundle
==================

The TgaOpenGraphBundle introduce OpenGraph into the Symfony2 world.
It provides useful tools to use OpenGraph with your classic entities.

For instance, once set up, you will be able to render OpenGraph for
any entity very easily:

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

The aim of this bundle is to introduce reusability and flexibility
into your OpenGraph definitions.


Documentation
-------------

All the documentation is stored in the `Resources/doc` directory
of this bundle:

[Read the Documentation](https://github.com/tgalopin/OpenGraphBundle/blob/master/Resources/doc/index.md)


Installation
------------

All the installation instructions are located in the documentation.


License
-------

This bundle is under the MIT license. See the complete license in the
file: `LICENSE`


Contributors
------------

This bundle is mainly developed by Titouan Galopin. For the complete
list of the contributors, please see the
[Github contributors list](https://github.com/tgalopin/OpenGraphBundle/contributors)

This bundle uses actively the library
[Opengraph by euskadi31](https://github.com/euskadi31/Opengraph).


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the
[Github issue tracker](https://github.com/tgalopin/OpenGraphBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

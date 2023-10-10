PHPainfree
==========

PHPainfree is an **ultra**-lightweight PHP framework. It is inspired by the
MVC concept and attempts to remove barriers to entry while providing the
flexibility to design, develop, and deploy applications of any size or
complexity.

Version 2 comes with a significant shift in opinion, focused on developer
productivity and happiness. Whenever possible, we follow a [HATEOS](https://en.wikipedia.org/wiki/HATEOAS)
approach to software development, and Version 2 of PHPainfree comes bundled
with "opinions" and options on how to build modern, functional web applications.

This version comes embedded with [htmx](https://htmx.org) and has significant
improvements to the underlying PHP library design to make use of the `htmx` 
system of partial content swaps with `htmx` magic. You're still free, as always,
to roll your own mechanisms for anything, but we've provided a more robust
set of defaults to show you a different way to build PHP software products.

Caveat Emptor
-------------

1. This software is under development, and all bugs should be reported through github's issues system.


About
-----
+ **Version:** 2.2.0
+ **Maintainer:** Eric Harrison [@blister](https://github.com/blister)

Development Quickstart
----------------------
PHPainfree2 comes with a predefined Docker image to make local development easier.
To start, simply run the following command inside your folder:
```console
docker compose up
```

Installation
------------
	1. Extract the PHPainfree release.
	2. Place the contents of the htdocs/ folder in your web directory's document root.
	3. Place the includes/ and templates/ folders somewhere accessible to your PHP's include root.
		(If you can't mess with your include root, you should be able to place these folders inside your document root)
	4. Edit includes/PainfreeConfig.php. Modify the $PainfreeConfig variable to match your application configuration.
	5. Run and enjoy!


Notes
-----
- v2 is a work in progress. All ideas and suggestions are welcome!

Contributors
------------
- Eric Ryan Harrison [@blister](https://github.com/blister)
- Kari Turner [@thespecialK](https://github.com/thespecialK)
- Ryan Laurie [@iethree](https://github.com/iethree)

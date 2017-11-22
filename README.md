# Documentation

> Constants

- All available constants are defined in the `config.ini` file

- In the `config.ini` file, constants are defined lower case. Constants in PHP runtime are instantiated in uppercase (@see `config.php`)

> Global methods defined in files that are required in init.php

- url(): _returns UrlBuilder object if no arguments given_

    - `key=>value` pairs passed as argument 2 (array) can be retrieved with the `\Content\Page\Request::getCurrentParams()` function
    
    - `\Content\Page\Request` is provided as protected property `$_request` in the `\Content\Page\EndpointControlling\AbstractController` class

- trans(): _returns translated string for requested language_
         
- inject(): _calls dependency injection on given class as argument 1 (string)_
    
    - The DependencyInjector stores instantiated in a public `$_loaded` property (array) in order to prevent classes being instantiated multiple times
    
    - This allows you to change properties of injected classes and access them from other objects
    
    - TODO: `create()` for injecting dependencies but instead of returning the stored instance of `$_loaded` property, it returns a new, independent object. E.G. for language switcher URLs (for not changing the _real_ requested language)
    
> \Content\Page\\* namespace

- `Content\Page\RenderObject`...

    - Responsible for rendering the HTML for the output.
    
    - TODO: Add a `render()` function being called in Index.php that renders all templates

- `Content\Page\Request`...

    - All around `$_GET` and `$_POST` (including .htaccess redirect info)

- `Content\Page\EndpointControlling\AbstractController`...

    - It's definitely recommended to extend this class from any endpoint controller you create
    
    - Providing basic data, dependencies and functions useful for a endpoint controller

- `Content\Page\Controller`...
    
    - Injected in Index.php for running the entire script
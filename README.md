php-query-filter-bundle
=======================

php-query-filter-bundle is a Symfony2 bundle for [php-query-filters](https://github.com/kalmanolah/php-query-filters).

## Installing

Include the bundle in your project with composer:

```shell
$ composer require kalmanolah/php-query-filter-bundle
```

Add the bundle to your `app/AppKernel.php` file:

```php
<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            ...
            new KalmanOlah\QueryFilterBundle\KalmanOlahQueryFilterBundle(),
            ...
        );
        ...
      }
      ...
}
```

## Usage

This bundle defines one main service: `query_filters`. You can use it to
retrieve filter sets. The bundle defines the filter sets `mongodb` and
`doctrine_orm` out of the box, but you can roll your own.

Getting a filter set:

```php
$filterSet = $container->get('query_filters')->get('mongodb');

// From here on out it's business as usual
$filterSet->filter($query, $filters);
```

## License

See [LICENSE](LICENSE)

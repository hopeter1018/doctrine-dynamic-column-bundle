# doctrine-dynamic-column-bundle

## Introduction

This bundle aims to add doctrine dynamic column.

## Installation

### Require the package

`composer require hopeter1018/doctrine-dynamic-column-bundle`

### Add to kernel

#### Symfony 4+ or Symfony Flex

Add `/config/bundles.php`

```php
return [
  ...,
  HoPeter1018\DoctrineDynamicColumnBundle\HoPeter1018DoctrineDynamicColumnBundle::class => ['all' => true],
];
```

#### Symfony 2+

Add `/app/AppKernel.php`

```php
$bundles = [
  ...,
  new HoPeter1018\DoctrineDynamicColumnBundle\HoPeter1018DoctrineDynamicColumnBundle(),
];
```

### Add to doctrine config

```yaml
doctrine:
  orm:
    entity_managers:
      mappings:
        HoPeter1018DoctrineDynamicColumnBundle: ~
```

### Config

####

###

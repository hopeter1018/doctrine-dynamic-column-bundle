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

```yaml
hopeter1018_doctrine_dynamic_column:
  class: 'HoPeter1018\DoctrineDynamicColumnBundle\Entity\DynamicColumnData'
  managers: []
```

### Usage

```php
namespace App\Entity;

use HoPeter1018\DoctrineDynamicColumnBundle\Annotation as DynCol;
use HoPeter1018\DoctrineDynamicColumnBundle\Entity\Traits\DynamicColumnTrait;

/**
 * @DynCol\Entity(columns={
 *     "s1": @DynCol\Column(name="s1", type="string", length=255),
 *     "b1": @DynCol\Column(name="b1", type="boolean", length=255),
 *     "datee": @DynCol\Column(name="datee", type="date"),
 * })
 */
class TheEntity
{
    use DynamicColumnTrait;
}
```

## TODO

-   [ ] Enhance Annotation
    -   [ ] Support more @ORM\*
        -   [ ] Relationships (ManyToOne, ManyToOne, OneToOne)
    -   [ ] Add more property
-   [ ] Support of other doctrine property types:
    -   [ ] array
    -   [ ] simple_array
    -   [ ] json_array
    -   [ ] json,
    -   [ ] object
    -   [ ] boolean
    -   [ ] integer
    -   [ ] smallint
    -   [ ] bigint
    -   [ ] string
    -   [ ] text
    -   [ ] datetime,
    -   [ ] datetime_immutable
    -   [ ] datetimetz
    -   [ ] datetimetz_immutable
    -   [ ] date,
    -   [ ] date_immutable
    -   [ ] time
    -   [ ] time_immutable
    -   [ ] decimal
    -   [ ] float
    -   [ ] binary
    -   [ ] blob
    -   [ ] guid
    -   [ ] dateinterval
    -   [ ] uuid
    -   [ ] uuid_binary_ordered_time
    -   [ ] EcCart_Product_StockStatusEnumType
-   [ ] Add Command to
    -   [ ] Refresh cache
-   [ ] Add helpers to
    -   [ ] SonataAdmin
    -   [ ] ApiPlatform
-   [ ] Check against different id type

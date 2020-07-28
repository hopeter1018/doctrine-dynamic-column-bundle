<?php

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Annotation;

use Doctrine\Common\Annotations\Target;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class DynamicColumnEntity
{
    public $columns = [];
}

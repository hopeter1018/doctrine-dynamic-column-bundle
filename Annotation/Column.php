<?php

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Annotation;

use Doctrine\Common\Annotations\Target;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
final class Column
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var mixed
     */
    public $type = 'string';

    /**
     * @var int
     */
    public $length;

    /**
     * The precision for a decimal (exact numeric) column (Applies only for decimal column).
     *
     * @var int
     */
    public $precision = 0;

    /**
     * The scale for a decimal (exact numeric) column (Applies only for decimal column).
     *
     * @var int
     */
    public $scale = 0;

    /**
     * @var bool
     */
    public $unique = false;

    /**
     * @var bool
     */
    public $nullable = false;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $columnDefinition;
}

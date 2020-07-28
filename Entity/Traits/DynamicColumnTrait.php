<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Entity\Traits;

trait DynamicColumnTrait
{
    protected $dynamicColumnData;

    protected $dynamicColumnDataRepository;

    public function __set(string $name, $value)
    {
    }

    public function __get(string $name)
    {
        return $name;
    }

    public function __isset(string $name)
    {
        return true;
    }

    public function __unset(string $name)
    {
    }

    public function setDynamicColumnDataRepository($dynamicColumnDataRepository)
    {
        $this->dynamicColumnDataRepository = $dynamicColumnDataRepository;
    }
}

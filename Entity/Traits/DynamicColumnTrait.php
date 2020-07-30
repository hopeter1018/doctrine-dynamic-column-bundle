<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Entity\Traits;

use HoPeter1018\DoctrineDynamicColumnBundle\Repository\DynamicColumnDataRepository;

trait DynamicColumnTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dynamic_column_updated", type="datetime", nullable=true)
     */
    protected $dynamicColumnUpdated;

    protected $newDatas = null;
    protected $dynamicColumnDatas = null;
    protected $dynamicColumnAnno = null;

    /** @var DynamicColumnDataRepository */
    protected $dynamicColumnDataRepository = null;

    public function __set(string $name, $value)
    {
        $this->loadDynamicColumnDatas();
        if (isset($this->dynamicColumnAnno['columns'][$name])) {
            if (!isset($this->dynamicColumnDatas[$name])) {
                $this->dynamicColumnDatas[$name] = $this->dynamicColumnDataRepository->newInstance($this, $name);
            }

            $this->dynamicColumnUpdated = new \DateTime();
            $this->dynamicColumnDatas[$name]->setRunTimeData($value);
        } else {
            $this->newDatas[$name] = $value;
        }
    }

    public function __get(string $name)
    {
        $this->loadDynamicColumnDatas();
        if (isset($this->dynamicColumnAnno['columns'][$name])) {
            if (!isset($this->dynamicColumnDatas[$name])) {
                $this->dynamicColumnDatas[$name] = $this->dynamicColumnDataRepository->newInstance($this, $name);
            }

            return $this->dynamicColumnDatas[$name]->getRunTimeData();
        } elseif (isset($this->newDatas[$name])) {
            return $this->newDatas[$name];
        }
    }

    public function __isset(string $name)
    {
        $this->loadDynamicColumnDatas();
        if (isset($this->dynamicColumnAnno['columns'][$name])) {
            return true;
        } elseif (isset($this->newDatas[$name])) {
            return true;
        }
    }

    public function __unset(string $name)
    {
        $this->loadDynamicColumnDatas();
        if (isset($this->dynamicColumnAnno['columns'][$name])) {
        } elseif (isset($this->newDatas[$name])) {
            unset($this->newDatas[$name]);
        }
    }

    public function setDynamicColumnAnno($dynamicColumnAnno)
    {
        $this->dynamicColumnAnno = $dynamicColumnAnno;

        return $this;
    }

    public function setDynamicColumnDataRepository($dynamicColumnDataRepository)
    {
        $this->dynamicColumnDataRepository = $dynamicColumnDataRepository;

        return $this;
    }

    /**
     * Get the value of Dynamic Column Data.
     *
     * @return mixed
     */
    public function getDynamicColumnDatas()
    {
        return $this->dynamicColumnDatas;
    }

    /**
     * Get the value of Dynamic Column Anno.
     *
     * @return mixed
     */
    public function getDynamicColumnAnno()
    {
        return $this->dynamicColumnAnno;
    }

    /**
     * Get the value of New Datas.
     *
     * @return mixed
     */
    public function getNewDatas()
    {
        return $this->newDatas;
    }

    public function getDynamicColumnData(string $fieldName)
    {
        return isset($this->dynamicColumnDatas[$fieldName]) ? $this->dynamicColumnDatas[$fieldName] : null;
    }

    public function setDynamicColumnData(string $fieldName, $dynamicColumnData)
    {
        if (isset($this->dynamicColumnDatas[$fieldName])) {
        } else {
            $this->dynamicColumnDatas[$fieldName] = $dynamicColumnData;
        }
    }

    /**
     * Get the value of Dynamic Column Updated.
     *
     * @return \DateTime
     */
    public function getDynamicColumnUpdated()
    {
        return $this->dynamicColumnUpdated;
    }

    /**
     * Set the value of Dynamic Column Updated.
     *
     * @return self
     */
    public function setDynamicColumnUpdated(\DateTime $dynamicColumnUpdated)
    {
        $this->dynamicColumnUpdated = $dynamicColumnUpdated;

        return $this;
    }

    protected function loadDynamicColumnDatas()
    {
        if (null !== $this->dynamicColumnDataRepository and null !== $this->dynamicColumnAnno and null === $this->dynamicColumnDatas) {
            $this->dynamicColumnDatas = $this->dynamicColumnDataRepository->findAllByEntity($this);
        }
    }
}

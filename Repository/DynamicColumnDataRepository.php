<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use HoPeter1018\DoctrineDynamicColumnBundle\Entity\DynamicColumnData;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DynamicColumnDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DynamicColumnData::class);
    }
}

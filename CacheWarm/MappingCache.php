<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\CacheWarm;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\ManagerRegistry;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\DynamicColumnEntity;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\DynamicColumnProperty;
use ReflectionClass;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Resource\FileResource;

class MappingCache
{
    /** @var string */
    protected $cacheFolder;

    /** @var bool */
    protected $debug;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var Reader */
    protected $annotationReader;

    public function __construct(string $cacheFolder, bool $debug, ManagerRegistry $managerRegistry, Reader $annotationReader)
    {
        $this->cacheFolder = $cacheFolder;
        $this->debug = $debug;
        $this->managerRegistry = $managerRegistry;
        $this->annotationReader = $annotationReader;
    }

    public function rules($manager, string $entityFqcn)
    {
        // $manager = $this->managerRegistry->getManagerForClass($entityFqcn);
        $metadata = $manager->getMetadataFactory()->getMetadataFor($entityFqcn);

        $filename = $this->cacheFolder.'/hopeter1018/doctrine-dynamic-column/'.str_replace('\\', '-', $entityFqcn).md5($entityFqcn);
        $cache = new ConfigCache($filename, $this->debug);
        if (!$cache->isFresh()) {
            $resources = [];
            $reflection = new ReflectionClass($entityFqcn);
            if (file_exists($reflection->getFileName())) {
                $resources[] = new FileResource($reflection->getFileName());
            }

            $rules = $this->getRulesOfEntityClass($manager, $metadata);
            if (0 === count($rules)) {
                $rules = null;
            }

            $cache->write(serialize($rules), $resources);
        }

        return unserialize(file_get_contents($filename));
    }

    public function getRulesOfEntityClass($manager, $metadata)
    {
        $rules = [];
        $classAnno = $this->annotationReader->getClassAnnotation($metadata->reflClass, DynamicColumnEntity::class);
        $entityFqcn = $metadata->reflClass->name;
        $prefix = sprintf('%s-', $entityFqcn);
        if ('DigPro\ErpV1Bundle\Entity\TQuotation' === $entityFqcn) {
            dump($metadata->getIdentifierFieldNames());
            dump($metadata->getFieldMapping($metadata->getIdentifierFieldNames()[0]));

            dump($classAnno);
        }
        if (null !== $classAnno) {
            foreach ($classAnno->columns as $name => $ormColumn) {
                $rules[$prefix.$name] = [
                    'entity_class' => $entityFqcn,
                ];
                static::parseRule($rules[$prefix.$name]);
            }
        }
        foreach ($metadata->reflClass->getProperties() as $property) {
            $propAnno = $this->annotationReader->getPropertyAnnotation($property, DynamicColumnProperty::class);
            if (null !== $propAnno) {
                $rules[$prefix.$property->name] = [
                    'entity_class' => $entityFqcn,
                ];
                static::parseRule($rules[$prefix.$property->name]);
            }
        }

        return $rules;
    }

    public static function parseRule(&$rule)
    {
    }
}

<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\CacheWarm;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\ManagerRegistry;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\Column;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\Entity;
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

    public function load($metadata)
    {
        $entityFqcn = $metadata->name;
        $filename = $this->cacheFolder.'/hopeter1018/doctrine-dynamic-column/'.str_replace('\\', '-', $entityFqcn).md5($entityFqcn);

        $cache = new ConfigCache($filename, $this->debug);
        if (!$cache->isFresh()) {
            $resources = [];
            $reflection = new ReflectionClass($entityFqcn);
            if (file_exists($reflection->getFileName())) {
                $resources[] = new FileResource($reflection->getFileName());
            }

            $rules = $this->getRulesOfEntityClass($metadata);
            if (0 === count($rules) or 0 === count($rules['columns'])) {
                $rules = null;
            } else {
                // dump($rules);
            }

            $cache->write(serialize($rules), $resources);
        }

        return unserialize(file_get_contents($filename));
    }

    public function getRulesOfEntityClass($metadata)
    {
        $entityFqcn = $metadata->reflClass->name;
        $classAnno = $this->annotationReader->getClassAnnotation($metadata->reflClass, Entity::class);

        $rules = [];
        if (1 === count($metadata->getIdentifierFieldNames())) {
            $rules = [
              'id' => [
                'name' => $metadata->getIdentifierFieldNames()[0],
                'type' => $metadata->getFieldMapping($metadata->getIdentifierFieldNames()[0])['type'],
              ],
              'columns' => [],
            ];
            if (null !== $classAnno) {
                foreach ($classAnno->columns as $name => $column) {
                    $fieldName = $column->name ? $column->name : $name;
                    $rules['columns'][$fieldName] = [
                        'entity_class' => $entityFqcn,
                        'column' => $column,
                    ];
                    static::parseRule($rules['columns'][$fieldName]);
                }
            }
            foreach ($metadata->reflClass->getProperties() as $property) {
                $column = $this->annotationReader->getPropertyAnnotation($property, Column::class);
                if (null !== $column) {
                    $fieldName = $column->name ? $column->name : $name;
                    $rules['columns'][$fieldName] = [
                        'entity_class' => $entityFqcn,
                        'column' => $column,
                    ];
                    static::parseRule($rules['columns'][$fieldName]);
                }
            }
        }

        return $rules;
    }

    public static function parseRule(&$rule)
    {
    }
}

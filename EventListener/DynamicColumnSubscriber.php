<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use HoPeter1018\DoctrineDynamicColumnBundle\Annotation\DynamicColumnEntity;
use HoPeter1018\DoctrineDynamicColumnBundle\CacheWarm\MappingCache;
use HoPeter1018\DoctrineDynamicColumnBundle\Repository\DynamicColumnDataRepository;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class DynamicColumnSubscriber implements EventSubscriber
{
    const ANNOTATION_ENTITY = DynamicColumnEntity::class;

    /** @var AnnotationReader */
    protected $annotationReader;

    /** @var PropertyAccessorInterface */
    protected $propertyAccessor;

    /** @var MappingCache */
    protected $mappingCache;

    /** @var DynamicColumnDataRepository */
    protected $dynamicColumnDataRepository;

    public function __construct(AnnotationReader $annotationReader, PropertyAccessorInterface $propertyAccessor, MappingCache $mappingCache, DynamicColumnDataRepository $dynamicColumnDataRepository)
    {
        $this->annotationReader = $annotationReader;
        $this->propertyAccessor = $propertyAccessor;
        $this->mappingCache = $mappingCache;
        $this->dynamicColumnDataRepository = $dynamicColumnDataRepository;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata,
            Events::postLoad,
            // Events::preRemove,
            // Events::postPersist,
            // Events::postUpdate,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        return;
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $rulesByAnno = $this->mappingCache->rules($event->getObjectManager(), get_class($event->getObject()));

        if (null !== $rulesByAnno) {
            $event->getObject()->setDynamicColumnDataRepository($this->dynamicColumnDataRepository);
        }

        return;
    }
}

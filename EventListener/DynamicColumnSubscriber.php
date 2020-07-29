<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\EventListener;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\ManagerRegistry;
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

    /** @var array */
    protected $config;

    /** @var ManagerRegistry */
    protected $managerRegistry;

    /** @var AnnotationReader */
    protected $annotationReader;

    /** @var PropertyAccessorInterface */
    protected $propertyAccessor;

    /** @var MappingCache */
    protected $mappingCache;

    /** @var DynamicColumnDataRepository */
    protected $dynamicColumnDataRepository;

    public function __construct(array $config, ManagerRegistry $managerRegistry, AnnotationReader $annotationReader, PropertyAccessorInterface $propertyAccessor, MappingCache $mappingCache)
    {
        $this->config = $config;
        $this->managerRegistry = $managerRegistry;
        $this->annotationReader = $annotationReader;
        $this->propertyAccessor = $propertyAccessor;
        $this->mappingCache = $mappingCache;
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
            // Create
            Events::postPersist,
            // Read
            Events::postLoad,
            // Update
            Events::postUpdate,
            // Delete
            Events::preRemove,
        ];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        return;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $em = $event->getObjectManager();
        $entityFqcn = get_class($event->getObject());
        $rulesByAnno = $this->mappingCache->load($em->getClassMetadata($entityFqcn));

        if (null !== $rulesByAnno) {
            $event->getObject()
                ->setDynamicColumnAnno($rulesByAnno)
                ->setDynamicColumnDataRepository($this->getDynamicColumnDataRepository())
            ;
            $this->getDynamicColumnDataRepository()->postPersist($em, $event->getObject());
        }
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        $em = $event->getObjectManager();
        $entityFqcn = get_class($event->getObject());
        $rulesByAnno = $this->mappingCache->load($em->getClassMetadata($entityFqcn));

        if (null !== $rulesByAnno) {
            $event->getObject()
                ->setDynamicColumnAnno($rulesByAnno)
            ;
            $this->getDynamicColumnDataRepository()->postUpdate($em, $event->getObject());
        }
    }

    public function preRemove(LifecycleEventArgs $event)
    {
        $em = $event->getObjectManager();
        $entityFqcn = get_class($event->getObject());
        $rulesByAnno = $this->mappingCache->load($em->getClassMetadata($entityFqcn));

        if (null !== $rulesByAnno) {
            $this->getDynamicColumnDataRepository()->preRemove($em, $event->getObject());
        }
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $em = $event->getObjectManager();
        $entityFqcn = get_class($event->getObject());
        $rulesByAnno = $this->mappingCache->load($em->getClassMetadata($entityFqcn));

        if (null !== $rulesByAnno) {
            $event->getObject()
                ->setDynamicColumnAnno($rulesByAnno)
                ->setDynamicColumnDataRepository($this->getDynamicColumnDataRepository())
            ;
        }
    }

    protected function getDynamicColumnDataRepository()
    {
        if (null === $this->dynamicColumnDataRepository) {
            $this->dynamicColumnDataRepository = $this->managerRegistry->getManagerForClass($this->config['class'])->getRepository($this->config['class']);
        }

        return $this->dynamicColumnDataRepository;
    }
}

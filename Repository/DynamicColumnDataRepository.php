<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Repository;

use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Exception;
use HoPeter1018\DoctrineDynamicColumnBundle\Entity\DynamicColumnData;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * - id
 * -
 * - foreignIdInt
 * - foreignIdGuid
 * - foreignIdBinary
 * -
 * - model
 * - field
 * -
 * - dataText
 * - dataString
 * - dataInteger
 * - dataDecimal
 * - dataDatetime
 * - dataBinary.
 */
class DynamicColumnDataRepository extends ServiceEntityRepository
{
    /** @var PropertyAccessorInterface */
    protected $propertyAccessor;

    public function __construct(RegistryInterface $registry, PropertyAccessorInterface $propertyAccessor)
    {
        parent::__construct($registry, DynamicColumnData::class);
        $this->propertyAccessor = $propertyAccessor;
    }

    public function postPersist($em, $entity)
    {
        $model = get_class($entity);
        $anno = $entity->getDynamicColumnAnno();
        $id = $this->propertyAccessor->getValue($entity, $anno['id']['name']);
        $foreignIdFieldName = $this->getForeignIdFieldNameByAnno($anno);

        foreach ($anno['columns'] as $field => $column) {
            $dcd = $this->newInstance($entity, $field);
            $this->propertyAccessor->setValue($dcd, $foreignIdFieldName, $id);
            $dcd->setField($field);
            $value = $entity->getNewDatas()[$field];
            $this->updateDcd($anno, $field, $dcd, $value);
            // switch ($anno['columns'][$field]['column']->type) {
            //     case 'string': $newDcD->setDataString($entity->getNewDatas()[$field]); break;
            //     case 'text': $newDcD->setDataText($entity->getNewDatas()[$field]); break;
            //     case 'integer': $newDcD->setDataInteger($entity->getNewDatas()[$field]); break;
            //     case 'decimal': $newDcD->setDataDecimal($entity->getNewDatas()[$field]); break;
            //     case 'boolean': $newDcD->setDataInteger($entity->getNewDatas()[$field]); break;
            //     case 'date': $newDcD->setDataDatetime($entity->getNewDatas()[$field]); break;
            //     case 'datetime': $newDcD->setDataDatetime($entity->getNewDatas()[$field]); break;
            // }
            $dcd->setCreated(new DateTime());
            $dcd->setUpdated(new DateTime());
            $em->persist($dcd);
        }

        $em->flush();
    }

    public function postUpdate($em, $entity)
    {
        $model = get_class($entity);
        $anno = $entity->getDynamicColumnAnno();
        $id = $this->propertyAccessor->getValue($entity, $anno['id']['name']);
        $foreignIdFieldName = $this->getForeignIdFieldNameByAnno($anno);

        foreach ($anno['columns'] as $field => $column) {
            $dcd = $entity->getDynamicColumnData($field);
            if (null === $dcd) {
                $dcd = $this->newInstance($entity, $field);
                $this->propertyAccessor->setValue($dcd, $foreignIdFieldName, $id);
                $value = $entity->getNewDatas()[$field];
                $this->updateDcd($anno, $field, $dcd, $value);
                $entity->setDynamicColumnData($field, $dcd);
                $dcd->setCreated(new DateTime());
            } else {
                $value = $dcd->getRunTimeData();
                if (null === $this->propertyAccessor->getValue($dcd, $foreignIdFieldName)) {
                    $this->propertyAccessor->setValue($dcd, $foreignIdFieldName, $id);
                }
                if (null === $dcd->getCreated()) {
                    $dcd->setCreated(new DateTime());
                }
                $this->updateDcd($anno, $field, $dcd, $value);
            }
            $dcd->setUpdated(new DateTime());
            $em->persist($dcd);
        }

        $em->flush();
    }

    public function preRemove($em, $entity)
    {
        $model = get_class($entity);
        $anno = $entity->getDynamicColumnAnno();

        $foreignIdFieldName = $this->getForeignIdFieldNameByAnno($anno);

        $qb = $this->createQueryBuilder('dcd');
        $qb
          ->delete()
          ->where("dcd.{$foreignIdFieldName}=:id")
          ->andWhere('dcd.model=:model')
          ->setParameter('model', $model)
          ->setParameter('id', $this->propertyAccessor->getValue($entity, $anno['id']['name']))
          ->getQuery()
          ->execute()
        ;
    }

    public function findAllByEntity($entity)
    {
        $model = get_class($entity);
        $anno = $entity->getDynamicColumnAnno();

        $foreignIdFieldName = $this->getForeignIdFieldNameByAnno($anno);

        $qb = $this->createQueryBuilder('dcd', 'dcd.field');
        $qb
          ->where("dcd.{$foreignIdFieldName}=:id")
          ->andWhere('dcd.model=:model')
          ->setParameter('model', $model)
          ->setParameter('id', $this->propertyAccessor->getValue($entity, $anno['id']['name']))
        ;

        $dbResult = $qb->getQuery()->getResult();
        foreach ($dbResult as $field => $row) {
            switch ($anno['columns'][$field]['column']->type) {
                case 'string': $row->setRunTimeData($row->getDataString()); break;
                case 'text': $row->setRunTimeData($row->getDataText()); break;
                case 'integer': $row->setRunTimeData($row->getDataInteger()); break;
                case 'decimal': $row->setRunTimeData($row->getDataDecimal()); break;
                case 'boolean': $row->setRunTimeData(boolval($row->getDataInteger())); break;
                case 'date': $row->setRunTimeData(($row->getDataDatetime())); break;
                case 'datetime': $row->setRunTimeData(($row->getDataDatetime())); break;
            }
        }

        return $dbResult;
    }

    public function newInstance($model, $field)
    {
        $dcd = new DynamicColumnData();
        $dcd->setModel(get_class($model));
        $dcd->setRunTimeModel($model);
        $dcd->setField($field);

        return $dcd;
    }

    protected function updateDcd($anno, $field, $dcd, $value)
    {
        switch ($anno['columns'][$field]['column']->type) {
            case 'string': $dcd->setDataString($value); break;
            case 'text': $dcd->setDataText($value); break;
            case 'integer': $dcd->setDataInteger($value); break;
            case 'decimal': $dcd->setDataDecimal($value); break;
            case 'boolean': $dcd->setDataInteger($value); break;
            case 'date': $dcd->setDataDatetime($value); break;
            case 'datetime': $dcd->setDataDatetime($value); break;
      }
    }

    protected function getForeignIdFieldNameByAnno($anno)
    {
        $foreignIdFieldName = 'foreignId';
        switch ($anno['id']['type']) {
            case 'integer': $foreignIdFieldName .= 'Int'; break;
            case 'uuid': $foreignIdFieldName .= 'Guid'; break;
            case 'uuid_binary':
            case 'uuid_binary_ordered_time':
                $foreignIdFieldName .= 'Binary';
                break;
            default:
                throw new Exception('Unsupported id type '.$anno['id']['type'].' of model '.$model);
        }

        return $foreignIdFieldName;
    }
}

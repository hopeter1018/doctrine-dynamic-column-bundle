<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\DoctrineDynamicColumnBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Peter Ho <hokwaichi@gmail.com>
 *
 * @ORM\Entity(repositoryClass="HoPeter1018\DoctrineDynamicColumnBundle\Repository\DynamicColumnDataRepository")
 */
class DynamicColumnData
{
    /**
     * @var int
     *
     * @ORM\Column(name="foreign_id_int", type="integer", nullable=true)
     */
    protected $foreignIdInt;

    /**
     * @var string
     *
     * @ORM\Column(name="foreign_id_guid", type="guid", nullable=true)
     */
    protected $foreignIdGuid;

    /**
     * @var mixed
     *
     * @ORM\Column(name="foreign_id_binary", type="binary", nullable=true)
     */
    protected $foreignIdBinary;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=150, nullable=false)
     */
    protected $model;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=90, nullable=false)
     */
    protected $field;

    /**
     * @var string
     *
     * @ORM\Column(name="data_text", type="text", nullable=true)
     */
    protected $dataText;

    /**
     * @var string
     *
     * @ORM\Column(name="data_string", type="string", nullable=true)
     */
    protected $dataString;

    /**
     * @var string
     *
     * @ORM\Column(name="data_decimal", type="decimal", nullable=true)
     */
    protected $dataDecimal;

    /**
     * @var string
     *
     * @ORM\Column(name="data_datetime", type="datetime", nullable=true)
     */
    protected $dataDatetime;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}

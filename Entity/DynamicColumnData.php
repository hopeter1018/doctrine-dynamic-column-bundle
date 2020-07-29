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
 * @ORM\Table(name="dynamic_column_data")
 * @ORM\Entity(repositoryClass="HoPeter1018\DoctrineDynamicColumnBundle\Repository\DynamicColumnDataRepository")
 */
class DynamicColumnData
{
    protected $runTimeData;
    protected $runTimeModel;

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
     * @ORM\Column(name="data_integer", type="integer", nullable=true)
     */
    protected $dataInteger;

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
     * @var string
     *
     * @ORM\Column(name="data_binary", type="binary", nullable=true)
     */
    protected $dataBinary;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * Get id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Foreign Id Int.
     *
     * @return int
     */
    public function getForeignIdInt()
    {
        return $this->foreignIdInt;
    }

    /**
     * Set the value of Foreign Id Int.
     *
     * @param int $foreignIdInt
     *
     * @return self
     */
    public function setForeignIdInt($foreignIdInt)
    {
        $this->foreignIdInt = $foreignIdInt;

        return $this;
    }

    /**
     * Get the value of Foreign Id Guid.
     *
     * @return string
     */
    public function getForeignIdGuid()
    {
        return $this->foreignIdGuid;
    }

    /**
     * Set the value of Foreign Id Guid.
     *
     * @param string $foreignIdGuid
     *
     * @return self
     */
    public function setForeignIdGuid($foreignIdGuid)
    {
        $this->foreignIdGuid = $foreignIdGuid;

        return $this;
    }

    /**
     * Get the value of Foreign Id Binary.
     *
     * @return mixed
     */
    public function getForeignIdBinary()
    {
        return $this->foreignIdBinary;
    }

    /**
     * Set the value of Foreign Id Binary.
     *
     * @param mixed $foreignIdBinary
     *
     * @return self
     */
    public function setForeignIdBinary($foreignIdBinary)
    {
        $this->foreignIdBinary = $foreignIdBinary;

        return $this;
    }

    /**
     * Get the value of Model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of Model.
     *
     * @param string $model
     *
     * @return self
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of Field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the value of Field.
     *
     * @param string $field
     *
     * @return self
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get the value of Data Text.
     *
     * @return string
     */
    public function getDataText()
    {
        return $this->dataText;
    }

    /**
     * Set the value of Data Text.
     *
     * @param string $dataText
     *
     * @return self
     */
    public function setDataText($dataText)
    {
        $this->dataText = $dataText;

        return $this;
    }

    /**
     * Get the value of Data String.
     *
     * @return string
     */
    public function getDataString()
    {
        return $this->dataString;
    }

    /**
     * Set the value of Data String.
     *
     * @param string $dataString
     *
     * @return self
     */
    public function setDataString($dataString)
    {
        $this->dataString = $dataString;

        return $this;
    }

    /**
     * Get the value of Data Integer.
     *
     * @return string
     */
    public function getDataInteger()
    {
        return $this->dataInteger;
    }

    /**
     * Set the value of Data Integer.
     *
     * @param string $dataInteger
     *
     * @return self
     */
    public function setDataInteger($dataInteger)
    {
        $this->dataInteger = $dataInteger;

        return $this;
    }

    /**
     * Get the value of Data Decimal.
     *
     * @return string
     */
    public function getDataDecimal()
    {
        return $this->dataDecimal;
    }

    /**
     * Set the value of Data Decimal.
     *
     * @param string $dataDecimal
     *
     * @return self
     */
    public function setDataDecimal($dataDecimal)
    {
        $this->dataDecimal = $dataDecimal;

        return $this;
    }

    /**
     * Get the value of Data Datetime.
     *
     * @return string
     */
    public function getDataDatetime()
    {
        return $this->dataDatetime;
    }

    /**
     * Set the value of Data Datetime.
     *
     * @param string $dataDatetime
     *
     * @return self
     */
    public function setDataDatetime($dataDatetime)
    {
        $this->dataDatetime = $dataDatetime;

        return $this;
    }

    /**
     * Get the value of Data Binary.
     *
     * @return string
     */
    public function getDataBinary()
    {
        return $this->dataBinary;
    }

    /**
     * Set the value of Data Binary.
     *
     * @param string $dataBinary
     *
     * @return self
     */
    public function setDataBinary($dataBinary)
    {
        $this->dataBinary = $dataBinary;

        return $this;
    }

    /**
     * Get the value of Run Time Data.
     *
     * @return mixed
     */
    public function getRunTimeData()
    {
        return $this->runTimeData;
    }

    /**
     * Set the value of Run Time Data.
     *
     * @param mixed $runTimeData
     *
     * @return self
     */
    public function setRunTimeData($runTimeData)
    {
        $this->runTimeData = $runTimeData;

        return $this;
    }

    /**
     * Get the value of Run Time Model.
     *
     * @return mixed
     */
    public function getRunTimeModel()
    {
        return $this->runTimeModel;
    }

    /**
     * Set the value of Run Time Model.
     *
     * @param mixed $runTimeModel
     *
     * @return self
     */
    public function setRunTimeModel($runTimeModel)
    {
        $this->runTimeModel = $runTimeModel;

        return $this;
    }

    /**
     * Get the value of Created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of Created.
     *
     * @return self
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get the value of Updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of Updated.
     *
     * @return self
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;

        return $this;
    }
}

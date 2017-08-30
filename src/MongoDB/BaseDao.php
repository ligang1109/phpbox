<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/6/19
 * Time: 9:59
 */

namespace Phpbox\MongoDB;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use MongoDB\Collection;

abstract class BaseDao
{
    /**
     * @var Driver
     */
    protected $driver = null;

    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    /**
     * @var Collection
     */
    protected $collection = null;

    abstract protected function getCollectionName();

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function setDriver(Driver $driver)
    {
        $this->driver     = $driver;
        $this->collection = $this->driver->getDb()->selectCollection($this->getCollectionName());

        return $this;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    public function insertOne(array $item, array $options = array())
    {
        return $this->collection->insertOne($item, $options);
    }

    public function insetMany(array $data, array $options = array())
    {
        return $this->collection->insertMany($data, $options);
    }

    public function findOne(array $filter, array $options = array())
    {
        return $this->collection->findOne($filter, $options);
    }

    public function findById($idStr, array $options = array())
    {
        return $this->findOne(array('_id' => Driver::genObjectId($idStr)), $options);
    }

    /**
     * @param array $filter
     * @param array $sort $sort[0] = fieldName, $sort[1] = asc(1|-1) eg: $sort = array('name', 1)
     * @param int $skip
     * @param int $limit
     * @param int $projection fieldName which you want to see, eg: $projection = array('name', 'status')
     * @param array $options
     * @return array
     */
    public function find(array $filter, array $sort = array(), $skip = 0, $limit = 0, array $projection = array(), array $options = array())
    {
        if (!empty($sort)) {
            $field           = $sort[0];
            $asc             = isset($sort[1]) && $sort[1] == -1 ? -1 : 1;
            $options['sort'] = array($field => $asc);
        }
        if ($skip > 0) {
            $options['skip'] = $skip;
        }
        if ($limit > 0) {
            $options['limit'] = $limit;
        }
        if (!empty($projection)) {
            foreach ($projection as $field) {
                $options['projection'][$field] = 1;
            }
        }

        $cursor = $this->collection->find($filter, $options);
        $result = array();
        foreach ($cursor as $item) {
            $result[] = $item;
        }
        return $result;
    }

    public function count(array $filter, $skip = 0, $limit = 0, array $options = array())
    {
        if ($skip > 0) {
            $options['skip'] = $skip;
        }
        if ($limit > 0) {
            $options['limit'] = $limit;
        }

        return $this->collection->count($filter, $options);
    }

    /**
     * @param array $filter
     * @param array $fieldsValues eg: array('name' => 'abc', 'status' => 0)
     * @param array $options
     * @return \MongoDB\UpdateResult
     */
    public function updateMany(array $filter, array $fieldsValues, array $options = array())
    {
        $update['$set'] = $this->fmtUpdateFields($fieldsValues);
        return $this->collection->updateMany($filter, $update, $options);
    }

    public function updateById($idStr, array $fieldsValues, array $options = array())
    {
        $update['$set'] = $this->fmtUpdateFields($fieldsValues);
        return $this->collection->updateOne(array('_id' => Driver::genObjectId($idStr)), $update, $options);
    }

    public function deleteMany(array $filter, array $options = array())
    {
        return $this->collection->deleteMany($filter, $options);
    }

    public function deleteById($idStr, array $options = array())
    {
        return $this->deleteMany(array('_id' => Driver::genObjectId($idStr)), $options);
    }


    private function fmtUpdateFields(array $fieldsValues)
    {
        $result = array();
        foreach ($fieldsValues as $key => $value) {
            $this->fmtUpdateFieldKeyValue($key, $value, $result);
        }

        return $result;
    }

    private function fmtUpdateFieldKeyValue($key, $value, &$result)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $this->fmtUpdateFieldKeyValue($key.'.'.$k, $v, $result);
            }
        } else {
            $result[$key] = $value;
        }
    }
}

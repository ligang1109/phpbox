<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/7/24
 * Time: 18:09
 */

namespace Phpbox\MongoDB;

use PHPUnit\Framework\TestCase;

class MiscDao extends BaseDao
{
    protected function getCollectionName()
    {
        // TODO: Implement getCollectionName() method.
        return 'misc';
    }
}


class MongoDBTest extends TestCase
{
    public function daoProvider()
    {
        $dbConf = array(
            'host' => '127.0.0.1',
            'port' => '27017',
            'name' => 'misc',
            'user' => 'misc',
            'pass' => '123',
        );

        $dao = new MiscDao();

        return array(
            array($dao->setDriver(new Driver($dbConf))),
        );
    }

    public function testGenObjectId()
    {
        $id1 = Driver::genObjectId();
        $id2 = Driver::genObjectId("$id1");

        $this->assertEquals("$id1", "$id2");
    }

    /**
     * @dataProvider daoProvider
     * @param $dao MiscDao
     */
    public function testInsertOneFindOne($dao)
    {
        $item    = array(
            '_id'  => Driver::genObjectId(),
            'name' => 'zhangsan',
        );
        $insertR = $dao->insertOne($item);
        $findR   = $dao->findById($insertR->getInsertedId());
        $this->assertEquals($insertR->getInsertedId(), $findR['_id']);

        $item    = array(
            'name' => 'lisi',
        );
        $insertR = $dao->insertOne($item);
        $findR   = $dao->findById($insertR->getInsertedId());
        $this->assertEquals($insertR->getInsertedId(), $findR['_id']);
    }

    /**
     * @dataProvider daoProvider
     * @param $dao MiscDao
     */
    public function testInsertManyFindMany($dao)
    {
        $id1 = Driver::genObjectId();
        $id2 = Driver::genObjectId();
        $t = time();
        $data = array(
            array(
                '_id'    => $id1,
                'name'   => 'wangwu',
                'sex'    => 'man',
                'status' => 1,
                't' => $t,
            ),
            array(
                '_id'    => $id2,
                'name'   => 'zhaoliu',
                'sex'    => 'man',
                'status' => 1,
                't' => $t,
            ),
        );
        $dao->insetMany($data);

        $filter = array(
            'sex'    => 'man',
            'status' => 1,
            't' => $t,
        );
        $result = $dao->find($filter);

        $this->assertEquals(count($result), 2);
        $this->assertEquals($result[0]['_id'], $id1);
        $this->assertEquals($result[1]['_id'], $id2);
    }

    /**
     * @dataProvider daoProvider
     * @param $dao MiscDao
     */
    public function testUpdate($dao)
    {
        $id = Driver::genObjectId();
        $item = array('_id' => $id, 'name' => 'abc', 'status' => 1);
        $dao->insertOne($item);
        $dao->updateById("$id", array('name' => 'bcd', 'status' => 2));

        $result = $dao->findById("$id");
        $this->assertEquals($result['_id'], $id);

        $t = time();
        $data = array(
            array('name' => 'cde', 'status' => 3, 't' => $t),
            array('name' => 'cde', 'status' => 3, 't' => $t),
            );

        $dao->insetMany($data);
        $dao->updateMany(array('t' => $t, 'status' => 3), array('name' => 'def', 'status' => 4));
        $result = $dao->find(array('t' => $t, 'status' => 4));

        foreach ($result as $item) {
            $this->assertEquals($item['name'], 'def');
            $this->assertEquals($item['status'], 4);
        }
    }

    /**
     * @dataProvider daoProvider
     * @param $dao MiscDao
     */
    public function testDelete($dao)
    {
        $id = Driver::genObjectId();
        $item = array('_id' => $id, 'name' => 'abc', 'status' => 5);
        $dao->insertOne($item);
        $result = $dao->findById("$id");
        $this->assertEquals($result['_id'], $id);

        $dao->deleteById("$id");
        $result = $dao->findById("$id");
        $this->assertEquals(count($result), 0);

        $t = time();
        $data = array(
            array('name' => 'xxx', 'status' => 6, 't' => $t),
            array('name' => 'xxx', 'status' => 6, 't' => $t),
        );

        $dao->insetMany($data);
        $result = $dao->deleteMany(array('status' => 6, 't' => $t));
        $this->assertEquals($result->getDeletedCount(), 2);
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: ligang
 * Date: 2017/6/17
 * Time: 16:08
 */

namespace Phpbox\MongoDB;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\BSON\ObjectID;

class Driver
{
    private $dbConf = array();
    private $uri    = '';

    /**
     * @var Client
     */
    private $client = null;

    /**
     * @var Database
     */
    private $db = null;

    /**
     * New driver
     *
     * @param $dbConf , eg:
     * $dbConf = array(
     * 'host'       => '127.0.0.1',
     * 'user'       => 'root',
     * 'pass'       => '123',
     * 'name'       => 'test',
     * 'port'       => 3306,
     * 'uri_opts'    => array(https://docs.mongodb.com/manual/reference/connection-string/#connections-connection-options),
     * 'driver_opts' => array(https://secure.php.net/manual/kr/mongodb-driver-manager.construct.php),
     * );
     *
     */
    public function __construct(array $dbConf)
    {
        $this->dbConf = $dbConf;

        $this->initUri();
        $this->initDb();
    }

    public static function genObjectId($id = null)
    {
        return new ObjectID($id);
    }

    public static function ObjectIdToString($oid)
    {
        return "$oid";
    }

    /**
     * Get MongoDB Client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getDb()
    {
        return $this->db;
    }

    private function initUri()
    {
        $this->uri = 'mongodb://';
        if (isset($this->dbConf['user']) && isset($this->dbConf['pass'])) {
            $this->uri .= $this->dbConf['user'] . ':' . $this->dbConf['pass'] . '@';
        }

        $this->uri .= $this->dbConf['host'];
        if (isset($this->dbConf['port'])) {
            $this->uri .= ':' . $this->dbConf['port'];
        }

        $this->uri .= '/' . $this->dbConf['name'];
    }

    private function initDb()
    {
        $uriOpts    = isset($this->dbConf['uri_opts']) ? $this->dbConf['uri_opts'] : array();
        $driverOpts = isset($this->dbConf['driver_opts']) ? $this->dbConf['driver_opts'] : array();

        if (!isset($driverOpts['typeMap'])) {
            $driverOpts['typeMap'] = array(
                'root'     => 'array',
                'document' => 'array',
            );
        }

        $this->client = new Client($this->uri, $uriOpts, $driverOpts);
        $this->db     = $this->client->selectDatabase($this->dbConf['name']);
    }
}
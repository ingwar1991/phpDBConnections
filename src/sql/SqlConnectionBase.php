<?php
/**
 * Author: ingwar1991
 */

namespace ingwar1991\DBConnections\sql;

use ingwar1991\DBConnections\ConnectionBase;


abstract class SqlConnectionBase extends ConnectionBase {
    protected $attrDriverPrefix = null;

    protected function getAttrDriverPrefix() {
        if (empty($this->attrDriverPrefix)) {
            throw new \Exception("driverPrefix attr is required for sql connection");
        }

        return $this->attrDriverPrefix;
    }

    /**
     * @param array $dnConnInfo [
     *      REQUIRED
     *      'host': string, 
     *      'user': string, 
     *      'password': string, 
     *      OPTIONAL
     *      'name': string, 
     *      'port': int, 
     *      'ssl-cert': string
     *      'ssl-key': string
     *      'ssl-ca': string
     *  ]
     */
    public function __construct($dbConnInfo) {
        if (empty($dbConnInfo['host'])) {
            throw new \Exception('No database host defined');
        }

        $dsn = "{$this->getAttrDriverPrefix()}:host={$dbConnInfo['host']};";
        if (!empty($dbConnInfo['name'])) {
            $dsn .= "dbname={$dbConnInfo['name']};";
        }
        if (!empty($dbConnInfo['port'])) {
            $dsn .= "port={$dbConnInfo['port']};";
        }
        $dsn .= 'charset=utf8;';

        $options = $this->prepareConnectionForSslCertUsage($dbConnInfo, $dsn); 

        $this->conn = new \PDO(
            $dsn,
            $dbConnInfo['user'],
            $dbConnInfo['password'],
            $options
       );
    }

    /**
     * @param array $dbConnInfo [
     *      OPTIONAL
     *      'ssl-cert': string
     *      'ssl-key': string
     *      'ssl-ca': string
     *  ]
     * @param string $dsn
     *
     * @return array $options
     */
    protected abstract function prepareConnectionForSslCertUsage($dbConnInfo, &$dsn);

    /**
     * @return \PDO
     */
    protected function getConnection() {
        return parent::getConnection(); 
    }

    /**
     * @param $sql
     *
     * @return \PDOStatement
     */
    public function prepare($sql) {
        return parent::prepare($sql);
    }

    /**
     * @param       $sql
     * @param array $params
     *
     * @return \PDOStatement
     */
    public function exec($sql, $params = []) {
        return parent::exec($sql, $params);
    }
}

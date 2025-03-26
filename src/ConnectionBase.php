<?php
/**
 * Author: ingwar1991
 */

namespace ingwar1991\DBConnections;


abstract class ConnectionBase {
    protected $conn;
    protected $logs = [];

    /**
     * @param array $dnConnInfo
     */
    public abstract function __construct($dbConnInfo);

    protected function getConnection() {
        return $this->conn;
    }

    public function prepare($sql) {
        $pdo = $this->getConnection();

        return $pdo->prepare($sql);
    }

    /**
     * @param string $stmt
     * @param array $params
     */
    public function exec($stmt, $params = []) {
        try {
            $startTime = microtime(true);

            $stmt = $this->prepare($stmt);
            $status = $stmt->execute($params);

            $finishTime = microtime(true);
            $this->log($stmt, $params, $finishTime - $startTime, $status);

            return $stmt;
        } catch(\Exception $e) {
            $finishTime = microtime();
            $this->log($stmt, $params, $finishTime - $startTime, false);

            throw $e;
        }
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string $time
     * @param string $status
     */
    protected function log($sql, $params, $time, $status) {
        $this->logs[] = [
            'sql' => $sql,
            'params' => $params,
            'time' => $time,
            'status' => $status,
        ];
    }

    public function getLogs() {
        return $this->logs;
    }
}

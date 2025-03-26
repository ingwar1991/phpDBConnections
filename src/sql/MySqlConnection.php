<?php
/**
 * Author: ingwar1991
 */

namespace ingwar1991\DBConnections\sql;


class MySqlConnection extends SqlConnectionBase {
    protected $attrDriverPrefix = 'mysql';

    protected function prepareConnectionForSslCertUsage($dbConnInfo, &$dsn) {
        $options = [];
        if (!empty($dbConnInfo['ssl-cert'])) {
            $options[\PDO::MYSQL_ATTR_SSL_CERT] = $dbConnInfo['ssl-cert'];
            $options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;

            if (!empty($dbConnInfo['ssl-key'])) {
                $options[\PDO::MYSQL_ATTR_SSL_KEY] = $dbConnInfo['ssl-key'];
            }
            if (!empty($dbConnInfo['ssl-ca'])) {
                $options[\PDO::MYSQL_ATTR_SSL_CA] = $dbConnInfo['ssl-ca'];
            }
        }

        return $options;
    }
}

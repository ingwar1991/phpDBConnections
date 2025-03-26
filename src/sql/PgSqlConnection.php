<?php
/**
 * Author: ingwar1991
 */

namespace ingwar1991\DBConnections\sql;


class PgSqlConnection extends SqlConnectionBase {
    protected $attrDriverPrefix = 'pgsql';

    protected function prepareConnectionForSslCertUsage($dbConnInfo, &$dsn) {
        if (empty($dbConnInfo['ssl-cert'])) {
            return [];
        }

        $dsn .= ";sslmode=require;sslcert={$dbConnInfo['ccl-cert']}";
        if (!empty($dbConnInfo['ssl-key'])) {
            $dsn .= ";sslkey={$dbConnInfo['ssl-key']}";
        }
        if (!empty($dbConnInfo['ssl-ca'])) {
            $dsn .= ";sslrootcert={$dbConnInfo['ssl-ca']}";
        }

        return [];
    }
}

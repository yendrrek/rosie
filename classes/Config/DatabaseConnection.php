<?php

namespace Rosie\Config;

use PDO;
use PDOException;
use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\Logging;

class DatabaseConnection
{
    public function __construct(private Logging $logging)
    {
    }

    public function connectToDb()
    {
        $host = EnvironmentVariables::$host;
        $database = EnvironmentVariables::$database;
        $user = EnvironmentVariables::$user;
        $password = EnvironmentVariables::$password;
        $ownerEmergencyEmail = EnvironmentVariables::$ownerEmergencyEmail;

        $dsn = "mysql:host=$host;dbname=$database;charset=utf8";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        try {
            return new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            $connectionError = new PDOException($e->getMessage(), (int)$e->getCode());
            $this->logging->logMessage('alert', "Problems with connecting to database >> $connectionError");

            return die("Unfortunately, there has been a problem with connecting to the server.
        Please try again later.<br><br>I apologise for any inconvenience.<br><br>
        If you have any query, please contact me at $ownerEmergencyEmail<br><br><i>Rosie Piontek</i>");
        }
    }
}

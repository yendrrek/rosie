<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/EnvironmentVariablesValidation.php';

EnvironmentVariablesValidation::validateDbConnEnvVars();
$host = EnvironmentVariablesValidation::$host;
$database = EnvironmentVariablesValidation::$database;
$user = EnvironmentVariablesValidation::$user;
$password = EnvironmentVariablesValidation::$password;
$ownerEmergencyEmail = EnvironmentVariablesValidation::$ownerEmergencyEmail;

// https://phpdelusions.net/pdo#dsn
$dsn = "mysql:host=$host;dbname=$database;charset=utf8";
$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
    $connectionError = new \PDOException($e->getMessage(), (int)$e->getCode());
    mail('yendrrek@gmail.com', 'Problem with connecting', $connectionError);
    die('Unfortunately, there has been a problem with connecting to the server. Please try again later.<br><br>I apologise for any inconvenience.<br><br>If you have any query, please contact me at ' . $ownerEmergencyEmail . '<br><br><i>Rosie Piontek</i>');
}
<?php

use MyProject\Cli\AbstractCommand;
use MyProject\Exceptions\CliException;

require __DIR__ . '/../vendor/autoload.php';

try {
    unset($argv[0]);

    $className = '\\MyProject\\Cli\\' . array_shift($argv);

    if (!is_subclass_of($className, AbstractCommand::class)) {

        throw new CliException('Class "' . $className . '" not a subclass of AbstractCommand');
    }

    if (!class_exists($className)) {

        throw new CliException('Class "' . $className . '" not found');
    }

    $params = [];

    foreach ($argv as $argument) {

        preg_match('/^-(.+)=(.+)$/', $argument, $matches);

        if (!empty($matches)) {

            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    $class = new $className($params);
    $class->execute();

} catch (CliException $e) {

    echo 'Error: ' . $e->getMessage(); 
} 
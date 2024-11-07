<?php

namespace MyProject\Cli;

class TestCron extends AbstractCommand
{
    protected function checkParams()
    {
        $this->ensureParamExists('x');
        $this->ensureParamExists('y');
    }

    public function execute()
    {
        file_put_contents('/home/maksim/Документы/Проекты/Обучение/blog.com/src/MyProject/Cli/log.txt', date(DATE_ISO8601) . PHP_EOL, FILE_APPEND);
    }
}
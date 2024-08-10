<?php

namespace MyProject\Services;

class Config
{
    
    static function load(string $file): array
    {
        $env = [];

        if (file_exists($file)) {

            $lines = file($file);

            foreach ($lines as $line) {

                if (empty($line) || substr($line, 0, 1) === '#') {

                    continue;
                }

                $parts = explode('=', trim($line));
                $env[$parts[0]] = trim($parts[1] ?? '');
            }
        }
        return $env;
    }
}
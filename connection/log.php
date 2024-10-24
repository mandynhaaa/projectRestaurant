<?php

namespace Connection;
class Log {
    public static function addLog(string $text) : void
    {
        $log = __DIR__ . '/../log/php-error.log';
        $file = fopen($log, "a"); 
        if ($file) {
            fwrite($file, $text . "\n");
            fclose($file);
        } else {
            error_log("Não foi possível abrir o arquivo de log.");
        }
    }
}

?>
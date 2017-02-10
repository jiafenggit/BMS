<?php
/**
 * Created by PhpStorm.
 * User: yatou02
 * Date: 2016/10/25
 * Time: 10:16
 */
namespace App\Tools;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class MyLogger{

    public static function getLogger($name){
        $logger = new Logger($name);
        $date = date('Y_m_d', time());
        $file_name = $name . '_' . $date . '.log';
        $path = storage_path() . '/logs/Fund/' . ($name ? ($name . '/') : '') . $file_name;
        $stream = new StreamHandler($path, Logger::INFO);
        $firephp = new FirePHPHandler();
        $logger->pushHandler($stream);
        $logger->pushHandler($firephp);
        return $logger;
    }
}


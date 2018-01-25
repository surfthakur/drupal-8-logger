<?php

/**
 * @file
 * Drupal\surflogger\LoggerService;
 */

namespace Drupal\surflogger;

use \Psr\Log\LoggerInterface;
use \Monolog\Logger as MonologLogger;
use \Monolog\Handler\StreamHandler as MonologStreamHandler;

class LoggerService implements LoggerInterface {
  
  protected function logger($name = NULL, $logFile = NULL, $useLocking = FALSE){
    
    // Create the file path for the log file
    $logFile or $logFile = ($name ? $name . '/' : '') . date('Y/m/d') . '.log';
    $logFilePrefixed = DRUPAL_ROOT . '/../log/' . $logFile;
    
    // Figure out the log level to use
    $environment = isset($_SERVER['ENV']) ? $_SERVER['ENV'] : 'development';
    $minLevel = $environment == 'development' ? MonologLogger::DEBUG : MonologLogger::ERROR;
    
    // Make sure the directory exists
    if (!is_dir(dirname($logFilePrefixed))) {
      mkdir(dirname($logFilePrefixed), 0777, TRUE);
    }
    
    // Make sure file exists
    if (!is_file($logFilePrefixed)) {
      touch($logFilePrefixed);
      chmod($logFilePrefixed, 0666);
    }
    $logger = new MonologLogger($name);
    return $logger->pushHandler(
      new MonologStreamHandler(
        $logFilePrefixed,
        $minLevel,
        TRUE,
        NULL,
        $useLocking
      )
    );
  }
  
  public function alert(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addAlert($message, $context);
  }
  
  public function critical(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addCritical($message, $context);
  }
  
  public function debug(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addDebug($message, $context);
  }
  
  public function emergency(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addEmergency($message, $context);
  }
  
  public function error(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addError($message, $context);
  }
  
  public function info(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addInfo($message, $context);
  }
  
  public function log(
    $level,
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->log($level, $message, $context);
  }
  
  public function notice(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addNotice($message, $context);
  }
  
  public function warning(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addWarning($message, $context);
  }
}
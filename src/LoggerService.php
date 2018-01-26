<?php

/**
 * @file
 * Logger service
 * Drupal\surflogger\LoggerService;
 */

namespace Drupal\surflogger;

use \Psr\Log\LoggerInterface;
use \Monolog\Logger as MonologLogger;
use \Monolog\Handler\StreamHandler as MonologStreamHandler;

class LoggerService implements LoggerInterface {
  
  /**
   * creates the relevant paths to logs
   *
   * @param null $name
   * @param null $logFile
   * @param bool $useLocking
   *
   * @return $this
   */
  
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
  
  /**
   * displays alert log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function alert(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addAlert($message, $context);
  }
  
  /**
   * displays critical log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function critical(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addCritical($message, $context);
  }
  
  /**
   * displays as debug log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function debug(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addDebug($message, $context);
  }
  
  /**
   * displays as emergency
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function emergency(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addEmergency($message, $context);
  }
  
  /**
   * displays as error logs
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function error(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addError($message, $context);
  }
  
  /**
   * displays info log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function info(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addInfo($message, $context);
  }
  
  /**
   * displays as standard log
   *
   * @param mixed  $level
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function log(
    $level,
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->log($level, $message, $context);
  }
  
  /**
   * displays as notice log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  public function notice(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addNotice($message, $context);
  }
  
  /**
   * displays as warning log
   *
   * @param string $message
   * @param array  $context
   * @param null   $name
   * @param null   $logFile
   */
  
  public function warning(
    $message,
    array $context = [],
    $name = NULL,
    $logFile = NULL
  ){
    $this->logger($name, $logFile)->addWarning($message, $context);
  }
}
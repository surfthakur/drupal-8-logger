# drupal-8-logger

This module over-rides the default drupal loggers with it's own. This is to make the log dir structure a lot more useful. Instead of splitting logs by 'system.log' or 'debug.log' etc. it now does it by date (similar to FuelPHP).

The standard way to log in drupal would be to inject the class \Drupal\surflogger\LoggerService and then use the logging methods such as:

    $this->log->error("Message here", ['array_key' => 'array_value']);

This would add your log message to a file in (for example): DRUPAL_ROOT/log/2017/12/31.log.

The module depends on the following; installing through composer will fetch these libraries if they dont already exist

    "monolog/monolog"
    "psr/log"

There are also two additional parameters that can be passed to all the logging methods. They are explained in more detail below.


# how to use

    use Drupal\surflogger\LoggerService;
    use Symfony\Component\DependencyInjection\ContainerInterface;


create a protected  var

    protected $log;



use di to add to constructor by 

    
    public function __construct(
      .....,
      LoggerService $loggerService
    ){
      ... = ...,
      $this->log = $loggerService;
    }
    
dont forget to add to create     
    
    public static function create(ContainerInterface $container){
      return new static(
        ........,
        $container->get('surf.logger')    
      );
    }

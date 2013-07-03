<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/EmailZF2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EmailZF2;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerPluginConfig()
    {
    	return array(
    		'factories' => array(
    			'mailerZF2' => function ($sm) {
	    			$serviceLocator = $sm->getServiceLocator();
	    			$config = $serviceLocator->get('Configuration');
	    			if (!isset($config['email'])) {
	    				throw new \Exception('Configurazione delle mails non impostata.');
	    			}

	    			$renderer = new \Zend\View\Renderer\PhpRenderer();
	    			$resolver = new \Zend\View\Resolver\TemplatePathStack();
	    			$resolver->setPaths(array(
	    				__DIR__ . '/../'
	    			));
	    			$renderer->setResolver($resolver);
	    			$controllerPlugin = new Controller\Plugin\Mailer($renderer);

	    			$mail = $config['email']['credentials']['from_mail'];
	    			$name = $config['email']['credentials']['from_name'];
	    			$controllerPlugin->setFrom($mail, $name);

	    			switch ($config['email']['transport'])
	    			{
	    				case 'smtp':
	    					$transport = new \Zend\Mail\Transport\Smtp();
	    					$options = new \Zend\Mail\Transport\SmtpOptions(array(
	    						'host'              => $config['email']['smtp']['host'],
	    						'port'              => $config['email']['smtp']['port'],
	    						'connection_class'  => $config['email']['smtp']['connection_class'],
	    						'connection_config' => $config['email']['smtp']['connection_config'],
	    					));
	    					$transport->setOptions($options);
	    					$controllerPlugin->setMailTransport($transport);
	    				break;

	    				case 'sentmail':
	    					default:
	    						$transport = new \Zend\Mail\Transport\Sendmail();
	    						$controllerPlugin->setMailTransport($transport);
	    				break;
	    			}
	    			return $controllerPlugin;
    			},
    		),
    	);
    }
}

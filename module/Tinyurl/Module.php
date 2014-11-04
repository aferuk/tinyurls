<?php
namespace Tinyurl;
 
use Tinyurl\Model\Tinyurl;
use Tinyurl\Model\TinyurlTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
 
class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
 
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
	public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'TinyurlModelTinyurlTable' =>  function($sm) {
                    $tableGateway = $sm->get('TinyurlTableGateway');
                    $table = new TinyurlTable($tableGateway);
                    return $table;
                },
                'TinyurlTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Tinyurl());
                    return new TableGateway('tinyurl', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
	
}
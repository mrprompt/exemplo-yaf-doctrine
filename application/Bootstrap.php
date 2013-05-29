<?php
class Bootstrap extends \Yaf\Bootstrap_Abstract
{
    /**
     *
     * @var \Yaf\Config\Ini
     */
    protected $_config;

    /**
     * Load config file
     */
    protected function _initConfig()
    {
        $config = \Yaf\Application::app()->getConfig();

        \Yaf\Registry::set("Config", $config);

        $this->_config = $config;
    }

    /*
    * initIncludePath is only required because zend components have a shit load of
    * include_once calls everywhere. Other libraries could probably just use
    * the autoloader (see _initNamespaces below).
    */
    protected function _initIncludePath()
    {
        // Ensure library/ is on include_path
        set_include_path(
            implode(
                PATH_SEPARATOR,
                array(
                    $this->_config->application->library,
                    get_include_path(),
                )
            )
        );
    }

    /**
     * Init namespaces
     */
    protected function _initNamespaces()
    {
        $namespaces = $this->_config->application->namespaces->toArray();

        \Yaf\Loader::getInstance()->registerLocalNameSpace($namespaces);
    }

    /**
     * @param \Yaf\Dispatcher $dispatcher
     * @return \Yaf\Router
     */
    protected function _initRoute(\Yaf\Dispatcher $dispatcher)
    {
        if (\Yaf\Registry::get("Config")->routes) {
            $router = $dispatcher->getRouter();
            $router->addConfig(\Yaf\Registry::get("Config")->routes);

            return $router;
        }
    }

    /**
     * Init Session Register
     *
     */
    protected function _initSession()
    {
        $session = \Yaf\Session::getInstance();

        \Yaf\Registry::set('Session', $session);
    }

    /**
     *
     * @param \Yaf\Dispatcher $dispatcher
     */
    protected function _initLayout(\Yaf\Dispatcher $dispatcher)
    {
        /*
         * layout allows boilerplate HTML to live in
         * /layouts/scripts rather than every script
         */
        $layout = new LayoutPlugin(
            $this->_config->layout->file,
            $this->_config->layout->dir
        );

        /* Store a reference in the registry so values can be set later.
         *
         * This is a hack to make up for the lack of a getPlugin
         * method in the dispatcher.
         */
        \Yaf\Registry::set('Layout', $layout);

        /*add the plugin to the dispatcher*/
        $dispatcher->registerPlugin($layout);
    }

    /**
     * Init Doctrine
     *
     */
    protected function _initDoctrine()
    {
        $classLoader = new Doctrine\Common\ClassLoader('Doctrine');
        $classLoader->register();

        $classLoader = new Doctrine\Common\ClassLoader('Symfony');
        $classLoader->register();

        $cache = new Doctrine\Common\Cache\ArrayCache;

        $config = new Doctrine\ORM\Configuration;
        $config->setMetadataCacheImpl($cache);

        $path       = APPLICATION_PATH . '/entities/metadata';
        $driverImpl = new Doctrine\ORM\Mapping\Driver\YamlDriver($path);;

        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(sys_get_temp_dir());
        $config->setAutoGenerateProxyClasses(true);

        // database configuration parameters
        $connOptions = $this->_config->db->toArray();
        $conn = array(
            'driver'    => $connOptions['adapter'],
            'host'      => $connOptions['params']['host'],
            'user'      => $connOptions['params']['user'],
            'password'  => $connOptions['params']['password'],
            'dbname'    => $connOptions['params']['dbname']
        );

        // obtaining the entity manager
        $entityManager = \Doctrine\ORM\EntityManager::create($conn, $config);

        \Yaf\Registry::set('EntityManager', $entityManager);
    }
}

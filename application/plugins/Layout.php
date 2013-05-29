<?php
/**
 * Plugin para utilizar templates na aplicação
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use \Yaf\Response_Abstract as Response,
    \Yaf\Request_Abstract as Request;

class LayoutPlugin extends \Yaf\Plugin_Abstract
{
    /**
     * Diretório com os layouts
     *
     * @var string
     */
    private $_layoutDir;

    /**
     * Arquivo de template a ser utilizado
     *
     * @var string
     */
    private $_layoutFile;

    /**
     * Variáveis do template
     *
     * @var array
     */
    private $_layoutVars = array();

    /**
     * Construtor
     *
     * @param string $layoutFile
     * @param string $layoutDir
     */
    public function __construct($layoutFile, $layoutDir)
    {
        $this->_layoutFile = $layoutFile;
        $this->_layoutDir  = $layoutDir;
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_layoutVars[$name] = $value;
    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function dispatchLoopShutdown(Request $request, Response $response)
    {

    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function dispatchLoopStartup(Request $request, Response $response)
    {

    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function postDispatch(Request $request, Response $response)
    {
        /* get the body of the response */
        $body = $response->getBody();

        /*clear existing response*/
        $response->clearBody();

        /* wrap it in the layout */
        $layout = new \Yaf\View\Simple($this->_layoutDir);
        $layout->content = $body;
        $layout->assign('layout', $this->_layoutVars);

        /* set the response to use the wrapped version of the content */
        $response->setBody($layout->render($this->_layoutFile));
    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function preDispatch(Request $request, Response $response)
    {

    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function preResponse(Request $request, Response $response)
    {

    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerShutdown(Request $request, Response $response)
    {

    }

    /**
     *
     * @param \Yaf\Request_Abstract $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerStartup(Request $request, Response $response)
    {

    }
}

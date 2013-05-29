<?php
/**
 * Index controller module
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @since  2012-07-30
 */
class IndexController extends \Yaf\Controller_Abstract
{
    /**
     *
     * @var \Yaf\Session
     */
    protected $_session;

    /**
     * Construtor
     *
     */
    public function init()
    {
        $this->_session = \Yaf\Registry::get('Session');
    }

    /**
     * Default action
     *
     */
    public function indexAction()
    {

    }
}
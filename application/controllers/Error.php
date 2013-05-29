<?php
/**
 * Error controller module
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 * @since  2012-07-30
 */
class ErrorController extends \Yaf\Controller_Abstract
{
     /**
      * you can also call to Yaf_Request_Abstract::getException to get the
      * un-caught exception.
      */
    public function errorAction($exception)
    {
        /* error occurs */
        switch ($exception->getCode()) {
            case \YAF\ERR\NOTFOUND\MODULE:
            case \YAF\ERR\NOTFOUND\CONTROLLER:
            case \YAF\ERR\NOTFOUND\ACTION:
            case \YAF\ERR\NOTFOUND\VIEW:
                $this->_view->error = 404 . ":" . $exception->getMessage();
                break;

            default :
                $this->_view->error = $exception->getMessage();
                break;
        }
    }
}
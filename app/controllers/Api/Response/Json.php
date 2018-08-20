<?php
namespace DS\Controller\Api\Response;

use DS\Constants\Services;
use DS\Controller\Api\Meta\Envelope;
use DS\Controller\Api\Meta\EnvelopeV2;
use DS\Controller\Api\Meta\Error;
use DS\Controller\Api\Meta\ErrorV2;
use DS\Controller\Api\Meta\RecordInterface;
use DS\Controller\Api\Response;
use Phalcon\Http\Request;
use Phalcon\Mvc\Router;

/**
 *
 * Spreadshare
 *
 * @author Dennis Stücken
 * @license proprietary

 * @copyright Spreadshare
 * @link https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class Json extends Response
{
    /**
     * Set content type to application json
     */
    protected function setResponseType()
    {
        $this->response->setContentType('application/json');
    }

    /**
     * @param RecordInterface $records
     * @param bool            $error
     *
     * @return RecordInterface|Envelope|EnvelopeV2
     */
    private function prepare(RecordInterface $records = null, $error = false)
    {
        /**
         * @var Request $request
         */
        $request = $this->getDI()->get(Services::REQUEST);
        $this->envelope = $request->get('envelope', null, true) ? true : false;
        if ($this->envelope) {
            /** @var Router $router */
            $router = $this->getDI()->get('router');
            return strpos($router->getRewriteUri(), 'v1') !== false ?
                new Envelope($records, !$error) : new EnvelopeV2($records, !$error);
        }

        return $records;
    }

    /**
     * @param Error $error
     *
     * @return $this
     */
    public function setError(Error $error)
    {
        $this->error = $error;

        /** @var Router $router */
        $router =$this->getDI()->get('router');
        if (strpos($router->getRewriteUri(), 'v1') !== false) {
            // old-style
            $this->response->setJsonContent($error);
        } else {
            // new-style
            $this->response->setJsonContent(new ErrorV2($error));
        }

        return $this;
    }

    /**
     * @param RecordInterface $records
     * @param bool            $error
     *
     * @return $this
     */
    public function set(RecordInterface $records = null, $error = false)
    {
        // Prepare response content
        $envelope = $this->prepare($records, $error);

        // Set Json content
        $this->response->setJsonContent($envelope);

        return $this;
    }
}

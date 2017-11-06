<?php
namespace DS\Controller\Api\Response;

use DS\Constants\Services;
use DS\Controller\Api\Meta\Envelope;
use DS\Controller\Api\Meta\Error;
use DS\Controller\Api\Meta\RecordInterface;
use DS\Controller\Api\Response;
use Phalcon\Http\Request;

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
     * @return RecordInterface|Envelope
     */
    private function prepare(RecordInterface $records = null, $error = false)
    {
        /**
         * @var Request $request
         */
        $request = $this->getDI()->get(Services::REQUEST);

        if (!$request->get('envelope', null, true))
        {
            $this->envelope = false;
        }

        if ($this->envelope)
        {
            return new Envelope($records, !$error);
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

        $this->response->setJsonContent($error);

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
        // Preparing response content
        $content = $this->prepare($records, $error);

        // Set Json content
        $this->response->setJsonContent($content);

        return $this;
    }
}

<?php
namespace DS\Controller\Api\Meta;

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
final class Envelope implements \JsonSerializable
{
    /**
     * @var MetaObject
     */
    public $_meta;

    /**
     * @var RecordInterface
     */
    public $data = null;

    public $success;

    /**
     * Json serializer
     */
    function jsonSerialize()
    {
        return [
            '_meta' => $this->_meta,
            'data' => $this->data,
            'success' => $this->success, //I'm so sorry about this, but we needed to get a new response format
            'result' => $this->data,     //and we needed to ship in an impossible amount of time
        ];
    }

    /**
     * Envelope constructor.
     *
     * @param RecordInterface $records
     * @param bool         $success
     */
    public function __construct(RecordInterface $records = null, $success = true)
    {
        $this->success = $success;
        $status = ($success) ? 'SUCCESS' : 'ERROR';
        if ($records !== null)
        {
            $count = $records->count();

            $this->_meta = new MetaObject(
                $status,
                $count,
                $success
            );
        }
        else
        {
            $this->_meta = new MetaObject(
                $status,
                0,
                $success
            );
        }

        if ($records)
        {
            $this->data = $records->getData();
        }

        /*
        if ($this->_meta->count === 0)
        {
            // This is required to make the response JSON return an empty JS object.  Without
            // this, the JSON return an empty array:  [] instead of {}
            $this->data = new \stdClass();
        }
        else
        {
            $this->data = $records;
        }
        */
    }
}

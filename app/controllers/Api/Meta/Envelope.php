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

    /**
     * @var bool
     */
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
        $status = $success ? 'SUCCESS' : 'ERROR';
        $this->_meta = new MetaObject(
            $status,
            $records === null ? 0 : $records->count(),
            $success
        );

        if ($records) {
            $this->data = $records->getData();
        }
    }
}

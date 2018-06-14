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
final class EnvelopeV2 implements \JsonSerializable
{
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
            'success' => $this->success,
            'result' => $this->data,
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

        if ($records)
        {
            $this->data = $records->getData();
        }
    }
}

<?php

namespace DS\Api;

use DS\Model\DataSource\TableFlags;
use DS\Model\Tables;
use Phalcon\Exception;

/**
 * Spreadshare
 *
 * General Users Api
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class Table
    extends BaseApi
{
    
    /**
     * Creates a new table.
     *
     * @param int    $ownerUserId
     * @param string $title
     * @param string $tagline
     * @param string $image
     * @param int    $typeId
     * @param int    $topic1Id
     * @param int    $topic2Id
     * @param array  $tags
     * @param int    $flags
     *
     * @return Tables|static
     * @throws Exception
     */
    public function createTable(
        int $ownerUserId,
        string $title,
        string $tagline,
        string $image,
        int $typeId = null,
        int $topic1Id = null,
        int $topic2Id = null,
        array $tags = [],
        int $flags = TableFlags::Normal
    ) {
        $table = Tables::findByFieldValue('title', $title);
        
        if ($table)
        {
            throw new \InvalidArgumentException('A table with the exact same title already exists. Please choose another title');
        }
        
        $table = new Tables();
        $table->setOwnerUserId($ownerUserId)
              ->setTitle($title)
              ->setTagline($tagline)
              ->setTypeId($typeId)
              ->setImage($image)
              ->setTopic1Id($topic1Id)
              ->setTopic2Id($topic2Id)
              ->setFlags($flags)
              ->create();
        
        if (!$table->getId())
        {
            throw new Exception('There was an error creating the table. Please try again later or contact our support.');
        }
        
        return $table;
    }
}
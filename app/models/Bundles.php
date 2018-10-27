<?php

namespace DS\Model;

use DS\Model\Events\BundlesEvents;

/**
 * Tables
 *
 * @author    Vladislav Klimenko
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static self findFirstById(int $id)
 */
class Bundles extends BundlesEvents
{
    /**
     * @param null $columns
     * @return array
     */
    public function toArray($columns = null)
    {
        $append = [];
        if (is_array($columns) && in_array('tags', $columns)) {
            // tags are requested
            $tags = [];
            foreach ($this->bundleTags as $bundleTag) {
                $tags[] = [
                    'id'    => $bundleTag->tags->id,
                    'title' => $bundleTag->tags->title,
                ];
            }
            unset($columns['tags']);
            $append = ['tags' => $tags];
        }
        return array_merge(parent::toArray($columns), $append);
    }

    /**
     * @return array
     */
    public function getTagsIds()
    {
        $ids = [];
        foreach ($this->bundleTags as $bundleTag) {
            $ids[] = $bundleTag->tagId;
        }
        return $ids;
    }
}

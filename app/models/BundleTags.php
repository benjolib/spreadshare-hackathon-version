<?php

namespace DS\Model;

use DS\Model\Events\BundleTagsEvents;

/**
 * TableLocations
 *
 * @author    Vladislav Klimenko
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 *
 * @method static findFirstById(int $id)
 */
class BundleTags extends BundleTagsEvents
{
    /**
     * Assign new set of tags to a bundle
     *
     * @param array $tagIds
     *
     * @return $this
     */
    public function assignTags($tagIds): BundleTags
    {
        // Remove all tags for this bundle
        $this->getWriteConnection()->delete($this->getSource(), "bundleId = '{$this->bundleId}'");

        // Assign new tags
        if (is_array($tagIds)) {
            foreach ($tagIds as $id) {
                (new self())->setBundleId($this->bundleId)->setTagId($id)->create();
            }
        }

        return $this;
    }
}

<?php

namespace DS\Model\Helper;

/**
 * Spreadshare
 *
 * Table Filter Model
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Model
 */
class ChangeRequestsFilter
{
    const ONLY_ALL = '';
    const ONLY_NEW = 'new';
    const ONLY_EDITS = 'edits';
    const ONLY_DELETES = 'deletes';
    const ONLY_CONFIRMED = 'confirmed';
    const ONLY_REJECTED = 'rejected';
    
    /**
     * @var string
     */
    private $showOnly = self::ONLY_ALL;
    
    /**
     * @return string
     */
    public function getShowOnly(): string
    {
        return $this->showOnly;
    }
    
    /**
     * @param string $showOnly
     *
     * @return $this
     */
    public function setShowOnly($showOnly)
    {
        $this->showOnly = $showOnly;
        
        return $this;
    }
    
    
}

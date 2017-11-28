<?php

namespace DS\Controller;

use DS\Api\TableContent;
use DS\Application;
use League\Csv\Writer;
use Phalcon\Exception;
use Phalcon\Logger;
use Phalcon\Utils\Slug;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller
 */
class TableDownloadController
    extends BaseController
{
    /**
     * Spreadshare
     */
    public function indexAction(string $tableId, string $format = 'csv')
    {
        try
        {
            $tableContent = new TableContent();
            $tableData    = $tableContent->getTableData($tableId, $this->serviceManager->getAuth()->getUserId());
            
            if (method_exists($this, $format))
            {
                $this->$format($tableData);
            }
        }
        catch (Exception $e)
        {
            Application::instance()->log($e->getMessage(), Logger::CRITICAL);
        }
    }
    
    private function csv(array $tableData)
    {
        if (isset($tableData['rows']))
        {
            $csvWriter = Writer::createFromString('');
            
            foreach ($tableData['rows'] as $row)
            {
                $csvRow = [];
                foreach ($row['content'] as $cell)
                {
                    if ($cell['link'])
                    {
                        $csvRow[] = $cell['content'] . ' (' . $cell['link'] . ')';
                    }
                    else
                    {
                        $csvRow[] = $cell['content'];
                    }
                }
                
                $csvWriter->insertOne($csvRow);
            }
            
            $this->response->setContent($csvWriter->getContent())
                           ->setContentType('text/csv; charset=UTF-8')
                           ->setHeader('Content-Disposition', 'attachment; filename="spreadshare-table-' . Slug::generate($tableData['table']['title']) . '.csv"')
                           ->setHeader('Content-Description', 'Spreadshare Csv Download')
                           ->setHeader('Content-Encoding', 'none')
                           ->send();
            die;
        }
    }
}

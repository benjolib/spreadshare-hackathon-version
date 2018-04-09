<?php

namespace DS\Controller\AddTable\ChooseTable;

use DS\Api\TableContent;
use DS\Controller\BaseController;
use DS\Events\Table\TableDataImported;
use DS\Interfaces\TableSubcontrollerInterface;
use DS\Model\Tables;
use Phalcon\Exception;

/**
 * Spreadshare
 *
 * @author    Dennis Stücken
 * @license   proprietary
 * @copyright Spreadshare
 * @link      https://www.spreadshare.co
 *
 * @version   $Version$
 * @package   DS\Controller\User
 */
class CsvImport extends BaseController implements TableSubcontrollerInterface
{

    /**
     * Handle Subcontroller
     *
     * @param Tables $table
     *
     * @return $this
     */
    public function handle(Tables $table, int $userId, string $tab, string $param)
    {
        try {
            if ($table->getOwnerUserId() != $userId) {
                throw new Exception('Not allowed - You are not allowed to post data to this table!');
            }

            $this->view->setVar('content', 'table/add/csv-import');
            $this->view->setVar('content_js', 'table/add/csv-import.js');
            $this->view->setVar('action', '/table/add/choose/csv-import');
            $this->view->setVar('tab', 'choose-table');
            $this->view->setVar('tableId', $this->request->get('tableId'));

            try {
                if ($this->request->isPost()) {
                    if (!$this->request->hasFiles(true)) {
                        throw new \InvalidArgumentException('Invalid file - Please upload a valid csv file.');
                    }

                    $csvText = '';
                    $files   = $this->request->getUploadedFiles(true);
                    foreach ($files as $file) {
                        $csvText = file_get_contents($file->getTempName());
                    }

                    if (!$csvText) {
                        throw new \InvalidArgumentException('Empty file - The csv file you selected is empty.');
                    } else {
                        $tableId = $this->request->getPost('tableId');

                        $tableContentApi = new TableContent();
                        $tableContentApi->addfromCsvText($tableId, $csvText, ',', !!$this->request->getPost('csvFileHasHeaders'));

                        // Fire event
                        TableDataImported::after($userId, $table);

                        header('Location: /table/add/confirm?tableId=' . $tableId);
                    }
                }
            } catch (\Exception $e) {
                $this->flash->error($e->getMessage());
                $this->view->setVar('nextstep', 1);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }
}

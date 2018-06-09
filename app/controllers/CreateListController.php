<?php

namespace DS\Controller;

use DS\Interfaces\LoginAwareController;

class CreateListController extends BaseController implements LoginAwareController
{
    public function needsLogin()
    {
        return true;
    }

    public function indexAction()
    {
        if ($this->request->isPost()) {
            if ($this->request->get('step') == '2') {
                var_dump($this->request->getPost());die();

            } else {
                $this->view->setVar('post', $this->request->getPost());
                if ($this->request->has('image')) {
                    //TREAT TEMPORARY IMAGE. How to show in the client?
                }
                if ($this->request->has('file')) {
                    // LOAD CSV FROM FILE
                } else {
                    $csv = $this->request->get('copy');
                    // LOAD CSV FROM POST PARAM
                }
                $newlineSeparator = "\r\n";
                $lineSeparator = $this->request->get('seperator');
                $tableColumns = explode($lineSeparator, strtok($csv, $newlineSeparator));
                $this->view->setVar('tableColumns', $tableColumns);
                $table['id'] = '';
                $this->view->setVar('table', $table);

                $line = strtok($newlineSeparator);
                $tableContent = [];
                while($line !== false) {
                    $tableContent[] = explode($lineSeparator, $line);
                    $line = strtok($newlineSeparator);
                }
                $this->view->setVar('tableContent', $tableContent);


                // TREAT CSV


                /*
                 *
                 *name, tagline, description, tags, thumbnails, curators, related-lists, copy, seperator
                 */
            }
        }
        
        
        $this->view->setMainView('create-list/index');

        $user = $this->serviceManager->getAuth()->getUser();

        $this->view->setVar('editing', true);
    }
}

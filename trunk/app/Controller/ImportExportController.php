<?php

class ImportExportController extends AppController {

	public $name = 'ImportExport';
	public $uses = null;
        public $helpers = array('Html','Admin');

	public function admin ($ajax = false)
	{
            //Все связанные с контентом таблицы
            $tmp_table_name = array();
            $this->loadModel('Content');
            $this->Content->Behaviors->attach('Containable');
            $contents = $this->Content->find('first',array('contain' => array('ContentType','ContentDescription','ContentImage','ContentProduct','ContentNews')));	
            foreach ($contents AS $k_c => $content)
            {
                $myModelname = $k_c;
                App::import('Model', $myModelname);
                $this->myModel = new $myModelname();
                $tmp_table_name[$k_c ] = $this->myModel->getColumnTypes();
            }

            $this->Session->write('import_export.table_name', $tmp_table_name);
            $this->set('table_names', $tmp_table_name);
            
            $this->set('current_crumb', __('Import/Export', true));
            $this->set('title_for_layout', __('Import/Export', true));
	}

	public function import ()
	{
            if (isset($this->data['form_Import']['submittedfile'])
			&& $this->data['form_Import']['submittedfile']['error'] == 0
			&& is_uploaded_file($this->data['form_Import']['submittedfile']['tmp_name'])) 
            {
                $tmp_table_name = $this->Session->read('import_export.table_name');
                $file_name = $this->data['form_Import']['submittedfile']['name'];
                @unlink('./files/' . $file_name); 
                move_uploaded_file($this->data['form_Import']['submittedfile']['tmp_name'], './files/' . $file_name);
                $f_inf = pathinfo($file_name);
                if($f_inf['extension'] == 'zip')
                {
                    $zip = new ZipArchive();
                    $res = $zip->open('./files/' . $file_name);
                    if ($res === TRUE) 
                    {
                        $zip->extractTo('./files/','vc_content.xls');
                        $zip->close();
                        @unlink('./files/' . $file_name); 
                    }
                    else 
                    {
                        $this->Session->setFlash(__('Error extracting.',true));
                        $this->redirect('/import_export/admin');  
                    }
                }

                App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
                try {
                $xls = PHPExcel_IOFactory::load('./files/' . 'vc_content.xls');
                } catch (Exception $e) {
                die("Error loading file: ".$e->getMessage() . "<br />\n");
                }
                $worksheetIterator = $xls->getWorksheetIterator();
                foreach($worksheetIterator as $worksheet_name => $worksheet)
                {
                    $table_name = $worksheet->getTitle();
                    if(isset($tmp_table_name[$table_name]))
                    {
                        $rowIterator = $worksheet->getRowIterator();
                        $rowIterator->resetStart();
                        $cellIterator = $rowIterator->current()->getCellIterator();
                        foreach($cellIterator as $k_cell => $cell)
                        {
                            $tmp_head[$k_cell] = $cell->getValue();
                        }
                        $rowIterator->resetStart(2);
                        foreach($rowIterator as $k_row => $row)
                        {
                            $cellIterator = $row->getCellIterator();
                            foreach($cellIterator as $k_cell => $cell)
                            {
                                $tmp_row[$tmp_head[$k_cell]] = $cell->getValue();
                            }
                            $tmp[$table_name][$k_row - 2][$table_name] = $tmp_row;
                        }
                        App::import('Model', $table_name);
                        $this->myModel = new $table_name();
                        foreach($tmp[$table_name] AS $table_row)
                        {
                            $this->myModel->save($table_row);
                        }
                    }
                }

                $this->Session->setFlash(__('Import sucess!', true));
                $this->redirect('/import_export/admin');
            }
            die();
        }
        
        public function export ()
	{
            App::import('Vendor', 'PHPExcel/Classes/PHPExcel');
            if (!class_exists('PHPExcel')) 
            {
		throw new CakeException('Vendor class PHPExcel not found!');
            }
            $sfx = rand();
            $zip = new ZipArchive();
            $res = $zip->open('./files/vc_content' . $sfx . '.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
            if ($res === TRUE) 
            {            
                $xls = new PHPExcel();
                $xls->removeSheetByIndex(0);
                $index = 0;
                $tmp_table_name = $this->Session->read('import_export.table_name');
                foreach ($tmp_table_name AS $k_name_table => $fields)
                {
                    if($this->data['form_Export'][$k_name_table] == 1)
                    {
                        $myWorkSheet = new PHPExcel_Worksheet($xls, $k_name_table);
                        $myModelname = $k_name_table;
                        App::import('Model', $myModelname);
                        $this->myModel = new $myModelname();
                        $this->myModel->unbindAll();
                        $rows = $this->myModel->find('all');
                        $k_cell = 0;
                        foreach ($fields AS $field_name => $field_type)
                        {
                                $myWorkSheet->setCellValueByColumnAndRow($k_cell++, 1, $field_name);    
                        }
                        foreach ($rows AS $num_row => $row)
                        {
                            $k_cell = 0;
                            foreach ($row[$k_name_table] AS $field_name => $field_value)
                            {
                                $myWorkSheet->setCellValueByColumnAndRow($k_cell++, $num_row + 2, $field_value);    
                            }
                        }
                        $xls->addSheet($myWorkSheet, $index);
                        $xls->setActiveSheetIndex($index++);
                    }
                }
    
                $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');//new PHPExcel_Writer_Excel5($xls);
                $objWriter->save('./files/vc_content' . $sfx . '.xls');
                $xls->disconnectWorksheets();                
                $zip->addFile('./files/vc_content' . $sfx . '.xls','vc_content.xls');
                $zip->close();                
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="vc_content.zip"');
                readfile('./files/vc_content' . $sfx . '.zip');
                @unlink('./files/vc_content' . $sfx . '.zip');
                @unlink('./files/vc_content' . $sfx . '.xls');
                /*$this->Session->setFlash(__('Export sucess!', true));
                $this->redirect('/import_export/admin');*/
            }
            else {}            
            die();          
        }
        
}

?>
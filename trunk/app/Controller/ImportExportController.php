<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

class ImportExportController extends AppController {

	public $name = 'ImportExport';
	public $uses = null;
        public $helpers = array('Html','Admin');
        public $contain_table = array('ContentDescription' => null/*<-эта модель обязательна*/,'ContentType','ContentCategory','ContentImage','ContentProduct','ContentNews','ContentArticle','Attribute');

	public function admin ($ajax = false)
	{
            //Все связанные с контентом таблицы
            $tmp_table_name = array();
            $this->loadModel('Content');
            $this->Content->Behaviors->attach('Containable');
            $this->contain_table['ContentDescription'] = array('conditions' => array('ContentDescription.language_id' => $this->Session->read('Customer.language_id')));    
            $contents = $this->Content->find('all',array('contain' => $this->contain_table 
                                                        ,'conditions' => array('Content.content_type_id = 1')));
            //$hasMany = $this->Content->hasMany;

            foreach ($contents[0] AS $k_c => $content)
            {
                $myModelname = $k_c;
                App::import('Model', $myModelname);
                $this->myModel = new $myModelname();
                $tmp_table_name[$k_c ] = array();//['fields'] = $this->myModel->getColumnTypes();

            }
            $tmp_table_name['Content']['export_id'] = array_unique(Set::extract($contents, '/Content/id'));
            
            $sel_content = Set::combine($contents,'{n}.Content.id', '{n}.ContentDescription.{n}.name');
            $this->set('sel_content', $sel_content);
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
                        $zip->extractTo('./files/','content.xls');
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
                $xls = PHPExcel_IOFactory::load('./files/' . 'content.xls');
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
                        
                        if(method_exists($this->myModel,'import'))$rows = $this->myModel->import($tmp[$table_name]);
                        else
                            foreach($tmp[$table_name] AS $table_row)
                            {
                                $this->myModel->save($table_row);
                            }
                    }
                }

                $this->Session->setFlash(__('Import suсcess!', true));
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
            $tmp_table_name = $this->Session->read('import_export.table_name');

            if($this->data['sel_content'] != 0)
            {
                $tmp_table_name['Content']['export_id'] = $this->data['form_Export']['sel_content'];
            }
            
            $this->loadModel('Content');
            $this->Content->Behaviors->attach('Containable');
            $this->contain_table['ContentDescription'] = array('conditions' => array('1 = 1'));
            $contents = $this->Content->find('all',array('contain' => $this->contain_table
                                                        ,'conditions' => array('OR' => array(array('Content.parent_id' => $tmp_table_name['Content']['export_id']), array('Content.id' => $tmp_table_name['Content']['export_id'])))
                                                        ));    

            foreach ($contents[0] AS $k_c => $content)
            {
                $tmp_table_name[$k_c ]['export_id'] = array_unique(Set::extract($contents, '/' . $k_c . '/id'));
            }

            $sfx = rand();
            $zip = new ZipArchive();
            $res = $zip->open('./files/content' . $sfx . '.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
            if ($res === TRUE) 
            {            
                $xls = new PHPExcel();
                $xls->removeSheetByIndex(0);
                $index = 0;
                foreach ($tmp_table_name AS $k_name_table => $fields)
                {
                    if($this->data['form_Export'][$k_name_table] == 1)
                    {
                        $myWorkSheet = new PHPExcel_Worksheet($xls, $k_name_table);
                        App::import('Model', $k_name_table);
                        $this->myModel = new $k_name_table();
                        $this->myModel->unbindAll();
                        if(method_exists($this->myModel,'export'))$rows = $this->myModel->export($fields['export_id']);
                        else $rows = $this->myModel->find('all',array('conditions' => array('id' => $fields['export_id'])));
                        $k_cell = 0;
                        $flds = end($rows);
                        $flds = array_keys($flds[$k_name_table]);
                        foreach ($flds AS $field_name)
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
                $objWriter->save('./files/content' . $sfx . '.xls');
                $xls->disconnectWorksheets();                
                $zip->addFile('./files/content' . $sfx . '.xls','content.xls');
                $zip->close();                
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="content.zip"');
                readfile('./files/content' . $sfx . '.zip');
                @unlink('./files/content' . $sfx . '.zip');
                @unlink('./files/content' . $sfx . '.xls');
            }
            else {}            
            die();        
        }
        
        /*private function normalize_array ($arr_in = array())
        {
            $arr_out = array();
             foreach ($arr_in AS $k_first => $first_lev)
             {
                 if(count($first_lev) > 1)
                 {                     
                     foreach ($first_lev AS $k_next => $next_lev)
                     {
                         $arr_out[$k_first . '_' . $k_next] = $next_lev;
                     }
                 }
                 else $arr_out[$k_first] = $first_lev;
             }
             return $arr_out;
        }*/
        
}

?>
<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
set_time_limit(3600);

class ImportExportController extends AppController {

	public $name = 'ImportExport';
	public $uses = null;
        public $helpers = array('Html','Admin');
        public $contain_table = array('ContentDescription' => null/*<-эта модель обязательна*/,'ContentType','ContentCategory','ContentImage','ContentProduct','ContentManufacturer','ContentSpecial','ContentNews','ContentArticle','Attribute');

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

		App::import('Model', 'Language');
		$Language = new Language();

		$languages = $Language->find('all', array('order' => array('Language.id ASC')));
		$languages_list = array();
		
		foreach($languages AS $language)
		{
			$language_key = $language['Language']['id'];
			$languages_list[$language_key] = $language['Language']['name'];
		}
		
		$this->set('available_languages', $languages_list);	
		$this->set('current_language', $this->Session->read('Customer.language_id'));	

                $this->loadModel('GroupsCustomer');                    
                $this->GroupsCustomer->unbindModel(array('hasMany' => array('GroupsCustomerDescription')));
                $this->GroupsCustomer->bindModel(array('hasOne' => array('GroupsCustomerDescription' => array(
                                        'className' => 'GroupsCustomerDescription',
                                        'conditions' => 'language_id = ' . $this->Session->read('Customer.language_id')
                                )))); 
                $groups = $this->GroupsCustomer->find('all',array('fields' => array('GroupsCustomer.id', 'GroupsCustomerDescription.name')));
                $groups = Set::combine($groups,'{n}.GroupsCustomer.id','{n}.GroupsCustomerDescription.name');
                $groups[0] = __('no');
                asort($groups);
                $this->set('groups',$groups);


	}

	public function import ($action = null)
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
                        $zip->extractTo('./files/','content.csv');
                        $zip->close();
                        @unlink('./files/' . $file_name); 
                        $file_name = './files/content.csv';
                    }
                    else 
                    {
                        $this->Session->setFlash(__('Error extracting.',true));
                        $this->redirect('/import_export/admin');  
                    }
                } else $file_name = './files/' . $file_name;
                
                $content = array();
                $handle = fopen($file_name, "r");
                while (!feof($handle)) {                    
                    $str = fgets($handle);
                    if($str)
                        $content[] = array_merge(explode($this->data['ImportExport']['delimiter'],$str),array_fill(0, 30, null));
                }
                fclose($handle);             

                $this->loadModel('Content');    
                $this->Content->set_save_associations();
                $this->Content->unbindModel(array('hasOne' => array('ContentDescription')));
                $this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
                                'className' => 'ContentDescription',
                                'conditions'   => 'language_id = ' . ((isset($this->data['ImportExport']['language_id']))?$this->data['ImportExport']['language_id']:'')
                ))));     
                
              
                switch ($action) 
                {
                    case 'products':
                        foreach ($content as $imp_product) {
                            $data = $this->generate_data($imp_product,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentProduct');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);                           
                            //Смотрим существование артикула
                            $content = $this->Content->find('first',array('conditions' => array('ContentProduct.model' => $data['Content']['ContentProduct']['model'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentProduct']['id'] = $content['ContentProduct']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }
                            //Метка
                            $label = $this->Content->ContentProduct->Label->find('first',array('conditions' => array('Label.name' => $data['Content']['ContentProduct']['label'])));
                            if(isset($label['Label']['id'])) $data['Content']['ContentProduct']['label_id'] = $label['Label']['id'];
                            //
                            //$tax = $this->Content->ContentProduct->Tax->find('first',array('conditions' => array('Tax.name' => $data['Content']['ContentProduct']['tax'])));
                            //if(isset($tax['Tax']['id'])) $data['Content']['ContentProduct']['tax_id'] = $tax['Tax']['id'];
                            //Производитель
                            $manufacturer = $this->Content->ContentDescription->find('first',array('conditions' => array('ContentDescription.name' => $data['Content']['ContentProduct']['manufacturer'])));                           
                            if(isset($manufacturer['ContentDescription']['content_id'])) $data['Content']['ContentProduct']['manufacturer_id'] = $manufacturer['ContentDescription']['content_id'];
                            
                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));
                        }
                        
                    break;                    
                    case 'manufacturers':
                        foreach ($content as $imp_content) {
                            $data = $this->generate_data($imp_content,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentManufacturer');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);
                            //Смотрим существование производителя
                            $content = $this->Content->find('first',array('conditions' => array('Content.alias' => $data['Content']['alias'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }
                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));                            
                        }
                    break;
                    case 'categories':
                        foreach ($content as $imp_content) {
                            $data = $this->generate_data($imp_content,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentCategory');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);
                            //
                            $content = $this->Content->find('first',array('conditions' => array('Content.alias' => $data['Content']['alias'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }                            

                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));                            
                        }                        
                    break;
                    case 'pages':
                        foreach ($content as $imp_content) {
                            $data = $this->generate_data($imp_content,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentPage');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);
                            //
                            $content = $this->Content->find('first',array('conditions' => array('Content.alias' => $data['Content']['alias'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }                                

                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));                            
                        }                        
                    break;
                    case 'articles':
                        foreach ($content as $imp_content) {
                            $data = $this->generate_data($imp_content,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentArticle');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);
                            //
                            $content = $this->Content->find('first',array('conditions' => array('Content.alias' => $data['Content']['alias'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }                                

                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));                            
                        }                        
                    break;
                    case 'news':
                        foreach ($content as $imp_content) {
                            $data = $this->generate_data($imp_content,$this->data['Fields']);
                            $data['Content']['parent'] = explode($this->data['ImportExport']['cat_delimiter'],$data['Content']['parent']);
                            $data['Content']['content_type_id'] = $this->Content->get_content_type('ContentNews');
                            $data['Content']['image'] = explode('|',$data['Content']['image']);
                            $data['Content']['ContentDescription']['language_id'] = $this->data['ImportExport']['language_id'];
                            $data['Content']['ContentDescription']= array($data['Content']['ContentDescription']);
                            $data = $this->unpack_dependent_content($data);
                            //
                            $content = $this->Content->find('first',array('conditions' => array('Content.alias' => $data['Content']['alias'])));
                            if(isset($content['Content']['id'])) {
                                $data['Content']['id'] = $content['Content']['id'];
                                $data['Content']['ContentDescription'][0]['id'] = $content['ContentDescription']['id'];
                                unset($data['Content']['ContentImage']);
                            }                                

                            if($data['Content']['action'] == 'delete')
                               $this->Content->deleteAll(array('Content.id' => $data['Content']['id']));
                            else $this->Content->saveAll($data,array('deep' => true));                            
                        }                        
                    break;
                    case 'customers':
                        $this->loadModel('Customer'); 
                        foreach ($content as $imp_content) {
                            $data = $this->unpack_dependent_content($this->generate_data($imp_content,$this->data['Fields']));
                            //
                            $customer = $this->Customer->find('first',array('conditions' => array('Customer.email' => $data['Customer']['email'])));
                            if(isset($customer['Customer']['id'])) $data['Customer']['id'] = $customer['Customer']['id'];                            
                            
                            $this->Customer->saveAll($data,array('deep' => true)); 
                        }
                    break;
                    case 'orders':
                        $this->loadModel('Order');                              
                        foreach ($content as $imp_content) {
                            $data = $this->unpack_dependent_content($this->generate_data($imp_content,$this->data['Fields']));
                            $shipping_method = $this->Order->ShippingMethod->find('first',array('conditions' => array('ShippingMethod.name' => $data['Order']['shipping_method_id'])));
                            if(isset($shipping_method['ShippingMethod']['id'])) $data['Order']['shipping_method_id'] = $shipping_method['ShippingMethod']['id']; 
                            $payment_method = $this->Order->PaymentMethod->find('first',array('conditions' => array('PaymentMethod.name' => $data['Order']['payment_method_id'])));
                            if(isset($payment_method['PaymentMethod']['id'])) $data['Order']['payment_method_id'] = $payment_method['PaymentMethod']['id']; 
                    
                            $this->Order->saveAll($data,array('deep' => true));
                        }
                    break;
                }
                
                @unlink('./files/content.csv');

                $this->Session->setFlash(__('Import suсcess!', true));
                $this->redirect('/import_export/admin');
            }
            die();
        }
        
        public function export ($action = null)
	{
            $conditions = array();
            $this->loadModel('Content');
  
            $this->Content->set_save_associations();
            $this->Content->unbindAll();
            if(isset($this->data['ImportExport']['language_id'])) {
                $this->Content->bindModel(array('hasOne' => array('ContentDescription' => array(
                                'className' => 'ContentDescription',
                                'conditions'   => 'language_id = ' . $this->data['ImportExport']['language_id']
                ))));
            }
            $this->Content->bindModel(array('hasMany' => array('ContentImage'=> array(
                            'className' => 'ContentImage'))));   
            switch ($action) 
            {
                case 'products':
                    if(!empty($this->data['ImportExport']['parent_id'])) $categories = $this->data['ImportExport']['parent_id'];
                    else $categories = $this->Content->ContentCategory->find('list',array('fields' => array('id','content_id')));
                    $conditions[] = array('content_type_id' => $this->Content->get_content_type('ContentProduct'));
                    $conditions[] = array('Content.parent_id' => $categories);                

                    $this->Content->bindModel(array('hasOne' => array('ContentProduct'=> array(
                                    'className' => 'ContentProduct'))));
                    $this->Content->bindModel(array('hasOne' => array('ContentManufacturer'=> array(
                                    'className' => 'ContentManufacturer'))));
                    
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => $conditions)));                               
                    
                    //собираем доп. информацию
                    foreach ($content as $key => $value) {
                        $label = $this->Content->ContentProduct->Label->find('first',array('conditions' => array('Label.id' => $value['ContentProduct']['label_id'])));                    
                        $content[$key]['ContentProduct']['label'] = (isset($label['Label']['name']))?$label['Label']['name']:'';
                        $manufacturer = $this->Content->find('first',array('conditions' => array('Content.id' => $value['ContentProduct']['manufacturer_id'])));
                        $content[$key]['ContentProduct']['manufacturer'] = (isset($manufacturer['ContentDescription']['name']))?$manufacturer['ContentDescription']['name']:'';
                    }
                break;
                case 'manufacturers':
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => array('content_type_id' => $this->Content->get_content_type('ContentManufacturer'))))); 
                break;
                case 'categories':
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => array('content_type_id' => $this->Content->get_content_type('ContentCategory')))));
                break;
                case 'pages':
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => array('content_type_id' => $this->Content->get_content_type('ContentPage')))));                    
                break;
                case 'articles':
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => array('content_type_id' => $this->Content->get_content_type('ContentArticle')))));
                break;    
                case 'news':
                    $content = $this->pack_dependent_content($this->Content->find('all',array('conditions' => array('content_type_id' => $this->Content->get_content_type('ContentNews')))));
                break;  
                case 'customers':
                    $this->loadModel('Customer'); 
                    if(isset($this->data['ImportExport']['groups_customer_id'])&&$this->data['ImportExport']['groups_customer_id']!=0)
                        $conditions[] = array('groups_customer_id' => $this->data['ImportExport']['groups_customer_id']); 
                    else $conditions = null;
                    $content = $this->Customer->find('all',array('conditions' => $conditions));
                break;  
                case 'orders':
                    $this->loadModel('Order');
                    $conditions = array('Order.created >=' => $this->data['ImportExport']['date_start'], 'Order.created <=' => $this->data['ImportExport']['date_end']);
                    $content = $this->Order->find('all',array('conditions' => $conditions));
                break;              
            }

            $body = array();
            foreach ($content as $value) {
                $body_string = null;                         
                foreach ($this->data['Fields'] as $field) {
                    if(isset($value[key($field)][key(current($field))])&&current(current($field))==1) {                     
                        $body_string .= str_replace($this->data['ImportExport']['delimiter'],'<del>',$value[key($field)][key(current($field))]);
                    }   
                    $body_string .= $this->data['ImportExport']['delimiter'];                    
                }                  
                //$body[] = mb_convert_encoding($body_string,'Windows-1251','UTF-8') . PHP_EOL;
                $body[] = $body_string . PHP_EOL;
            }                
            if ($handle = fopen('./files/' . $action . '.csv', 'w')) {
                foreach ($body as $line)
                    fwrite($handle, str_replace(array("\r\n"), "", $line));
            }
            fclose($handle);
            
            $zip = new ZipArchive();
            $res = $zip->open('./files/' . $action . '.zip', ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
            if ($res === TRUE)
            {
                $zip->addFile('./files/' . $action . '.csv','content.csv');
                $zip->close();                
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $action . '.zip"');
                readfile('./files/' . $action . '.zip');
                //@unlink('./files/' . $action . '.zip');
                //@unlink('./files/' . $action . '.csv');
            }
            die();        
        }
        
        private function pack_dependent_content($data = null) 
        { 
            foreach ($data as $key => $value) {
                $data[$key]['Content']['parents'] = implode($this->data['ImportExport']['cat_delimiter'],array_reverse(Set::combine($this->Content->get_parents($value['Content']['id']),'{n}.Content.id','{n}.ContentDescription.name')));
                $images = $this->Content->ContentImage->find('all',array('conditions' => array('ContentImage.content_id' => $value['Content']['id'])));
                $data[$key]['Content']['image'] = implode('|',Set::combine($images,'{n}.ContentImage.id','{n}.ContentImage.image'));
            }
            return $data;
        }                       
        
        private function unpack_dependent_content($data = null) 
        {
            //Ищем родителя
            $parent_description = 0;       
            foreach ($data['Content']['parent'] as $value) {
                $description = $this->Content->ContentDescription->find('all',array('conditions' => array('ContentDescription.name' => $value)));
                if(empty($description)) { //создадим каталог                 
                    $category = array(
                      'Content' => array(
                          'id' => 0
                         ,'parent_id' => (isset($parent_description['ContentDescription']['content_id']))?$parent_description['ContentDescription']['content_id']:0
                         ,'content_type_id' => $this->Content->get_content_type('ContentCategory')
                         ,'ContentDescription' => array(0 => array(
                             'language_id' => $this->data['ImportExport']['language_id']
                            ,'name' => $value
                         ))                          
                      )  
                    );                                     
                    $this->Content->saveAll($category,array('deep' => true)); 
                    $description = $this->Content->ContentDescription->find('all',array('conditions' => array('ContentDescription.name' => $value)));                 
                }
                if(count($description) > 1) {
                    foreach ($description as $sub_description) {
                        $content_description = $this->Content->find('first',array('conditions' => array('Content.id' => $sub_description['ContentDescription']['content_id'])));
                        if($content_description['Content']['parent_id'] === $parent_description['ContentDescription']['content_id']) {
                            $parent_description = $sub_description; break;
                        }
                    }
                } else $parent_description = current($description);          
            }
            $data['Content']['parent_id'] = $parent_description['ContentDescription']['content_id'];                                      
            //Картинки
            $images = array();
            foreach ($data['Content']['image'] as $k => $value) {
                $images[] = array(
                    'image' => $value
                   ,'order' => $k
                );
            }
            $data['Content']['ContentImage'] = $images;
            return $data;
        }
        
        private function generate_data($data = null,$fields = null) 
        {         
            $fields_out = array();
            $key = 0;
            foreach ($fields as $k => $value) {
                if($data[$key]!='') {//$data[$key] = '0';
                    if(isset($value[key($value)][key(current($value))] )&&current(current($value)))
                        $value[key($value)][key(current($value))][key(current(current($value)))] = $data[$key];
                    else if(isset($value[key($value)][key(current($value))])) $value[key($value)][key(current($value))] = $data[$key]; 
                    $fields_out = array_merge_recursive($fields_out,$value);
                }
                $key++;
            }         
            return $fields_out;
        }        
        
        public function file_download($file, $filename = null) 
        {
            if (file_exists($file)) {
              if (ob_get_level()) {
                ob_end_clean();
              }
              // заставляем браузер показать окно сохранения файла
              header('Content-Description: File Transfer');
              header('Content-Type: application/octet-stream');
              if(is_null($filename))header('Content-Disposition: attachment; filename=' . basename($file));
              else header('Content-Disposition: attachment; filename="' . $filename .'"');
              header('Content-Transfer-Encoding: binary');
              header('Expires: 0');
              header('Cache-Control: must-revalidate');
              header('Pragma: public');
              header('Content-Length: ' . filesize($file));
              // читаем файл и отправляем его пользователю
              if ($fd = fopen($file, 'rb')) {
                while (!feof($fd)) {
                  print fread($fd, 1024);
                }
                fclose($fd);
              }
              exit;
            }
        }

        
}

?>
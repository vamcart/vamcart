<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/
class ImagesController extends AppController {
	public $name = 'Images';
	public $uses = array('ContentImage');
	
	public function thumb ($id=null,$src=null,$w=null,$h=null,$q=null)
	{

		$this->uses = null;
		$this->autoLayout = false;
		$this->autoRender = false;
		$this->helpers = null;
		$this->layout = null;	

            if(empty($src)){
                die("No source image");
            }

				if ($src == 'noimage.png') {
				$sourceFilename = IMAGES . DS . 'noimage.png';
				} else {
				$sourceFilename = IMAGES . DS . 'content/'.$id.'/'.$src;
				}

				if(!is_readable($sourceFilename)){
                die("Couldn't read source image");
				}
				
            global $config;
            
            //width
            $width = (!isset($w)) ? $config['THUMBNAIL_SIZE'] : $w;
            //height
            $height = (!isset($h)) ? $config['THUMBNAIL_SIZE'] : $h;
            //quality    
            $quality = (!isset($q)) ? 75 : $q;
            
            if(is_readable($sourceFilename)){
                App::import('Vendor', 'Phpthumb', array('file' => 'phpthumb'.DS.'phpthumb.class.php'));
                $phpThumb = new phpThumb();

                $phpThumb->src = $sourceFilename;
                $phpThumb->w = $width;
                $phpThumb->h = $height;
                $phpThumb->q = $quality;
                $phpThumb->config_imagemagick_path = '/usr/bin/convert';
                $phpThumb->config_prefer_imagemagick = false;
                $phpThumb->config_output_format = 'png';
                $phpThumb->config_error_die_on_error = true;
                $phpThumb->config_document_root = '';
                $phpThumb->config_temp_directory = APP . 'tmp';
                $phpThumb->config_cache_directory = IMAGES . 'content' . DS . $id . DS;
                $phpThumb->config_cache_disable_warning = true;
                
                
                $cacheFilename = str_replace('.png','',$src).'-'.$width.'.'.$phpThumb->config_output_format;
                
                $phpThumb->cache_filename = $phpThumb->config_cache_directory.$cacheFilename;
                
				// Check if image is already cached.
                if(!file_exists($phpThumb->cache_filename))
				{ 
                    if ($phpThumb->GenerateThumbnail()) 
					{
                        $phpThumb->RenderToFile($phpThumb->cache_filename);
                    } else {
                        die('Failed: '.$phpThumb->error);
                    }
                }
            
            if(file_exists($phpThumb->cache_filename)){ // If thumb was already generated we want to use cached version
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.Router::url(BASE . '/img/content/' . $id . '/' . $cacheFilename, true).'');
                die();
            }
            
            
            } else { // Can't read source
                die("Couldn't read source image");
            }
	}

	public function admin_delete_content_image($image_id) 
	{
		if($image_id != null)
		{
			$image = $this->ContentImage->read(null,$image_id);
			
			$filename =  WWW_ROOT . IMAGES_URL . 'content/' . $image['ContentImage']['content_id'] . '/' . $image['ContentImage']['image'];
			unlink($filename);
			
			$this->ContentImage->delete($image_id);			
		}
		$this->redirect('/images/admin_view_content_images/' . $image['ContentImage']['content_id']);
	}
	
	public function admin_view_content_images ($content_id)
	{
		$this->set('content_id',$content_id);
		$this->set('content_images',$this->ContentImage->find('all', array('conditions' => array('content_id' => $content_id))));
	}
		
}
?>
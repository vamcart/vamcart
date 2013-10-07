<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/
class ImagesController extends AppController {
	public $name = 'Images';
	public $uses = array('ContentImage');
	
	public function thumb ()
	{
            if(empty($_GET['src'])){
                die("No source image");
            }
            
            global $config;
            
            //width
            $width = (!isset($_GET['w'])) ? $config['THUMBNAIL_SIZE'] : $_GET['w'];
            //height
            $height = (!isset($_GET['h'])) ? $config['THUMBNAIL_SIZE'] : $_GET['h'];
            //quality    
            $quality = (!isset($_GET['q'])) ? 75 : $_GET['q'];
            
			$sourceFilename = WWW_ROOT . IMAGES_URL . $_GET['src'];

	
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
                $phpThumb->config_cache_directory = CACHE.'thumbs'.DS;
                $phpThumb->config_cache_disable_warning = true;
                
                $cacheFilename = md5($_SERVER['REQUEST_URI']);
                
                $phpThumb->cache_filename = $phpThumb->config_cache_directory.$cacheFilename;
                
				// Check if image is already cached.
                if(!is_file($phpThumb->cache_filename))
				{ 
                    if ($phpThumb->GenerateThumbnail()) 
					{
                        $phpThumb->RenderToFile($phpThumb->cache_filename);
                    } else {
                        die('Failed: '.$phpThumb->error);
                    }
                }
            
            if(is_file($phpThumb->cache_filename)){ // If thumb was already generated we want to use cached version
                $cachedImage = getimagesize($phpThumb->cache_filename);
                header('Content-Type: '.$cachedImage['mime']);
                readfile($phpThumb->cache_filename);
                exit;
            }
            
            
            } else { // Can't read source
                die("Couldn't read source image ".$sourceFilename);
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
<?php
/** SMS - Selling Made Simple
 * Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
 * This project's homepage is: http://sellingmadesimple.org
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * BUT withOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**/

class ImagesController extends AppController {
	var $name = 'Images';
	var $uses = array('ContentImage');
	
	function thumb ()
	{
            if(empty($_GET['src'])){
                die("No source image");
            }
            
            //width
            $width = (!isset($_GET['w'])) ? 100 : $_GET['w'];
            //height
            $height = (!isset($_GET['h'])) ? 150 : $_GET['h'];
            //quality    
            $quality = (!isset($_GET['q'])) ? 75 : $_GET['q'];
            
			$sourceFilename = WWW_ROOT . IMAGES_URL . $_GET['src'];

	
            if(is_readable($sourceFilename)){
                vendor("phpthumb".DS."phpthumb.class");
                $phpThumb = new phpThumb();

                $phpThumb->src = $sourceFilename;
                $phpThumb->w = $width;
                $phpThumb->h = $height;
                $phpThumb->q = $quality;
                $phpThumb->config_imagemagick_path = '/usr/bin/convert';
                $phpThumb->config_prefer_imagemagick = false;
                $phpThumb->config_output_format = 'jpg';
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

	function admin_delete_content_image($image_id) 
	{
		if($image_id != null)
		{
			$image = $this->ContentImage->read(null,$image_id);
			
			$filename =  WWW_ROOT . IMAGES_URL . 'content/' . $image['ContentImage']['content_id'] . '/' . $image['ContentImage']['image'];
			unlink($filename);
			
			$this->ContentImage->del($image_id);			
		}
		$this->redirect('/images/admin_view_content_images/' . $image['ContentImage']['content_id']);
	}
	
	function admin_view_content_images ($content_id)
	{
		$this->set('content_id',$content_id);
		$this->set('content_images',$this->ContentImage->findAll(array('content_id' => $content_id)));
		$this->render('','ajax');
	}
		
}
?>
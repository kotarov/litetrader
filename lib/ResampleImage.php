<?php
/**
 * $image_content: image data
 * $to_width: resized to width
 * $to_height: resized to height
 * $bgcolor: 
 */

function resampleimage(&$image_content, $to_width = 1024, $to_height = 960, $bgcolor = array('R'=>255,'G'=>255,'B'=>255) ){
        $img = imagecreatefromstring($image_content);
        $width  = imagesx($img);
        $height = imagesy($img);
        $x = 0;
        $y = 0;
        $new_x = 0;
        $new_y = 0;
        
        if($width > $to_width && $height > $to_height){
            if($width/$height > $to_width/$to_height){
                $new_width = ($to_height / $height) * $width; 
                $new_height = $to_height;
                $x = ($new_width - $to_width) / 2;
            }else{
                $new_width = $to_width;
                $new_height = ($to_width / $width) * $height;
                $y = ($new_height - $to_height) / 2;
            }
        }elseif($width > $to_width && $height < $to_height){
            $new_width = $to_width;
            $new_height = $height;
            $new_y = ($to_height - $height) /2 ;
            $x = ($width - $to_width) / 2;
        }elseif($width < $to_width && $height > $to_height){
            $new_width = $width;
            $new_height = $to_height;
            $new_x = ($to_width - $width)/2;
            $y = ($height - $to_height)/2;
        }else{
            $new_width = $width;
            $new_height = $height;
            $new_x = ($to_width - $new_width)/2;
            $new_y = ($to_height - $new_height)/2;
        }
        
        
        $new_img = imagecreatetruecolor($to_width, $to_height);
        $color = imagecolorallocate($new_img, $bgcolor['R'], $bgcolor['G'], $bgcolor['B']);
        imagefill($new_img, 0, 0, $color);
        //imagesavealpha($new_img, TRUE);
        
        if(!imagecopyresampled($new_img, $img, $new_x, $new_y, $x, $y, $new_width, $new_height, $width, $height)) 
            return false;
        
        ob_start(); imagejpeg($new_img);
        return ob_get_clean();
} 
?>
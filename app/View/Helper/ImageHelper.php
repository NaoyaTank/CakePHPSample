<?php 
class ImageHelper extends HtmlHelper {
	public function img_path($img_name) {
		if($img_name) {
			return '/img/' . h($img_name);
		}else{
			return '/img/' . 'noimage.jpg';
		}
	}
}
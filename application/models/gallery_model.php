<?php
class Gallery_model extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
	}

	function do_upload(){

		if(isset($_FILES['userfile']))
		{
			$imageName = $_FILES['userfile']['name'];
			$imageType = $_FILES['userfile']['type'];
			$imageSize = $_FILES['userfile']['size'];
			$imageTmpName = $_FILES['userfile']['tmp_name'];

			$imageCheck = substr($imageType,0,5);
		}
		else
		{
			$imageCheck = 'fail';
		}

		if (($imageCheck != "image"))
		{
			// file failed the XSS test or wasn't an image
			$this->bannermessage->setBanner('error', 'Please select an Image file to upload.');
			redirect('gallery/display/' . $this->input->post('album_id'));
		}
		else if (!($this->quota_check($imageSize)))
		{
			$this->bannermessage->setBanner('error', 'You have exceeded your quota.');
			redirect('gallery/display/' . $this->input->post('album_id'));
		}
		else
		{
			$currentCount = Doctrine_Query::create()
			->select('COUNT(*) as num_pics')
			->from('picture')
			->where('album_id = ' . $this->input->post('album_id'))
			->setHydrationMode(Doctrine::HYDRATE_RECORD)
			->fetchOne();

			//collect EXIF data for display
			if ($imageType == 'image/jpeg' || $imageType == 'image/tiff')
			{
				$exif = @exif_read_data($imageTmpName, 0, true);
			}
			else
			{
				$exif = false;
			}


			if ($exif)
			{
				//start with GPS
				if(isset($exif['GPS']['GPSLatitude']) && isset($exif['GPS']['GPSLongitude']))
				{
					$lat = $exif['GPS']['GPSLatitude'];
					$log = $exif['GPS']['GPSLongitude'];
					if (!(!$lat || !$log))
					{
						// latitude values //
						$lat_degrees = $this->divide($lat[0]);
						$lat_minutes = $this->divide($lat[1]);
						$lat_seconds = $this->divide($lat[2]);
						$lat_hemi = $exif['GPS']['GPSLatitudeRef'];

						// longitude values //
						$log_degrees = $this->divide($log[0]);
						$log_minutes = $this->divide($log[1]);
						$log_seconds = $this->divide($log[2]);
						$log_hemi = $exif['GPS']['GPSLongitudeRef'];

						$lat_decimal = $this->toDecimal($lat_degrees, $lat_minutes, $lat_seconds, $lat_hemi);
						$log_decimal = $this->toDecimal($log_degrees, $log_minutes, $log_seconds, $log_hemi);
					}
				}

				if(isset($exif['IFD0']['Make'])) 
					$makeString = $exif['IFD0']['Make'];
				if(isset($exif['IFD0']['Model'])) 
					$modelString = $exif['IFD0']['Model'];
				if(isset($exif['EXIF']['ExposureTime'])) 
					$exposure = $exif['EXIF']['ExposureTime'].' sec';
				if(isset($exif['COMPUTED']['ApertureFNumber'])) 
					$FNumber = $exif['COMPUTED']['ApertureFNumber'];
				if(isset($exif['EXIF']['ISOSpeedRatings'])) 
					$ISOSpeed = $exif['EXIF']['ISOSpeedRatings'];
				if(isset($exif['EXIF']['Flash'])) 
					$flashString = $exif['EXIF']['Flash'];
				if(isset($exif['EXIF']['DateTimeOriginal'])) 
					$dateTaken = $exif['EXIF']['DateTimeOriginal'];

			}
			//end collect EXIF data

			$info = pathinfo($imageName);
			$trimmedImageName =  basename($imageName,'.'.$info['extension']);

			$newImage = new Picture();
			$newImage->name = $trimmedImageName;
			$newImage->type = $imageType;
			$newImage->size = $imageSize;
				
			$newImage->album_pos = $currentCount->num_pics + 1;

			$fp = fopen($imageTmpName, 'r');
			$content = fread($fp, $imageSize);
			fclose($fp);
			$content = base64_encode($content);
			$content = addslashes($content);
				
			$newImage->album_id = $this->input->post('album_id');
			$newImage->image = $content;
			$newImage->save();

			//set exif data
			if(!$exif || ((!isset($modelString)) && (!isset($exposure)) && (!isset($FNumber)) && (!isset($ISOSpeed)) && (!isset($flashString)) && (!isset($dateTaken)) && (!isset($lat_decimal)) && (!isset($log_decimal))))
			{

			}
			else
			{
				$setExif = new Exif();

				$setExif->picture_id = $newImage->id;
				if(isset($makeString)) $setExif->make = $makeString;
				if(isset($modelString)) $setExif->model = $modelString;
				if(isset($exposure)) $setExif->Exposure = $exposure;
				if(isset($FNumber)) $setExif->FNumber = $FNumber;
				if(isset($ISOSpeed)) $setExif->ISOSpeed = $ISOSpeed;
				if(isset($flashString)) $setExif->flash = $flashString;
				if(isset($dateTaken)) $setExif->dateTaken = $dateTaken;
				if(isset($lat_decimal)) $setExif->gpsLat = $lat_decimal;
				if(isset($log_decimal)) $setExif->gpsLon = $log_decimal;
				$setExif->save();
			}
			$this->generateThumb($newImage->id);
			$this->bannermessage->setBanner('info', 'Uploaded new Image: ' . $imageName);

			redirect('gallery/display/' . $this->input->post('album_id'));
		}
	}

	function generateThumb($id)
	{
		//TODO: this is an epic hack, and should be fixed
		ini_set("memory_limit","-1");

		$result = Doctrine::getTable('picture')->find($id);
		$fileType = $result->type;
		$fileContent = $result->image;

		$fileContent = stripslashes($fileContent);
		$fileContent = base64_decode($fileContent);

		// get originalsize of image
		$im = imagecreatefromstring($fileContent);
		$width  = imagesx($im);
		$height = imagesy($im);

		//save width/height
		$result->width = $width;
		$result->height = $height;
		/*
		 // Set thumbnail-width to 100 pixel
		//$imgw = 100;
		$imgh = 100;

		// calculate thumbnail-height from given width to maintain aspect ratio
		//$imgh = $height / $width * $imgw;
		$imgw = $width / $height * $imgh;

		if($imgw > 200) { $imgw = 200; $imgh = 75; }
		*/
		// Set thumbnail-width to 100 pixel
		if ($height > 100){
			$imgh = 100;
		}else{
			$imgh=$height;
		}

		// calculate thumbnail-height from given width to maintain aspect ratio
		$imgw = $width / $height * $imgh;

		//lame hack
		if($imgw > 200) {
			$imgw = 200; $imgh = 100;
		}

		// create new image using thumbnail-size
		$thumb=imagecreatetruecolor($imgw, $imgh);

		// copy original image to thumbnail
		imagecopyresampled($thumb,$im,0,0,0,0,$imgw,$imgh,ImageSX($im),ImageSY($im));

		//if png
		if ($fileType == "image/png")
		{
			$black = imagecolorallocate($thumb, 0, 0, 0);
			imagecolortransparent($thumb, $black);
		}

		ob_start();
		if($fileType == "image/png")
		{
			imagepng($thumb, null, 0, PNG_ALL_FILTERS);
		}
		else if($fileType == "image/gif")
		{
			imagegif($thumb);
		}
		else
		{
			imagejpeg($thumb, null, 100);
		}
		$uploadData = ob_get_contents();
		ob_end_clean();

		$uploadData = base64_encode($uploadData);
		$uploadData = addslashes($uploadData);

		$result->thumb = $uploadData;
		$result->save();

		// clean memory
		imagedestroy ($im);
		imagedestroy ($thumb);
	}

	private function quota_check($curImgSize)
	{
		$quota = Current_User::user()->quota;

		//quota is stored as bytes, MB formula = 1024*1024*100 = 100MB

		$usage = Doctrine_Query::create()
		->select('sum(p.size) totalSize')
		->from('picture p, album a')
		->where('a.id = p.album_id and a.user_id = ?', Current_User::user()->id)
		->setHydrationMode(Doctrine::HYDRATE_RECORD)
		->fetchOne();

		$spaceUsage = $usage->totalSize;

		if(($quota-$spaceUsage-$curImgSize > 0) || ($quota == 0))
		{
			return true;
		}
		else
		{
			return false;
		}

	}


	private  function toDecimal($deg, $min, $sec, $hemi)
	{
		$d = $deg + $min/60 + $sec/3600;
		return ($hemi=='S' || $hemi=='W') ? $d*=-1 : $d;
	}

	private function divide($a)
	{
		// evaluate the string fraction and return a float //
		$e = explode('/', $a);
		// prevent division by zero //
		if (!$e[0] || !$e[1]) {
			return 0;
		}	
		else
		{
			return $e[0] / $e[1];
		}
	}
	 


}

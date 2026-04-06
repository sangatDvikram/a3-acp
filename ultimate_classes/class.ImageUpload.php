<?php
/**
 * This is Image Upload class Which is used to Generate the image and rename it also Pluse generate the link of the image.
 * @author vikramsangat
 * @category Image Uploads.
 */


class ImageUpload
{

	//////////////////////////////////////////////
	////  Propertis or Variable Declearation /////
	//////////////////////////////////////////////
	public $imagename;
	public $link;
	public $thumbnail;
	public $gallery;
	public $original;
	public $MakeItProgressive = TRUE;
	public $folder;
	public $imagepath;
	public $erros= array();

	// Protected Members.
	protected $_randomeKey;
	protected $_imagesize;
	protected $_imagetype;
	protected $_imageSource;
	protected $_imagewidth;
	protected $_imageheight;




	//////////////////////////////////////////////
	////        Methodes Declearations       /////
	//////////////////////////////////////////////

	/**
	 * Get User Uploaded Iamge.
	 * @param file $image user uploaded file
	 */
	function __construct($image)
	{
		$this->imagename=$image['name'];
		$this->_imagesize=($image['size']/1024)."kb";
		$this->_imageSource=$image['tmp_name'];
		$this->_imagetype=$image['type'];

	}
	/**
	 * Timepass Function That Gives image details.
	 * @return array Returns All the image information
	 */
	function getimagedetails()
	{
	 return array("Name"=>$this->imagename,"Size"=>$this->_imagesize,"Type"=>$this->_imagetype,"TempName"=>$this->_imageSource,"UniqNoIs"=>$this->_generateUniqno());
	}
	/**
	 * Check for folder to be crearted or save image into.
	 * @param string $folder Enter folder to be selected.
	 */
	function setFolder($folder='')
	{
		if(is_dir($folder))
		{
			$this->folder=$folder;
			$this->imagepath=$this->folder."/".$this->imagename;
		}
		else
		{
		 mkdir($folder);
		 $this->setFolder($folder);
		}
	}
	/**
	 * Generate Randome string according to current time stamp. 
	 * @return string randome key.
	 */
	protected function _generateUniqno()
	{
		$md5 = md5(microtime() * time());
		$string = substr($md5,0,7);
		$hex='';
		for ($i=0; $i < strlen($string); $i++)
		{
		$hex .= dechex(ord($string[$i]));
		}
		
		$this->_randomeKey=$hex;
		
		return $hex;
		
		
	}
	/**
	 * Upload Image into selected directory.
	 */
	function uploadimage()
	{
		move_uploaded_file($this->_imageSource, $this->imagepath);
	}
	/**
	 * Set current image height and width.
	 */
	protected function _setImageHW()
	{
		list($this->_imagewidth, $this->_imageheight) = getimagesize($this->imagepath) ;

	}
	/**
	 * Check that user has only selected the Jpeg type of image.
	 * @return boolean
	 */
	function ValidateImage()
	{
		if ($this->_imagetype=='image/jpeg')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/**
	 * Generate the Image according to the height and width given.
	 * @param string $type Type of image name you needed 'small','medium','large'
	 * @param integer $compression Enter the compression ratio of image default is set to 85.
	 * @param integer $width Enter manual width.
	 * @param integer $height Enter manual height
	 * @return string Name of new created image.
	 */
	function generateImage($type='',$compression='80',$width=NULL,$height=NULL)
	{
		$this->_setImageHW();

		switch ($type)
		{
			case 'small': $newName=$this->folder."/"."small_".$this->_randomeKey.".jpg";	break;
			case 'medium': $newName=$this->folder."/"."medium_".$this->_randomeKey.".jpg"; break;
			case 'large': $newName=$this->folder."/"."large_".$this->_randomeKey.".jpg"; break;
		}

		if (isset($width)&&is_null($height))
		{
			$height=$this->_imageheight;
			$tn = imagecreatetruecolor($width, $this->_imageheight) ;
		}
		elseif (isset($height)&&is_null($width))
		{
			$width=$this->_imagewidth;
			$tn = imagecreatetruecolor($this->_imagewidth, $height) ;
		}
		elseif (isset($height)&&isset($width))
		{
			$tn = imagecreatetruecolor($width, $height) ;
		}
		else
		{
			$height=$this->_imageheight;
			$width=$this->_imagewidth;
			$tn = imagecreatetruecolor($this->_imagewidth, $this->_imageheight) ;
		}



		if (!is_file($newName))
		{
			$image = imagecreatefromjpeg($this->imagepath) ;
				
			imagecopyresampled($tn, $image, 0, 0, 0, 0,$width, $height, $this->_imagewidth, $this->_imageheight);
				
			imageinterlace($tn,$this->MakeItProgressive);
				
			imagejpeg($tn, $newName,$compression) ;
			
			imagedestroy($tn);
				
		}

		return $newName;
	}
	public function destroyImage()
	{
		unlink($this->imagepath);
	}
	
	public function setProgressive($value)
	{
		$this->MakeItProgressive=$value;
	}


}
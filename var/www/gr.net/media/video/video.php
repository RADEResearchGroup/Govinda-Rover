<?php
//Start Sesi User
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/common.php');	
	//Sertakan fungsi user
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/user.php');
	//Sertakan file text antarmuka
	require_once($_SERVER['DOCUMENT_ROOT'] . '/include/lang.php');

	
	
		
//Cek apakah yang meminta akses adalah user
//yang memiliki cukup hak akses
if(user_check_login(1)) :
	/*

		Single File PHP Gallery 4.1.1 (SFPG)

		See EULA in readme.txt for commercial use

		See readme.txt for configuration
		Released: 20-August-2011
		http://sye.dk/sfpg/
		by Kenny Svalgaard,
		Modified by Aditya Suranata
		http://rade.stikom-bali.ac.id

	*/
//	----------- CONFIGURATION START ------------
	define("GALLERY_ROOT", "./");
	define("DATA_ROOT", "./_sfpg_data/");
	define("SECURITY_PHRASE", "govinda");

	define("DIR_NAME_FILE", "_name.txt");
	define("DIR_IMAGE_FILE", "_image.jpg");
	define("DIR_DESC_FILE", "_desc.txt");
	define("DIR_SORT_REVERSE", FALSE);
	define("DIR_SORT_BY_TIME", FALSE);
	$dir_exclude = array("_sfpg_data", "_sfpg_icons");

	define("SHOW_IMAGE_EXT", FALSE);
	define("IMAGE_SORT_REVERSE", FALSE);
	define("IMAGE_SORT_BY_TIME", FALSE);
	define("ROTATE_IMAGES", TRUE);
	define("IMAGE_JPEG_QUALITY", 90);

	define("SHOW_FILES", TRUE);
	define("SHOW_FILE_EXT", TRUE);
	define("FILE_IN_NEW_WINDOW", TRUE);
	define("FILE_THUMB_EXT", ".jpg");
	define("FILE_SORT_REVERSE", FALSE);
	define("FILE_SORT_BY_TIME", FALSE);
	$file_exclude = array();
	$file_ext_exclude = array(".php", ".txt");
	$file_ext_thumbs = array();

	define("LINK_BACK", "");
	define("CHARSET", "iso-8859-1");
	define("DATE_FORMAT", "Y-m-d h:i:s");
	define("DESC_EXT", ".txt");
	define("SORT_DIVIDER", "--");
	define("SORT_NATURAL", TRUE);
	define("FONT_SIZE", 12);
	define("UNDERSCORE_AS_SPACE", TRUE);
	define("NL_TO_BR", FALSE);
	define("SHOW_EXIF_INFO", TRUE);
	
	define("THUMB_MAX_WIDTH", 120);
	define("THUMB_MAX_HEIGHT", 120);
	define("THUMB_ENLARGE", FALSE);
	define("THUMB_JPEG_QUALITY", 75);

	define("USE_PREVIEW", FALSE);
	define("PREVIEW_MAX_WIDTH", 600);
	define("PREVIEW_MAX_HEIGHT", 400);
	define("PREVIEW_ENLARGE", FALSE);
	define("PREVIEW_JPEG_QUALITY", 75);
	
	define("WATERMARK", "");

	define("INFO_BOX_WIDTH", 250);
	define("MENU_BOX_HEIGHT", 70);
	define("NAV_BAR_HEIGHT", 25);

	define("THUMB_BORDER_WIDTH", 1);
	define("THUMB_MARGIN", 10);
	define("THUMB_BOX_MARGIN", 7);
	define("THUMB_BOX_EXTRA_HEIGHT", 14);
	define("THUMB_CHARS_MAX", 20);

	define("FULLIMG_BORDER_WIDTH", 5);
	define("NAVI_CHARS_MAX", 100);

	define("OVERLAY_OPACITY", 90);
	define("FADE_FRAME_PER_SEC", 30);
	define("FADE_DURATION_MS", 300);
	define("LOAD_FADE_GRACE", 500);

	define("TEXT_GALLERY_NAME", "Single File PHP Gallery");
	define("TEXT_HOME", "Home");
	define("TEXT_CLOSE_IMG_VIEW", "Close Image");
	define("TEXT_ACTUAL_SIZE", "Actual Size");
	define("TEXT_FULLRES", "Full resolution");
	define("TEXT_PREVIOUS", "<< Previous");
	define("TEXT_NEXT", "Next >>");
	define("TEXT_INFO", "Information");
	define("TEXT_DOWNLOAD", "Download full-size image");
	define("TEXT_NO_IMAGES", "No Images in gallery");
	define("TEXT_DATE", "Date");
	define("TEXT_FILESIZE", "File size");
	define("TEXT_IMAGESIZE", "Full Image");
	define("TEXT_DISPLAYED_IMAGE", "Displayed Image");
	define("TEXT_DIR_NAME", "Gallery Name");
	define("TEXT_IMAGE_NAME", "Image Name");
	define("TEXT_FILE_NAME", "File Name");
	define("TEXT_DIRS", "Sub galleries");
	define("TEXT_IMAGES", "Images");
	define("TEXT_IMAGE_NUMBER", "Image number");
	define("TEXT_FILES", "Files");
	define("TEXT_DESCRIPTION", "Description");
	define("TEXT_DIRECT_LINK_GALLERY", "Direct link to Gallery");
	define("TEXT_DIRECT_LINK_IMAGE", "Direct link to Image");
	define("TEXT_NO_PREVIEW_FILE", "No Preview for file");
	define("TEXT_IMAGE_LOADING", "Image Loading ");
	define("TEXT_LINKS", "Links");
	define("TEXT_NOT_SCALED", "Not Scaled");
	define("TEXT_LINK_BACK", "Back to my site");
	define("TEXT_THIS_IS_FULL", "Full");
	define("TEXT_THIS_IS_PREVIEW", "Preview");
	define("TEXT_SCALED_TO", "Scaled to");
	define("TEXT_YES", "Yes");
	define("TEXT_NO", "No");
	define("TEXT_EXIF_DATE", "EXIF Date");
	define("TEXT_EXIF_CAMERA", "Camera");
	define("TEXT_EXIF_ISO", "ISO");
	define("TEXT_EXIF_SHUTTER", "Shutter Speed");
	define("TEXT_EXIF_APERTURE", "Aperture");
	define("TEXT_EXIF_FOCAL", "Focal Length");
	define("TEXT_EXIF_FLASH", "Flash fired");
	define("TEXT_EXIF_MISSING", "No EXIF informatin in image");
	
		//	----------- CONFIGURATION END ------------

function sfpg_array_sort(&$arr, &$arr_time, $sort_by_time, $sort_reverse)
	{
		if ($sort_by_time)
		{
			if ($sort_reverse)
			{
				array_multisort ($arr_time, SORT_DESC, SORT_NUMERIC, $arr);
			}
			else
			{
				array_multisort ($arr_time, SORT_ASC, SORT_NUMERIC, $arr);
			}
		}
		else
		{
			if (SORT_NATURAL)
			{
				natcasesort ($arr);
				if ($sort_reverse)
				{
					array_reverse ($arr);
				}
			}
			else
			{
				if ($sort_reverse)
				{
					rsort ($arr);
				}
				else
				{
					sort ($arr);
				}
			}
		}
	}


	function sfpg_file_size($size)
	{
		$sizename = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
		return ($size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . " " . $sizename[$i] : "0 Bytes");
	}


	function sfpg_base64url_encode($plain)
	{
		$base64 = base64_encode($plain);
		$base64url = strtr($base64, "+/", "-_");
		return rtrim($base64url, "=");
	}


	function sfpg_base64url_decode($base64url)
	{
		$base64 = strtr($base64url, "-_", "+/");
		$plain = base64_decode($base64);
		return ($plain);
	}


	function sfpg_url_string($dir = "", $img = "")
	{
		$res = $dir . "*" . $img . "*";
		return sfpg_base64url_encode($res . md5($res . SECURITY_PHRASE));
	}


	function str_to_script($str)
	{
		return str_replace("\r", "", str_replace("\n", "", str_replace("\"", "\\\"", str_replace("'", "\'", (NL_TO_BR ? nl2br($str) : $str)))));
	}


	function sfpg_display_name($name, $show_ext)
	{
		$break_pos = strpos($name, SORT_DIVIDER);
		if ($break_pos !== FALSE)
		{
			$display_name = substr($name, $break_pos + strlen(SORT_DIVIDER));
		}
		else
		{
			$display_name = $name;
		}
		if (UNDERSCORE_AS_SPACE)
		{
			$display_name = str_replace("_", " ", $display_name);
		}
		if (!$show_ext)
		{
			$display_name = substr($display_name, 0, strrpos($display_name, "."));
		}
		return $display_name;
	}


	function sfpg_ext($file)
	{
		return strtolower(substr($file, strrpos($file, ".")));
	}


	function sfpg_image_type($file)
	{
		$type = sfpg_ext($file);
		if (($type == ".jpg") or ($type == ".jpeg"))
		{
			return "jpeg";
		}
		elseif ($type == ".png")
		{
			return "png";
		}
		elseif ($type == ".gif")
		{
			return "gif";
		}
		return FALSE;
	}


	function sfpg_get_dir($dir)
	{
		global $dir_exclude, $file_exclude, $file_ext_exclude;
		$dirs = array();
		$dirs_time = array();
		$images = array();
		$images_time = array();
		$files = array();
		$files_time = array();
		$directory_handle = opendir(GALLERY_ROOT . $dir);
		if ($directory_handle != FALSE)
		{
			while($var = readdir($directory_handle))
			{
				if (is_dir(GALLERY_ROOT . $dir . $var))
				{
					if	(($var != ".") and ($var != "..") and !in_array(strtolower($var), $dir_exclude))
					{
						$dirs[] = $var;
						if (DIR_SORT_BY_TIME)
						{
							$dirs_time[] = filemtime(GALLERY_ROOT . $dir . $var . "/.");
						}
					}
				}
				elseif (sfpg_image_type($var))
				{
					if ($var != DIR_IMAGE_FILE)
					{
						$images[] = $var;
						if (IMAGE_SORT_BY_TIME)
						{
							$images_time[] = filemtime(GALLERY_ROOT . $dir . $var);
						}
					}
				}
				elseif (SHOW_FILES)
				{
					if (!in_array(strtolower($var), $file_exclude) and !((strrpos($var, ".") !== FALSE) and in_array(sfpg_ext($var), $file_ext_exclude)))
					{
						$files[] = $var;
						if (FILE_SORT_BY_TIME)
						{
							$files_time[] = filemtime(GALLERY_ROOT . $dir . $var);
						}
					}
				}
			}
			if (SHOW_FILES)
			{
				foreach ($files as $val)
				{
					$fti = array_search($val . FILE_THUMB_EXT, $images);
					if ($fti !== FALSE)
					{
						array_splice($images, $fti, 1);
						array_splice($images_time, $fti, 1);
					}
				}
			}
			sfpg_array_sort($dirs, $dirs_time, DIR_SORT_BY_TIME, DIR_SORT_REVERSE);
			sfpg_array_sort($images, $images_time, IMAGE_SORT_BY_TIME, IMAGE_SORT_REVERSE);
			sfpg_array_sort($files, $files_time, FILE_SORT_BY_TIME, FILE_SORT_REVERSE);
			return array($dirs, $images, $files);
		}
		else
		{
			header("Location: " . $_SERVER["PHP_SELF"]);
			exit;
		}
	}


	function sfpg_image($image_dir, $image_file, $func, $download=FALSE)
	{
		$image_path_file = DATA_ROOT . $func . "/" . $image_dir . $image_file;
		$image_type = sfpg_image_type($image_path_file);

		if ($func == "image")
		{
			if (!file_exists($image_path_file))
			{
				$image_path_file = GALLERY_ROOT . $image_dir . $image_file;
			}
			if ($download)
			{		
				header("Content-Type: application/octet-stream");
				header("Content-Disposition: attachment; filename=\"" . $image_file . "\"");
			}
			else
			{
				header("Content-Type: image/" . $image_type);
				header("Content-Disposition: filename=\"" . $image_file . "\"");
			}
			readfile($image_path_file);
			exit;
		}

		if (($func == "thumb") or ($func == "preview"))
		{
			if (file_exists($image_path_file))
			{
				header("Content-Type: image/" . $image_type);
				header("Content-Disposition: filename=\"" . $func . "_" . $image_file . "\"");
				readfile($image_path_file);
				exit;
			}
			else
			{
				if($func == "thumb")
				{
					$max_width = THUMB_MAX_WIDTH;
					$max_height = THUMB_MAX_HEIGHT;
					$enlarge = THUMB_ENLARGE;
					$jpeg_quality = THUMB_JPEG_QUALITY;
					$source_img = GALLERY_ROOT . $image_dir . $image_file;
				}
				else
				{
					$max_width = PREVIEW_MAX_WIDTH;
					$max_height = PREVIEW_MAX_HEIGHT;
					$enlarge = PREVIEW_ENLARGE;
					$jpeg_quality = PREVIEW_JPEG_QUALITY;
					$source_img = DATA_ROOT . "image/" . $image_dir . $image_file;
					if (!file_exists($source_img))
					{
						$source_img = GALLERY_ROOT . $image_dir . $image_file;
					}
				}

				if (!$image = imagecreatefromstring(file_get_contents($source_img)))
				{
					exit;
				}

				if (($func == "thumb") and ($image_dir != "_sfpg_icons/"))
				{
					$image_changed = FALSE;
					if (!is_dir(DATA_ROOT . "info/" . $image_dir))
					{
						mkdir(DATA_ROOT . "info/" . $image_dir, 0777, TRUE);
					}
					$exif_info = "";
					if (function_exists("read_exif_data"))
					{
						if (SHOW_EXIF_INFO)
						{
							$exif_data = exif_read_data(GALLERY_ROOT . $image_dir . $image_file, "IFD0");
							if ($exif_data !== FALSE)
							{
								$exif_info .= TEXT_EXIF_DATE . ": " . $exif_data["DateTimeOriginal"] ." | ";
								$exif_info .= TEXT_EXIF_CAMERA . ": " . $exif_data["Model"] ." | ";
								$exif_info .= TEXT_EXIF_ISO . ": ";
								if(isset($exif_data["ISOSpeedRatings"]))
								{
									$exif_info .= $exif_data["ISOSpeedRatings"];
								}
								else
								{
									$exif_info .= "n/a";
								}
								$exif_info .= " | ";
								
								$exif_info .= TEXT_EXIF_SHUTTER . ": ";
								if(isset($exif_data["ExposureTime"]))
								{
									$exif_ExposureTime=create_function('','return '.$exif_data["ExposureTime"].';');
									$exp_time = $exif_ExposureTime();
									if ($exp_time > 0.25)
									{
										$exif_info .= $exp_time;
									}
									else
									{
										$exif_info .= $exif_data["ExposureTime"];
									}
									$exif_info .= "s";
									
								}
								else
								{
									$exif_info .= "n/a";
								}
								$exif_info .= " | ";

								$exif_info .= TEXT_EXIF_APERTURE . ": ";
								if(isset($exif_data["FNumber"]))
								{
									$exif_FNumber=create_function('','return number_format(round('.$exif_data["FNumber"].',1),1);');
									$exif_info .= "f".$exif_FNumber();
								}
								else
								{
									$exif_info .= "n/a";
								}
								$exif_info .= " | ";

								$exif_info .= TEXT_EXIF_FOCAL . ": ";
								if(isset($exif_data["FocalLength"]))
								{
									$exif_FocalLength=create_function('','return number_format(round('.$exif_data["FocalLength"].',1),1);');
									$exif_info .= $exif_FocalLength();
								}
								else
								{
									$exif_info .= "n/a";
								}
								$exif_info .= "mm | ";
								
								$exif_info .= TEXT_EXIF_FLASH . ": ";
								if(isset($exif_data["Flash"]))
								{
									$exif_info .= (($exif_data["Flash"] & 1) ? TEXT_YES : TEXT_NO);
								}
								else
								{
									$exif_info .= "n/a";
								}
								$exif_info .= " | ";
							}
							else
							{
								$exif_info .= TEXT_EXIF_MISSING . " | ";
							}
						}

						if (ROTATE_IMAGES and isset($exif_data["Orientation"]))
						{
							$image_width = imagesx($image);
							$image_height = imagesy($image);

							switch ($exif_data["Orientation"])
							{
								case 2 :
								{
									$rotate = @imagecreatetruecolor($image_width, $image_height);
									imagecopyresampled($rotate, $image, 0, 0, $image_width-1, 0, $image_width, $image_height, -$image_width, $image_height);
									imagedestroy($image);
									$image_changed = TRUE;
									break;
								}
								case 3 :
								{
									$rotate = imagerotate($image, 180, 0);
									imagedestroy($image);
									$image_changed = TRUE;
									break;
								}
								case 4 :
								{
									$rotate = @imagecreatetruecolor($image_width, $image_height);
									imagecopyresampled($rotate, $image, 0, 0, 0, $image_height-1, $image_width, $image_height, $image_width, -$image_height);
									imagedestroy($image);
									$image_changed = TRUE;
									break;
								}
								case 5 :
								{
									$rotate = imagerotate($image, 270, 0);
									imagedestroy($image);
									$image = $rotate;
									$rotate = @imagecreatetruecolor($image_height, $image_width);
									imagecopyresampled($rotate, $image, 0, 0, 0, $image_width-1, $image_height, $image_width, $image_height, -$image_width);
									$image_changed = TRUE;
									break;
								}
								case 6 :
								{
									$rotate = imagerotate($image, 270, 0);
									imagedestroy($image);
									$image_changed = TRUE;
									break;
								}
								case 7 :
								{
									$rotate = imagerotate($image, 90, 0);
									imagedestroy($image);
									$image = $rotate;
									$rotate = @imagecreatetruecolor($image_height, $image_width);
									imagecopyresampled($rotate, $image, 0, 0, 0, $image_width-1, $image_height, $image_width, $image_height, -$image_width);
									$image_changed = TRUE;
									break;
								}
								case 8 :
								{
									$rotate = imagerotate($image, 90, 0);
									imagedestroy($image);
									$image_changed = TRUE;
									break;
								}
								default: $rotate = $image;
							}
							$image = $rotate;
						}
					}
					
					if (WATERMARK)
					{
						$wm_file = GALLERY_ROOT . "_sfpg_icons/" . WATERMARK;
						if (file_exists($wm_file))
						{
							if ($watermark = imagecreatefromstring(file_get_contents($wm_file)))
							{
								$image_width = imagesx($image);
								$image_height = imagesy($image);
								$ww = imagesx($watermark);
								$wh = imagesy($watermark);
								imagecopy($image, $watermark, $image_width-$ww, $image_height-$wh, 0, 0, $ww, $wh);
								imagedestroy($watermark);
								$image_changed = TRUE;
							}
						}
					}

					if ($image_changed)
					{
						if (!is_dir(DATA_ROOT . "image/" . $image_dir))
						{
							mkdir(DATA_ROOT . "image/" . $image_dir, 0777, TRUE);
						}
						$new_full_img = DATA_ROOT . "image/" . $image_dir . $image_file;
						if ($image_type == "jpeg")
						{
							imagejpeg($image, $new_full_img, IMAGE_JPEG_QUALITY);
						}
						elseif ($image_type == "png")
						{
							imagepng($image, $new_full_img);
						}
						elseif ($image_type == "gif")
						{
							imagegif($image, $new_full_img);
						}
					}
					
					$fp = fopen(DATA_ROOT . "info/" . $image_dir . $image_file . ".sfpg", "w");
					fwrite($fp, date(DATE_FORMAT, filemtime(GALLERY_ROOT . $image_dir . $image_file)) . "|" . sfpg_file_size(filesize(GALLERY_ROOT . $image_dir . $image_file)) . "|" . imagesx($image) . "|" . imagesy($image) . "|" . $exif_info);
					fclose($fp);
				}

				$image_width = imagesx($image);
				$image_height = imagesy($image);
				if (($image_width < $max_width) and ($image_height < $max_height) and !$enlarge)
				{
					$new_img_height = $image_height;
					$new_img_width = $image_width;
				}
				else
				{
					$aspect_x = $image_width / $max_width;
					$aspect_y = $image_height / $max_height;
					if ($aspect_x > $aspect_y)
					{
						$new_img_width = $max_width;
						$new_img_height = $image_height / $aspect_x;
					}
					else
					{
						$new_img_height = $max_height;
						$new_img_width = $image_width / $aspect_y;
					}
				}
				$new_image = imagecreatetruecolor($new_img_width, $new_img_height);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_img_width, $new_img_height, imagesx($image), imagesy($image));
				imagedestroy($image);
				if (!is_dir(DATA_ROOT . $func . "/" . $image_dir))
				{
					mkdir(DATA_ROOT . $func . "/" . $image_dir, 0777, TRUE);
				}
				header("Content-type: image/" . $image_type);
				header("Content-Disposition: filename=\"" . $func . "_" . $image_file . "\"");
				if ($image_type == "jpeg")
				{
					imagejpeg($new_image, NULL, $jpeg_quality);
					imagejpeg($new_image, $image_path_file, $jpeg_quality);
				}
				elseif ($image_type == "png")
				{
					imagepng($new_image);
					imagepng($new_image, $image_path_file);
				}
				elseif ($image_type == "gif")
				{
					imagegif($new_image);
					imagegif($new_image, $image_path_file);
				}
				imagedestroy($new_image);
			}
		}
	}

	function sfpg_dir_info($directory, $initial=TRUE)
	{
		list($dirs, $images, $files) = sfpg_get_dir($directory);
		if ($initial)
		{
			$info = count($dirs) . "|" . count($images) . "|" . count($files) . "|" . date(DATE_FORMAT, filemtime(GALLERY_ROOT . GALLERY . ".")) . "|";
		}
		else
		{
			$info = "";
		}
		if ((DIR_IMAGE_FILE) and file_exists(GALLERY_ROOT . $directory . DIR_IMAGE_FILE))
		{
			return $info . sfpg_url_string($directory, DIR_IMAGE_FILE);
		}
		if (isset($images[0]))
		{
			return $info . sfpg_url_string($directory, $images[0]);
		}
		else
		{
			foreach ($dirs as $subdir)
			{
				$subresult = sfpg_dir_info($directory . $subdir . "/", FALSE);
				if ($subresult != "")
				{
					return $info . $subresult;
				}
			}
		}
		return $info;
	}


	function sfpg_set_dir_info($directory)
	{
		if (!is_dir(DATA_ROOT . "info/" . $directory))
		{
			mkdir(DATA_ROOT . "info/" . $directory, 0777, TRUE);
		}
		if ($fp = fopen(DATA_ROOT . "info/" . $directory . "_info.sfpg", "w"))
		{
			fwrite($fp, sfpg_dir_info($directory));
			fclose($fp);
		}
	}

	

//Fungsi listing item foto untuk gallery
function gallery_print_photo_list(){
	
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------------

function sfpg_javascript()
	{
		global $dirs, $images, $files, $file_ext_thumbs, $text;
		
		//echo "navLink[1] = '" . sfpg_url_string('') . "';\n";
		//echo "navName[1] = '" . str_to_script(TEXT_HOME) . "';\n\n";
		
		$links = explode("/", GALLERY);
		$gal_dirs = "";
		/**if (GALLERY and is_array($links))
		{
			for ($i = 0; $i < count($links); $i++)
			{
				if ($links[$i])
				{
					$gal_dirs .= $links[$i] . "/";
					$display_name = @file(GALLERY_ROOT . $gal_dirs . DIR_NAME_FILE);
					if ($display_name)
					{
						$display_name = trim($display_name[0]);
					}
					else
					{
						$display_name = sfpg_display_name($links[$i], TRUE);
					}
					$a_names[] = $display_name;
					$a_links[] = $gal_dirs;
				}
			}
			$link_disp_lenght = strlen(TEXT_HOME) + 4;
			$start_link = count($a_names)-1;
			for($i = count($a_names)-1; $i >= 0; $i--)
			{
				$link_disp_lenght += strlen($a_names[$i]) + 5;
				if ($link_disp_lenght < NAVI_CHARS_MAX)
				{
					$start_link = $i;
				}
			}
			$i = 2;
			for ($link_nr = $start_link; $link_nr < count($a_links); $link_nr++)
			{
				if(($start_link > 0) and ($link_nr == $start_link))
				{
					echo "navLink[".$i."] = '';\n";
					echo "navName[".$i."] = '" . str_to_script(" ... ") . "';\n\n";
					$i++;
				}
				else
				{
					echo "navLink[".$i."] = '';\n";
					echo "navName[".$i."] = '" . str_to_script(" > ") . "';\n\n";
					$i++;
				}
				echo "navLink[".$i."] = '" . sfpg_url_string($a_links[$link_nr]) . "';\n";
				echo "navName[".$i."] = '" . str_to_script($a_names[$link_nr]) . "';\n\n";
				$i++;
			}
			echo "dirLink[0] = '" . sfpg_url_string($a_links[count($a_links)-1]) . "';\n";
			echo "dirName[0] = '" . str_to_script((count($a_links) == 0 ? TEXT_HOME : $a_names[count($a_links)-1])) . "';\n";
		}
		else
		{
			echo "dirLink[0] = '" . sfpg_url_string("") . "';\n";
			echo "dirName[0] = '" . str_to_script(TEXT_HOME) . "';\n";
		}**/
		
		if (!file_exists(DATA_ROOT . "info/" . GALLERY . "_info.sfpg"))
		{
			sfpg_set_dir_info(GALLERY);
		}

		$filed = explode("|", file_get_contents(DATA_ROOT . "info/" . GALLERY . "_info.sfpg"));
		if ((count($dirs) != $filed[0]) or (count($images) != $filed[1]) or (count($files) != $filed[2]))
		{
			sfpg_set_dir_info(GALLERY);
			$filed = explode("|", file_get_contents(DATA_ROOT . "info/" . GALLERY . "_info.sfpg"));
		}
		//echo "dirThumb[0] = '" . $filed[4] . "';\n";
		//echo "dirInfo[0] = '" . str_to_script($filed[3]."|".$filed[0]."|".$filed[1]."|".$filed[2]."|".@file_get_contents(GALLERY_ROOT . GALLERY . DIR_DESC_FILE)) . "';\n\n";
		
		/**$item = 1;
		foreach ($dirs as $val)
		{
			$display_name = @file(GALLERY_ROOT . GALLERY . $val . "/" . DIR_NAME_FILE);
			if ($display_name)
			{
				$display_name = trim($display_name[0]);
			}
			else
			{
				$display_name = sfpg_display_name($val, TRUE);
			}
			echo "dirName[" . ($item) . "] = '" . str_to_script($display_name) . "';\n";
			echo "dirLink[" . ($item) . "] = '" . sfpg_url_string((GALLERY . $val . "/")) . "';\n";
			if (!file_exists(DATA_ROOT . "info/" . GALLERY . $val . "/_info.sfpg"))
			{
				sfpg_set_dir_info(GALLERY . $val . "/");
			}
			$filed = explode("|", file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . "/_info.sfpg"));
			echo "dirThumb[" . ($item) . "] = '" . $filed[4] . "';\n";
			echo "dirInfo[" . ($item) . "] = '" . str_to_script($filed[3]."|".$filed[0]."|".$filed[1]."|".$filed[2]."|".@file_get_contents(GALLERY_ROOT . GALLERY . $val . "/" . DIR_DESC_FILE)) . "';\n\n";
			$item++;
		}**/

		/**$img_direct_link = FALSE;
		$item = 1;
		foreach ($images as $val)
		{
			if ($val == IMAGE)
			{
				$img_direct_link = ($item);
			}
			
			print '
				<a href="/media/foto/gallery.php?cmd=image&sfpg=' . sfpg_url_string(GALLERY, $val) . '" title="' . str_to_script(@file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg")."|".@file_get_contents(GALLERY_ROOT . GALLERY . $val . DESC_EXT)) . '" data-gallery="">
					<img src="/media/foto/gallery.php?cmd=thumb&sfpg=' . sfpg_url_string(GALLERY, $val) .'">
				</a>
			';
			
			//echo "imgLink[" . ($item) . "] = '" . sfpg_url_string(GALLERY, $val) . "';\n";
			$img_name = sfpg_display_name($val, SHOW_IMAGE_EXT);
			//echo "imgName[" . ($item) . "] = '" . str_to_script($img_name) . "';\n";
			//echo "imgInfo[" . ($item) . "] = '" . str_to_script(@file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg")."|".@file_get_contents(GALLERY_ROOT . GALLERY . $val . DESC_EXT))."';\n\n";
			$item++;
		}
		if ($img_direct_link)
		{
			define("OPEN_IMAGE_ON_LOAD", $img_direct_link);
		}
		else
		{
			define("OPEN_IMAGE_ON_LOAD", FALSE);
		}**/
		
		$table = '
			<table class="table">
					<thead>
						<tr>
							<th>' . $text[42] . '<th>
							<th>' . $text[86] . '<th>
							<th>' . $text[87] . '<th>
							<th>' . $text[29] . '</th>
						</tr>
					</thead>
					<tbody>
		';
		$java_vid = '<script>
			var myPlayer = videojs("pemutar_1");
			$("#pesan").hide();
			$("a").click(function(){ 
		';
		
		$t_label = '
			<div class="row">
		';

		$item = 1;
		foreach ($files as $val)
		{
			$ext = sfpg_ext($val);
			//echo "fileLink[" . ($item) . "] = '" . sfpg_url_string(GALLERY, $val) . "';\n";
			
			if($item == 1) {
			$java_vid .= '   
				if($(this).attr("id") == "PL-'. sfpg_url_string(GALLERY, $val) . '"){
					videojs("pemutar_1").ready(function(){
					  var myPlayer = this;
					  myPlayer.src({ type: "video/mp4", src: "/media/video/video.php?cmd=file&sfpg=' . sfpg_url_string(GALLERY, $val) . '" });
					  myPlayer.width("100%",true);
					  myPlayer.load();
					  myPlayer.play();
					});
				}
				
				else if($(this).attr("id") == "RM-' . sfpg_url_string(GALLERY, $val) . '"){
					if (confirm("' . $text[96] . '")) {
					$("#pesan").show();
					var loadUrl = "/media/video/video.php?cmd=del&sfpg=' .  sfpg_url_string(GALLERY, $val) . '";
					$("#pesan").html();
					$.get(
						loadUrl,
						{language: "php", version: 5},
						function(responseText){
							$("#pesan").html(responseText);
						},
						"html"
					);
					$("#DIV-' . sfpg_url_string(GALLERY, $val) . '").remove();
					} else {
						// Do nothing!
					}
				}';
			}
			else{
				$java_vid .= ' 
				else if($(this).attr("id") == "PL-'. sfpg_url_string(GALLERY, $val) .'"){
					videojs("pemutar_1").ready(function(){
					  var myPlayer = this;
					  myPlayer.src({ type: "video/mp4", src: "/media/video/video.php?cmd=file&sfpg=' . sfpg_url_string(GALLERY, $val) . '" });
					  myPlayer.width("100%",true);
					  myPlayer.load();
					  myPlayer.play();
					});
				}
				
				else if($(this).attr("id") == "RM-' . sfpg_url_string(GALLERY, $val) . '"){
					if (confirm("' . $text[96] . '")) {
					$("#pesan").show();
					var loadUrl = "/media/video/video.php?cmd=del&sfpg=' .  sfpg_url_string(GALLERY, $val) . '";
					$("#pesan").html();
					$.get(
						loadUrl,
						{language: "php", version: 5},
						function(responseText){
							$("#pesan").html(responseText);
						},
						"html"
					);
					$("#DIV-' . sfpg_url_string(GALLERY, $val) . '").remove();
					} else {
						// Do nothing!
					}
				}';
			}
			
			/**$table .= '
				<tr>
					<td>' . $item . '<td>
					<td>' . str_to_script(sfpg_display_name($val, SHOW_FILE_EXT)) . '<td>
					<td>' . str_to_script(@file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg") . " | " . @file_get_contents(GALLERY_ROOT . GALLERY . $val . DESC_EXT)) . '<td>					
					<td><a href="#" id="' . sfpg_url_string(GALLERY, $val) . '"><i class="fa fa-play"> </i> </a></td>
				</tr>
			';**/
			$info = str_to_script(@file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg") . " | " . @file_get_contents(GALLERY_ROOT . GALLERY . $val . DESC_EXT));
			$extract = explode('|',$info);
			$date_taken = $extract[0];
			$size = $extract[1];
			$t_label .= '
			<div id="DIV-' . sfpg_url_string(GALLERY, $val) . '" class="col-sm-3 col-md-3">
				<div class="thumbnail">
				  <img src="/media/vid.jpg" alt="..." class="img-circle">
				  <div class="caption">
					<h5>' . str_to_script(sfpg_display_name($val, SHOW_FILE_EXT)) . '</h5>
					<p class="info">' . $text[90] . ' : ' . $date_taken . '</p>
					<p class="info">' . $text[91] . ' : ' . $size . '</p>
					<p class="kontrol"><a href="#" id="PL-' . sfpg_url_string(GALLERY, $val) . '" title="'. $text[89] .'"><i class="fa fa-play"> </i> </a> <a href="/media/video/video.php?cmd=file&sfpg=' . sfpg_url_string(GALLERY, $val) . '" title="'. $text[39] .'"> <i class="fa fa-download"></i></a> <a href="#" id="RM-' . sfpg_url_string(GALLERY, $val) . '"  title="'. $text[92] .'"><i class="fa fa-trash-o"></i> </a></p>
				  </div>
				</div>
			  </div>
			';
			
			//print sfpg_url_string(GALLERY, $val);
			/**if (FILE_THUMB_EXT and file_exists(GALLERY_ROOT . GALLERY . $val . FILE_THUMB_EXT))
			{
				echo "fileThumb[" . ($item) . "] = '" . sfpg_url_string(GALLERY, $val . FILE_THUMB_EXT) . "';\n";
			}
			elseif (isset($file_ext_thumbs[$ext]))
			{
				echo "fileThumb[" . ($item) . "] = '" . sfpg_url_string("_sfpg_icons/", $file_ext_thumbs[$ext]) . "';\n";
			}
			else
			{
				echo "fileThumb[" . ($item) . "] = '';\n";
			}
			echo "fileName[" . ($item) . "] = '" . str_to_script(sfpg_display_name($val, SHOW_FILE_EXT)) . "';\n";**/
			if (!file_exists(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg"))
			{
				$fp = fopen(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg", "w");
				fwrite($fp, date(DATE_FORMAT, filemtime(GALLERY_ROOT . GALLERY . $val)) . " | " . sfpg_file_size(filesize(GALLERY_ROOT . GALLERY . $val)));
				fclose($fp);
			}
			//echo "fileInfo[" . ($item) . "] = '" . str_to_script(@file_get_contents(DATA_ROOT . "info/" . GALLERY . $val . ".sfpg") . " | " . @file_get_contents(GALLERY_ROOT . GALLERY . $val . DESC_EXT)) . "';\n\n";
			$item++;
		}
		$java_vid .= '
		});
		</script>';
		$table .= '
					</tbody>
				</table>
			';
		$t_label .= '
						</div>
		';
		//print $table;
		print $t_label;
		print $java_vid;
		
	}


//-----------------------------------------------------------------------------------------------------------------------------------------------------------
	$get_set = FALSE;
	if (isset($_GET["sfpg"]))
	{
		$get = explode("*", sfpg_base64url_decode($_GET["sfpg"]));
		if ((md5($get[0] . "*" . $get[1] . "*" . SECURITY_PHRASE) === $get[2]) and (strpos($get[0] . $get[1], "..") === FALSE))
		{			
			define("GALLERY", $get[0]);
			define("IMAGE", $get[1]);
			$get_set = TRUE;
		}
	}
	if (!$get_set)
	{
		define("GALLERY", "");
		define("IMAGE", "");
	}

	if (isset($_GET["cmd"]))
	{
		if ($_GET["cmd"] == "del")
		{			
			//Hapus berkas
			//Utama
			unlink($_SERVER['DOCUMENT_ROOT'] . '/media/video/' . IMAGE);
			//Thumb
			//unlink($_SERVER['DOCUMENT_ROOT'] . '/media/video/_sfpg_data/thumb/' . IMAGE);
			//Info
			unlink($_SERVER['DOCUMENT_ROOT'] . '/media/video/_sfpg_data/info/' . IMAGE . '.sfpg');
			
			//Siapkan respon
			$data = $text[94] . ' ' . IMAGE . ' ' . $text[95] . '.';
			
			print $data;
		}
	
		if ($_GET["cmd"] == "thumb")
		{
			sfpg_image(GALLERY, IMAGE, "thumb");
			exit;
		}


		if ($_GET["cmd"] == "preview")
		{
			if (USE_PREVIEW)
			{
				sfpg_image(GALLERY, IMAGE, "preview");
			}
			exit;
		}


		if ($_GET["cmd"] == "image")
		{
			sfpg_image(GALLERY, IMAGE, "image");
			exit;
		}


		if (($_GET["cmd"] == "dl") and TEXT_DOWNLOAD)
		{
			sfpg_image(GALLERY, IMAGE, "image", TRUE);
			exit;
		}


		if ($_GET["cmd"] == "file")
		{
			header("Location: " . GALLERY_ROOT . GALLERY . IMAGE);
			exit;
		}

	}

	list($dirs, $images, $files) = sfpg_get_dir(GALLERY);

	
	//print '<pre>';
	//var_dump(sfpg_get_dir(GALLERY));
	//var_dump($get[1]);
	//print '</pre>';
	//exit();
	endif;
?>
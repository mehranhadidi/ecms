<?php
/**
 * Created by PhpStorm.
 * User: BioDread
 * Date: 10/5/2014
 * Time: 2:56 PM
 */

class Utils
{

	private  static $salt = "9f65555006851acccaed052b03431f708124c077";   // for hashing
	private static $seed = "iportal";                              // for encrypt/decrypt strings



	/**
	 * Get the current Date & Time
	 *
	 * @param string $format
	 * @return string
	 */
	public static function GET_CURRENT_DATE_TIME ($format = "%Y-%m-%d %H:%M:%S")
	{
		return strftime($format, time());
	}

	/**
	 * Compress strings for smallest size
	 *
	 * @param string $string
	 * @return string
	 */
	public static function COMPRESS_STRING ($string = null)
	{
		if ($string != null)
			return gzcompress($string);
		else return null;
	}

	/**
	 * decompress minified strings
	 *
	 * @param string $compressed_string
	 * @return string
	 */
	public static function DECOMPRESS_STRING ($compressed_string = null)
	{
		if ($compressed_string != null)
			return gzuncompress($compressed_string);
		else return null;
	}

	/**
	 * Generate a random string equal to length given
	 *
	 * @param int $length
	 * @return string
	 */
	public static function RANDOM_STRING ($length)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$str = "";
		$size = strlen( $chars );

		for( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}

	/**
	 * Generate a random number equal to length given
	 *
	 * @param int $length
	 * @return string
	 */
	public static function RANDOM_NUMBER ($length)
	{
		$chars = "123456789";

		$str ="";
		$size = strlen( $chars );

		for( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}

	/**
	 * calculating bytes to GB,MB,KB
	 * @param $bytes
	 * @return string
	 */

	public static function FORMAT_FILE_SIZE($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		return $bytes;
	}


	/**
	 * Character Limiter
	 *
	 * Limits the string based on the character count.  Preserves complete words
	 * so the character count may not be exactly as specified.
	 *
	 * @access   public
	 * @param    string
	 * @param    integer
	 * @param    string  the end character. Usually an ellipsis
	 * @return   string
	 */
	public static function CHARACTER_LIMITER($str, $n = 500, $end_char = '&#8230;')
	{
		if (strlen($str) < $n)
		{
			return $str;
		}

		$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

		if (strlen($str) <= $n)
		{
			return $str;
		}

		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';

			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}
		}

		return null;
	}


	/**
	 *
	 * @param string $string
	 * @param boolean $salt
	 * @return string
	 */
	public static function HASH($string, $salt = true)
	{
		if($salt)
		{
			return md5(( $string . self::$salt) . self::$salt );
		}
		else
		{
			return md5($string);
		}
	}


	/**
	 *
	 * @param string $string
	 * @return string
	 */
	public static function ENCRYPT ($string)
	{
		return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$seed, $string, MCRYPT_MODE_ECB);
	}


	/**
	 * @param $upload_control_temp_image
	 * @return string
	 */
	public static function IMAGE_CONVERT_TO_BYTE_ARRAY ($upload_control_temp_image)
	{
		return addslashes (file_get_contents($upload_control_temp_image));
		// $_FILES["FieldName"]["tmp_name"]
	}

	/**
	 * @param $url
	 * @param bool $permanent
	 */
	public static function REDIRECT_TO ($url, $permanent = false)
	{
		if (headers_sent() === false)
		{
			header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
		}

		exit();
	}

	/**
	 * dump object to debug
	 *
	 * @param $object
	 */
	public static function DUMP($object)
	{
		echo '<pre>';
		var_dump($object);
		echo '</pre>';
	}
} 
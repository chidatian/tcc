<?php

namespace A;

class Logger
{
    const ALL = 0;
	const DEBUG = 1;
	const TRACE = 2;
	const INFO = 3;
	const NOTICE = 4;
	const WARNING = 5;
	const FATAL = 6;
	protected static $ARR_DESC = array (
                                0 => 'ALL', 
                                1 => 'DEBUG', 
                                2 => 'TRACE', 
                                3 => 'INFO',
                                4 => 'NOTICE', 
                                5 => 'WARNING', 
                                6 => 'FATAL' 
                            );
    protected static $FILE = array();

    public static function init($filename, $level = 0)
    {
		self::checkFileDir($filename);

        self::$FILE[$level] = $filename;
    }

    protected static function checkFileDir($filename)
    {
		$dir = dirname ( $filename );
        if (! file_exists ( $dir ))
        {
            if (! mkdir ( $dir, 0755, true ))
            {
                trigger_error ( "create log file $filename failed, no permmission" );
                return false;
            }
        }
        return true;
    }

    protected static function log($level, $arr)
    {
       
        $file = isset(self::$FILE[$level]) ? self::$FILE[$level] : self::$FILE[0];
		$arrMicro = explode ( " ", microtime() );
        $content = '[' . date ( 'Y-m-d H:i:s ' );
		$content .= sprintf ( "%06d", intval ( 1000000 * $arrMicro [0] ) );
		$content .= '][';
		$content .= self::$ARR_DESC [$level];
		$content .= "]";
        $content .= call_user_func_array('sprintf', $arr);
        // $content .= json_encode($arr);
        $content .= PHP_EOL;


        file_put_contents($file, $content, FILE_APPEND);
    }

    public static function info()
	{

		$arrArg = func_get_args ();
		self::log ( self::INFO, $arrArg );
	}

    public static function debug()
	{

		$arrArg = func_get_args ();
		self::log ( self::DEBUG, $arrArg );
	}

    public static function notice()
	{

		$arrArg = func_get_args ();
		self::log ( self::NOTICE, $arrArg );
	}

	public static function warning()
	{

		$arrArg = func_get_args ();
		self::log ( self::WARNING, $arrArg );
	}

	public static function fatal()
	{

		$arrArg = func_get_args ();
		self::log ( self::FATAL, $arrArg );
	}

    public static function trace()
	{

		$arrArg = func_get_args ();
		self::log ( self::TRACE, $arrArg );
	}


}
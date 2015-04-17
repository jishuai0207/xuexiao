<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Common Functions
 *
 * Loads the base classes and executes the request.
 *
 * @package		CodeIgniter
 * @subpackage	codeigniter
 * @category	Common Functions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/
 */

// ------------------------------------------------------------------------

/**
 * Determines if the current version of PHP is greater then the supplied value
 *
 * Since there are a few places where we conditionally test for PHP > 5
 * we'll set a static variable.
 *
 * @access	public
 * @param	string
 * @return	bool	TRUE if the current version is $version or higher
 */
if ( ! function_exists('is_php'))
{
    function is_php($version = '5.0.0')
    {
        static $_is_php;
        $version = (string)$version;

        if ( ! isset($_is_php[$version]))
        {
            $_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
        }

        return $_is_php[$version];
    }
}

// ------------------------------------------------------------------------

/**
 * Tests for file writability
 *
 * is_writable() returns TRUE on Windows servers when you really can't write to
 * the file, based on the read-only attribute.  is_writable() is also unreliable
 * on Unix servers if safe_mode is on.
 *
 * @access	private
 * @return	void
 */
if ( ! function_exists('is_really_writable'))
{
    function is_really_writable($file)
    {
        // If we're on a Unix server with safe_mode off we call is_writable
        if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
        {
            return is_writable($file);
        }

        // For windows servers and safe_mode "on" installations we'll actually
        // write a file then read it.  Bah...
        if (is_dir($file))
        {
            $file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));

            if (($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
            {
                return FALSE;
            }

            fclose($fp);
            @chmod($file, DIR_WRITE_MODE);
            @unlink($file);
            return TRUE;
        }
        elseif ( ! is_file($file) OR ($fp = @fopen($file, FOPEN_WRITE_CREATE)) === FALSE)
        {
            return FALSE;
        }

        fclose($fp);
        return TRUE;
    }
}

// ------------------------------------------------------------------------

/**
 * Class registry
 *
 * This function acts as a singleton.  If the requested class does not
 * exist it is instantiated and set to a static variable.  If it has
 * previously been instantiated the variable is returned.
 *
 * @access	public
 * @param	string	the class name being requested
 * @param	string	the directory where the class should be found
 * @param	string	the class name prefix
 * @return	object
 */
if ( ! function_exists('load_class'))
{
    function &load_class($class, $directory = 'libraries', $prefix = 'CI_')
    {
        static $_classes = array();

        // Does the class exist?  If so, we're done...
        if (isset($_classes[$class]))
        {
            return $_classes[$class];
        }

        $name = FALSE;

        // Look for the class first in the local application/libraries folder
        // then in the native system/libraries folder
        foreach (array(APPPATH, BASEPATH) as $path)
        {
            if (file_exists($path.$directory.'/'.$class.'.php'))
            {
                $name = $prefix.$class;

                if (class_exists($name) === FALSE)
                {
                    require($path.$directory.'/'.$class.'.php');
                }

                break;
            }
        }

        // Is the request a class extension?  If so we load it too
        if (file_exists(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php'))
        {
            $name = config_item('subclass_prefix').$class;

            if (class_exists($name) === FALSE)
            {
                require(APPPATH.$directory.'/'.config_item('subclass_prefix').$class.'.php');
            }
        }

        // Did we find the class?
        if ($name === FALSE)
        {
            // Note: We use exit() rather then show_error() in order to avoid a
            // self-referencing loop with the Excptions class
            exit('Unable to locate the specified class: '.$class.'.php');
        }

        // Keep track of what we just loaded
        is_loaded($class);

        $_classes[$class] = new $name();
        return $_classes[$class];
    }
}

// --------------------------------------------------------------------

/**
 * Keeps track of which libraries have been loaded.  This function is
 * called by the load_class() function above
 *
 * @access	public
 * @return	array
 */
if ( ! function_exists('is_loaded'))
{
    function &is_loaded($class = '')
    {
        static $_is_loaded = array();

        if ($class != '')
        {
            $_is_loaded[strtolower($class)] = $class;
        }

        return $_is_loaded;
    }
}

// ------------------------------------------------------------------------

/**
 * Loads the main config.php file
 *
 * This function lets us grab the config file even if the Config class
 * hasn't been instantiated yet
 *
 * @access	private
 * @return	array
 */
if ( ! function_exists('get_config'))
{
    function &get_config($replace = array())
    {
        static $_config;

        if (isset($_config))
        {
            return $_config[0];
        }

        // Is the config file in the environment folder?
        if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/config.php'))
        {
            $file_path = APPPATH.'config/config.php';
        }

        // Fetch the config file
        if ( ! file_exists($file_path))
        {
            exit('The configuration file does not exist.');
        }

        require($file_path);

        // Does the $config array exist in the file?
        if ( ! isset($config) OR ! is_array($config))
        {
            exit('Your config file does not appear to be formatted correctly.');
        }

        // Are any values being dynamically replaced?
        if (count($replace) > 0)
        {
            foreach ($replace as $key => $val)
            {
                if (isset($config[$key]))
                {
                    $config[$key] = $val;
                }
            }
        }

        $_config[0] =& $config;
        return $_config[0];
    }
}

// ------------------------------------------------------------------------

/**
 * Returns the specified config item
 *
 * @access	public
 * @return	mixed
 */
if ( ! function_exists('config_item'))
{
    function config_item($item)
    {
        static $_config_item = array();

        if ( ! isset($_config_item[$item]))
        {
            $config =& get_config();

            if ( ! isset($config[$item]))
            {
                return FALSE;
            }
            $_config_item[$item] = $config[$item];
        }

        return $_config_item[$item];
    }
}

// ------------------------------------------------------------------------

/**
 * Error Handler
 *
 * This function lets us invoke the exception class and
 * display errors using the standard error template located
 * in application/errors/errors.php
 * This function will send the error page directly to the
 * browser and exit.
 *
 * @access	public
 * @return	void
 */
if ( ! function_exists('show_error'))
{
    function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
    {
        $_error =& load_class('Exceptions', 'core');
        echo $_error->show_error($heading, $message, 'error_general', $status_code);
        exit;
    }
}

// ------------------------------------------------------------------------

/**
 * 404 Page Handler
 *
 * This function is similar to the show_error() function above
 * However, instead of the standard error template it displays
 * 404 errors.
 *
 * @access	public
 * @return	void
 */
if ( ! function_exists('show_404'))
{
    function show_404($page = '', $log_error = TRUE)
    {
        $_error =& load_class('Exceptions', 'core');
        $_error->show_404($page, $log_error);
        exit;
    }
}

// ------------------------------------------------------------------------

/**
 * Error Logging Interface
 *
 * We use this as a simple mechanism to access the logging
 * class and send messages to be logged.
 *
 * @access	public
 * @return	void
 */
if ( ! function_exists('log_message'))
{
    function log_message($level = 'error', $message, $php_error = FALSE)
    {
        static $_log;

        if (config_item('log_threshold') == 0)
        {
            return;
        }

        $_log =& load_class('Log');
        $_log->write_log($level, $message, $php_error);
    }
}

// ------------------------------------------------------------------------

/**
 * Set HTTP Status Header
 *
 * @access	public
 * @param	int		the status code
 * @param	string
 * @return	void
 */
if ( ! function_exists('set_status_header'))
{
    function set_status_header($code = 200, $text = '')
    {
        $stati = array(
            200	=> 'OK',
            201	=> 'Created',
            202	=> 'Accepted',
            203	=> 'Non-Authoritative Information',
            204	=> 'No Content',
            205	=> 'Reset Content',
            206	=> 'Partial Content',

            300	=> 'Multiple Choices',
            301	=> 'Moved Permanently',
            302	=> 'Found',
            304	=> 'Not Modified',
            305	=> 'Use Proxy',
            307	=> 'Temporary Redirect',

            400	=> 'Bad Request',
            401	=> 'Unauthorized',
            403	=> 'Forbidden',
            404	=> 'Not Found',
            405	=> 'Method Not Allowed',
            406	=> 'Not Acceptable',
            407	=> 'Proxy Authentication Required',
            408	=> 'Request Timeout',
            409	=> 'Conflict',
            410	=> 'Gone',
            411	=> 'Length Required',
            412	=> 'Precondition Failed',
            413	=> 'Request Entity Too Large',
            414	=> 'Request-URI Too Long',
            415	=> 'Unsupported Media Type',
            416	=> 'Requested Range Not Satisfiable',
            417	=> 'Expectation Failed',

            500	=> 'Internal Server Error',
            501	=> 'Not Implemented',
            502	=> 'Bad Gateway',
            503	=> 'Service Unavailable',
            504	=> 'Gateway Timeout',
            505	=> 'HTTP Version Not Supported'
        );

        if ($code == '' OR ! is_numeric($code))
        {
            show_error('Status codes must be numeric', 500);
        }

        if (isset($stati[$code]) AND $text == '')
        {
            $text = $stati[$code];
        }

        if ($text == '')
        {
            show_error('No status text available.  Please check your status code number or supply your own message text.', 500);
        }

        $server_protocol = (isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;

        if (substr(php_sapi_name(), 0, 3) == 'cgi')
        {
            header("Status: {$code} {$text}", TRUE);
        }
        elseif ($server_protocol == 'HTTP/1.1' OR $server_protocol == 'HTTP/1.0')
        {
            header($server_protocol." {$code} {$text}", TRUE, $code);
        }
        else
        {
            header("HTTP/1.1 {$code} {$text}", TRUE, $code);
        }
    }
}

// --------------------------------------------------------------------

/**
 * Exception Handler
 *
 * This is the custom exception handler that is declaired at the top
 * of Codeigniter.php.  The main reason we use this is to permit
 * PHP errors to be logged in our own log files since the user may
 * not have access to server logs. Since this function
 * effectively intercepts PHP errors, however, we also need
 * to display errors based on the current error_reporting level.
 * We do that with the use of a PHP error template.
 *
 * @access	private
 * @return	void
 */
if ( ! function_exists('_exception_handler'))
{
    function _exception_handler($severity, $message, $filepath, $line)
    {
        // We don't bother with "strict" notices since they tend to fill up
        // the log file with excess information that isn't normally very helpful.
        // For example, if you are running PHP 5 and you use version 4 style
        // class functions (without prefixes like "public", "private", etc.)
        // you'll get notices telling you that these have been deprecated.
        if ($severity == E_STRICT)
        {
            return;
        }

        $_error =& load_class('Exceptions', 'core');

        // Should we display the error? We'll get the current error_reporting
        // level and add its bits with the severity bits to find out.
        if (($severity & error_reporting()) == $severity)
        {
            $_error->show_php_error($severity, $message, $filepath, $line);
        }

        // Should we log the error?  No?  We're done...
        if (config_item('log_threshold') == 0)
        {
            return;
        }

        $_error->log_exception($severity, $message, $filepath, $line);
    }
}

// --------------------------------------------------------------------

/**
 * Remove Invisible Characters
 *
 * This prevents sandwiching null characters
 * between ascii characters, like Java\0script.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('remove_invisible_characters'))
{
    function remove_invisible_characters($str, $url_encoded = TRUE)
    {
        $non_displayables = array();

        // every control character except newline (dec 10)
        // carriage return (dec 13), and horizontal tab (dec 09)

        if ($url_encoded)
        {
            $non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
            $non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
        }

        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

        do
        {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        }
        while ($count);

        return $str;
    }
}

// ------------------------------------------------------------------------

/**
 * Returns HTML escaped variable
 *
 * @access	public
 * @param	mixed
 * @return	mixed
 */
if ( ! function_exists('html_escape'))
{
    function html_escape($var)
    {
        if (is_array($var))
        {
            return array_map('html_escape', $var);
        }
        else
        {
            return htmlspecialchars($var, ENT_QUOTES, config_item('charset'));
        }
    }
}

/**
 *description:加载自定义类包
 *author:yanyalong
 *date:2014/11/04
 */
if(!function_exists('loadLib'))
{
    function loadLib($libName){
        include_once "application/libraries/$libName.php";
    }
}
/**
 *description:获取页面入口根路径
 *author:yanyalong
 *date:2014/11/04
 */
if(!function_exists('siteurl'))
{
    function siteurl(){
        $ci = &get_instance();
        return $ci->config->site_url(); 
    }
}

/**
 *description:加载防sql注入类库
 *author:yanyalong
 *date:2014/11/04
 */
if ( ! function_exists('safeFilter'))
{
    function safeFilter()
    {
        loadLib("Safe_filter");
    }
}

/**
 *description:json返回
 *author:yanyalong
 *param:$flag 0：数据结果为空或执行失败等,1：执行成功或存在相应数据，message:消息说明
 *date:2014/11/04
 */
if(!function_exists('echojson'))
{
    function echojson($status,$data,$msg="") {
        echo "{".'"status":'.intval($status).",".'"data"'.":".json_encode($data).",".'"msg"'.":".json_encode($msg)."}";exit;
    }
}

/**
* Description : 检测用户名
* Author      : jishuai
* Created Time: 2014-12-19 18:33
*/
if(!function_exists('checkName'))
{
    function checkName($name) {
        if((preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$name) && strlen($name) < 13) || preg_match("/^[A-Za-z\s]{1,40}$/",$name)){
            return true;
        }else{
            return false;
        }
    }
}

/**
* Description : 检测电话号码
* Author      : jishuai
* Created Time: 2014-12-19 18:33
*/
if(!function_exists('checkTel'))
{
    function checkTel($tel) {
		
        if(preg_match('/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/',$tel)){
            return true;
        }else{
            return false;
        }
    }
}
/**
 *description:根据二维数组某个索引值进行排序
 *author:yanyalong
 *date:2013/08/28
 */
if(!function_exists('arraysort'))
{
    function arraysort(&$array, $key_name, $sort_order = 'SORT_ASC', $sort_type = 'SORT_REGULAR') {
        if (!is_array($array)) {
            return $array;
        }
        $arg_count = func_num_args();
        for ($i = 1; $i < $arg_count; $i++) {
            $arg = func_get_arg($i);
            if (!preg_match('/SORT/', $arg)) {
                $key_name_list[] = $arg;
                $sort_rule[] = '$'.$arg;
            } else {
                $sort_rule[] = $arg;
            }
        }
        foreach ($array as $key => $info) {
            foreach ($key_name_list as $key_name) {
                ${$key_name}[$key] = $info[$key_name];
            }
        }
        $eval_str = 'array_multisort('.implode(',', $sort_rule).', $array);';
        eval($eval_str);
        return $array;
    }
}


/**
 *description:检测长度
 *author:yanyalong
 *date:2014/11/06
 */
function checkUtf8Len($string,$allowlen){
    if((strlen(trim($string)) + mb_strlen(trim($string),'UTF8'))/2>$allowlen*2) return false;
    else return true;
}
/**
 *description:跟均老师，班级，学员id生成相关编码
 *author:yanyalong
 *date:2014/11/07
 */
function objEncode($objId,$codetype){
    $ci = &get_instance();
    $ci->config->load('public');
    $common_public = $ci->config->item('common_public');
    switch ($codetype) {
    case 'S':
        $code = $common_public['studentInfo']['codeBase'];
        break;
    case 'T':
        $code = $common_public['teacherInfo']['codeBase'];
        break;
    case 'C':
        $code = $common_public['classInfo']['codeBase'];
        break;
    default:
        return false;
    }
    if(strlen($objId)>7)
        return $_SESSION['insCode'].$codetype.strval($objId);
    return $_SESSION['insCode'].$codetype.substr($code,strlen($objId)).strval($objId);
}
/**
 *description:获取指定年月的天数
 *author:yanyalong
 *date:2014/11/08
 */
function getDaysByMonth($year,$month){
    return cal_days_in_month(CAL_GREGORIAN,$month,$year);
}

/**
 *description:获取客户端ip
 *author:yanyalong
 *date:2014/11/09
 */
if ( ! function_exists('getClientIp'))
{
    function getClientIp()
    {
        if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
            $ip = getenv ( "HTTP_CLIENT_IP" );
        else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
            $ip = getenv ( "HTTP_X_FORWARDED_FOR" );
        else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
            $ip = getenv ( "REMOTE_ADDR" );
        else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
            $ip = $_SERVER ['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return ($ip);
    }
}

/**
 *description:加载父类控制器
 *author:yanyalong
 *date:2014/11/28
 */
if(!function_exists('loadParentController'))
{
    function loadParentController($parentControllerName){
        include_once $_SERVER['DOCUMENT_ROOT']."/application/controllers/".$parentControllerName.".php";
    }
}

/**
 *description:下载excel文件
 *author:yanyalong
 *date:2014/12/01
 */
function sendFile($fileName, $contentType='application/octet-stream', $returnCfg=array()) {
    error_reporting(0);
    header("Pragma:public");
    header("Expires:0");
    header("Content-type:" . $contentType . ';charset=utf-8');
    header("Accept-Ranges:bytes");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    if ('' != $returnCfg['contents']) {
        ob_clean();
        $fileSize = strlen($returnCfg['contents']);
    } else if ('' != $returnCfg['filepath']){
        ob_clean();
        $fileSize = filesize($returnCfg['filepath']);
    }
    if($fileSize > 0)
        header("Accept-Length:".$fileSize);
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/firefox/i', $ua)) {
        $fileName = str_replace('+', '%20', urlencode($fileName));
        $fileName = "utf8''" . $fileName;
        header("Content-Disposition:attachment; filename*=\"{$fileName}\"");
    } else if(preg_match('/msie/i', $ua)  || preg_match('/rv:/', $ua)){
        $fileName = str_replace('+', '%20', urlencode($fileName));
        header("Content-Disposition:attachment; filename=\"{$fileName}\"");
    } else {
        header("Content-Disposition:attachment; filename=\"{$fileName}\"");
    }
    if ('' != $returnCfg['contents']) {
        echo $returnCfg['contents'];
    } else if('' != $returnCfg['filepath']) {
            echo file_get_contents($returnCfg['filepath']);exit;
        if(preg_match('/apache/i', $_SERVER['SERVER_SOFTWARE'])) {
            echo file_get_contents($returnCfg['filepath']);
        } else if (preg_match('/lighttpd/i', $_SERVER['SERVER_SOFTWARE'])) {
            header('X-LIGHTTPD-Send-file:' . $returnCfg['filepath']);
        } else if (preg_match('/nginx/i', $_SERVER['SERVER_SOFTWARE'])) {
            //$nginxSendfileMaps = C('NGINX_SENDFILE_MAP');
            //$filePath = $returnCfg['filepath'];
            //foreach($nginxSendfileMaps as $map) {
                //if(0 === strpos($filePath, $map[0])) {
                    //$filePath = str_replace($map[0], $map[1], $filePath);
                    //break;
                //}
            //}
            //header('X-Accel-Redirect:' . $filePath);
            echo file_get_contents($returnCfg['filepath']);
        }
    }
    exit;
}

    /**
 	* Description : 检测所有字符长度（汉字视为一个字符）
 	* Author      : jishuai
 	* Created Time: 2015-01-12 10:53
	*/
if(!function_exists('strlenZh'))
{
    function strlenZh($str){
		$num = preg_match_all("/[\x{4e00}-\x{9fa5}]/u",trim($str),$tmpArr);
		return strlen(trim($str))-$num*2;
    }
}

    /**
 	* Description : curl发送http请求
 	* Author      : jishuai
 	* Created Time: 2015-01-23 17:19
	*/
   function curl_post_data($url, $array){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER,0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl, CURLOPT_POST,1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $array);
        $result = curl_exec($curl);  //$result 获取页面信息 
        curl_close($curl);
        return $result; //输出 页面结果
    }
/* End of file Common.php */
/* Location: ./system/core/Common.php */


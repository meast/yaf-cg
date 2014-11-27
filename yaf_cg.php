#!/usr/bin/env php
<?php
/**
 * @name yaf_cg.php
 * @desc yaf_cg 生成
 * @modifier Meast(782812005@qq.com)
 */
$useNamespace = (bool) ini_get("yaf.use_namespace");

if ($argc < 2)
{
	die(<<<USAGE
Yaf Code Generetor Version 1.0.0
Usage:
{$argv[0]} ApplicationName [ApplicationPath]

USAGE
);
}

$app_name = $argv[1];

if (empty($argv[2]))
{
	$app_path = dirname(__FILE__) . "/output/{$app_name}";
} else {
	$app_path = rtrim($argv[2], '/\\');
}

$author 	= trim(`whoami`);
$hostname 	= trim(`hostname`);
if(PHP_OS == "WINNT")
{
    # windows,用户名前边带主机名
    $a = explode("\\", $author);
    if(count($a)>1 && isset($a[1]))
    {
        $author = ucfirst($a[1]);
    }
}

$conf= array (
    'AUTHOR' 	=> $author,#开发人员
    'APP_NAME' 	=> $app_name,#app名字,请确保这也是一个合法的文件夹名
 	'DEV_PC' 	=> $author . '@' . $hostname ,#开发机,用于生产makefile自动部署
);

define('INPUT_DIR', dirname(__FILE__).'/templates');

$strOutputRoot = $app_path;

if(file_exists($strOutputRoot)) {
    rename($strOutputRoot, $strOutputRoot.date('Ymd-His', time()));
}

$arrTpls = getAllTpls();
foreach($arrTpls as $strFultTplPath) {
    $strContent = processTemplates($strFultTplPath);
    $strRelativeTplPath = substr($strFultTplPath, strlen(INPUT_DIR)+1);
    $strOutputRelativePath = convertPath($strRelativeTplPath);
    $strOutputPath = $strOutputRoot.'/'.$strOutputRelativePath;
    $strOutputDir = dirname($strOutputPath);
    if(!file_exists($strOutputDir))
    {
        mkdir($strOutputDir, 0777, true);
    }
    file_put_contents($strOutputPath, $strContent);    
}

echo "DONE\n";

#获取所有的代码模板文件
function getAllTpls() 
{
	$intFirst = 0;
    $intLast = 1;
    $arrQueue = array(INPUT_DIR);
    $arrFiles = array ();
    while ($intFirst < $intLast) 
    {
		$strPath = $arrQueue[$intFirst++];
		if (!is_dir($strPath)) 
		{
			if (file_exists($strPath)) 
			{
			    $arrSep = explode('.', $strPath);
			    #只取.tpl文件
			    if($arrSep[count($arrSep) - 1] == 'tpl')
			    {
				    array_push($arrFiles, $strPath);   
			    }
			}
		}
        else 
        {
			$arrPaths = scandir($strPath);
			if (count($arrPaths) == 0) 
			{
				continue;
			}
            foreach ($arrPaths as $strSubPath) 
            {
				if ($strSubPath === '.' || $strSubPath === '..')
				{
					continue;
				}
				$strCurPath = $strPath.'/'.$strSubPath;
				$arrQueue[$intLast++] = $strCurPath;
			}   
        }   
    }
	return $arrFiles;
} 

#将模板文件名转换成输出的文件名
function convertPath($strPath)
{
    global $conf;
    #去掉模板后缀
    $strPath = str_replace('.tpl', '', $strPath);
    
    $arrSep = explode('.', $strPath);
    $bolIsPhp = false;
    if($arrSep[count($arrSep) - 1] == 'php')
    {
	   $bolIsPhp = true;
    }
    #替换文件名中的模板变量
    $strToFind = '$APP_NAME$';
    $strToRelace = $bolIsPhp? ucfirst($conf['APP_NAME']) : $conf['APP_NAME'];
    $strPath = str_replace($strToFind, $strToRelace, $strPath);
    return $strPath;
}

#以后如果需要，可以用smarty等复杂的模板引擎来处理
function processTemplates($strTpl)
{
    global $useNamespace;
    $strContent = file_get_contents($strTpl);
    $arrSearch = array();
    $arrReplace = array();
    global $conf;
    foreach($conf as $strKey => $strValue)
    {
        $arrSearch[] = '{&$'.$strKey.'&}';
        $arrReplace[] = $strValue;
    }
    # 处理使用或不使用命名空间的情况
    if($useNamespace)
    {
        $strContent = strtr($strContent , array("Yaf_"=>'Yaf\\',"YAF_ERR_"=>"YAF\\ERR\\"));
        $strContent = strtr($strContent , array(
            "Yaf\\Request_Http"=>"Yaf\\Request\\Http",
            "Yaf\\Request_Simple"=>"Yaf\\Request\\Simple",
            "Yaf\\Response_Http"=>"Yaf\\Response\\Http",
            "Yaf\\Config_Ini"=>"Yaf\\Config\\Ini",
            "Yaf\\Config_Simple"=>"Yaf\\Config\\Simple",
            "Yaf\\View_Simple"=>"Yaf\\View\\Simple",
            "Yaf\\Route_Simple"=>"Yaf\\Route\\Simple",
            "Yaf\\Route_Supervar"=>"Yaf\\Route\\Supervar",
            "Yaf\\Route_Rewrite"=>"Yaf\\Route\\Rewrite",
            "Yaf\\Route_Regex"=>"Yaf\\Route\\Regex",
            "Yaf\\Route_Map"=>"Yaf\\Route\\Map",
            "Yaf\\Exception_StartupError"=>"Yaf\\Exception\\StartupError",
            "Yaf\\Exception_RouterFailed"=>"Yaf\\Exception\\RouterFailed",
            "Yaf\\Exception_DispatchFailed"=>"Yaf\\Exception\\DispatchFailed",
            "Yaf\\Exception_LoadFailed"=>"Yaf\\Exception\\LoadFailed",
            "Yaf\\Exception_LoadFailed_Module"=>"Yaf\\Exception\\LoadFailed\\Module",
            "Yaf\\Exception_LoadFailed_Controller"=>"Yaf\\Exception\\LoadFailed\\Controller",
            "Yaf\\Exception_LoadFailed_Action"=>"Yaf\\Exception\\LoadFailed\\Action",
            "Yaf\\Exception_LoadFailed_View"=>"Yaf\\Exception\\LoadFailed\\View",
            "Yaf\\Exception_TypeError"=>"Yaf\\Exception\\TypeError",
            "YAF\\ERR\\NOTFOUND_MODULE"=>"YAF\\ERR\\NOTFOUND\\MODULE",
            "YAF\\ERR\\NOTFOUND_CONTROLLER"=>"YAF\\ERR\\NOTFOUND\\CONTROLLER",
            "YAF\\ERR\\NOTFOUND_ACTION"=>"YAF\\ERR\\NOTFOUND\\ACTION",
            "YAF\\ERR\\NOTFOUND_VIEW"=>"YAF\\ERR\\NOTFOUND\\VIEW",
        ));
    }else{
        $strContent = strtr($strContent , array("Yaf\\"=>'Yaf_',"YAF\\ERR\\"=>"YAF_ERR_"));
        $strContent = strtr($strContent , array(
            "Yaf_Request\\Http"=>"Yaf_Request_Http",
            "Yaf_Request\\Simple"=>"Yaf_Request_Simple",
            "Yaf_Response\\Http"=>"Yaf_Response_Http",
            "Yaf_Config\\Ini"=>"Yaf_Config_Ini",
            "Yaf_Config\\Simple"=>"Yaf_Config_Simple",
            "Yaf_View\\Simple"=>"Yaf_View_Simple",
            "Yaf_Route\\Simple"=>"Yaf_Route_Simple",
            "Yaf_Route\\Supervar"=>"Yaf_Route_Supervar",
            "Yaf_Route\\Rewrite"=>"Yaf_Route_Rewrite",
            "Yaf_Route\\Regex"=>"Yaf_Route_Regex",
            "Yaf_Route\\Map"=>"Yaf_Route_Map",
            "Yaf_Exception\\StartupError"=>"Yaf_Exception_StartupError",
            "Yaf_Exception\\RouterFailed"=>"Yaf_Exception_RouterFailed",
            "Yaf_Exception\\DispatchFailed"=>"Yaf_Exception_DispatchFailed",
            "Yaf_Exception\\LoadFailed"=>"Yaf_Exception_LoadFailed",
            "Yaf_Exception\\LoadFailed\\Module"=>"Yaf_Exception_LoadFailed_Module",
            "Yaf_Exception\\LoadFailed\\Controller"=>"Yaf_Exception_LoadFailed_Controller",
            "Yaf_Exception\\LoadFailed\\Action"=>"Yaf_Exception_LoadFailed_Action",
            "Yaf_Exception\\LoadFailed\\View"=>"Yaf_Exception_LoadFailed_View",
            "Yaf_Exception\\TypeError"=>"Yaf_Exception_TypeError",
            "YAF_ERR_NOTFOUND\\MODULE"=>"YAF_ERR_NOTFOUND_MODULE",
            "YAF_ERR_NOTFOUND\\CONTROLLER"=>"YAF_ERR_NOTFOUND_CONTROLLER",
            "YAF_ERR_NOTFOUND\\ACTION"=>"YAF_ERR_NOTFOUND_ACTION",
            "YAF_ERR_NOTFOUND\\VIEW"=>"YAF_ERR_NOTFOUND_VIEW",
        ));
    }
    $strResult = str_replace($arrSearch, $arrReplace, $strContent);
    return $strResult;
}

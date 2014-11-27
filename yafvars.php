<?php

$useNamespace = (bool) ini_get("yaf.use_namespace");
$yafClassPrefix = sprintf("Yaf%s", $useNamespace ? "\\" : "_");
$classes = array_merge(get_declared_classes(), get_declared_interfaces());
foreach ($classes as $key => $value) {
    if (strncasecmp($value, $yafClassPrefix, 4)) {
        unset($classes[$key]);
    }
}

$vars = get_defined_constants();
$varsarr = array();
foreach($vars as $k => $v)
{
    if(strncasecmp($k, $yafClassPrefix, 4) == 0)
        $varsarr[] = $k;
}

$str1 = '';
foreach($classes as $k => $v)
{
    $str1 .= $v . PHP_EOL;
}
$str1 .= '=====' . PHP_EOL;
foreach($varsarr as $k => $v)
{
    $str1 .= $v . PHP_EOL;
}
$fn = __DIR__ . '/yaf.vars.ns.' . ($useNamespace ? 'true':'false') . '.txt';
file_put_contents($fn, $str1);

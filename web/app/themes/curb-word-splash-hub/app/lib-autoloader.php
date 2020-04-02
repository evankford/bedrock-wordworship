<?php 
// Load more themewide functions for extended functionality
// Inspired by https://discourse.roots.io/t/what-is-the-right-way-to-include-custom-function-in-sage-9/8410/5

// Glob recursive needed to load recursively
// Source https://stackoverflow.com/questions/12109042/php-get-file-listing-including-sub-directories
if ( ! function_exists('glob_recursive'))
{
    // Does not support flag GLOB_BRACE
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }
}

//Requires each file
//$files = glob(__DIR__ . '/lib/**/*.php'); //will only load first level sub-dir
$files = glob_recursive(__DIR__ . '/lib/*.php');
if ($files === false) {
    throw new RuntimeException("Failed to glob for function files");
}
foreach ($files as $file) {
    require_once $file;
}
unset($file, $files);
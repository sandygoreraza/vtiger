<?php

class DeleteFolder{


public function __Construct($FullPath){


    if (! is_dir($FullPath)) {
        throw new InvalidArgumentException("$FullPath must be a directory");
    }
    if (substr($FullPath, strlen($FullPath) - 1, 1) != '/') {
        $FullPath .= '/';
    }
    $files = glob($FullPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($FullPath);

}	
	
	
}


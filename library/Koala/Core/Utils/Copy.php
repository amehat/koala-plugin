<?php
class Koala_Core_Utils_Copy {
	
	public static function recursiveCopy( $source, $destination )
    {
        if( is_dir($source) ) {
        	if ( !file_exists($destination)){
            	mkdir( $destination );
        	}
            $objects = scandir($source);
            if( sizeof($objects) > 0 ) {
                foreach ( $objects as $file )
                {
                    if ( $file == "." || $file == ".." )
                        continue;

                    if ( is_dir( $source.DIRECTORY_SEPARATOR.$file ) )
                    {
                        self::recursiveCopy( $source.DIRECTORY_SEPARATOR.$file, $destination.DIRECTORY_SEPARATOR.$file );
                    } else {
                        copy( $source.DIRECTORY_SEPARATOR.$file, $destination.DIRECTORY_SEPARATOR.$file );
                    }
                }
            }
            return true;
        } else if ( is_file($source) ) {
            return copy ( $source, $destination );
        } else {
            return false;
        }
    }
}
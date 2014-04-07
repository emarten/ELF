<?php
function convertBytes( $value ) {
    if ( is_numeric( $value ) ) {
        return $value;
    } else {
        $value_length = strlen( $value );
        $qty = substr( $value, 0, $value_length - 1 );
        $unit = strtolower( substr( $value, $value_length - 1 ) );
        switch ( $unit ) {
            case 'k':
                $qty *= 1024;
                break;
            case 'm':
                $qty *= 1048576;
                break;
            case 'g':
                $qty *= 1073741824;
                break;
        }
        return $qty;
    }
}
$maxFileSize = convertBytes( ini_get( 'upload_max_filesize' ) );

$this->_assign->max_filesize=$maxFileSize;
$this->_assign->max_filesize_str="Maximale Dateigröße: ".($maxFileSize/1024/1024)."MB";

$this->_assign->time2live_days=($_ELF->_config["time2live"]/(24*60*60));
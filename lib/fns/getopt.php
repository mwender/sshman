<?php

namespace sshman\lib\fns\getopt;

$options = getopt( 'vh', ['version','help'] );
if( isset( $options['v'] ) || isset( $options['version'] ) ){
    $version = file_get_contents('VERSION');
    echo "\033[33m" . '[SSHman](https://github.com/mwender/sshman) - Version ' . $version . "\033[0m" . "\n\n";
    display_file( 'LICENSE' );
    exit;
}
if( isset( $options['h'] ) || isset( $options['help'] ) ){
    display_file( 'HELP' );
    exit;
}

function display_file( $file ){
  if( empty( $file ) )
    return false;

  if( ! file_exists( $file ) )
    return false;

  $contents = file_get_contents( $file );
  $lines = explode("\n", $contents );
  foreach( $lines as $line ){
    if( stristr( $line, '{version}') ){
      $version = file_get_contents('VERSION');
      $line = str_replace( '{version}', $version, $line );
    }

    if( '# ' == substr( $line, 0, 2 ) )
      $line = "\033[33m" . substr($line, 2 ) . "\033[0m";
    echo $line . "\n";
  }

  return true;
}
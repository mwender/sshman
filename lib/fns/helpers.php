<?php
namespace sshman\lib\fns\helpers;

function get_server_meta( $key, $meta ){
	global $servers;

	if( ! is_numeric( $key ) )
		return 'ERROR: Key `' . $key . '` not a number!';

	if( ! array_key_exists( $key, $servers ) )
		return 'ERROR: Key `' . $key . '` not found in `$servers`!';

	$server = $servers[$key];
	if( !array_key_exists( $meta, $server ) )
		return 'ERROR: Key `' . $key . '` not set for this server!';

	return $servers[$key][$meta];
}

function get_ssh_connection( $key, $full_connection_string = 'y', $user = '' ){
	global $servers, $options;

	$ip = $servers[$key]['ip'];

	$port = '';
	if( 22 != $servers[$key]['port'] )
		$port = '-p ' . $servers[$key]['port'] . ' ';

	$identity = '';
	if( ! empty( $servers[$key]['id_file'] ) )
		$identity = '-i ' . $servers[$key]['id_file'] . ' ';

	if( empty( $user ) )
		$user = 'root';

	$protocol = ( isset( $options['s'] ) || isset( $options['sftp'] ) )? 'sftp' : 'ssh';

	$ssh_connection = ( 'y' != $full_connection_string )? $ip : $protocol . ' ' . $identity . $port . $user . '@' . $ip;

	return $ssh_connection;
}
?>
#!/usr/bin/env php
<?php
require 'phar://sshman.phar/vendor/autoload.php';
require 'phar://sshman.phar/lib/fns/fns.helpers.php';

/**
 * OS CHECK
 *
 * `sshman` currently only supports Mac OS X because I'm
 * adding the output to the user's buffer via `pbpaste`.
 *
 * Todo: Detect the user's OS, and vary how we're adding
 * text to the user's buffer.
 */
$os_name = php_uname( 's' );
if( ! stristr( $os_name, 'Darwin' ) ){
	\cli\err( 'ERROR: I\'m sorry, but `sshman` currently just supports Mac OS X.' );
	exit;
}

/**
 * SERVERS loaded from ~/.servers in CSV format:
 *
 * - server_name,ip,user(optional)
 * - server.example.com,123.456.78.99,sysadmin
 * - server2.example.com,223.14.56.89,"sysadmin,webdev,user3"
 */

// Check for ~/.servers
$csv = $_SERVER['HOME'] . '/.servers';
if( ! file_exists( $csv ) ){
	\cli\err( 'ERROR: File `~/.servers` not found. Please add a `.servers` file to your home directory.' );
	exit;
}

$row = 1;
if ( false !== ( $fp = fopen( $csv, 'r' ) ) ) {
	while( false !== ( $data = fgetcsv( $fp, 1000, ',' ) ) ){
		$num = count( $data );
		$servers[$row] = array(
			'name' => $data[0],
			'ip' => $data[1],
		);
		$servers[$row]['user'] = ( isset( $data[2] ) && ! empty( $data[2] ) )?  $data[2] : '---' ;
		$row++;
	}
}

usort( $servers, function( $a, $b ){
	return strcasecmp( $a['name'], $b['name'] );
} );

// Display servers in a table
$servers_display = [];
foreach( $servers as $key => $server ){
	$servers_display[$key] = array(
		$key,
		$server['name'],
		$server['ip'],
		$server['user']
	);
}

$headers = array( 'ID', 'Name', 'IP', 'User' );
$servers_table = new \cli\Table();
$servers_table->setHeaders( $headers );
$servers_table->setRows( $servers_display );

$hr = '---------------------------------------------';

$users = array(
	'root',
);

// LOGIC
echo exec( 'clear' );

// Select a server
$servers_table->display();

\cli\out( 'Select a server: ' );
$server = trim( fgets( STDIN ) );

// Return full connection string or just the server IP?
\cli\line( $hr );
\cli\line( 'Fetching ' . strtoupper( \sshman\lib\fns\helpers\get_server_meta( $server, 'name' ) ) );
\cli\out( 'Return full connection string (y/n)? ' );
$full_connection_string = trim( fgets( STDIN ) );

// Which user?
$user = '';
if( 'y' == $full_connection_string ){
	$server_user = \sshman\lib\fns\helpers\get_server_meta( $server, 'user' );

	if( 'ERROR' != substr( $server_user, 0, 5 ) && ! empty( $server_user ) && ! in_array( $server_user, $users ) ){
		if( stristr( $server_user, ',') ){
			$server_users = explode( ',', $server_user );
			foreach( $server_users as $user ){
				$users[] = $user;
			}
		} else {
			$users[] = $server_user;
		}
	}

	$select_user_str = '';
	foreach( $users as $key => $user ){
		if( '---' != $user )
			$select_user_str.= $key . '. ' . $user . "\n";
	}
	if( 1 == count( $users ) ){
		$user = $users[0];
	} else {
		\cli\line( $hr );
		\cli\out( $select_user_str );
		\cli\line( $hr );
		\cli\out( 'Select a user: ' );
		$user = $users[ trim( fgets( STDIN ) ) ];
	}
}

// Return server details and add to buffer
echo exec( 'clear' );
$ssh_cmd = trim( \sshman\lib\fns\helpers\get_ssh_connection( $server, $full_connection_string, $user ) );
\cli\line();
\cli\line( 'The following text is in your buffer:' );
\cli\line( $ssh_cmd );
exec( 'echo ' . $ssh_cmd . ' | tr -d \'\\n\' | pbcopy' );
?>
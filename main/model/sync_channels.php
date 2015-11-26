<?php
if (! defined ( 'INDEX' )) {
	die ( "Attempt to hack !!!" );
}

// Get all channels
$chans = fetchData ( 'channels', null, true );
$channels = array ();
foreach ( $chans as $ch ) {
	array_push ( $channels, array (
	'id' => $ch ['id'],
	'name' => $ch ['name'],
	'description' => $ch ['description'],
	'image' => $ch ['image']
	) );
}

$data ['channels'] = $channels;

?>
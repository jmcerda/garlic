<?php
$fs_url = 'https://www.formstack.com/admin';

$part = '/form/dashboard';
if ( isset( $_GET['page'] ) && 'FormstackNewForm' === $_GET['page'] ) {
	$fs_url .= '/form/add?steps=1';
} else if ( isset( $_GET['page'] ) && 'FormstackAPI' === $_GET['page'] ) {
	$part = '/apiKey/main';
	if ( isset( $_GET['new'] ) && '1' === $_GET['new'] ) {
		$fs_url .= '/apiKey/add';
	}
}
$url = $fs_url . $part;
?>
<iframe id="formstack_iframe" src="<?php echo esc_attr( $url );?>"></iframe>

<?php 
define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','new_db1');
define('GOOGLE_CLIENT_ID','831205866918-0i28lucaugbje4e7a0kr2hitannfpu0h.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET','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');
define('GOOGLE_OAUTH_SCOPE','https://www.googleapis.com/auth/drive');
define('REDIRECT_URI','http://localhost/ehtesham_task/google_drive_sync.php');
if(!session_id()) session_start(); 
 
// Google OAuth URL 
$googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode(GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . REDIRECT_URI . '&response_type=code&client_id=' . GOOGLE_CLIENT_ID . '&access_type=online'; 
 
?>
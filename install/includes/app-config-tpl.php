<?php

/**
 * Application base url
 */
define('APP_BASE_URL', '%URL%');


/**
 * Application name
 */
 define('APP_NAME', 'onTrack');

/**
 * Encryption key
 */
define('ENCRYPTION_KEY', '%ENCRYPTION_KEY%');


/**
 * File Manager access key
 */
define('FM_ACCESS_KEY', '%FM_ACCESS_KEY%');


/**
 * Database Credentials
 */
define('APP_DB_HOSTNAME', '%HOSTNAME%');
define('APP_DB_NAME', '%DATABASE%');
define('APP_DB_USERNAME', '%USERNAME%');
define('APP_DB_PASSWORD', '%PASSWORD%');



/**
 * Sessions
 */
define('SESS_DRIVER', 'database');
define('SESS_COOKIE_NAME', 'ontrack_session');
define('SESS_SAVE_PATH', 'core_sessions');

/**
 * Cookies
 */
define('COOKIE_PREFIX', 'ontrack_');


/**
 * Output Compression
 */
define('COMPRESS_OUTPUT', FALSE);


/**
 * FOLDERS
 */

define('UPLOADS_FOLDER', FCPATH . 'uploads' . '/');

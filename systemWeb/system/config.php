<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT_PATH . 'App' . DS);
define('SYSTEM_PATH', ROOT_PATH . 'System' . DS);
define('WEB_PATH', ROOT_PATH . 'System' . DS);
define('FILES_PATH', ROOT_PATH . 'Files' . DS);
define('EXT', '.php');

define('DEVELOPMENT_ENVIRONMENT', TRUE);

define('CONTROLLER_PATH', APP_PATH . 'Controllers' . DS);
define('MODELS_PATH', APP_PATH . 'Models' . DS);
define('VIEWS_PATH', APP_PATH . 'Views' . DS);
define('INDEX_PAGE', 'dashboard');
define('EXT_VIEW', '.html');

define('PATH', 'http://'.$_SERVER['HTTP_HOST'].'/SYSCoffe/systemSimpleInPhp_ProgInternet_Univates/'); //endereço raiz
//define('PATH', 'http://'.$_SERVER['HTTP_HOST'].'/systemSimpleInPhp_ProgInternet_Univates/'); //endereço raiz
define('NODE', 'node_modules/');
define('URL', PATH . 'sis/');
define('NODEPATH', PATH . 'tamplete/');

define('PATH_EST', PATH .'img/');
define('PATH_ARQ', PATH .'img/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'mysql04-farm76.kinghost.net'); //local
define('DB_NAME', 'syscoffe01'); //banco
define('DB_USER', 'syscoffe01'); //usuario
define('DB_PASS', 'alegra123'); //senha
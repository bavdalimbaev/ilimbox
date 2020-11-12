<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'ilimbox';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'root';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '3606',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'http://localhost/ilimbox';
$CFG->dataroot  = '/var/www/ilimboxdata';
$CFG->admin     = 'admin';
$CFG->sslproxy  = false;

$CFG->directorypermissions = 02777;

$CFG->site_is_public = false;
$CFG->disableupdatenotifications = true;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!

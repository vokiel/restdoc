<?php

error_reporting(0);
date_default_timezone_set('Europe/Warsaw');

define('DS', DIRECTORY_SEPARATOR);
define('DOCROOT', realpath(dirname(__FILE__)).DS);


if ( !file_exists(DOCROOT.'settings.php') ) {
  die("No settings file found. Aborting");
}
$settings = require_once DOCROOT.'settings.php';

$file_name = NULL;
$IS_DETAIL = false;
if ( array_key_exists("token", $_REQUEST) && !empty($_REQUEST["token"]) ) {
  $file_name = base64_decode($_REQUEST["token"]);
  if ($file_name == NULL || !file_exists(DOCROOT.$file_name)) {
    die("YAML file ".$file_name." for API not found");
  }
  $IS_DETAIL = true;
}

if ( !$IS_DETAIL ) {
  if (!array_key_exists("yaml.index", $settings)) {
    die ('{yaml.index} key is not defined in settings. Aborting');
  }
  $index_yaml = $settings["yaml.index"];
  if (!file_exists(DOCROOT . $index_yaml)) {
    die("index YAML file '.$index_yaml.' Not Found");
  }
}

// YAML parser
include('Spyc.php');
$brand_name = array_key_exists("brand.name", $settings) ? $settings["brand.name"] : "";
$api_version = array_key_exists("api.version", $settings) ? $settings["api.version"] : "v1.0";
$docs_revision = substr(file_get_contents(DOCROOT.DS.'.git'.DS.'refs'.DS.'heads'.DS.'master'),0,7);

$detail_url = "/?token=";
$data = $IS_DETAIL ? Spyc::YAMLLoad($file_name) : Spyc::YAMLLoad(DOCROOT.$index_yaml) ;
?>
<!doctype html>
<html>
<head>
  <title><?php echo $brand_name ?> | REST API Documentation</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <style>
    /* Sticky footer styles */
    html { position: relative; min-height: 100%; }
    body { margin-bottom: 60px; padding-top: 50px; }
    #footer { position: absolute; bottom: 0; width: 100%; height: 60px; background-color: #f5f5f5; }

    .container { width: auto; max-width: 90%; }
    .container .text-muted { margin: 20px 0; }
  </style>
</head>

<body>
  <div class="container">

  <div class="row">
    <div class="col-lg-12">
      <nav class="navbar navbar-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex5-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?php echo $brand_name ?> REST API documentation</a>
        </div>
        <?php if ( !empty($docs_revision) ): ?>
        <div class="pull-right">
          <p><small>Docs revision: <?php echo $docs_revision;?></small></p>
        </div>
        <?php endif; ?>
      </nav>
    </div>
  </div>
  <!-- top toolbar  -->


  <div class="row">
    <div class="col-lg-12">
      <ol class="breadcrumb">
        <?php if ( !$IS_DETAIL): ?>
          <li class="active">Home</li>
        <?php else: ?>
          <li><a href="/">Home</a></li>
          <li class="active"><?php echo $data["resource"]; ?></li>
        <?php endif; ?>
      </ol>
    </div>
  </div>
  <!--  breadcrumbs  -->

  <div class="row">
    <div class="col-lg-12">
      <div class="page-header">
        <?php if ( !$IS_DETAIL ): ?>
          <h1>General</h1>
        <?php else: ?>
          <h1><?php echo $data["resource"] ?></h1>
          <p><span class="label label-info">API version <?php echo $data["version"] ?></span></p>
        <?php endif; ?>
      </div>

    </div>
  </div>

  <?php
    if ( $IS_DETAIL ){
      require_once 'detail_view.php';
    }
    else {
      require_once 'index_view.php';
    }
  ?>

  </div>
  <div id="footer">
    <div class="container">
      <?php $cur_year = date('Y'); $cur_year = ( $cur_year > 2014 )? ' - '.$cur_year.' ' : ''; ?>
      <p class="text-muted pull-left">&copy; 2014 <?php echo $cur_year;?><a href="http://<?php echo $_SERVER['HTTP_HOST'];?>" target="_blank"><?php echo $brand_name;?></a></p>
    </div>
  </div>
</body>
</html>

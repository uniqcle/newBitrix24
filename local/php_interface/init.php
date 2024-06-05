<?php

# автолоадер композера
if(file_exists( __DIR__ . '/vendor/autoload.php' )){
	require_once( __DIR__ . '/vendor/autoload.php'  );
}


# автолоадер композера
if(file_exists( __DIR__ . '/../app/autoload.php' )){
	require_once( __DIR__ . '/../app/autoload.php'  );
}



//#события
include_once __DIR__ . '/events.php';
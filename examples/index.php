<?php
include_once '../Radio3FmHelper.php';
include_once '../Radio3FmResponse.php';

use golles\radio3fm\Radio3FmHelper;

$nowPlaying = Radio3FmHelper::get3FMNowPlaying();

// Parse the information and output it as human readable text.
echo '<h2>Simple</h2>';
echo 'Now playing: ' . $nowPlaying->artist . ' - ' . $nowPlaying->title . '<br>';
echo 'Or shorter: ' . $nowPlaying . '<br>';

echo '<h2>Data</h2>';
echo '<pre>';
print_r($nowPlaying);
echo '</pre>';

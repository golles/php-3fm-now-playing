<?php
include_once '../Helper3FM.php';
include_once '../Response3FM.php';

use golles\radio3fm\Helper3FM;
use golles\radio3fm\Response3FM;

$helper = new Helper3FM();
$helper->get3FMNowPlaying();
$nowPlaying = $helper->getResponse3FM();

// Parse the information and output it as human readable text.
echo ucwords($nowPlaying->artist . ' - ' . $nowPlaying->title);

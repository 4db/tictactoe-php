<?php

include_once('classes/DB.php');
include_once('classes/User.php');
include_once('classes/Game.php');

$g = new Game();

var_dump($g->boardToStr());

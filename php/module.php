<?php

    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/workspace/php/model/*.php') AS $models) { require($models); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/workspace/php/view/*.php') AS $views) { require($views); }
    foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/satellites/workspace/php/controller/*.php') AS $controllers) { require($controllers); }

?>
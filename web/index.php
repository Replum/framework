<?php

/* 
 * This file is part of the FERTIX project demo.
 * (c) 2017 by Dennis Birkholz
 * All rights reserved.
 */

$installDir = \dirname(\dirname($_SERVER['SCRIPT_FILENAME']));
$contextFile = $installDir . '/replum-context.php';

require_once($installDir . '/vendor/autoload.php');

if (\file_exists($contextFile)) {
    $context = require($contextFile);
} else {
    $context = null;
}

$executer = new \Replum\Executer($context);
$executer->execute();

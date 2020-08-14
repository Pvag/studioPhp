<?php
function autoloader($nameSpace)
{
    $path = str_replace('\\', '/', $nameSpace);
    include __DIR__ . '/../classes/' . $path . '.php';
}
spl_autoload_register('autoloader');

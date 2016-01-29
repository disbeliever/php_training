<?php
function __autoload($className) {
    if (file_exists(__DIR__ . '/' . $className . '.php')) {
        require_once __DIR__ . '/' . $className . '.php';
        return true;
    }
    return false;
}

function canClassBeAutloaded($className) {
    return class_exists($className);
}

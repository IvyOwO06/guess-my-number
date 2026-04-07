<?php

session_start();

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

// dd($_SESSION);
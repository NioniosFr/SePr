<?php
if (! defined('CW'))
    exit('invalid access');

interface Controller
{
    public function init($args);
    public function index();
}

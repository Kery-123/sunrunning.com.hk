<?php
defined('_JEXEC') or die;

require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';

$app = JFactory::getApplication();
$themeOptions = $app->getTemplate(true)->params;
$fileName = $themeOptions->get('cart', '');
if ($fileName) {
    include_once dirname(__FILE__) . '/' . $fileName . '.php';
}
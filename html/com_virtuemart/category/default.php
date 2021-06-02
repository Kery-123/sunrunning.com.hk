<?php
defined ('_JEXEC') or die('Restricted access');

$themePath = dirname(dirname(dirname(dirname(__FILE__))));
require_once $themePath . DIRECTORY_SEPARATOR . 'functions.php';

$app = JFactory::getApplication();
$themeOptions = $app->getTemplate(true)->params;
$fileName = $themeOptions->get('products', '');
if ($fileName) {
    include_once dirname(__FILE__) . '/' . $fileName . '.php';
}

?>


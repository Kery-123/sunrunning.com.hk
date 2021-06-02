<?php
defined('_JEXEC') or die;

require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'functions.php';

/* Let's see if we found the product */
if (empty($this->product)) {
    echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));

$app = JFactory::getApplication();
$themeOptions = $app->getTemplate(true)->params;
$fileName = $themeOptions->get('product', '');
if ($fileName) {
    include_once dirname(__FILE__) . '/' . $fileName . '.php';
}
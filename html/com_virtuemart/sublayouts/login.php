<?php
defined('_JEXEC') or die;

//set variables, usually set by shopfunctionsf::getLoginForm in case this layout is differently used
if (!isset( $this->show )) $this->show = TRUE;
if (!isset( $this->from_cart )) $this->from_cart = FALSE;
if (!isset( $this->order )) $this->order = FALSE ;


if (empty($this->url)){
    $url = vmURI::getCurrentUrlBy('request');
} else{
    $url = $this->url;
}
//$url = JRoute::_($url, $this->useXHTML, $this->useSSL);
vmdebug('My Url in loginform',$url);
$user = JFactory::getUser();

if ($this->show and $user->id == 0  ) {
    vmJsApi::vmValidator();

    //Extra login stuff, systems like openId and plugins HERE
    if (JPluginHelper::isEnabled('authentication', 'openid')) {
        $lang = vmLanguage::getLanguage();
        $lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR);
        $langScript = '
//<![CDATA[
'.'var JLanguage = {};' .
            ' JLanguage.WHAT_IS_OPENID = \'' . vmText::_('WHAT_IS_OPENID') . '\';' .
            ' JLanguage.LOGIN_WITH_OPENID = \'' . vmText::_('LOGIN_WITH_OPENID') . '\';' .
            ' JLanguage.NORMAL_LOGIN = \'' . vmText::_('NORMAL_LOGIN') . '\';' .
            ' var comlogin = 1;
//]]>
                ';
        vmJsApi::addJScript('login_openid',$langScript);
        JHtml::_('script', 'openid.js');
    }

    $html = '';
    VmConfig::importVMPlugins('vmpayment');
    $dispatcher = JDispatcher::getInstance();
    $returnValues = $dispatcher->trigger('plgVmDisplayLogin', array($this, &$html, $this->from_cart));

    if (is_array($html)) {
        foreach ($html as $login) {
            echo $login.'<br />';
        }
    }
    else {
        echo $html;
    }

    //end plugins section

    //anonymous order section
    if ($this->order  ) {
        ?>

        <div class="order-view">

            <h2><?php echo vmText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h2>

            <form action="<?php echo JRoute::_( 'index.php', 1, $this->useSSL); ?>" method="post" name="com-login" >

                <div id="com-form-order-number">
                    <label for="order_number"><?php echo vmText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label><br />
                    <input type="text" id="order_number" name="order_number" class="inputbox" size="18" />
                </div>
                <br />
                <div id="com-form-order-pass">
                    <label for="order_pass"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PASS') ?></label><br />
                    <input type="text" id="order_pass" name="order_pass" class="inputbox" size="18" />
                </div>
                <br />
                <div class="" id="com-form-order-submit">
                    <input type="submit" name="Submitbuton" class="button" value="<?php echo vmText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
                </div>
                <div class="clr"></div>
                <input type="hidden" name="option" value="com_virtuemart" />
                <input type="hidden" name="view" value="orders" />
                <input type="hidden" name="layout" value="details" />
                <input type="hidden" name="return" value="" />

            </form>

        </div>

    <?php   }


    // XXX style CSS id com-form-login ?>
    <div class="com-form-container">
        <form id="com-form-login" action="<?php echo JUri::root(true).'/'.$url; ?>" method="post" name="com-login" >
            <fieldset class="userdata">
                <?php if (!$this->from_cart ) { ?>
                    <div>
                        <h2><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></h2>
                    </div>
                <?php } else { ?>
                    <p><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></p>
                <?php }   ?>
                <div id="com-form-login-username">
                    <input type="text" name="username" class="inputbox" size="18" title="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>') this.value='';" />
                </div>
                <br />
                <div id="com-form-login-password">
                    <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" title="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>') this.value='';" />
                </div>
                <br />
                <div id="com-form-login-remember">
                    <input type="submit" name="Submit" class="form-login-button" value="<?php echo vmText::_('COM_VIRTUEMART_LOGIN') ?>" />
                    <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
                        <label for="remember"><?php echo $remember_me = vmText::_('JGLOBAL_REMEMBER_ME') ?></label>
                        <input type="checkbox" id="remember" name="remember" class="checkbox" value="yes" />
                    <?php endif; ?>
                </div>
                <div class="clr"></div>
            </fieldset>
            <br />
            <div class="width30 floatleft">
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" rel="nofollow">
                    <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a>
            </div>
            <div style= "margin-left:10px" class="width30 floatleft">
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" rel="nofollow">
                    <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>
            </div>

            <div class="clr"></div>

            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </form>
    </div>
<?php  } else if ( $user->id ) { ?>
    <div class="com-form-container">
        <form action="<?php echo JUri::root(true).'/'.$url; ?>" method="post" name="login" id="form-login">
            <?php echo vmText::sprintf( 'COM_VIRTUEMART_HINAME', $user->name ); ?>
            <input type="submit" name="Submit" class="form-login-button" value="<?php echo vmText::_( 'COM_VIRTUEMART_BUTTON_LOGOUT'); ?>" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.logout" />
            <?php echo JHtml::_('form.token'); ?>
            <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
        </form>
    </div>

<?php }
?>

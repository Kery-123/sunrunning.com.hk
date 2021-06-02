<?php
    $document = JFactory::getDocument();
?>
    <header class="u-clearfix u-header u-header" id="sec-0490">
  <div class="u-clearfix u-sheet u-sheet-1">
    <?php $logoInfo = getLogoInfo(array(
            'src' => "/images/LogoProject.png",
            'href' => "https://nicepage.com",
            'default_width' => '181'
        ), true); ?><a href="<?php echo $logoInfo['href']; ?>" class="u-image u-logo u-image-1" data-image-width="1293" data-image-height="729">
      <img src="<?php echo $logoInfo['src']; ?>" class="u-logo-image u-logo-image-1" data-image-width="181">
    </a>
    <?php echo CoreStatements::position('hmenu', '', 1, 'hmenu'); ?>
  </div>
</header>
    
<?php
    $document = JFactory::getDocument();
?>
    <footer class="u-clearfix u-footer u-grey-80" id="sec-f5e0">
  <div class="u-clearfix u-sheet u-sheet-1">
    <?php $logoInfo = getLogoInfo(array(
            'src' => "/images/Logo01Project.png",
            'href' => "https://nicepage.com",
            'default_width' => '193'
        ), true); ?><a href="<?php echo $logoInfo['href']; ?>" class="u-image u-logo u-image-1" data-image-width="1293" data-image-height="729">
      <img src="<?php echo $logoInfo['src']; ?>" class="u-logo-image u-logo-image-1" data-image-width="193.9683">
    </a>
    <?php echo CoreStatements::position('hmenu-2', '', 2, 'hmenu'); ?>
  </div>
</footer>
    
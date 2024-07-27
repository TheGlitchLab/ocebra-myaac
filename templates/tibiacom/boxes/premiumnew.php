<?php
echo '<div class="Themebox" style="background-image:url(' . $template_path . '/images/themeboxes/premium/themebox.png); height: 204px;">
  <div id="PremiumBoxDecor" style="background-image:url(' . $template_path . '/images/themeboxes/premium/coin_animation.gif);"></div>
  <div id="PremiumBoxBg" style="background-image:url(' . $template_path . '/images/themeboxes/donate/coins.gif);"></div>
  <div id="PremiumBoxOverlay" style="background-image:url(' . $template_path . '/images/themeboxes/premium/type_overlay.png);">
    <p id="PremiumBoxOverlayText">Exclusive Content!</p>
  </div>
  <div id="PremiumBoxButton">
    <form action="?points" method="post" style="padding:0px;margin:0px;">
      <div class="BigButton" style="background-image:url(' . $template_path . '/images/global/buttons/button.png); width: 142px; height: 34px;"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="Button" style="background-image: url(' . $template_path . '/images/global/buttons/button_hover.png); visibility: hidden;"></div><input class="BigButtonText" style="width: 144px; height: 34px;" type="submit" value="Get ' . $config['lua']['serverName'] . ' Coins"></div></div>
    </form>
  </div>
  <div id="PremiumBoxButtonDecor" style="background-image:url(' . $template_path . '/images/themeboxes/premium/button_tibia_coins.png);"></div>
</div>';
?>

<?php
echo '<div class="Themebox" style="background-image:url(' . $template_path . '/images/themeboxes/discord/themebox.png); height: 154px;">
    </div>
    <div id="PremiumBoxButton">
        <form action="' . $config['discord_link'] . '" method="post" style="padding:0px;margin:0px;" target="_blank">>
            <div class="BigButton" style="background-image:url(' . $template_path . '/images/global/buttons/button.png); width: 142px; height: 34px;"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="Button" style="background-image: url(' . $template_path . '/images/global/buttons/button_hover.png); visibility: hidden;"></div><input class="BigButtonText" style="width: 144px; height: 34px;" type="submit" value="Discord"></div></div>
        </form>
    </div>
</div>';
?>

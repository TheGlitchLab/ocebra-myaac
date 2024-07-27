<?php
defined('MYAAC') or die('Direct access not allowed!');

if (isset($config['boxes']))
    $config['boxes'] = explode(",", $config['boxes']);

if($db->hasTable('players_online'))
    $playersOnline = $db->query('SELECT * FROM `players_online`')->fetchAll();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?= template_place_holder('head_start'); ?>
    <link rel="shortcut icon" href="<?= $template_path; ?>/images/favicon.ico" type="image/x-icon"/>
    <link rel="icon" href="<?= $template_path; ?>/images/favicon.ico" type="image/x-icon"/>
    <link href="<?= $template_path; ?>/css/basic.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="tools/basic.js"></script>
    <script type="text/javascript" src="tools/generic.js"></script>
    <!-- <script type="text/javascript" src="tools/ajaxcip_tibia_v1.js"></script> -->

    <script type="text/javascript" src="<?= $template_path; ?>/ticker.js"></script>

    <link rel="stylesheet" href="tools/fonts/fontawesome/all.css">
    <script src="tools/fonts/fontawesome/all.js"></script>

    <script src="admin/bootstrap/jquery-3.6.0.min.js"></script>
    <script src="admin/bootstrap/popper.min.js"></script>
    <script src="admin/bootstrap/js/bootstrap.min.js"></script>
    <link href="admin/bootstrap/bootstrap-myaac.css" rel="stylesheet" type="text/css">

    <?php if ($config['pace_load']) { ?>
        <script src="admin/bootstrap/pace/pace.js"></script>
        <link
            href="admin/bootstrap/pace/themes/<?= $config['pace_color'] ?>/pace-theme-<?= $config['pace_theme'] ?>.css"
            rel="stylesheet"/>
    <?php } ?>

    <script>
        function CollapseTable(a_ID) {
            $('#' + a_ID).slideToggle('slow');
            if ($('#Indicator_' + a_ID).hasClass('CircleSymbolPlus')) {
                $('#Indicator_' + a_ID).attr('class', 'CircleSymbolMinus');
                $('#Indicator_' + a_ID).css('background-image', 'url(' + IMAGES + '/global/content/circle-symbol-plus.gif)');
            } else {
                $('#Indicator_' + a_ID).css('background-image', 'url(' + IMAGES + '/global/content/circle-symbol-minus.gif)');
                $('#Indicator_' + a_ID).attr('class', 'CircleSymbolPlus');
            }
        }
    </script>

    <script type="text/javascript">
        var menus = '';
        var loginStatus = "<?= ($logged ? 'true' : 'false'); ?>";
        <?php
        if (PAGE !== 'news') {
            if (strpos(URI, 'subtopic=') !== false) {
                $tmp = $_REQUEST['subtopic'];
                if ($tmp === 'accountmanagement') {
                    $tmp = 'accountmanage';
                }
            } else {
                $tmp = str_replace('/', '', URI);
                $exp = explode('/', URI);
                if (URI !== 'account/create' && URI !== 'account/lost' && isset($exp[1])) {
                    if ($exp[0] === 'account') {
                        $tmp = 'accountmanage';
                    } else if ($exp[0] === 'news' && $exp[1] === 'archive') {
                        $tmp = 'newsarchive';
                    } else
                        $tmp = $exp[0];
                }
            }
        } else {
            $tmp = 'news';
        }
        ?>
        var activeSubmenuItem = "<?= $tmp; ?>";
        var IMAGES = "<?= $template_path; ?>/images";
        var LINK_ACCOUNT = "<?= BASE_URL; ?>";

        function rowOverEffect(object) {
            if (object.className == 'moduleRow') object.className = 'moduleRowOver';
        }

        function rowOutEffect(object) {
            if (object.className == 'moduleRowOver') object.className = 'moduleRow';
        }

        function InitializePage() {
            LoadLoginBox();
            LoadMenu();
        }

        // initialisation of the loginbox status by the value of the variable 'loginStatus' which is provided to the HTML-document by PHP in the file 'header.inc'
        function LoadLoginBox() {
            if (loginStatus == "false") {
                document.getElementById('ButtonText').style.backgroundImage = "url('" + IMAGES + "/global/buttons/mediumbutton_login.png')";
                document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account.gif')";
                document.getElementById('LoginstatusText_2_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account.gif')";
                document.getElementById('LoginstatusText_2_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-create-account-over.gif')";
            } else {
                document.getElementById('ButtonText').style.backgroundImage = "url('" + IMAGES + "/global/buttons/mediumbutton_myaccount.png')";
                document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout.gif')";
                document.getElementById('LoginstatusText_2_1').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout.gif')";
                document.getElementById('LoginstatusText_2_2').style.backgroundImage = "url('" + IMAGES + "/loginbox/loginbox-font-logout-over.gif')";
            }
        }

        // mouse-over and click events of the loginbox
        function MouseOverLoginBoxText(source) {
            var loginText1 = source.querySelector('#LoginstatusText_2_1');
            var loginText2 = source.querySelector('#LoginstatusText_2_2');

            if (loginText1 && loginText2) {
                loginText1.style.visibility = "hidden";
                loginText2.style.visibility = "visible";
            }
        }

        function MouseOutLoginBoxText(source) {
        var loginText1 = source.querySelector('#LoginstatusText_2_1');
        var loginText2 = source.querySelector('#LoginstatusText_2_2');

        if (loginText1 && loginText2) {
            loginText1.style.visibility = "visible";
            loginText2.style.visibility = "hidden";
            }
        }

        function LoginButtonAction() {
            if (loginStatus == "false") {
                window.location = "<?= getLink('account/manage'); ?>";
            } else {
                window.location = "<?= getLink('account/manage'); ?>";
            }
        }

        function LoginstatusTextAction(source) {
            if (loginStatus == "false") {
                window.location = "<?= getLink('account/create'); ?>";
            } else {
                window.location = "<?= getLink('account/logout'); ?>";
            }
        }

        var menu = [];
        menu[0] = {};
        var unloadhelper = false;

        // load the menu and set the active submenu item by using the variable 'activeSubmenuItem'
        function LoadMenu() {
            document.getElementById("submenu_" + activeSubmenuItem).style.color = "white";
            document.getElementById("ActiveSubmenuItemIcon_" + activeSubmenuItem).style.visibility = "visible";
            menus = localStorage.getItem('menus');
            if (menus.lastIndexOf("&") === -1) {
                menus = "news=1&account=0&community=0&library=0&forum=0<?php if ($config['gifts_system']) echo '&shops=0'; ?>&charactertrade=0&";
            }
            FillMenuArray();
            InitializeMenu();
        }

        function SaveMenu() {
            if (!unloadhelper) {
                SaveMenuArray();
                unloadhelper = true;
            }
        }

        // store the values of the variable 'self.name' in the array menu
        function FillMenuArray() {
            while (menus.length > 0) {
                var mark1 = menus.indexOf("=");
                var mark2 = menus.indexOf("&");
                var menuItemName = menus.substr(0, mark1);
                menu[0][menuItemName] = menus.substring(mark1 + 1, mark2);
                menus = menus.substr(mark2 + 1, menus.length);
            }
        }

        // hide or show the corresponding submenus
        function InitializeMenu() {
            for (menuItemName in menu[0]) {
                if (menu[0][menuItemName] == "0") {
                    document.getElementById(menuItemName + "_Submenu").style.visibility = "hidden";
                    document.getElementById(menuItemName + "_Submenu").style.display = "none";
                    document.getElementById(menuItemName + "_Lights").style.visibility = "visible";
                    document.getElementById(menuItemName + "_Extend").style.backgroundImage = "url(" + IMAGES + "/general/plus.gif)";
                } else {
                    document.getElementById(menuItemName + "_Submenu").style.visibility = "visible";
                    document.getElementById(menuItemName + "_Submenu").style.display = "block";
                    document.getElementById(menuItemName + "_Lights").style.visibility = "hidden";
                    document.getElementById(menuItemName + "_Extend").style.backgroundImage = "url(" + IMAGES + "/general/minus.gif)";
                }
            }
        }


        function SaveMenuArray() {
            var stringSlices = "";
            var temp = "";

            for (menuItemName in menu[0]) {
                stringSlices = menuItemName + "=" + menu[0][menuItemName] + "&";
                temp = temp + stringSlices;
            }

            localStorage.setItem('menus', temp);
        }

        // onClick open or close submenus
        function MenuItemAction(sourceId) {
            if (menu[0][sourceId] == 1) {
                CloseMenuItem(sourceId);
            } else {
                $.each(menu[0], function (index, value) {
                    if (value === '1') {
                        CloseMenuItem(index);
                    }
                });
                OpenMenuItem(sourceId);
            }
        }

        function OpenMenuItem(sourceId) {
            menu[0][sourceId] = 1;
            document.getElementById(sourceId + "_Submenu").style.visibility = "visible";
            document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + IMAGES + "global/general/minus.gif)";
            document.getElementById(sourceId + "_Lights").style.visibility = "hidden";
            $('#' + sourceId + '_Submenu').slideDown('slow');
            // document.getElementById(sourceId+"_Submenu").style.visibility = "visible";
            //document.getElementById(sourceId+"_Submenu").style.display = "block";
            //document.getElementById(sourceId+"_Lights").style.visibility = "hidden";
            document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + IMAGES + "/general/minus.gif)";
        }

        function CloseMenuItem(sourceId) {
            menu[0][sourceId] = 0;
            document.getElementById(sourceId + "_Lights").style.visibility = "visible";
            document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + IMAGES + "global/general/plus.gif)";
            $('#' + sourceId + '_Submenu').slideUp('fast', function () {
                document.getElementById(sourceId + "_Submenu").style.visibility = "hidden";
            });
            //document.getElementById(sourceId+"_Submenu").style.visibility = "hidden";
            //document.getElementById(sourceId+"_Submenu").style.display = "none";
            //document.getElementById(sourceId+"_Lights").style.visibility = "visible";
            document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + IMAGES + "/general/plus.gif)";
        }

        // mouse-over effects of menubuttons and submenuitems
        function MouseOverMenuItem(source) {
            if (source.firstChild.style) {
                source.firstChild.style.visibility = "visible";
            }
        }

        function MouseOutMenuItem(source) {
            if (source.firstChild.style) {
                source.firstChild.style.visibility = "hidden";
            }
        }

        function MouseOverSubmenuItem(source) {
            if (source.style) {
                source.style.backgroundColor = "#14433F";
            }
        }

        function MouseOutSubmenuItem(source) {
            if (source.style) {
                source.style.backgroundColor = "#0D2E2B";
            }
        }
    </script>
    <?= template_place_holder('head_end'); ?>
</head>
<body onBeforeUnLoad="SaveMenu();" onUnload="SaveMenu();" style="background-image:url(templates/tibiacom/images/header/background-artwork.jpg);
         background-attachment: fixed;
         background-size: cover;
         background-repeat: repeat;
         ">
<?
<?= template_place_holder('body_start'); ?>

<div id="top"></div>
<div id="ArtworkHelper">
    <div id="Bodycontainer">
        <div id="ContentRow">
            <div id="MenuColumn">
                <div id="LeftArtwork">
                    <img id="TibiaLogoArtworkTop"
                         src="<?= $template_path; ?>/images/header/<?= $config['logo_image']; ?>"
                         onClick="window.location = '<?= getLink('news') ?>';" alt="logoartwork"/>
                </div>

                <div id="Loginbox">
                    <div id="LoginTop"
                         style="background-image:url(<?= $template_path; ?>/images/general/box-top.gif)"></div>
                    <div id="BorderLeft" class="LoginBorder"
                         style="background-image:url(<?= $template_path; ?>/images/general/chain.gif)"></div>


                    <div id="LoginButtonContainer"
                         style="background-image:url(<?= $template_path; ?>/images/loginbox/loginbox-textfield-background.gif)">
                        <div id="LoginButton"
                             style="background-image:url(<?= $template_path; ?>/images/global/buttons/mediumbutton.gif)">
                            <div onClick="LoginButtonAction();" onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);">
                                <div class="Button"
                                     style="background-image:url(<?= $template_path; ?>/images/global/buttons/mediumbutton-over.gif)"></div>
                                <?php
                                echo '<div id="ButtonText" ' . ($logged ? '' : 'style="background-image:url(' . $template_path . '/images/global/buttons/mediumbutton_login.png)"') . '> </div>';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div style="clear:both"></div>

                <div class="Loginstatus" style="background-image:url(https://static.tibia.com/images/global/loginbox/loginbox-textfield-background.gif)">
                    <div id="LoginstatusText_2" onclick="LoginstatusTextAction(this);" onmouseover="MouseOverLoginBoxText(this);" onmouseout="MouseOutLoginBoxText(this);" style="background-image: url(&quot;templates/myaac/images/loginbox/loginbox-font-create-account.gif&quot;);">
                        <div id="LoginstatusText_2_1" class="LoginstatusText" style="background-image: url(templates/myaac/images/loginbox/loginbox-font-create-account.gif); visibility: visible;">
                        </div>
                        <div id="LoginstatusText_2_2" class="LoginstatusText" style="background-image: url(https://static.tibia.com/images/global/loginbox/loginbox-font-create-account-over.gif); visibility: hidden;">
                        </div>
                    </div>
                </div>

                    <div id="BorderRight" class="LoginBorder"
                         style="background-image:url(<?= $template_path; ?>/images/general/chain.gif)"></div>
                    <div id="LoginBottom" class="Loginstatus"
                         style="background-image:url(<?= $template_path; ?>/images/general/box-bottom.gif)"></div>
                </div>

                <div class="SmallMenuBox" id="DownloadBox">
                    <div class="SmallBoxTop"
                         style="background-image:url(<?= $template_path; ?>/images/global/general/box-top.gif)"></div>
                    <div class="SmallBoxBorder"
                         style="background-image:url(<?= $template_path; ?>/images/global/general/chain.gif);"></div>


                <div class="SmallBoxButtonContainer"
                    style="background-image:url(<?= $template_path; ?>/images/global/loginbox/loginbox-textfield-background.gif)">
                    <a href="?subtopic=downloadclient&step=downloadagreement">
                        <div id="PlayNowContainer">
                            <div class="MediumButtonBackground"
                                style="background-image:url(<?= $template_path; ?>/images/global/buttons/mediumbutton.gif)" onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this)">
                                <div class="Button"
                                    style="background-image: url(<?= $template_path; ?>/images/global/buttons/mediumbutton-over.gif)"></div>
                                <input class="MediumButtonText" type="image" name="Download" alt="Download"
                                    src="<?= $template_path; ?>/images/global/buttons/mediumbutton_download.png">
                            </div>
                        </div>
                    </a>
                </div>

                    <div class="SmallBoxBorder BorderRight"
                         style="background-image:url(<?= $template_path; ?>/images/global/general/chain.gif);"></div>
                    <div class="Loginstatus SmallBoxBottom"
                         style="background-image:url(<?= $template_path; ?>/images/global/general/box-bottom.gif);"></div>
                </div>

                <div-- id='Menu'>
                    <div id='MenuTop'
                         style='background-image:url(<?= $template_path; ?>/images/general/box-top.gif);'></div>

                    <?php
                    $menus = get_template_menus();

                    foreach ($config['menu_categories'] as $id => $cat) {
                        if (!isset($menus[$id]) || ($id == MENU_CATEGORY_SHOP && !$config['gifts_system'])) {
                            continue;
                        }
                        ?>
                        <div id='<?= $cat['id']; ?>' class='menuitem'>
	<span onClick="MenuItemAction('<?= $cat['id']; ?>')">
		<div class='MenuButton' style='background-image:url(<?= $template_path ?>/images/menu/button-background.gif);'>
			<div onMouseOver='MouseOverMenuItem(this);' onMouseOut='MouseOutMenuItem(this);'><div class='Button'
                                                                                                  style='background-image:url(<?= $template_path; ?>/images/menu/button-background-over.gif);'></div>
				<span id='<?= $cat['id']; ?>_Lights' class='Lights'>
					<div class='light_lu'
                         style='background-image:url(<?= $template_path; ?>/images/menu/green-light.gif);'></div>
					<div class='light_ld'
                         style='background-image:url(<?= $template_path; ?>/images/menu/green-light.gif);'></div>
					<div class='light_ru'
                         style='background-image:url(<?= $template_path; ?>/images/menu/green-light.gif);'></div>
				</span>
				<div id='<?= $cat['id']; ?>_Icon' class='Icon'
                     style='background-image:url(<?= $template_path ?><?= getImageMenuRandom($cat['id']) ?>);'></div>
				<div id='<?= $cat['id']; ?>_Label' class='Label'
                     style='background-image:url(<?= $template_path; ?>/images/menu/label-<?= $cat['id']; ?>.gif);'></div>
				<div id='<?= $cat['id']; ?>_Extend' class='Extend'
                     style='background-image:url(<?= $template_path; ?>/images/general/plus.gif);'></div>
			</div>
		</div>
	</span>
    <div id='<?= $cat['id']; ?>_Submenu' class='Submenu'>
    <?php
    $default_menu_color = "ffffff";
    $loginStatus = ($logged ? 'true' : 'false');

    foreach ($menus[$id] as $category => $menu) {
        $link_color = '#' . (strlen($menu['color']) == 0 ? $default_menu_color : $menu['color']);
        ?>
        <?php
        if ($loginStatus == "false" && $menu['name'] == 'Create Auction') {
            continue;
        }
        ?>
        <a href='<?= $menu['link_full']; ?>'<?= $menu['blank'] ? ' target="_blank"' : '' ?>>
            <div id='submenu_<?= str_replace('/', '', $menu['link']); ?>'
                 class='Submenuitem' onMouseOver='MouseOverSubmenuItem(this)'
                 onMouseOut='MouseOutSubmenuItem(this)' style="color: <?= $link_color; ?>;">
                <div class='LeftChain'
                     style='background-image:url(<?= $template_path; ?>/images/general/chain.gif);'></div>
                <div id='ActiveSubmenuItemIcon_<?= str_replace('/', '', $menu['link']); ?>'
                     class='ActiveSubmenuItemIcon'
                     style='background-image:url(<?= $template_path; ?>/images/menu/icon-activesubmenu.gif);'></div>
                <div class='SubmenuitemLabel'
                     style="color: <?= $link_color; ?>;"><?= $menu['name']; ?></div>
                <div class='RightChain'
                     style='background-image:url(<?= $template_path; ?>/images/general/chain.gif);'></div>
            </div>
        </a>
        <?php
    }
    ?>
</div>
                            <?php
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div id='MenuBottom'
                    style='background-image:url(<?= $template_path; ?>/images/general/box-bottom.gif);'>
                    </div>
                    <script type="text/javascript">
                        InitializePage();
                    </script>
            </div>


            <div id="ContentColumn">


                <div class="Content">

                    <?php if ($config['status_bar'] == true) { ?>
                        <div class="Box">
                            <div class="Corner-tl"
                                 style="background-image:url(<?= $template_path; ?>/images/global/content/corner-tl.gif);"></div>
                            <div class="Corner-tr"
                                 style="background-image:url(<?= $template_path; ?>/images/global/content/corner-tr.gif);"></div>
                            <div class="Border_1"
                                 style="background-image:url(<?= $template_path; ?>/images/global/content/border-1.gif);"></div>
                            <div class="BorderTitleText"
                                 style="background-image:url(<?= $template_path; ?>/images/global/content/newsheadline_background.gif); height: 28px;">
                                <div class="InfoBar">
                                    <?php if (isset($config['discord_link']) && !empty($config['discord_link'])) { ?>
                                        <img class="InfoBarBigLogo"
                                             src="<?= $template_path; ?>/images/global/header/icon-discord.png">
                                        <span class="InfoBarNumbers">
					<a class="InfoBarLinks" href="<?= $config['discord_link']; ?>" target="new"><span
                            class="InfoBarSmallElement">Join Discord</span></a>
				</span>
                                    <?php } ?>
                                    <?php if (isset($config['whatsapp_link']) && !empty($config['whatsapp_link'])) { ?>
                                        <img class="InfoBarBigLogo"
                                             src="<?= $template_path; ?>/images/global/header/icon-whatsapp.png"
                                             width="16">
                                        <span class="InfoBarNumbers">
					<a class="InfoBarLinks" href="https://wa.me/<?= $config['whatsapp_link']; ?>" target="new"><span
                            class="InfoBarSmallElement">Whatsapp</span></a>
				</span>
                                    <?php } ?>
                                    <?php if (isset($config['instagram_link']) && !empty($config['instagram_link'])) { ?>
                                        <img class="InfoBarBigLogo"
                                             src="<?= $template_path; ?>/images/global/header/icon-instagram.png"
                                             width="16">
                                        <span class="InfoBarNumbers">
					<a class="InfoBarLinks" href="https://www.instagram.com/<?= $config['instagram_link']; ?>"
                       target="new"><span class="InfoBarSmallElement">Instagram</span></a>
				</span>
                                    <?php } ?>
                                    <?php if (isset($config['facebook_link']) && !empty($config['facebook_link'])) { ?>
                                        <img class="InfoBarBigLogo"
                                             src="<?= $template_path; ?>/images/global/header/icon-facebook.png"
                                             width="16">
                                        <span class="InfoBarNumbers">
					<a class="InfoBarLinks" href="https://www.facebook.com/<?= $config['facebook_link']; ?>"
                       target="new"><span class="InfoBarSmallElement">Facebook</span></a>
				</span>
                                    <?php } ?>
                                    <img class="InfoBarBigLogo"
                                         src="<?= $template_path; ?>/images/global/header/icon-download.png">
                                    <span class="InfoBarNumbers">
					<a class="InfoBarLinks" href="?subtopic=downloadclient"><span
                            class="InfoBarSmallElement">Download</span></a>
				</span>
                                    <span style="float: right; margin-top: -2px;">
				<img class="InfoBarBigLogo" src="<?= $template_path; ?>/images/global/header/icon-players-online.png">
				<span class="InfoBarNumbers">
					<span class="InfoBarSmallElement">
						<a class="InfoBarLinks" href="?online">
<?php
if ($status['online']) {
    echo '' . count($playersOnline) . ' Players Online';
} else {
    echo 'Server Offline';
}
?>
						</a>
					</span>
				</span>
<?php if ($config['collapse_status'] == true) { ?>
    <a data-bs-toggle="collapse" href="#statusbar" role="button" aria-expanded="false" aria-controls="statusbar">
<img src="<?= $template_path; ?>/images/global/content/top-to-back.gif" class="InfoBarBigLogo">
</a>
<?php } ?>
</span>

                                </div>
                            </div>
                            <!-- COLLAPSE STATUS BAR -->
                            <?php if ($config['collapse_status'] == true) { ?>
                                <div class="collapse" id="statusbar" style="background-color: #d4c0a1;">
                                    <table class="Table3" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="InnerTableContainer"
                                                     style="display: flex; flex-wrap: wrap; font-family: Verdana;">
                                                    <?php if ($config['carousel_status'] == true) { ?>
                                                        <table style="width:100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="TableContentContainer">
                                                                        <table class="TableContent" width="100%"
                                                                               style="border:1px solid #faf0d7; font-size: 12px;">
                                                                            <tbody>
                                                                            <tr bgcolor="#F1E0C6">
                                                                                <td>
                                                                                    <div class="container">
                                                                                        <div
                                                                                            id="carouselExampleCaptions"
                                                                                            class="carousel slide"
                                                                                            data-bs-ride="carousel">
                                                                                            <div class="carousel-inner">
                                                                                                <?php
                                                                                                $count = 1;
                                                                                                foreach ($config['carousel'] as $carousel) {
                                                                                                    if ($count == 1) {
                                                                                                        ?>
                                                                                                        <div
                                                                                                            class="carousel-item active">
                                                                                                            <img
                                                                                                                src="<?= $template_path ?>/images/carousel/<?= $carousel ?>"
                                                                                                                style="width: 100%;">
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    } elseif ($count > 1) {
                                                                                                        ?>
                                                                                                        <div
                                                                                                            class="carousel-item">
                                                                                                            <img
                                                                                                                src="<?= $template_path ?>/images/carousel/<?= $carousel ?>"
                                                                                                                style="width: 100%;">
                                                                                                        </div>
                                                                                                        <?php
                                                                                                    }
                                                                                                    $count++;
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                            <button
                                                                                                class="carousel-control-prev"
                                                                                                type="button"
                                                                                                data-bs-target="#carouselExampleCaptions"
                                                                                                data-bs-slide="prev">
                                                                                                <span
                                                                                                    class="carousel-control-prev-icon"
                                                                                                    aria-hidden="true"></span>
                                                                                            </button>
                                                                                            <button
                                                                                                class="carousel-control-next"
                                                                                                type="button"
                                                                                                data-bs-target="#carouselExampleCaptions"
                                                                                                data-bs-slide="next">
                                                                                                <span
                                                                                                    class="carousel-control-next-icon"
                                                                                                    aria-hidden="true"></span>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- COLLAPSE STATUS BAR -->
                            <?php } ?>
                            <div class="Border_1"
                                 style="background-image:url(<?= $template_path; ?>/images/global/content/border-1.gif);"></div>
                            <div class="CornerWrapper-b">
                                <div class="Corner-bl"
                                     style="background-image:url(<?= $template_path; ?>/images/global/content/corner-bl.gif);"></div>
                            </div>
                            <div class="CornerWrapper-b">
                                <div class="Corner-br"
                                     style="background-image:url(<?= $template_path; ?>/images/global/content/corner-br.gif);"></div>
                            </div>
                        </div>
                    <?php } ?>

                    <div id="ContentHelper">
                        <?= tickers(); ?>
                        <div id="<?= PAGE; ?>" class="Box">
                            <div class="Corner-tl"
                                 style="background-image:url(<?= $template_path; ?>/images/content/corner-tl.gif);"></div>
                            <div class="Corner-tr"
                                 style="background-image:url(<?= $template_path; ?>/images/content/corner-tr.gif);"></div>
                            <div class="Border_1"
                                 style="background-image:url(<?= $template_path; ?>/images/content/border-1.gif);"></div>
                            <div class="BorderTitleText"
                                 style="background-image:url(<?= $template_path; ?>/images/content/title-background-green.gif);"></div>
                            <?php
                            $headline = $template_path . '/images/header/headline-' . PAGE . '.gif';
                            if (!file_exists($headline))
                                $headline = $template_path . '/headline.php?t=' . ucfirst($title);
                            ?>
                            <img class="Title" src="<?= $headline; ?>" alt="Contentbox headline"/>
                            <div class="Border_2">
                                <div class="Border_3">
                                    <?php $hooks->trigger(HOOK_TIBIACOM_BORDER_3); ?>
                                    <div class="BoxContent"
                                         style="background-image:url(<?= $template_path; ?>/images/content/scroll.gif);">
                                        <?= template_place_holder('center_top') . $content; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="Border_1"
                                 style="background-image:url(<?= $template_path; ?>/images/content/border-1.gif);"></div>

                            <div class="CornerWrapper-b">
                                <div class="Corner-bl"
                                     style="background-image:url(<?= $template_path; ?>/images/content/corner-bl.gif);"></div>
                            </div>
                            <div class="CornerWrapper-b">
                                <div class="Corner-br"
                                     style="background-image:url(<?= $template_path; ?>/images/content/corner-br.gif);"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Footer"><?= template_footer(); ?></div>
            </div>

            <div id="ThemeboxesColumn">
                <?PHP
                $creaturequery = $SQL->query("SELECT `boostname`, `looktype`, `lookfeet` , `looklegs` , `lookhead` , `lookbody` , `lookaddons` , `lookmount` FROM `boosted_creature`")->fetch();
                $bossquery = $SQL->query("SELECT `boostname`, `looktype`, `lookfeet` , `looklegs` , `lookhead` , `lookbody` , `lookaddons` , `lookmount` FROM `boosted_boss`")->fetch();
                ?>
                <div id="RightArtwork">
                    <img id="Creature"
                         src="<?= $config['outfit_images_url'] ?>?id=<?= $creaturequery['looktype']; ?>&addons=<?= $creaturequery['lookaddons']; ?>&head=<?= $creaturequery['lookhead']; ?>&body=<?= $creaturequery['lookbody']; ?>&legs=<?= $creaturequery['looklegs']; ?>&feet=<?= $creaturequery['lookfeet']; ?>&mount=<?= $creaturequery['lookmount']; ?>"
                         alt="Creature of the Day"
                         onclick="window.open('https://tibia.fandom.com/wiki/<?= ($creaturequery['boostname'])?>', '_blank')"
                         title="Today's boosted creature: <?= ($creaturequery['boostname']); ?>">
                    <img id="Boss"
                         src="<?= $config['outfit_images_url'] ?>?id=<?= $bossquery['looktype']; ?>&addons=<?= $bossquery['lookaddons']; ?>&head=<?= $bossquery['lookhead']; ?>&body=<?= $bossquery['lookbody']; ?>&legs=<?= $bossquery['looklegs']; ?>&feet=<?= $bossquery['lookfeet']; ?>&mount=<?= $bossquery['lookmount']; ?>"
                         alt="Boss of the Day"
                         onclick="window.open('https://tibia.fandom.com/wiki/<?= ($bossquery['boostname'])?>', '_blank')"
                         title="Today's boosted boss: <?= ($bossquery['boostname']); ?>">
                    <img id="PedestalAndOnline" src="<?= $template_path; ?>/images/header/pedestal.gif" alt="Monster Pedestal and Players Online Box"/>
                </div>
                <div id="Themeboxes">
                    <?php
                    $twig_loader->prependPath(__DIR__ . '/boxes/templates');

                    foreach ($config['boxes'] as $box) {
                        /** @var string $template_name */
                        $file = TEMPLATES . $template_name . '/boxes/' . $box . '.php';
                        if (file_exists($file)) {
                            include($file); ?>
                            <?php
                        }
                    }
                    if ($config['template_allow_change'])
                        echo '<span style="color: white">Template:</span><br/>' . template_form();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= template_place_holder('body_end'); ?>

<style>
    .scrollToTop {
        width: 70px;
        height: 70px;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        color: #444;
        text-decoration: none;
        position: fixed;
        bottom: 10px;
        right: 10px;
        display: none;
        z-index: 50000;
    }

    .scrollToTop:hover {
        text-decoration: none;
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function () {
        //Check to see if the window is top if not then display button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });
        //Click event to scroll to top
        $('.scrollToTop').click(function () {
            $('html, body').animate({scrollTop: 0}, 800);
            return false;
        });
    });
</script>
     <div class="scrollToTop" style="background: url(<?= $template_path; ?>/images/global/content/top.png) no-repeat 0 0;"></div>


<script src="<?= $template_path; ?>/js/generic.js"></script>
<div id="HelperDivContainer" style="background-image: url(<?= $template_path; ?>/images/global/content/scroll.gif);">
    <div class="HelperDivArrow"
         style="background-image: url(<?= $template_path; ?>/images/global/content/back-to-top.gif);"></div>
    <div id="HelperDivHeadline"></div>
    <div id="HelperDivText"></div>
    <center><img class="Ornament" src="<?= $template_path; ?>/images/global/content/ornament.gif"></center>
    <br>
</div>

</body>
</html>
<?php

function logo_monster()
{
    global $config;
    return str_replace(" ", "", trim(strtolower($config['logo_monster'])));
}

/**
 * @param $menu
 * @return string
 */
function getImageMenuRandom($menu): string
{
    global $config;
    if (!$config['allow_menu_animated']) {
        return $menu === 'bgs' ? "/images/header/{$config['background_image']}" : "/images/menu/icon-{$menu}.gif";
    }

    $images = [
        'bgs'            => ['00.jpg', '01.jpg', '02.jpg', '03.jpg', '04.jpg', '05.jpg', '06.jpg', '07.jpg', '08.jpg', '09.jpg', '10.jpg', '11.jpg', '12.jpg'],
        'news'           => ['icon-news01.gif', 'icon-news02.gif', 'icon-news03.gif', 'icon-news04.gif', 'icon-news05.gif', 'icon-news06.gif'],
        'community'      => ['icon-community01.gif', 'icon-community02.gif', 'icon-community03.gif', 'icon-community04.gif', 'icon-community05.gif', 'icon-community06.gif', 'icon-community07.gif', 'icon-community08.gif'],
        'forum'          => ['icon-forum01.gif', 'icon-forum02.gif', 'icon-forum03.gif', 'icon-forum04.gif', 'icon-forum05.gif', 'icon-forum06.gif', 'icon-forum07.gif', 'icon-forum08.gif', 'icon-forum09.gif', 'icon-forum10.gif'],
        'account'        => ['icon-account01.gif', 'icon-account02.gif', 'icon-account03.gif', 'icon-account04.gif', 'icon-account05.gif'],
        'library'        => ['icon-library01.gif', 'icon-library02.gif', 'icon-library03.gif', 'icon-library04.gif', 'icon-library05.gif'],
        'wars'           => ['icon-wars01.gif', 'icon-wars02.gif', 'icon-wars03.gif', 'icon-wars04.gif', 'icon-wars05.gif', 'icon-wars06.gif', 'icon-wars07.gif', 'icon-wars08.gif', 'icon-wars09.gif', 'icon-wars10.gif', 'icon-wars11.gif', 'icon-wars12.gif', 'icon-wars13.gif', 'icon-wars14.gif'],
        'events'         => ['icon-events01.gif', 'icon-events02.gif', 'icon-events03.gif', 'icon-events04.gif', 'icon-events05.gif', 'icon-events06.gif', 'icon-events07.gif', 'icon-events08.gif', 'icon-events09.gif', 'icon-events10.gif', 'icon-events11.gif', 'icon-events12.gif', 'icon-events13.gif'],
        'support'        => ['icon-support01.gif', 'icon-support02.gif', 'icon-support03.gif', 'icon-support04.gif', 'icon-support05.gif', 'icon-support06.gif', 'icon-support07.gif', 'icon-support08.gif', 'icon-support09.gif', 'icon-support10.gif', 'icon-support11.gif'],
        'shops'          => ['icon-shops01.gif', 'icon-shops02.gif', 'icon-shops03.gif', 'icon-shops04.gif'],
        'charactertrade' => ['icon-bazaar01.gif', 'icon-bazaar02.gif'],
    ];
    if (!$images[$menu]) {
        return "/images/menu/icon-{$menu}.gif";
    }

    // generate random number size of the array
    $img = $images[$menu][rand(0, count($images[$menu]) - 1)];
    return $menu !== 'bgs' ? "/images/menu/anim/{$img}" : "/images/header/bgs/{$img}";
}

<?php

global $config, $db, $template_path;
$auction_iddetails = $getPageDetails;



/* GET INFO AUCTION */
$getAuction = $db->query("SELECT `id`, `account_old`, `account_new`, `player_id`, `price`, `date_end`, `date_start`, `bid_account`, `bid_price`, `status` FROM `myaac_charbazaar` WHERE `id` = {$db->quote($auction_iddetails)}");
if (!$getAuction = $getAuction->fetch()) {
    echo "We can not find auction with this id!";
    return;
}
/* GET INFO AUCTION END */

global $config;
$mounts_xml = $config['data_path'] . 'XML/mounts.xml';
$xml = simplexml_load_file($mounts_xml);
$normal_mounts = [];
$store_mounts = [];

foreach ($xml->mount as $mount) {
    $type = (string)$mount['type'];
    $clientid = (int)$mount['clientid'];

    switch ($type) {
        case 'store':
            $store_mounts[] = $clientid;
            break;
        case 'quest':
            $normal_mounts[] = $clientid;
            break;
    }
}

/* GET DAILY STREAK */

$getDailyStreak = $db->query("SELECT `daystreak` FROM `daily_reward_history` WHERE `player_id` = {$getAuction['player_id']}")->fetch();
$getDailyStreak = ($getDailyStreak !== false) ? $getDailyStreak : 0;

/* GET DAILY STREAK END */

// GET ACHIEVEMENTS AMOUNT

require_once BASE . '/tools/achievements.php';

    $achievementPoints = 0;

    foreach ($achievements as $achievement => $value) {
        $achievementStorage = $config['achievements_base'] + $achievement;
        $searchAchievementsbyStorage = $db->query("SELECT `key`, `value` FROM `player_storage` WHERE `key` = $achievementStorage AND `player_id` = {$getAuction['player_id']}")->fetch();

        if ($searchAchievementsbyStorage && $searchAchievementsbyStorage['key'] == $achievementStorage) {
            $achievementPoints += $value['points'];
        }
    }

/* GET HIRELING */

$getHireling =  $db->query("SELECT `player_id` FROM `player_hirelings` WHERE `player_id` = {$getAuction['player_id']}")->fetchAll();
$getHireling = ($getHireling !== false) ? count($getHireling) : 0;
/* END HIRELING */


/* GET INFO CHARACTER */
$getCharacter = $db->query("SELECT `name`, `vocation`, `level`, `sex`, `looktype`, `lookaddons`, `lookhead`, `lookbody`, `looklegs`, `lookfeet`, `health`, `healthmax`, `mana`, `manamax`, `maglevel`, `manaspent`, `balance`, `skill_fist`, `skill_fist_tries`, `skill_club`, `skill_club_tries`, `skill_sword`, `skill_sword_tries`, `skill_axe`, `skill_axe_tries`, `skill_dist`, `skill_dist_tries`, `skill_shielding`, `skill_shielding_tries`, `skill_fishing`, `skill_fishing_tries`, `skill_shielding`, `skill_shielding_tries`, `cap`, `soul`, `created`, `experience`, `blessings1`, `blessings2`, `blessings3`, `blessings4`, `blessings5`, `blessings6`, `blessings7`, `blessings8`, `prey_wildcard`, `boss_points`, `forge_dusts`, `forge_dust_level`, `task_points` FROM `players` WHERE `id` = {$getAuction['player_id']}");
$character = $getCharacter->fetch();
/* GET INFO CHARACTER END */

/* GET ITEMS DEPOT */
$getDepotItems = $db->query("SELECT `sid`, `pid`, `itemtype`, `count`, `attributes` FROM `player_depotitems` WHERE `player_id` = {$getAuction['player_id']}")->FetchAll();
$getStashItems = $db->query("SELECT `item_id` as `itemtype`, `item_count` as `count` FROM `player_stash` WHERE `player_id` = {$getAuction['player_id']}")->FetchAll();

/* GET ITEMS DEPOT END */

// GET STORE ITEMS
$getStoreItems = $db->query("SELECT `sid`, `pid`, `itemtype`, `count`, `attributes` FROM `player_items` WHERE `player_id` = {$getAuction['player_id']} AND `itemtype` = 23396")->fetch();
$inboxItems = $db->query("SELECT `itemtype`, `count` FROM `player_items` WHERE `player_id` = {$getAuction['player_id']} AND `pid` = {$getStoreItems['sid']}")->fetchAll();
$allItems = $db->query("SELECT `sid`, `pid`, `itemtype`, `count`, `attributes` FROM `player_items` WHERE `player_id` = {$getAuction['player_id']} AND `pid` <> {$getStoreItems['sid']} AND `itemtype` <> 23396")->fetchAll();


$characterItems = array_merge($getDepotItems, $getStashItems, $allItems);

// STORE ITEMS END

##Limit for 33 per page add pagination

$getFamiliars = $db->query("SELECT `key`, `value` FROM `player_storage` WHERE `key` BETWEEN 10003000 AND 10003500 AND `player_id` = {$getAuction['player_id']}")->fetchAll();
$getMounts = $db->query("SELECT `key`, `value` FROM `player_storage` WHERE `key` BETWEEN 10002002 AND 10002011 AND `player_id` = {$getAuction['player_id']}")->fetchAll();
$getOutfits = $db->query("SELECT `key`, `value` FROM `player_storage` WHERE `key` BETWEEN 10001000 AND 10001500 AND `player_id` = {$getAuction['player_id']}")->fetchAll();

/* GET BLESS */
$BlessCount = 0;
for ($b = 1; $b < 8; $b++) {
    if ($character["blessings$b"] >= 1) {
        $BlessCount = $BlessCount++;
    }
}

$BlessTwist = ($character['blessings8'] >= 1) ? 'yes' : 'no';
/* GET BLESS END */

// GET REROLL SLOT
$getRerollSlotQuery = $db->query("SELECT `slot`, `state` FROM `player_prey` WHERE `player_id` = {$getAuction['player_id']}  ORDER BY `slot` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$thirdRerollSlot = ($getRerollSlotQuery['state'] > 0) ? 1 : 0;

// GET TASK SLOT
$getTaskSlotQuery = $db->query("SELECT `slot`, `state` FROM `player_taskhunt` WHERE `player_id` = {$getAuction['player_id']} ORDER BY `slot` DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$thirdTaskSlot = ($getTaskSlotQuery['state'] > 0) ? 1 : 0;


/* GET CHARM CHARACTER */
$getCharm = $db->query("SELECT `player_guid`, `charm_points`, `charm_expansion`, `rune_wound`, `rune_enflame`, `rune_poison`, `rune_freeze`, `rune_zap`, `rune_curse`, `rune_cripple`, `rune_parry`, `rune_dodge`, `rune_adrenaline`, `rune_numb`, `rune_cleanse`, `rune_bless`, `rune_scavenge`, `rune_gut`, `rune_low_blow`, `rune_divine`, `rune_vamp`, `rune_void`, `UsedRunesBit` FROM `player_charms` WHERE `player_guid` = {$getAuction['player_id']}");
$getCharm = $getCharm->fetch();

$Charm_Points = $getCharm['charm_points'] ?? '0';
$Charm_UsedPoints = $getCharm['UsedRunesBit'] ?? '0';
$Charm_Expansion = isset($getCharm['charm_expansion']) && $getCharm['charm_expansion'] == 1
    ? "<img src='{$template_path}/images/premiumfeatures/icon_yes.png'> yes"
    : "<img src='{$template_path}/images/premiumfeatures/icon_no.png'> no";
/* GET CHARM CHARACTER END */

/* OUTFIT CHARACTER */
$outfit_url = "{$config['outfit_images_url']}?id={$character['looktype']}" . (!empty($character['lookaddons']) ? "&addons={$character['lookaddons']}" : '') . "&head={$character['lookhead']}&body={$character['lookbody']}&legs={$character['looklegs']}&feet={$character['lookfeet']}";
/* OUTFIT CHARACTER */

/* EQUIPAMENT CHARACTER */
$eq_sql = $db->query("SELECT `pid`, `itemtype` FROM player_items WHERE player_id = {$getAuction['player_id']} AND (`pid` >= 1 and `pid` <= 10)");
$equipment = [];
foreach ($eq_sql as $eq)
    $equipment[$eq['pid']] = $eq['itemtype'];

$empty_slots = ["", "no_helmet", "no_necklace", "no_backpack", "no_armor", "no_handleft", "no_handright", "no_legs", "no_boots", "no_ring", "no_ammo"];
for ($i = 0; $i <= 10; $i++) {
    if (!isset($equipment[$i]) || $equipment[$i] == 0)
        $equipment[$i] = $empty_slots[$i];
}

for ($i = 1; $i < 11; $i++) {
    $equipment[$i] = Validator::number($equipment[$i])
        ? getItemImage($equipment[$i])
        : "<img src='images/items/{$equipment[$i]}.gif' width='32' height='32' border='0' alt='{$equipment[$i]}' />";
}
/* EQUIPAMENT CHARACTER END */

/* CONVERT SEX */
$character_sex = $config['genders'][$character['sex']] ?? ($character['sex'] == 0 ? 'Male' : 'Female');
/* CONVERT SEX END */

/* CONVERT VOCATION */
$character_voc = $config['vocations'][$character['vocation']] ?? null;

if (!$character_voc) {
    $vocationId = $character['vocation'];
    $prefix = '';

    switch ($vocationId) {
        case 1:
        case 5:
            $prefix = ($vocationId == 5) ? 'Master ' : '';
            $character_voc = $prefix . 'Sorcerer';
            break;
        case 2:
        case 6:
            $prefix = ($vocationId == 6) ? 'Elder ' : '';
            $character_voc = $prefix . 'Druid';
            break;
        case 3:
        case 7:
            $prefix = ($vocationId == 7) ? 'Royal ' : '';
            $character_voc = $prefix . 'Paladin';
            break;
        case 4:
        case 8:
            $prefix = ($vocationId == 8) ? 'Elite ' : '';
            $character_voc = $prefix . 'Knight';
            break;
        default:
            $character_voc = 'None';
    }
}
/* CONVERT VOCATION END */

/* GET QUESTS */
$quests = $config['quests'];
$sql_query_in = '';
$i = 0;
foreach ($quests as $quest_name => $quest_storage) {
    if ($i != 0)
        $sql_query_in .= ', ';

    $sql_query_in .= $quest_storage;
    $i++;
}
$storage_sql = $db->query("SELECT `key`, `value` FROM `player_storage` WHERE `player_id` = {$getAuction['player_id']} AND `key` IN ({$sql_query_in})");
$player_storage = [];
foreach ($storage_sql as $storage)
    $player_storage[$storage['key']] = $storage['value'];

foreach ($quests as &$storage) {
    $storage = isset($player_storage[$storage]) && $player_storage[$storage] > 0;
}
/* GET QUESTS END */

/* GET MY BID */
$getAuctionBid = $db->query("SELECT `account_id`, `auction_id`, `bid`, `date` FROM `myaac_charbazaar_bid` WHERE `auction_id` = {$getAuction['id']}");
$getAuctionBid = $getAuctionBid->fetch();

$My_Bid = '<img src="' . $template_path . '/images/premiumfeatures/icon_no.png">';
if ($logged && isset($getAuctionBid['account_id']) && $account_logged == $getAuctionBid['account_id']) {
    $val = number_format($getAuctionBid['bid'], 0, ',', ',');
    $My_Bid = "<b>{$val}</b> <img src='{$template_path}/images/account/icon-tibiacointrusted.png' class='VSCCoinImages' title='Transferable Tibia Coins'>";
}
/* GET MY BID END */

/* VERIFY DATE */
$Hoje = date('Y-m-d H:i:s');
$End = date('Y-m-d H:i:s', strtotime($getAuction['date_end']));
/* VERIFY DATE END */
?>

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <div class="Text">Auction Details</div>
            <span class="CaptionVerticalRight"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <span class="CaptionBorderBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionEdgeLeftBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
        </div>
    </div>
    <table class="Table5" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="Auction">
                                                    <div class="AuctionHeader">
                                                        <div class="AuctionLinks"></div>
                                                        <div
                                                            class="AuctionCharacterName"><?= $character['name'] ?></div>
                                                        Level: <?= $character['level'] ?> |
                                                        Vocation: <?= $character_voc ?> | <?= $character_sex ?> |
                                                        World: <?= $config['lua']['serverName'] ?>
                                                        <br>
                                                    </div>
                                                    <div class="AuctionBody">
                                                        <div class="AuctionBodyBlock AuctionDisplay AuctionOutfit"
                                                             style="font-size: 10px; text-align: center;">
                                                            <img class="AuctionOutfitImage" src="<?= $outfit_url ?>">
                                                        </div>
                                                        <div class="AuctionBodyBlock AuctionDisplay AuctionItemsViewBox">
                                                            <div class="CVIcon CVIconObject" title="(no item for display selected)"></div>
                                                            <div class="CVIcon CVIconObject" title="(no item for display selected)"></div>
                                                            <div class="CVIcon CVIconObject" title="(no item for display selected)"></div>
                                                            <div class="CVIcon CVIconObject" title="(no item for display selected)"></div>
                                                        </div>
                                                        <div class="AuctionBodyBlock ShortAuctionData">
                                                            <?php $dateFormat = $subtopic == 'currentcharactertrades' ? 'M d Y, H:i:s' : 'd M Y' ?>
                                                            <div class="ShortAuctionDataLabel">Auction Start:</div>
                                                            <div
                                                                class="ShortAuctionDataValue"><?= date($dateFormat, strtotime($getAuction['date_start'])) ?></div>
                                                            <div class="ShortAuctionDataLabel">Auction End:</div>
                                                            <?php
                                                            if ($subtopic == 'currentcharactertrades') {
                                                                $dateTimer = date('Y-m-d', strtotime($getAuction['date_end']));
                                                                if ($showCounter ?? (date('Y-m-d', strtotime($dateTimer . ' - 1 days')) == date('Y-m-d'))) { ?>
                                                                    <script>
                                                                        const countDownDate = new Date("<?= date($dateFormat, strtotime($getAuction['date_end'])) ?>").getTime();
                                                                        const x = setInterval(function () {
                                                                            const now = new Date().getTime();
                                                                            const distance = countDownDate - now;

                                                                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                                            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                                            document.getElementById("timeAuction").innerHTML = "in " + days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                                                                            document.getElementById("timeAuction").style.color = 'red';

                                                                            if (distance < 0) {
                                                                                clearInterval(x);
                                                                                document.getElementById("timeAuction").innerHTML = "Finished";
                                                                            }
                                                                        }, 1000);
                                                                    </script>
                                                            <?php } ?>
                                                                <div id="timeAuction" class="ShortAuctionDataValue">
                                                                    <?= date($dateFormat, strtotime($getAuction['date_end'])) ?>
                                                                </div>
                                                                <div class="ShortAuctionDataBidRow">
                                                                    <div class="ShortAuctionDataLabel">Current Bid:
                                                                    </div>
                                                                    <div class="ShortAuctionDataValue">
                                                                        <b><?= number_format($getAuction['price'], 0, ',', ',') ?></b>
                                                                        <img
                                                                            src="<?= $template_path; ?>/images/account/icon-tibiacointrusted.png"
                                                                            class="VSCCoinImages"
                                                                            title="Transferable Tibia Coins">
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="ShortAuctionDataValue">
                                                                    <?= date($dateFormat, strtotime($getAuction['date_end'])) ?></div>
                                                                <div class="ShortAuctionDataBidRow">
                                                                    <div class="ShortAuctionDataLabel">Winning Bid:
                                                                    </div>
                                                                    <div class="ShortAuctionDataValue">
                                                                        <b><?= number_format($getAuction['bid_price'], 0, ',', ',') ?></b>
                                                                        <img
                                                                            src="<?= $template_path; ?>/images/account/icon-tibiacointrusted.png"
                                                                            class="VSCCoinImages"
                                                                            title="Transferable Tibia Coins"></div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($logged && isset($getAuctionBid['account_id']) && $account_logged == $getAuctionBid['account_id']) { ?>
                                                                <div class="ShortAuctionDataBidRow"
                                                                     style="background-color: #d4c0a1; padding: 5px; border: 1px solid #f0e8da; box-shadow: 2px 2px 5px 0 rgb(0 0 0 / 50%);">
                                                                    <div class="ShortAuctionDataLabel">My Bid:</div>
                                                                    <div
                                                                        class="ShortAuctionDataValue"><?= $My_Bid ?></div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if ($logged && $getAuction['status'] == 0) { ?>
                                                            <?php if (strtotime($End) > strtotime($Hoje) && $account_logged != $getAuction['account_old']) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel">My Bid Limit
                                                                        </div>
                                                                        <form
                                                                            action="?subtopic=currentcharactertrades&action=bid"
                                                                            method="POST">
                                                                            <input type="hidden" name="auction_iden"
                                                                                   value="<?= $getAuction['id'] ?>">
                                                                            <input class="MyMaxBidInput" type="text"
                                                                                   name="maxbid">
                                                                            <div class="BigButton"
                                                                                 style="background-image:url(<?= $template_path; ?>/images/global/buttons/sbutton_green.gif)">
                                                                                <div
                                                                                    onmouseover="MouseOverBigButton(this);"
                                                                                    onmouseout="MouseOutBigButton(this);">
                                                                                    <div class="BigButtonOver"
                                                                                         style="background-image: url(<?= $template_path; ?>/images/global/buttons/sbutton_green_over.gif); visibility: hidden;"></div>
                                                                                    <input name="auction_confirm"
                                                                                           class="BigButtonText"
                                                                                           type="submit"
                                                                                           value="Bid On Auction">
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (strtotime($End) > strtotime($Hoje) && $account_logged == $getAuction['account_old']) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel"
                                                                             style="font-weight: normal;">My auction.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (strtotime($End) < strtotime($Hoje) && (
                                                                    ($account_logged == $getAuction['account_old'] && $account_logged != $getAuction['bid_account']) ||
                                                                    ($account_logged != $getAuction['account_old'] && $account_logged == $getAuction['bid_account'])
                                                                )) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel"
                                                                             style="font-weight: bold; color: green;">
                                                                            <form method="post"
                                                                                  action="?subtopic=currentcharactertrades&action=finish">
                                                                                <input type="hidden"
                                                                                       name="auction_iden"
                                                                                       value="<?= $getAuction['id'] ?>">
                                                                                <div class="BigButton"
                                                                                     style="background-image:url(<?= $template_path; ?>/images/global/buttons/sbutton_green.gif)">
                                                                                    <div
                                                                                        onmouseover="MouseOverBigButton(this);"
                                                                                        onmouseout="MouseOutBigButton(this);">
                                                                                        <div class="BigButtonOver"
                                                                                             style="background-image: url(<?= $template_path; ?>/images/global/buttons/sbutton_green_over.gif); visibility: hidden;"></div>
                                                                                        <input name="auction_finish"
                                                                                               class="BigButtonText"
                                                                                               type="submit"
                                                                                               value="Finish Auction">
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (strtotime($End) < strtotime($Hoje) && $account_logged != $getAuction['account_old'] && $account_logged != $getAuction['bid_account']) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel"
                                                                             style="font-weight: bold; color: green;">
                                                                            finished
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php if (!$logged) { ?>
                                                            <?php if ($getAuction['status'] == 0) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel"
                                                                             style="font-weight: normal;">Please
                                                                            first login.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($getAuction['status'] == 1) { ?>
                                                                <div class="AuctionBodyBlock CurrentBid">
                                                                    <div class="Container">
                                                                        <div class="MyMaxBidLabel"
                                                                             style="font-weight: normal;">finished
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <div class="AuctionBodyBlock SpecialCharacterFeatures">
                                                            <div class="Entry">
                                                                <img class="CharacterFeatureCategory"
                                                                     src="<?= $template_path; ?>/images/charactertrade/usp-category-3.png">Blessings
                                                                active: <?= $BlessCount ?>/7, Twist of Fate
                                                                active: <?= $BlessTwist ?>
                                                            </div>
                                                            <div class="Entry">
                                                                <img class="CharacterFeatureCategory"
                                                                     src="<?= $template_path; ?>/images/charactertrade/usp-category-7.png">Total
                                                                Charm Points <?= $Charm_Points ?>, Unused
                                                                Charm Points: <?= $Charm_UsedPoints ?>
                                                            </div>
                                                            <div class="Entry">
                                                                <img class="CharacterFeatureCategory"
                                                                     src="<?= $template_path; ?>/images/charactertrade/usp-category-0.png">10
                                                                Distance Fighting (Loyalty bonus not included)
                                                            </div>
                                                            <div class="Entry">
                                                                <img class="CharacterFeatureCategory"
                                                                     src="<?= $template_path; ?>/images/charactertrade/usp-category-0.png">10
                                                                Shielding (Loyalty bonus not included)
                                                            </div>

                                                        </div>
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
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<br>
<center>
<div class="BigButton" style="background-image:url(templates/tibiacom/images/global/buttons/sbutton.gif)">
    <div class="BigButtonOver" style="background-image: url(templates/tibiacom/images/global/buttons/sbutton_over.gif); visibility: hidden;"></div>
    <a href="?subtopic=currentcharactertrades">
        <input name="auction_confirm" class="BigButtonText" type="button" value="Back">
    </a>
</div>
</center>
<br>

<div class="SmallBox" id="StickyNavigation"> <div class="MessageContainer"> <div class="BoxFrameHorizontal" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-horizontal.gif);"></div> <div class="BoxFrameEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></div> <div class="BoxFrameEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></div> <div class="Message"> <div class="BoxFrameVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></div> <div class="BoxFrameVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></div><div class="NavigationBarContainer"><div class="NavigationBarLinkList"><nobr>[<a onclick="ScrollToAnchor('Auction Details');">Auction Details</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('General');">General</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Item Summary');">Item Summary</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Store Item Summary');">Store Item Summary</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Mounts');">Mounts</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Store Mounts');">Store Mounts</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Outfits');">Outfits</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Store Outfits');">Store Outfits</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Familiars');">Familiars</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Blessings');">Blessings</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Imbuements');">Imbuements</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Charms');">Charms</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Completed Cyclopedia Map Areas');">Completed Cyclopedia Map Areas</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Completed Quest Lines');">Completed Quest Lines</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Titles');">Titles</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Achievements');">Achievements</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Bestiary Progress');">Bestiary Progress</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Bosstiary Progress');">Bosstiary Progress</a>]</nobr> <nobr>[<a onclick="ScrollToAnchor('Revealed Gems');">Revealed Gems</a>]</nobr> </div></div> </div> <div class="BoxFrameHorizontal" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-horizontal.gif);"></div> <div class="BoxFrameEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></div> <div class="BoxFrameEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></div> </div></div>
<br>
<div class="TopButtonContainer">
    <div class="TopButton" style="">
        <a href="#top">
            <img style="border:0px;" src="<?= $template_path; ?>/images/content/back-to-top.gif">
        </a>
    </div>
</div>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <div class="Text">General</div>
            <span class="CaptionVerticalRight"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <span class="CaptionBorderBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionEdgeLeftBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
        </div>
    </div>
    <table class="Table5" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <table style="width: 100%;" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td style="vertical-align:top;210px;">
                                            <div class="TableContentContainer">
                                                <table class="TableContent" style="border:1px solid #faf0d7;"
                                                       width="100%">
                                                    <tbody>
                                                    <tr class="Even">
                                                        <td><span class="LabelV">Health:</span>
                                                            <div
                                                                style="float:right; text-align: right;"><?= $character['healthmax'] ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td><span class="LabelV">Mana:</span>
                                                            <div
                                                                style="float:right; text-align: right;"><?= $character['manamax'] ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td><span class="LabelV">Capacity:</span>
                                                            <div
                                                                style="float:right; text-align: right;"><?= $character['cap'] ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td><span class="LabelV">Speed:</span>
                                                            <div
                                                                style="float:right; text-align: right;"><?= $character['level'] + 109 ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td><span class="LabelV">Blessings:</span>
                                                            <div
                                                                style="float:right; text-align: right;"><?= $BlessCount?>/7
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td><span class="LabelV">Mounts:</span>
                                                            <div style="float:right; text-align: right;">0</div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td><span class="LabelV">Outfits:</span>
                                                            <div style="float:right; text-align: right;"><?= count($getOutfits) ?></div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td><span class="LabelV">Titles:</span>
                                                            <div style="float:right; text-align: right;">-</div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="TableContentContainer">
                                                <table class="TableContent" style="border:1px solid #faf0d7;"
                                                       width="100%">
                                                    <tbody>
                                                    <tr class="Even">
                                                        <td class="LabelColumn"><b>Axe Fighting</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_axe'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_axe_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_axe_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td class="LabelColumn"><b>Club Fighting</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_club'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_club_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_club_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td class="LabelColumn"><b>Distance Fighting</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_dist'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_dist_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_dist_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td class="LabelColumn"><b>Fishing</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_fishing'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_fishing_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_fishing_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td class="LabelColumn"><b>Fist Fighting</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_fist'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_fist_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_fist_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td class="LabelColumn"><b>Magic Level</b></td>
                                                        <td class="LevelColumn"><?= $character['maglevel'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= OTS_Player::getMagicLevelPercent($character) ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer">
                                                                <span class="PercentageString">
                                                                    <?= OTS_Player::getMagicLevelPercent($character) ?> %
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td class="LabelColumn"><b>Shielding</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_shielding'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_shielding_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_shielding_tries'] ?> %</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="Odd">
                                                        <td class="LabelColumn"><b>Sword Fighting</b></td>
                                                        <td class="LevelColumn"><?= $character['skill_sword'] ?></td>
                                                        <td class="PercentageColumn">
                                                            <div id="SkillBar" class="PercentageBar"
                                                                 style="width: <?= $character['skill_sword_tries'] ?>%">
                                                                <div class="PercentageBarSpacer"></div>
                                                            </div>
                                                            <div class="PercentageStringContainer"><span
                                                                    class="PercentageString"><?= $character['skill_sword_tries'] ?> %</span>
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
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Even">
                                            <td><span class="LabelV">Creation Date:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= date('d M Y, H:i:s', $character['created']) ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Experience:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= number_format($character['experience'], 0, ',', ',') ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td><span class="LabelV">Gold:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['balance'] ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Achievements:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?=$achievementPoints?></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Charm Expansion:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $Charm_Expansion ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td><span class="LabelV">Available Charm Points:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $Charm_Points ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Spent Charm Points:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $Charm_Points ?></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Even">
                                            <td><span class="LabelV">Daily Reward Streak:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $getDailyStreak?></div>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Hunting Task Points:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['task_points']?></div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td><span class="LabelV">Permanent Hunting Task Slots:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $thirdTaskSlot?></div>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Permanent Prey Slots:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $thirdRerollSlot?></div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td><span class="LabelV">Prey Wildcards:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['prey_wildcard'] ?></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Hirelings:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $getHireling ?></div>
                                            </td>
                                        </tr>
                                        <tr class="Even">
                                            <td><span class="LabelV">Hireling Jobs:</span>
                                                <div
                                                    style="float:right; text-align: right;">-</div>
                                            </td>
                                        </tr>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Hireling Outfits:</span>
                                                <div
                                                    style="float:right; text-align: right;">-</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Exalted Dust:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['forge_dusts']?>/<?=$character['forge_dust_level'] ?></div>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Even">
                                            <td><span class="LabelV">Boss Points:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['boss_points']?></div>
                                            </td>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Odd">
                                            <td><span class="LabelV">Bonus Promotion Points:</span>
                                                <div
                                                    style="float:right; text-align: right;"><?= $character['boss_points']?></div>
                                            </td>
                                        </tbody>
                                    </table>
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
</div>
<br>
<div class="TopButtonContainer">
    <div class="TopButton" style="">
        <a href="#top">
            <img style="border:0px;" src="<?= $template_path; ?>/images/content/back-to-top.gif">
        </a>
    </div>
</div>

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <div class="Text">Item Summary</div>
            <span class="CaptionVerticalRight"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <span class="CaptionBorderBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionEdgeLeftBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
        </div>
    </div>
    <table class="Table3" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Even tmp-container-ItemSummary">
                                            <td>
                                            <div id="ajax-target-type-0" class="paged-container page-object-container">
                                                <div class="BlockPage BlockPageObject">
                                                    <?php
                                                    if ($characterItems) {
                                                        $itemTotals = array();

                                                        foreach ($characterItems as $characterItem) {
                                                            if (array_key_exists($characterItem['itemtype'], $itemTotals)) {
                                                                $itemTotals[$characterItem['itemtype']] += $characterItem['count'];
                                                            } else {
                                                                $itemTotals[$characterItem['itemtype']] = $characterItem['count'];
                                                            }
                                                        }

                                                        foreach ($itemTotals as $itemType => $itemCount) {
                                                            ?>
                                                            <div class="CVIcon CVIconObject">
                                                                <img src="https://static.tibia.com/images/charactertrade/objects/<?= $itemType ?>.gif">
                                                                <div class="ObjectAmount"><?= $itemCount ?></div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                                    <?php if (!$getDepotItems || count($getDepotItems) == 0) { ?>
                                                        <div style="text-align: center;">No items.</div>
                                                    <?php } ?>
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
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<br>

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <div class="Text">Store Item Summary</div>
            <span class="CaptionVerticalRight"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
            <span class="CaptionBorderBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
            <span class="CaptionEdgeLeftBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightBottom"
                  style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
        </div>
    </div>
    <table class="Table3" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                        <tbody>
                                        <tr class="Even tmp-container-ItemSummary">
                                            <td>
                                            <div id="ajax-target-type-0" class="paged-container page-object-container">
                                                <div class="BlockPage BlockPageObject">
                                                    <?php if ($inboxItems) {
                                                        $itemTotals = array();
                                                        foreach ($inboxItems as $inboxItem) { ?>
                                                            <?php

                                                            $itemType = $inboxItem['itemtype'];
                                                            $itemCount = $inboxItem['count'];

                                                            if (array_key_exists($itemType, $itemTotals)) {
                                                                $itemTotals[$itemType] += $itemCount;
                                                            } else {
                                                                $itemTotals[$itemType] = $itemCount;
                                                            }
                                                            ?>
                                                        <?php }

                                                        foreach ($itemTotals as $itemType => $totalCount) { ?>
                                                            <div class="CVIcon CVIconObject">
                                                                <img src="https://static.tibia.com/images/charactertrade/objects/<?= $itemType ?>.gif">
                                                                <div class="ObjectAmount"><?= $totalCount ?></div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>

                                                <?php if (!$inboxItems || count($inboxItems) == 0) { ?>
                                                    <div style="text-align: center;">No items.</div>
                                                <?php } ?>
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
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<br>

<div class="CharacterDetailsBlock" id="StoreMounts">
  <a name="Store Mounts"></a>
  <div class="TopButtonContainer">
    <a name="Store Mounts"></a>
    <div class="TopButton">
      <a name="Store Mounts"></a>
      <a onclick="ScrollToAnchor('top');">
        <img style="border: 0px;" src="https://static.tibia.com/images/global/content/back-to-top.gif">
      </a>
    </div>
  </div>
  <div class="TableContainer">
    <div class="CaptionContainer">
      <div class="CaptionInnerContainer">
        <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
        <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
        <div class="Text">Store Mounts</div>
        <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
        <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
        <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
      </div>
    </div>
    <table class="Table3" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td>
            <div class="TableScrollbarWrapper" style="width: unset;">
              <div class="TableScrollbarContainer"></div>
            </div>
            <div class="InnerTableContainer" style="max-width: unset;">
              <table style="width:100%;">
                <tbody>
                  <tr>
                    <td>
                      <div class="TableContentContainer">
                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                          <tbody>
                            <tr class="Odd tmp-container-StoreMounts">
                              <td>
                                <div id="ajax-target-type-3" class="paged-container page-object-container">
                                  <div class="BlockPage">
                                    <?php foreach($store_mounts as $mounts){?>
                                        <div class="CVIcon">
                                        <img src="https://static.tibia.com/images/charactertrade/mounts/<?=$mounts?>.gif">
                                        </div>
                                    <?php }?>
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
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<br>

<div class="CharacterDetailsBlock" id="Familiars">
  <a name="Familiars"></a>
  <div class="TopButtonContainer">
    <a name="Familiars"></a>
    <div class="TopButton">
      <a name="Familiars"></a>
      <a onclick="ScrollToAnchor('top');">
        <img style="border: 0px;" src="https://static.tibia.com/images/global/content/back-to-top.gif">
      </a>
    </div>
  </div>
  <div class="TableContainer">
    <div class="CaptionContainer">
      <div class="CaptionInnerContainer">
        <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
        <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
        <div class="Text">Familiars</div>
        <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
        <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
        <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
      </div>
    </div>
    <table class="Table3" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td>
            <div class="TableScrollbarWrapper" style="width: unset;">
              <div class="TableScrollbarContainer"></div>
            </div>
            <div class="InnerTableContainer" style="max-width: unset;">
              <table style="width:100%;">
                <tbody>
                  <tr>
                    <td>
                      <div class="TableContentContainer">
                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                          <tbody>
                            <tr class="Odd tmp-container-Familiars">
                              <td>
                                <div id="ajax-target-type-6" class="paged-container page-object-container">
                                  <div class="BlockPage">
                                        <?php
                                        foreach ($getFamiliars as $familiars) {
                                        ?>
                                            <div class="CVIcon">
                                                <img src="https://static.tibia.com/images/charactertrade/summons/<?= undoLeftShiftBytes($familiars['value']) ?>.gif">
                                            </div>
                                        <?php
                                        }
                                        ?>
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
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="CharacterDetailsBlock " id="Charms"><a name="Charms"></a>
    <div class="TopButtonContainer"><a name="Charms"></a>
        <div class="TopButton"><a name="Charms"></a><a onclick="ScrollToAnchor('top');">
                <img style="border: 0px;" src="<?= $template_path; ?>/images/global/content/back-to-top.gif"></a>
        </div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop"
                          style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
                <div class="Text">Charms</div>
                <span class="CaptionVerticalRight"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            </div>
        </div>
        <?php
        $Charm_CountRunes = 0;
        $charmNames = ['wound', 'enflame', 'poison', 'freeze', 'zap', 'curse', 'cripple', 'parry', 'dodge', 'adrenaline', 'numb', 'cleanse', 'bless', 'scavenge', 'gut', 'low_blow', 'divine', 'vamp', 'void'];
        $runes = [];
        foreach ($charmNames as $charm) {
            if (!$getCharm || $charm < 1) {
                $runes["rune_$charm"] = '<img src="' . $template_path . '/images/premiumfeatures/icon_no.png">';
                continue;
            }
            $Charm_CountRunes++;
            $runes["rune_$charm"] = '<img src="' . $template_path . '/images/premiumfeatures/icon_yes.png">';
        }
        ?>
        <table class="Table3" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                            <tbody>
                                            <?php foreach ($charmNames as $k => $charm) { ?>
                                                <tr class="<?= $k % 2 == 0 ? 'Even' : 'Odd' ?>">
                                                    <td>
                                                        <?= $runes["rune_$charm"] ?>
                                                        Rune <?= ucwords(str_replace('_', ' ', $charm)) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
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
    </div>
</div>
<br>
<div class="CharacterDetailsBlock " id="CompletedQuestLines"><a name="Completed Quest Lines"></a>
    <div class="TopButtonContainer"><a name="Completed Quest Lines"></a>
        <div class="TopButton"><a name="Completed Quest Lines"></a><a onclick="ScrollToAnchor('top');"><img
                    style="border: 0px;" src="<?= $template_path; ?>/images/global/content/back-to-top.gif"></a>
        </div>
    </div>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer"><span class="CaptionEdgeLeftTop"
                                                     style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
                <div class="Text">Completed Quest Lines</div>
                <span class="CaptionVerticalRight"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom"
                      style="background-image:url(<?= $template_path; ?>/images/global/content/box-frame-edge.gif);"></span>
            </div>
        </div>
        <table class="Table3" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                            <tbody>
                                            <tr class="LabelH">
                                                <td>Quest Line Name</td>
                                            </tr>
                                            <?php
                                            $i_bg = 0;
                                            foreach ($quests as $quest_name => $quest_storage) {
                                                $i_bg = $i_bg + 1;
                                                ?>
                                                <tr bgcolor="<?= getStyle($i_bg) ?>">
                                                    <td> <?= $quest_name; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
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
    </div>
</div>
<!-- END PAGE DETAILS -->

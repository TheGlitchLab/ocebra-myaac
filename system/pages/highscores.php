<?php
/**
 * Highscores
 *
 * @package   MyAAC
 * @author    Gesior <jerzyskalski@wp.pl>
 * @author    Slawkens <slawkens@gmail.com>
 * @author    OpenTibiaBR
 * @copyright 2023 MyAAC
 * @link      https://github.com/opentibiabr/myaac
 */

defined('MYAAC') or die('Direct access not allowed!');
$title = 'Highscores';

if($config['account_country'] && $config['highscores_country_box'])
	require SYSTEM . 'countries.conf.php';

$list = $_GET['list'] ?? '';
$_page = $_GET['page'] ?? 0;
$vocation = $_GET['vocation'] ?? null;

if (!is_numeric($_page) || $_page < 0 || $_page > PHP_INT_MAX) {
    $_page = 1;
}

$add_sql = '';
$config_vocations = $config['vocations'];
if($config['highscores_vocation_box'] && isset($vocation))
{
	foreach($config['vocations'] as $id => $name) {
		if(strtolower($name) == $vocation) {
			$add_vocs = array($id);

			$i = $id + $config['vocations_amount'];
			while(isset($config['vocations'][$i])) {
				$add_vocs[] = $i;
				$i += $config['vocations_amount'];
			}

			$add_sql = 'AND `vocation` IN (' . implode(', ', $add_vocs) . ')';
			break;
		}
	}
}

define('SKILL_FRAGS', -1);
define('SKILL_BOSS', -2);
define('SKILL_BALANCE', -3);
define('SKILL_ACHIEVEMENT', -4);
define('SKILL_CHARM', -5);

$skill = POT::SKILL__LEVEL;
$skillMap = [
  'fist' => POT::SKILL_FIST,
  'club' => POT::SKILL_CLUB,
  'sword' => POT::SKILL_SWORD,
  'axe' => POT::SKILL_AXE,
  'distance' => POT::SKILL_DIST,
  'shield' => POT::SKILL_SHIELD,
  'fishing' => POT::SKILL_FISH,
  'level' => POT::SKILL_LEVEL,
  'experience' => POT::SKILL_LEVEL,
  'magic' => POT::SKILL__MAGLEVEL,
  'boss' => SKILL_BOSS,
  'charm' => SKILL_CHARM,
  'achievement' => SKILL_ACHIEVEMENT,
];

if (is_numeric($list)) {
  $list = (int) $list;
  if ($list >= POT::SKILL_FIRST && $list <= POT::SKILL__LAST) {
      $skill = $list;
  }
} else {
  if (array_key_exists($list, $skillMap)) {
      $skill = $skillMap[$list];
  } elseif ($list === 'balance' && $config['highscores_balance']) {
      $skill = SKILL_BALANCE;
  } elseif ($list === 'frags' && $config['highscores_frags'] && $config['otserv_version'] == TFS_03) {
      $skill = SKILL_FRAGS;
  }
}

$promotion = '';
if($db->hasColumn('players', 'promotion'))
	$promotion = ',promotion';

$online = '';
if($db->hasColumn('players', 'online'))
	$online = ',online';

$deleted = 'deleted';
if($db->hasColumn('players', 'deletion'))
	$deleted = 'deletion';

$outfit_addons = false;
$outfit = '';
if($config['highscores_outfit']) {
	$outfit = ', lookbody, lookfeet, lookhead, looklegs, looktype';
	if($db->hasColumn('players', 'lookaddons')) {
		$outfit .= ', lookaddons';
		$outfit_addons = true;
	}
}

$offset = max(0, ($_page - 1) * $config['highscores_length']);
if($skill >= POT::SKILL_FIRST && $skill <= POT::SKILL_LAST) { // skills
	if($db->hasColumn('players', 'skill_fist')) {// tfs 1.0
		$skill_ids = array(
			POT::SKILL_FIST => 'skill_fist',
			POT::SKILL_CLUB => 'skill_club',
			POT::SKILL_SWORD => 'skill_sword',
			POT::SKILL_AXE => 'skill_axe',
			POT::SKILL_DIST => 'skill_dist',
			POT::SKILL_SHIELD => 'skill_shielding',
			POT::SKILL_FISH => 'skill_fishing',
		);
    $skills = $db->query('SELECT accounts.country, players.id, players.name' . $online . ', level, vocation' . $promotion . $outfit . ', ' . $skill_ids[$skill] . ' as value FROM accounts, players WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY ' . $skill_ids[$skill] . ' DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();
	}
	else
		$skills = $db->query('SELECT accounts.country, players.id,players.name' . $online . ',value,level,vocation' . $promotion . $outfit . ' FROM accounts,players,player_skills WHERE players.id NOT IN (' . implode(', ', $config['highscores_ids_hidden']) . ') AND players.' . $deleted . ' = 0 AND players.group_id < '.$config['highscores_groups_hidden'].' '.$add_sql.' AND players.id = player_skills.player_id AND player_skills.skillid = '.$skill.' AND accounts.id = players.account_id ORDER BY value DESC, count DESC LIMIT 101 OFFSET '.$offset)->fetchAll();
}
else if($skill == SKILL_BOSS) // boss points
{
  $skills = $db->query('SELECT accounts.country, players.id, players.name' . $online . ', level, boss_points as value, vocation' . $promotion . $outfit . ' FROM accounts, players WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY value DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();
}
else if($skill == SKILL_CHARM) // charm points
{
  $skills = $db->query('SELECT accounts.country, players.id, players.name, player_charms.charm_points as value' . $online . ', level, vocation' . $promotion . $outfit . ' FROM accounts, players, player_charms WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND players.id = player_charms.player_guid AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY value DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();}
else if($skill == SKILL_BALANCE) // balance
{
  $skills = $db->query('SELECT accounts.country, players.id, players.name' . $online . ', level, balance as value, vocation' . $promotion . $outfit . ' FROM accounts, players WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY value DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();}
else if ($skill == SKILL_ACHIEVEMENT) {
  $skills = $db->query('SELECT accounts.country, players.id, players.name' . $online . ', level, vocation' . $promotion . $outfit . ' FROM accounts, players WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY players.level DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();
    require_once BASE . '/tools/achievements.php';

    foreach ($skills as &$player_temp) {
        $achievementPoints = 0;
        $player_temp['achievement'] = 0;

        foreach ($achievements as $achievement => $value) {
            $achievementStorage = $config['achievements_base'] + $achievement;
            $searchAchievementsbyStorage = $db->query('SELECT `key`, `value` FROM `player_storage` WHERE `key` = ' . $achievementStorage . ' AND `player_id` = ' . $player_temp['id'] . '');
            $achievementsPlayer = $searchAchievementsbyStorage->fetch();

            if ($achievementsPlayer && $achievementsPlayer['key'] == $achievementStorage) {
                $achievementPoints += $value['points'];
            }
        }

        $player_temp['achievement'] = $achievementPoints;

        $allSkills[] = $player_temp;
    }

    usort($allSkills, function ($a, $b) {
        return $b['achievement'] - $a['achievement'];
    });

    $skills = $allSkills;
}
else
{
  if($skill == POT::SKILL__MAGLEVEL) {
    $skills = $db->query(
      'SELECT 
          accounts.country, 
          players.id, 
          players.name' . $online . ', 
          maglevel, 
          level, 
          vocation' . $promotion . $outfit . ' 
      FROM 
          accounts, 
          players 
      WHERE 
          players.' . $deleted . ' = 0 
          ' . $add_sql . ' 
          AND accounts.id = players.account_id 
          AND accounts.id != ' . $config['highscores_account_id'] . ' 
      ORDER BY 
          maglevel DESC, 
          manaspent DESC 
      LIMIT 101 
      OFFSET ' . $offset
    )->fetchAll();
  }
	else { // level
    $skills = $db->query('SELECT accounts.country, players.id, players.name' . $online . ', level, experience, vocation' . $promotion . $outfit . ' FROM accounts, players WHERE players.' . $deleted . ' = 0 ' . $add_sql . ' AND accounts.id = players.account_id AND accounts.id != ' . $config['highscores_account_id'] . ' ORDER BY level DESC, experience DESC LIMIT 101 OFFSET ' . $offset)->fetchAll();		// $skills = $db->query('SELECT accounts.country, players.id,players.name' . $online . ',level,experience,vocation' . $promotion . $outfit . ' FROM accounts, players WHERE players.id NOT IN (' . implode(', ', $config['highscores_ids_hidden']) . ') AND players.' . $deleted . ' = 0 '.$add_sql.' AND players.group_id < '.$config['highscores_groups_hidden'].' AND accounts.id = players.account_id ORDER BY level DESC, experience DESC LIMIT 101 OFFSET '.$offset)->fetchAll();
		$list = 'experience';
	}
}

$rank_category = isset($_POST['category']) ? $_POST['category'] : null;
$rank_vocation = isset($_POST['profession']) ? $_POST['profession'] : null;

?>

<div class="TableContainer">
  <div class="CaptionContainer">
    <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
      <div class="Text">Highscores Filter</div>
      <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> </div>
  </div>
  <table class="Table1" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td><div class="InnerTableContainer">
            <table style="width:100%;">
              <tbody>
				<form method="post" action="">
                <?php if ($config['multiworld']): ?>
				<tr>
                  <td>World:</td>
                  <td><select name="world">
                      <option value="0" selected>All Worlds</option>
                    </select></td>
				</tr>
                <?php endif; ?>
                <tr>
                  <td>Vocation:</td>
                  <td><select name="profession">
                      <option value="all">(all)</option>
                      <option value="knight" <?php echo $vocation == "knight" ? 'selected': ''?>>Knight</option>
                      <option value="paladin" <?php echo $vocation == "paladin" ? 'selected': ''?>>Paladin</option>
                      <option value="sorcerer" <?php echo $vocation == "sorcerer" ? 'selected': ''?>>Sorcerer</option>
                      <option value="druid" <?php echo $vocation == "druid" ? 'selected': ''?>>Druid</option>
                    </select>
                    </td>
                    <td style="text-align: right;"><div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div><input class="BigButtonText" type="submit" value="Submit"></div>
                </div></td>
				</tr>
				<tr>
                  <td>Category:</td>
                  <td><select name="category">
                      <option value="achievement"<?php echo $list == "achievement" ? 'selected': ''?>>Achievements</option>
                      <option value="boss"<?php echo $list == "boss" ? 'selected': ''?>>Boss Points</option>
                      <option value="charm"<?php echo $list == "charm" ? 'selected': ''?>>Charm Points</option>
                      <?php if ($config['characters']['balance']):?>
                        <option value="balance" <?php echo $list == "balance" ? 'selected': ''?>>Balance</option>
                      <?php endif; ?>
                      <option value="axe" <?php echo $list == "axe" ? ' selected' : ''?>>Axe Fighting</option>
                      <option value="club" <?php echo $list == "club" ? ' selected' : ''?>>Club Fighting</option>
                      <option value="distance" <?php echo $list == "distance" ? ' selected' : ''?>>Distance Fighting</option>
                      <option value="experience" <?php echo $list == "experience" ? ' selected' : ''?>>Experience Points</option>
                      <option value="fishing" <?php echo $list == "fishing" ? ' selected' : ''?>>Fishing</option>
                      <option value="fist" <?php echo $list == "fist" ? ' selected' : ''?>>Fist Fighting</option>
                      <option value="magic" <?php echo $list == "magic" ? ' selected' : ''?>>Magic Level</option>
                      <option value="shield" <?php echo $list == "shield" ? ' selected' : ''?>>Shielding</option>
                      <option value="sword" <?php echo $list == "sword" ? ' selected' : ''?>>Sword Fighting</option>
                    </select></td>
                </tr>
				</form>
              </tbody>
            </table>
          </div></td>
      </tr>
    </tbody>
  </table>
</div>

<?php

if (isset($config['multiword'])) {
    $rank_world = $_POST['world'];
  }

  if (empty($rank_vocation)) {
    if (isset($rank_category)) {
      header('Location: ?highscores/' . $rank_category . '');
    }
  } else {
    if (isset($rank_category)) {
      header('Location: ?highscores/' . $rank_category . '/' . $rank_vocation . '');
    }
  }

?>

<?php

$pages = 1;
$i = 0;

$online_exist = false;
if($db->hasColumn('players', 'online'))
	$online_exist = true;

$players = array();
foreach($skills as $player) {
	$players[] = $player['id'];
}

if($db->hasTable('players_online') && count($players) > 0) {
	$query = $db->query('SELECT `player_id`, 1 FROM `players_online` WHERE `player_id` IN (' . implode(', ', $players) . ')')->fetchAll();
	foreach($query as $t) {
		$is_online[$t['player_id']] = true;
	}
}

if ($db->hasTable('myaac_charbazaar')) {
    $query = $db->query('SELECT `player_id` FROM `myaac_charbazaar` WHERE `player_id` IN (' . implode(', ', $players) . ')')->fetchAll();

    foreach ($query as $result) {
        $playerIdFromQuery = $result['player_id'];

        $key = array_search($playerIdFromQuery, array_column($skills, 'id'));
        if ($key !== false) {
            $skills[$key]['charbazar'] = true;
        }
    }
}

$number_of_players = count($players);
$pages = ($number_of_players <$config['highscores_length'] ? 1 : ceil($number_of_players / $config['highscores_length']));

?>

<p><i>Skills displayed in the Highscores do not include any bonuses (loyalty, equipment etc.).</i></p>

<div class="TableContainer">
  <div class="CaptionContainer">
    <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
      <div class="Text">Highscores
      <span class="RightArea">Last Update: Now</span>
      </div>
      <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> </div>
  </div>
  <table class="Table3" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td>
            <div class="InnerTableContainer">
            <table style="width:100%;">
              <tbody>
              <tr>
                <td class="PageNavigation">
                    <small>
                        <div style="float: left;"><b>» Pages:</b>
                        <?php
                        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $pagesArray = range(1, $pages);
                        foreach ($pagesArray as $page){
                        if ($page == $currentPage){
                            echo '<span class="PageLink"><span class="CurrentPageLink"><b>' . $page . '</b></span></span>';
                        }
                         else {
                            echo '<span class="PageLink"><a href="' . getLink('highscores') . '/' . $list . (isset($vocation) ? '/' . $vocation : '') . '/' . ($page) . '">' . $page . '</a></span>';
                        }
                        }
                        ?>
                        </div>
                        <div style="float: right;"><b>» Results: <?php echo $number_of_players ?></b></div>
                    </small>
                </td>
                </tr>
                <tr>
                  <td>
                    <div class="TableContentContainer">
                      <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                        <tbody>
                          <tr class="LabelH">
                            <td>Rank</td>
							<?php if($config['highscores_outfit']){ ?>
							<td style="width: 64px;">Outfit</td>
							<?php } ?>
                            <td style="width: 90%;">Name</td>
                            <td style="text-align:left;">Vocation</td>
                            <td style="text-align:left;">World</td>
                            <td style="text-align: left;">Level</td>
                            <td style="text-align: right;"><?php echo ($skill == SKILL_BALANCE ? 'Balance' : ($skill == SKILL_FRAGS ? 'Frags' : (($skill == POT::SKILL_FIST || $skill == POT::SKILL_CLUB || $skill == POT::SKILL_SWORD || $skill == POT::SKILL_AXE || $skill == POT::SKILL_DIST || $skill == POT::SKILL_SHIELD || $skill == POT::SKILL_FISH) ? 'Skill Level' : 'Points'))); ?></td>
                          </tr>
<?php
foreach($skills as $player)
{
    if(isset($is_online)) {
	    $player['online'] = (isset($is_online[$player['id']]) ? 1 : 0);
    } else {
        if(!isset($player['online'])) {
	        $player['online'] = 0;
        }
    }

	if(++$i <= $config['highscores_length'])
	{
		if($skill == POT::SKILL__MAGIC)
			$player['value'] = $player['maglevel'];
		else if($skill == POT::SKILL__LEVEL)
			$player['value'] = $player['level'];
        else if ($skill == SKILL_ACHIEVEMENT)
            $player['value'] = $player['achievement'];

        echo '
                    <tr bgcolor ='. getStyle($offset + $i) .'><td>' . ($offset + $i) . '</td>';
                    if($config['highscores_outfit'])
                    echo '<td><img style="position:absolute;margin-top:' . (in_array($player['looktype'], array(75, 266, 302)) ? '-15px;margin-left:5px' : '-45px;margin-left:-25px') . ';" src="' . $config['outfit_images_url'] . '?id=' . $player['looktype'] . ($outfit_addons ? '&addons=' . $player['lookaddons'] : '') . '&head=' . $player['lookhead'] . '&body=' . $player['lookbody'] . '&legs=' . $player['looklegs'] . '&feet=' . $player['lookfeet'] . '" alt="" /></td>';

                    echo '
                    <td>
                        <a href="' . getPlayerLink($player['name'], false) . '">
                            <span>' . $player['name'] . '</span>
                        </a>';

                        if (isset($player['charbazar']) && $player['charbazar'] === true) {
                            echo '<img src="/images/icons/hot.gif" alt="Auction">';
                        }

                    if ($config['highscores_vocation']) {
                        if (isset($player['promotion'])) {
                            if ((int)$player['promotion'] > 0) {
                                $player['vocation'] += ($player['promotion'] * $config['vocations_amount']);
                            }
                        }

                        $tmp = 'Unknown';
                        if (isset($config['vocations'][$player['vocation']])) {
                            $tmp = $config['vocations'][$player['vocation']];
                        }
                    }

        echo '
                    </td>
                    <td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . $tmp . '</td>
                    <td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . $config['lua']['serverName'] . '</td>
                    <td style="text-align:right;">' . $player['level'] . '</td>
                    <td>
                    <div style="text-align:right;">'. ($skill == POT::SKILL__LEVEL ? number_format($player['experience']) : $player['value']) . '</div></td>';
                echo '</tr>';
    }
}

if(!$i) {
	$extra = ($config['highscores_outfit'] ? 1 : 0);
?>
<tr bgcolor="<?php echo $config['darkborder'] ?>"><td colspan="<?php echo $skill == POT::SKILL__LEVEL ? 5 + $extra : 4 + $extra ?>">No records yet.</td></tr>
<?php } ?>


                        </tbody>
                      </table>
                    </div>
                 </td>
                </tr>
                <tr>
                <td class="PageNavigation">
                    <small>
                        <div style="float: left;"><b>» Pages: <span class="PageLink"><span class="CurrentPageLink">1</span></b></div>
                        <div style="float: right;"><b>» Results: <?php echo $number_of_players ?></b></div>
                    </small>
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

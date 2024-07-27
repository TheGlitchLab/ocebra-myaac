<?php

$title = 'Powergamers';

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

function FormatString($valuein)
{
    $value = '';

    $value2 = $valuein;
    while (strlen($value2) > 3) {
        $value .= '.' . substr($value2, -3, 3);
        $value2 = substr($value2, 0, strlen($value2) - 3);
    }
    $value = $value2 . $value;

    if($valuein > 0)
        return '<font color="green">+'.$value.'</font>';
    elseif($valuein < 0)
        return '<font color="red">'.$value.'</font>';
    else
        return '<font color="black">'.$value.'</font>';
}


function getVocation($number)
{
    $vocations = [
        0 => 'No Vocation',
        1 => 'Sorcerer',
        2 => 'Druid',
        3 => 'Paladin',
        4 => 'Knight',
        5 => 'Master Sorcerer',
        6 => 'Elder Druid',
        7 => 'Royal Paladin',
        8 => 'Elite Knight',
    ];

    return $vocations[$number] ?? 'No Vocation';
}

$user_choice = isset($_POST['range']) ? $_POST['range'] : 0;

switch ($user_choice) {
    case 0:
        $orderByColumn = 'players.experience - players.exphist_lastexp';
        break;
    case 1:
        $orderByColumn = 'players.exphist1';
        break;
    case 2:
        $orderByColumn = 'players.exphist1 + players.exphist2 + players.exphist3 + players.exphist4 + players.exphist5 + players.exphist6 + players.exphist7 + players.experience - players.exphist_lastexp';
        break;
    default:
        $orderByColumn = 'players.exphist1 + players.exphist2 + players.exphist3 + players.exphist4 + players.exphist5 + players.exphist6 + players.exphist7 + players.experience - players.exphist_lastexp';
        break;
}
?>


<div class="TableContainer">
    <div class="CaptionContainer">
    <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
      <div class="Text">Powergamers Filter</div>
        <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        </div>
        <form method="post" action="">
            <table class="Table1" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="InnerTableContainer">
                                <table style="width:100%;">
                                    <tbody>
                                            <tr>
                                                <td>Range:</td>
                                                <td>
                                                    <select name="range">
                                                        <option value="0" <?php echo $user_choice == 0 ? 'selected' : '' ?>>Today</option>
                                                        <option value="1" <?php echo $user_choice == 1 ? 'selected' : '' ?>>Yesterday</option>
                                                        <option value="2" <?php echo $user_choice == 2 ? 'selected' : '' ?>>7 Days</option>
                                                        <option value="3" <?php echo $user_choice == 3 ? 'selected' : '' ?>>Overall</option>
                                                    </select>
                                                </td>
                                                <td style="text-align: right;"><div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div><input class="BigButtonText" type="submit" value="Submit"></div>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </form>
        <table class="Table3" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="TableContentContainer">
                                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                    <tbody>
                                                        <tr class="LabelH">
                                                            <td>Rank</td>
                                                            <td style="width: 90%;">Name</td>
                                                            <td style="text-align:left;">Vocation</td>
                                                            <td style="text-align:left;">Level</td>
                                                            <?php if ($user_choice == 3) {
                                                             echo '<td style="text-align: left;">Today</td>';
                                                             echo '<td style="text-align: left;">1 Day Ago</td>';
                                                             echo '<td style="text-align: left;">2 Day Ago</td>';
                                                             echo '<td style="text-align: left;">3 Day Ago</td>';
                                                             echo '<td style="text-align: left;">4 Day Ago</td>';
                                                             echo '<td style="text-align: left;">5 Day Ago</td>';
                                                             echo '<td style="text-align: left;">6 Day Ago</td>';
                                                             echo '<td style="text-align: left;">7 Day Ago</td>';
                                                             echo '<td style="text-align: left;">Total</td>';
                                                            } else {
                                                             echo '<td style="text-align: left;">Daily EXP</td>';
                                                            }?>
                                                        </tr>
                                                        <?php
                                                        $limit = $config['powergaming_length'];
                                                        $players = $db->query('SELECT * FROM accounts, players WHERE players.deletion = 0 AND ' . $orderByColumn . ' <> 0 ' . $add_sql . ' AND accounts.id = players.account_id AND players.level > 8 AND accounts.id != ' . $config['powergaming_account_id'] . ' ORDER BY ' . $orderByColumn . ' DESC LIMIT ' . $limit)->fetchAll();
                                                        if (empty($players)){
                                                            echo '<tr><td colspan="13"> No records yet.</td></tr>';
                                                        } else {
                                                            foreach ($players as $player) {
                                                                echo '
                                                                <tr bgcolor="' . getStyle($number_of_rows + 1) . '"><td style="text-align:left">' . ($number_of_rows + 1) . '. </td>
                                                                <td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;"><a href="?subtopic=characters&name=' . urlencode($player['name']) . '"><b>' . htmlspecialchars($player['name']) . '</b></a></td>
                                                                <td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . getVocation($player['vocation']) . '</td>
                                                                <td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . $player['level'] . '</td>';
                                                            if ($user_choice == 0){
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['experience'] - $player['exphist_lastexp']). '</td>';
                                                            } elseif ($user_choice == 1 ){
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist1']) . '</td>';
                                                            } elseif ($user_choice == 2){
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist1'] + $player['exphist2'] + $player['exphist3'] + $player['exphist4'] + $player['exphist5'] + $player['exphist6'] + $player['exphist7'] + $player['experience'] - $player['exphist_lastexp']). '</td>';
                                                            } elseif ($user_choice == 3){
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['experience'] - $player['exphist_lastexp']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist1']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist2']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist3']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist4']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist5']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist6']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist7']). '</td>';
                                                                echo '<td style="text-align:left; overflow: hidden; white-space: nowrap; width: 100%;">' . FormatString($player['exphist1'] + $player['exphist2'] + $player['exphist3'] + $player['exphist4'] + $player['exphist5'] + $player['exphist6'] + $player['exphist7'] + $player['experience'] - $player['exphist_lastexp']). '</td>';
                                                            }
                                                                echo '</tr>';
                                                                $number_of_rows++;
                                                            }
                                                        }
                                                            ?>
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

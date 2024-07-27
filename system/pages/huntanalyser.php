<?php

defined('MYAAC') or die('Direct access not allowed!');
$title = 'Party Loot Analyzer';
?>


<div class="tooltip">
    <div class="tooltipimage">
        <span>Paste your party hunt session</span>
        <img class="tooltip_show" style="border: 0px;" src="https://static.tibia.com/images/global/content/info.gif">
    </div>
</div>

<div id="party-loot-wrapper" class="tool-wrapper" >
    <section>
     <h2>Input from Tibia's party hunt analyser</h2>
     <textarea id="party-loot-input" class="tool-input" style="width: 394px; height: 442px; resize: none;" autofocus="">Session data: From 2019-12-02, 15:00:18 to 2019-12-02, 15:56:19
Session: 00:56h
Loot Type: Market
Loot: 711,112
Supplies: 662,148
Balance: 48,964
Ell Em
	Loot: 349,363
	Supplies: 98,318
	Balance: 251,045
	Damage: 215,683
	Healing: 117,408
Mathias Bynens (Leader)
	Loot: 205,479
	Supplies: 123,737
	Balance: 81,742
	Damage: 885,460
	Healing: 332,423
Snol
	Loot: 86,795
	Supplies: 95,319
	Balance: -8,524
	Damage: 498,063
	Healing: 168,844
Sofsterella
	Loot: 46,904
	Supplies: 174,424
	Balance: -127,520
	Damage: 628,303
	Healing: 223
Xarsman
	Loot: 22,571
	Supplies: 170,350
	Balance: -147,779
	Damage: 564,848
	Healing: 104,877</textarea>
    </section>
    <section>
     <h2>Output</h2>
     <div id="party-loot-output" class="tool-output">
      <ul>
       <li data-copy="transfer 18316 to Snol" title="Click to copy bank NPC transfer text">Ell Em should pay <b>18,316 gp</b> to Snol.</li>
       <li data-copy="transfer 137312 to Sofsterella" title="Click to copy bank NPC transfer text">Ell Em should pay <b>137,312 gp</b> to Sofsterella.</li>
       <li data-copy="transfer 85625 to Xarsman" title="Click to copy bank NPC transfer text">Ell Em should pay <b>85,625 gp</b> to Xarsman.</li>
       <li data-copy="transfer 71946 to Xarsman" title="Click to copy bank NPC transfer text">Mathias Bynens should pay <b>71,946 gp</b> to Xarsman.</li>
       <li>Total balance: <b>48,964 gp</b></li><li>Number of people: <b>5</b></li>
       <li>Balance per person: <b>9,792 gp</b></li>
      </ul>
     </div>
    </section>
   </div>


<style>
    .tooltip_show{
        width: 16px;
        height: 16px;
    }

    .tool-wrapper{
        display: grid;
        grid-template-columns: 50% 40%;
        grid-gap: 1em;
    }

    .tool-output li[data-copy] {
    cursor: pointer
    }
</style>

<script type="text/javascript" src="templates/tibiacom/js/hunt_analyser.js"></script>

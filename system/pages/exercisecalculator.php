<?php $title = 'Exercise Calculator'; ?>
<script>

window.onload = function() {
    var skillButtons = document.getElementsByName("skill");

    // Disable all buttons on page load
    for (var i = 0; i < skillButtons.length; i++) {
        skillButtons[i].disabled = true;
    }

    document.getElementById("vocation").onchange = function() {
        var vocation = this.value;
        var currentskill = document.getElementById("currentskill");
        var distanceButton = document.querySelector('button[value="distance"]');

        if (vocation == "none") {
            for (var i = 0; i < skillButtons.length; i++) {
                skillButtons[i].disabled = true;
            }
        } else {
            for (var i = 0; i < skillButtons.length; i++) {
                skillButtons[i].disabled = false;
            }

            if (vocation == "knight" || vocation == "paladin"){
                currentskill.value = 10;
            } else {
                currentskill.value = 0;
            }

            if (vocation == "knight") {
                distanceButton.disabled = true;
            }
        }

        for (var i = 0; i < skillButtons.length; i++) {
            skillButtons[i].classList.remove("toggled");
        }
    }

    document.getElementById('isVip').addEventListener('change', calculateTime);

    document.getElementById('calculator_ew_remaining_charges').addEventListener('input', calculateTime);

    function calculateTime() {
        var hours, mins, secs, charges = document.getElementById('calculator_ew_remaining_charges').value;
        var isVip = document.getElementById('isVip').checked;
        var percent = 10; // Change this to the percentage you want
        var speed = isVip ? 2 * (1 - percent / 100) : 2;
        hours = Math.floor((charges * speed) / 3600);
        charges -= hours * 3600 / speed;
        mins = Math.floor((charges * speed) / 60);
        charges -= mins * 60 / speed;
        secs = charges * speed;
        secs = (secs % 1 != 0) ? parseFloat(secs.toFixed(1)) : Math.floor(secs);
        document.getElementById('calculator_ew_remaining_time').innerHTML = hours + ' hours, ' + mins + ' minutes and ' + secs + ' seconds';
    }
}

//Each weapon is equivalent to 300k mana points - 600 ultimate mana potions * 500 average value, and all vocs progress their main skill at the same rate with the weapons
function submit_exercise_form() {
  vocation = document.getElementById("vocation").value;
  targetskill = document.getElementById("targetskill").value;
  currentskill = document.getElementById("currentskill").value;

 if (vocation == 'none') {
    alert("Please select a vocation.");
    return;
  }

  skillButtons = document.getElementsByName("skill");
  skill;

  for (var i = 0; i < skillButtons.length; i++) {
        if (skillButtons[i].classList.contains("toggled")) {
            skill = skillButtons[i].value;
            break;
        }
    }

  if (!skill) {
    alert("Please toggle a skill.");
    return;
  }

  if (!(targetskill) || targetskill == 0) {
    alert("Please enter a valid target skill.");
    return;
  }

  if (targetskill < currentskill) {
    alert("Target skill must be higher than current skill.");
    return;
  }

  points_main_skill_regular_weapon = 300000;
  points_main_skill_durable_weapon = points_main_skill_regular_weapon * 3.6;
  points_main_skill_lasting_weapon = points_main_skill_regular_weapon * 28.8;

  cost_regular_k = 262.5

  cost_durable_k = 945

  cost_lasting_k = 7560

  exerciseformrvalues = document.getElementById("vocation_exercise_form");
  exerciseformresults = document.getElementById("exerciseformresults");
  exerciseformresults.innerHTML = ""

  currentskillpercentage = document.getElementById("currentskillpercentage").value;
  if (currentskillpercentage.includes(",")) {
    currentskillpercentage = currentskillpercentage.replace(",", ".")
  }

  IsDummy = document.getElementById("dummy").checked;
  IsEvent = document.getElementById("event").checked;
  rate = document.getElementById("currentrate").value || 0;

  vocation_constant = 1.1

  if (vocation == "paladin" && skill == "magic") {
    vocation_constant = 1.4;
  } else if (vocation == "knight" && skill == "magic") {
    vocation_constant = 3.0;
    }

  points_required = main_skill_calculation_points_required(vocation_constant, currentskill, currentskillpercentage, targetskill, IsDummy, IsEvent, rate, 0)

  regular_weapons_required = Math.ceil(points_required / (points_main_skill_regular_weapon))
  durable_weapons_required = Math.ceil(points_required / (points_main_skill_durable_weapon))
  lasting_weapons_required = Math.ceil(points_required / (points_main_skill_lasting_weapon))

  regular_k_or_kk = "k"
  regular_cost = regular_weapons_required * cost_regular_k

  if (Math.round(regular_cost) > 1000) {
    regular_cost = regular_cost / 1000
    regular_k_or_kk = "kk"
  }

  durable_k_or_kk = "k"
  durable_cost = durable_weapons_required * cost_durable_k
  if (Math.round(durable_cost) > 1000) {
    durable_cost = durable_cost / 1000
    durable_k_or_kk = "kk"
  }

  lasting_k_or_kk = "k"
  lasting_cost = lasting_weapons_required * cost_lasting_k
  if (Math.round(lasting_cost) > 1000) {
    lasting_cost = lasting_cost / 1000
    lasting_k_or_kk = "kk"
  }

  exerciseformresults.innerHTML = "To get from skill <b>" + currentskill + "</b> to skill <b>" + targetskill + "</b>, you need to use a total of: <br><br><b>"
      + regular_weapons_required + " regular exercise weapons</b>, at a cost of " + regular_cost + regular_k_or_kk + ", time required: " + Math.floor(regular_weapons_required / 3.6) + " hours and " + Math.round((regular_weapons_required % 3.6) * 16.67) + " minutes<br><br><b>"
      + durable_weapons_required + " durable exercise weapons</b>, at a cost of " + durable_cost + durable_k_or_kk + ", time required: " + durable_weapons_required + " hours<br><br><b>"
      + lasting_weapons_required + " lasting exercise weapons</b>, at a cost of " + lasting_cost + lasting_k_or_kk + ", time required: " + lasting_weapons_required * 8 + " hours";
}

function main_skill_calculation_points_required(vocation_constant, currentskill, currentskillpercentage, targetskill, IsDummy, IsEvent, rate, skill_offset) {
  current_skill_total_points = total_skill_points_at_given_level(1600, vocation_constant, parseInt(currentskill) + 1, skill_offset)
  points_to_next_skill = points_to_next_skill_level(1600, vocation_constant, parseInt(currentskill), skill_offset) * (currentskillpercentage / 100)
  target_skill_total_points = total_skill_points_at_given_level(1600, vocation_constant, targetskill, skill_offset)

  total_points_needed_for_target = (target_skill_total_points - (current_skill_total_points - points_to_next_skill))

  if (rate > 0) {
    total_points_needed_for_target = total_points_needed_for_target / rate
  }

  if (IsEvent) {
    total_points_needed_for_target = total_points_needed_for_target / 2
  }
  if (IsDummy) {
    total_points_needed_for_target = total_points_needed_for_target / 1.1
  }

  return total_points_needed_for_target
}

function points_to_next_skill_level(skill_constant, vocation_constant, skill, skill_offset) {
  exponent = Math.pow(vocation_constant, skill - skill_offset)
  total_points = skill_constant * exponent
  return total_points
}

function total_skill_points_at_given_level(skill_constant, vocation_constant, skill, skill_offset) {
  exponent = Math.pow(vocation_constant, skill - skill_offset)
  total_points = skill_constant * ((exponent - 1) / (vocation_constant - 1))
  return total_points
}

function toggleButton(button) {
    var buttons = document.getElementsByName('skill');

    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('toggled');
    }

    button.classList.add('toggled');
    skill = button.value;
}

</script>

<div class="TableContentContainer">
    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
        <tbody>
            <tr>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Vocation:</span>
                </td>
                <td id="LabelV150 PlannerTopTableLabel">
                    <select id="vocation">
                        <option value="none">-</option>
                        <option value="knight">Knight</option>
                        <option value="paladin">Paladin</option>
                        <option value="druid">Druid</option>
                        <option value="sorcerer">Sorcerer</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Skill:</span>
                </td>
                <td class="LabelV150 PlannerTopTableLabel" style="text-align: left;">
                    <button value="magic" name="skill" onclick="toggleButton(this)">Magic</button>
                    <button value="melee" name="skill" onclick="toggleButton(this)">Club/Sword/Axe</button>
                    <button value="distance" name="skill" onclick="toggleButton(this)">Distance</button>
                </td>
            </tr>
            <tr>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Current Skill</span>
                </td>
                <td>
                    <input type="number" id="currentskill" min="1" max="999" style="width:60px;">
                </td>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Desired Skill</span>
                </td>
                <td>
                    <input type="number" id="targetskill" min="1" max="999" style="width:60px;">
                </td>
                <td class="LabelV150 PlannerTopTableLabel" style="text-align:right;">
                    <span>% Left</span>
                </td>
                <td>
                    <input type="number" id="currentskillpercentage" min="0" max="100" style="width:60px;" value="100">
                </td>
            </tr>
            <tr>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Extra:</span>
                </td>
                <td>
                    <input type="checkbox" id="dummy">
                    <label for="dummy">Dummy</label>
                    <input type="checkbox" id="event">
                    <label for="event">Double Skill Event</label>
                </td>
            </tr>
            <tr>
                <td class="LabelV150 PlannerTopTableLabel">
                    <span>Rate:</span>
                </td>
                <td>
                    <input type="number" id="currentrate" min="1" max="999" style="width:60px;">
                </td>
            </tr>
        </tbody>
    </table>
</div>
    <center>
        <div class="BigButton" onclick="submit_exercise_form()" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>
    <p id="exerciseformresults"></p>

<div class="TableContainer">
  <div class="CaptionContainer">
    <div class="CaptionInnerContainer">
      <span class="CaptionEdgeLeftTop" style="background-image:url(templates/tibiacom/images/global/content/box-frame-edge.gif);"></span>
      <span class="CaptionEdgeRightTop" style="background-image:url(templates/tibiacom/images/global/content/box-frame-edge.gif);"></span>
      <span class="CaptionBorderTop" style="background-image:url(templates/tibiacom/images/global/content/table-headline-border.gif);"></span>
      <span class="CaptionVerticalLeft" style="background-image:url(templates/tibiacom/images/global/content/box-frame-vertical.gif);"></span>
      <div class="Text">
        <font color="white">Calculate duration of remaining charges on weapon:</font>
      </div>
      <span class="CaptionVerticalRight" style="background-image:url(templates/tibiacom/images/global/content/box-frame-vertical.gif);"></span>
      <span class="CaptionBorderBottom" style="background-image:url(templates/tibiacom/images/global/content/table-headline-border.gif);"></span>
      <span class="CaptionEdgeLeftBottom" style="background-image:url(templates/tibiacom/images/global/content/box-frame-edge.gif);"></span>
      <span class="CaptionEdgeRightBottom" style="background-image:url(templates/tibiacom/images/global/content/box-frame-edge.gif);"></span>
    </div>
  </div>
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
                      <table border="0" cellpadding="4" cellspacing="1" width="100%">
                        <tbody>
                          <tr bgcolor="#D4C0A1">
                            <td width="60%">
                                <label>Remaining charges: <input id="calculator_ew_remaining_charges" type="number" value="0" min="1" max="99999" style="width:70px;"></label>
                                <label>VIP Account: <input type="checkbox" id="isVip"></label>
                            </td>
                            <td id="calculator_ew_remaining_time"></td>
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

<style>
    .toggled {
        background-color: #4CAF50;
        color: white;
    }

    .exerciseformresults{
        padding-left: 20px;
        text-align: left;
    }
</style>

<?php

$title = 'Hunt Finder';
$huntsFound = 0;
$hunts = [
    '1' => [
        'name' => 'Asura Mirror',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 1.6,
            'maxExp' => 2.1,
        ],
        'level' => 300,
    ],
    '2' => [
        'name' => 'The Hive',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 1,
            'maxExp' => 1.3,
        ],
        'level' => 200,
    ],
    '3' => [
        'name' => 'Exotic Cave',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '4' => [
        'name' => 'Asura Palace',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '5' => [
        'name' => 'Hyena Lairs',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '6' => [
        'name' => 'Krailos Ruins',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '8' => [
        'name' => 'Deeper Banuta',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '9' => [
        'name' => 'Court of Winter',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 900,
            'maxExp' => 1.4,
        ],
        'level' => 130,
    ],
    '11' => [
        'name' => 'Razachai',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2,
            'maxExp' => 2.5,
        ],
        'level' => 400,
    ],
    '12' => [
        'name' => 'Asura Palace',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3.5,
        ],
        'level' => 300,
    ],
    '14' => [
        'name' => 'Lion Sanctum',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '15' => [
        'name' => 'Naga',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 700,
    ],
    '16' => [
        'name' => 'Cobra Bastion',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '17' => [
        'name' => 'Roshamuul West',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '18' => [
        'name' => 'Roshamuul East',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '19' => [
        'name' => 'Souleater Mountains',
        'vocation' => 'Druid',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '20' => [
        'name' => 'Pirat Mines',
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 200,
    ],
    '21' => [
        'name' => 'Catacombs',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 400,
    ],
    '22' => [
        'name' => 'Old Fortress',
        'vocation' => 'Paladin',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 200,
    ],
    '23' => [
        'name' => "Vampire Crypt",
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 100,
    ],
    '24' => [
        'name' => "Drefia Grim Reaper",
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 200,
    ],
    '25' => [
        'name' => "Draken Walls",
        'vocation' => 'Knight',
        'exp' => [
            'minExp' => 2.5,
            'maxExp' => 3,
        ],
        'level' => 250,
    ],
];

?>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: -10px;
            justify-content: flex-start;
            margin-left: 25px;
        }

        .card-box {
            box-shadow: 2px 2px 2px #875f3e;
            border: 1px solid #5f4d41;
            width: 30%;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            height: 215px;
        }

        .card-box-img {
            width: 120%;
            height: auto;
            transform: translate(-5px, -18px);
            object-fit: cover;
        }
        
        .card-box-img:hover {
            filter: brightness(120%);
        }

        .label-frame {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            display: inline-block;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .hunt-title {
            font-weight: bold;
            line-height: 18px;
            padding: 10px 3px;
            transform: translateY(-26px);
        }
        .vocation-title {
            font-size: 8px;
            transform: translate(1px, -41px);
        }

        .exp-title {
            font-size: 8px;
            transform: translate(1px, -48px);
        }

        .hunt-vocation {
            font-size: 14px;
            color: rgb(105, 105, 105);
            font-weight: normal;
            margin: 0px;
            padding: 0px 15px;
        }

        .center-text {
            text-align: center;
        }

        .TableContentContainer, .InnerTableContainer, .TableScrollbarWrapper, .TableScrollbarContainer {
            width: 100%;
        }

    </style>

    <div id="wod-wrapper" class="WheelOfDestinyWrapper UseFullWidth hide">
        <div class="TableContainer Captionless">
            <table class="Table5" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="TableScrollbarWrapper">
                            <div class="TableScrollbarContainer"></div>
                        </div>
                        <div class="InnerTableContainer">
                            <table style="width:100%;" id="VocationSelection">
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tr>
                                                    <td>
                                                        <label class="LabelV150 PlannerTopTableLabel" for="level">Level:</label>
                                                        <input type="number" class="level" style="width: 60px;" id="level-input" min="0" inputmode="numeric" pattern="\d*">                                                    </td>
                                                    <td class="LabelV150 PlannerTopTableLabel">
                                                        <span>Vocation:</span>
                                                    </td>
                                                    <td>
                                                        <select class="vocation-select">
                                                            <option value="all">All Vocations</option>
                                                            <option value="knight">Knight</option>
                                                            <option value="paladin">Paladin</option>
                                                            <option value="druid">Druid</option>
                                                            <option value="sorcerer">Sorcerer</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>
    <p style="text-align: left; margin-left: 27px;">
    Raw experience can vary based on factors such as level, equipment, skills, rotations, and the Wheel of Destiny.<br>
    The displayed raw experience represents a minimum; significantly higher values are possible.
    </p>
    <br>
    <br>
    <div class="card-container" id="huntsContainer"></div>

    <script>
    var hunts = <?php echo json_encode($hunts); ?>;

    function updateAmountHunts(hunts) {
        var amountHunts = hunts.length;
        document.getElementById("total_hunts").textContent = amountHunts + ' hunts found';
    }

    function formatDisplayExperience(number) {
    if (!isNaN(number)) {
        if (number.toString().includes('.')) {
            return number + 'kk';
        } else if (number < 10) {
            return number + 'kk';
        } else {
            return number + 'k';
        }
    } else {
        return false;
    }
    }

    function formatToImageName(name) {
       return name.toLowerCase().replace(/ /g, '_');
    }

    function getMatchingHunts(userLevel, userVocation) {
        var matchingHunts = Object.values(hunts).filter(hunt => {
            var levelMatch = !userLevel || userLevel >= hunt.level;
            var vocationMatch = userVocation.toLowerCase() === 'all' || userVocation.toLowerCase() === hunt.vocation.toLowerCase();
            return levelMatch && vocationMatch;
        });
        matchingHunts.sort((a, b) => b.level - a.level);
        return matchingHunts;
    }

    function filterAndDisplayHunts(){
        var level = document.getElementById('level-input').value;
        var vocation = document.querySelector('.vocation-select').value;
        var hunts = getMatchingHunts(level, vocation);
        displayHunts(hunts);
    }

    function displayIcon(vocation) {
    if (vocation === 'Knight') {
        return '🛡 Knight';
    } else if (vocation === 'Paladin') {
        return '🏹 Paladin';
    } else if (vocation === 'Mages') {
        return '🧙 Mages';
    } else if (vocation === 'Sorcerer') {
        return '🔥 Sorcerer';
    } else if (vocation === 'Druid') {
        return '❄️ Druid';
    }
    }

    function displayHunts(hunts){
        var container = document.getElementById("huntsContainer");
        container.innerHTML = '';
        hunts.forEach(hunt => {
            var cardBox = document.createElement('div');
            cardBox.className = 'card-box';
            cardBox.innerHTML = `
            <table>
                <tbody>
                    <tr>
                        <td style="110px;">
                            <img src="../images/hunts/${formatToImageName(hunt.name)}.webp" class="card-box-img" alt="${hunt.name}">
                        </td>
                    </tr>
                    <tr>
                        <td class="hunt-title">${hunt.name}</td>
                    </tr>
                    <tr>
                        <td class="vocation-title">${displayIcon(hunt.vocation)}</td>
                    <tr>
                    <br>
                        <!-- <td class="exp-title center-text"><b>EXP/HR RAW:</b> ${formatDisplayExperience(hunt.exp.minExp)}</td> -->
                    </tr>
                </tbody>
            </table>
        `;
        container.appendChild(cardBox);
    });
    }

    document.getElementById('level-input').addEventListener('input', filterAndDisplayHunts);
    document.querySelector('.vocation-select').addEventListener('change', filterAndDisplayHunts);
    window.onload = function () {
        var userLevel = '';
        var userVocation = 'all';
        filterAndDisplayHunts(userLevel, userVocation);
    };
    </script>



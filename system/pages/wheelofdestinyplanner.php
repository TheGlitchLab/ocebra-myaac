<link href="<?= $template_path; ?>/css/wheelofdestiny.css" rel="stylesheet" type="text/css" />
<div class="BoxContent" style="background-image:url(https://static.tibia.com/images/global/content/scroll.gif);">
  <p id="wod-warning" class="hide">To use the Wheel of Destiny Planner, please ensure that JavaScript is enabled!</p>
  <div id="wod-wrapper" class="WheelOfDestinyWrapper UseFullWidth">
    <div class="TableContainer Captionless">
      <table class="Table5" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td>
              <div class="TableScrollbarWrapper" style="width: unset;">
                <div class="TableScrollbarContainer"></div>
              </div>
              <div class="InnerTableContainer" style="max-width: unset;">
                <table style="width:100%;" id="VocationSelection">
                  <tbody>
                    <tr>
                      <td>
                        <div class="TableContentContainer ">
                          <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                            <tbody>
                              <tr>
                                <td class="LabelV150 PlannerTopTableLabel">
                                  <span>Vocation:</span>
                                </td>
                                <td id="VocationList">
                                  <span class="OptionContainer">
                                    <label for="wod-vocation_knight">
                                      <span class="OptionContainer">
                                        <input id="wod-vocation_knight" type="radio" name="wod-vocation" value="knight" checked="checked">
                                        <label for="wod-vocation_knight">Knight</label>
                                      </span>
                                    </label>
                                  </span>
                                  <span class="OptionContainer">
                                    <label for="wod-vocation_druid">
                                      <span class="OptionContainer">
                                        <input id="wod-vocation_druid" type="radio" name="wod-vocation" value="druid">
                                        <label for="wod-vocation_druid">Druid</label>
                                      </span>
                                    </label>
                                  </span>
                                  <span class="OptionContainer">
                                    <label for="wod-vocation_sorcerer">
                                      <span class="OptionContainer">
                                        <input id="wod-vocation_sorcerer" type="radio" name="wod-vocation" value="sorcerer">
                                        <label for="wod-vocation_sorcerer">Sorcerer</label>
                                      </span>
                                    </label>
                                  </span>
                                  <span class="OptionContainer">
                                    <label for="wod-vocation_paladin">
                                      <span class="OptionContainer">
                                        <input id="wod-vocation_paladin" type="radio" name="wod-vocation" value="paladin">
                                        <label for="wod-vocation_paladin">Paladin</label>
                                      </span>
                                    </label>
                                  </span>
                                </td>
                              </tr>
                              <tr>
                                <td class="LabelV150 PlannerTopTableLabel">
                                  <span>Promotion Points:</span>
                                </td>
                                <td>
                                  <span id="wod-reqpoints">0</span>
                                  <span> / </span>
                                  <input id="wod-limitpoints" class="PromotionPointsLimit" type"text"="" maxlength="4" inputmode="numeric">
                                  <span>
                                    <span class="PromotionPointsToolTipContainer">
                                      <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Promotion Points', '
																									<p>From level 51 onwards, you receive one promotion point with each level. You can also earn bonus promotion points by using certain rare items or by enhancing a mod in the Fragment Workshop.</p>', '');" onmouseout="$('#HelperDivContainer').hide();">
                                        <img style="border: 0px;" src="https://static.tibia.com/images/global/content/info.gif">
                                      </span>
                                    </span>
                                  </span>
                                </td>
                              </tr>
                              <tr class="CodeExport">
                                <td class="LabelV150">
                                  <span>Code:</span>
                                </td>
                                <td class="CodeColumn">
                                  <span id="wod-code-mobile">K0Y2AgDP4jAQA</span>
                                </td>
                              </tr>
                              <tr class="ButtonRow">
                                <td class="ButtonColumn" colspan="2">
                                  <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                                    <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                      <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                                      <input class="BigButtonText" type="button" id="wod-code-copy-mobile" value="Copy to Clipboard">
                                    </div>
                                  </div>
                                  <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                                    <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                      <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                                      <input class="BigButtonText" type="button" id="wod-code-url-mobile" value="Copy full URL">
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr class="CodeImport">
                                <td class="CodeColumn" colspan="2">
                                  <input id="wod-code-input-mobile" class="UseFullWidth" type="text" maxlength="256" placeholder="Enter copied export code or URL of the planner, e.g. K0Y2BABkZGCBIB5P9Dgfz__wA">
                                  <div id="wod-code-invalid-mobile" class="ColorRed hide InvalidCode">You have entered an invalid code.</div>
                                </td>
                              </tr>
                              <tr class="ButtonRow">
                                <td class="ButtonColumn" colspan="2">
                                  <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                                    <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                      <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                                      <input class="BigButtonText" type="button" id="wod-code-import-mobile" value="Import">
                                    </div>
                                  </div>
                                  <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                                    <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                      <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                                      <input class="BigButtonText" type="button" id="wod-code-reset-mobile" value="Reset">
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
    <div class="TableContainer">
      <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
          <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
          <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
          <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
          <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
          <div class="Text">Code</div>
          <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
          <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
          <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
          <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
        </div>
      </div>
      <table class="Table5" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td>
              <div class="TableScrollbarWrapper" style="width: unset;">
                <div class="TableScrollbarContainer"></div>
              </div>
              <div class="InnerTableContainer" style="max-width: unset;">
                <table style="width:100%;">
                  <tbody>
                    <tr class="CodeExport">
                      <td class="CodeColumn">
                        <span id="wod-code">K0Y2AgDP4jAQA</span>
                      </td>
                      <td class="ButtonColumn">
                        <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                          <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                            <div class="BigButtonOver" style="background-image: url(&quot;https://static.tibia.com/images/global/buttons/button_blue_over.gif&quot;); visibility: hidden;"></div>
                            <input class="BigButtonText" type="button" id="wod-code-copy" value="Copy to Clipboard">
                          </div>
                        </div>
                        <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                          <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                            <div class="BigButtonOver" style="background-image: url(&quot;https://static.tibia.com/images/global/buttons/button_blue_over.gif&quot;); visibility: hidden;"></div>
                            <input class="BigButtonText" type="button" id="wod-code-url" value="Copy full URL">
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr class="CodeImport">
                      <td class="CodeColumn">
                        <input id="wod-code-input" class="UseFullWidth" type="text" maxlength="256" placeholder="Enter copied export code or URL of the planner, e.g. K0Y2BABkZGCBIB5P9Dgfz__wA">
                        <div id="wod-code-invalid" class="ColorRed hide InvalidCode">You have entered an invalid code.</div>
                      </td>
                      <td class="ButtonColumn">
                        <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                          <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                            <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                            <input class="BigButtonText" type="button" id="wod-code-import" value="Import">
                          </div>
                        </div>
                        <div class="BigButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue.gif)">
                          <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                            <div class="BigButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_over.gif);"></div>
                            <input class="BigButtonText" type="button" id="wod-code-reset" value="Reset">
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
    <br>
    <table id="WheelOfDestinySelectionBlock">
      <tbody>
        <tr id="WheelOfDestinySelection">
          <td id="PerkInformationTables">
            <div class="TableContainer">
              <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                  <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                  <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                  <div class="Text">Selection</div>
                  <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                  <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                  <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                </div>
              </div>
              <table class="Table5" cellpadding="0" cellspacing="0">
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
                              <td class="BoxWrapper">
                                <div class="SkillPercentage hide" id="wod-selection-box-bar">
                                  <span class="PercentageBar" id="wod-selection-box-bar-filling" style="background-image:url(https://static.tibia.com/images/community/wheelofdestiny/skill-percentage.png);"></span>
                                  <div class="Text" id="wod-selection-box-bar-text">0/100</div>
                                  <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                                  <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                                  <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                                  <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                                  <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                </div>
                                <div id="wod-selection-box-empty">Select a slice ...</div>
                                <div id="wod-selection-box-medium" class="hide">
                                  <div id="wod-selection-box-dedication-wrapper" class="PerkWrapper">
                                    <div id="wod-selection-box-dedication-header" class="Bold UseFullWidth">Dedication Perk</div>
                                    <div id="wod-selection-box-dedication-value" class="SkillValue"></div>
                                  </div>
                                  <div id="wod-selection-box-conviction-wrapper" class="PerkWrapper">
                                    <div id="wod-selection-box-conviction-header" class="Bold UseFullWidth">Conviction Perk</div>
                                    <div id="wod-selection-box-conviction-value" class="SkillValue"></div>
                                  </div>
                                  <div id="wod-selection-box-buttons" class="SmallButtonRow">
                                    <span id="SubtractPerkButtons">
                                      <div class="SmallButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small.gif)">
                                        <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                          <div class="SmallButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small_over.gif);"></div>
                                          <input class="SmallButtonText" type="button" id="wod-maxminus-button" value="- Max">
                                        </div>
                                      </div>
                                      <div class="SmallButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small.gif)">
                                        <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                          <div class="SmallButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small_over.gif);"></div>
                                          <input class="SmallButtonText" type="button" id="wod-minus-button" value="- 1">
                                        </div>
                                      </div>
                                    </span>
                                    <span id="AddPerkButtons">
                                      <div class="SmallButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small.gif)">
                                        <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                          <div class="SmallButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small_over.gif);"></div>
                                          <input class="SmallButtonText" type="button" id="wod-plus-button" value="+ 1">
                                        </div>
                                      </div>
                                      <div class="SmallButton" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small.gif)">
                                        <div class="ButtonEventHook" onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                          <div class="SmallButtonOver" style="background-image:url(https://static.tibia.com/images/global/buttons/button_blue_small_over.gif);"></div>
                                          <input class="SmallButtonText" type="button" id="wod-maxplus-button" value="+ Max">
                                        </div>
                                      </div>
                                    </span>
                                  </div>
                                </div>
                                <div id="wod-selection-box-large" class="hide">
                                  <div id="wod-selection-box-revelation-wrapper" class="PerkWrapper">
                                    <div id="wod-selection-box-revelation-header" class="Bold UseFullWidth">Revelation Perk</div>
                                    <div class="TextCenter">
                                      <div id="wod-selection-box-revelation-icon"></div>
                                    </div>
                                    <div id="wod-selection-box-revelation-name" class="LargePerkName"></div>
                                    <div id="wod-selection-box-revelation-description" class="LargePerkValue"></div>
                                  </div>
                                </div>
                                <div id="wod-selection-box-socket" class="hide">
                                  <div id="wod-selection-box-gem-wrapper" class="GemWrapper">
                                    <div id="wod-selection-box-gem-modgrades" class="ModGrades">
                                      <div class="ModGradesBox">
                                        <img id="wod-selection-box-gem-modgrades-1" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                        <img id="wod-selection-box-gem-modgrades-2" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                        <img id="wod-selection-box-gem-modgrades-3" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                      </div>
                                    </div>
                                    <div id="wod-selection-box-gem-name" class="Bold UseFullWidth">Gem</div>
                                    <div id="wod-selection-box-gem-mod-wrapper" class="GemModsWrapper">
                                      <div class="GemDropdownWrapper">
                                        <select name="wod-selection-box-gem-mod1-dropdown" class="GemDropdown"></select>
                                      </div>
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-selection-box-gem-mod1-icon"></div>
                                        </div>
                                        <div id="wod-selection-box-gem-mod1" class="ModEffectValue"></div>
                                      </div>
                                      <div class="GemDropdownWrapper">
                                        <select name="wod-selection-box-gem-mod2-dropdown" class="GemDropdown"></select>
                                      </div>
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-selection-box-gem-mod2-icon"></div>
                                        </div>
                                        <div id="wod-selection-box-gem-mod2" class="ModEffectValue"></div>
                                      </div>
                                      <div class="GemDropdownWrapper">
                                        <select name="wod-selection-box-gem-mod3-dropdown" class="GemDropdown"></select>
                                      </div>
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-selection-box-gem-mod3-icon"></div>
                                        </div>
                                        <div id="wod-selection-box-gem-mod3" class="ModEffectValue"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div id="wod-selection-box-vessel-wrapper" class="VesselWrapper">
                                    <div id="wod-selection-box-vessel-header" class="Bold UseFullWidth">Vessel</div>
                                    <div id="wod-selection-box-vessel-value" class="VesselValue"></div>
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
            <div class="TableContainer">
              <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                  <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                  <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                  <div class="Text">Information</div>
                  <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                  <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                  <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                  <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                </div>
              </div>
              <table class="Table5" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td>
                      <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"></div>
                      </div>
                      <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;" id="InformationBox">
                          <tbody>
                            <tr>
                              <td class="BoxWrapper UseFullWidth">
                                <div class="SkillPercentage hide" id="wod-information-box-bar">
                                  <span class="PercentageBar" id="wod-information-box-bar-filling" style="background-image:url(https://static.tibia.com/images/community/wheelofdestiny/skill-percentage.png);"></span>
                                  <div class="Text" id="wod-information-box-bar-text">0/100</div>
                                  <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                                  <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                                  <span class="CaptionVerticalRight" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
                                  <span class="CaptionBorderBottom" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
                                  <span class="CaptionEdgeLeftBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                  <span class="CaptionEdgeRightBottom" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
                                </div>
                                <div id="wod-information-box-empty">Move the cursor over a slice ...</div>
                                <div id="wod-information-box-medium" class="hide">
                                  <div id="wod-information-box-dedication-wrapper" class="PerkWrapper">
                                    <div id="wod-information-box-dedication-header" class="Bold UseFullWidth">Dedication Perk</div>
                                    <div id="wod-information-box-dedication-value" class="SkillValue"></div>
                                  </div>
                                  <div id="wod-information-box-conviction-wrapper" class="PerkWrapper">
                                    <div id="wod-information-box-conviction-header" class="Bold UseFullWidth">Conviction Perk</div>
                                    <div id="wod-information-box-conviction-value" class="SkillValue"></div>
                                  </div>
                                  <div id="wod-information-box-fillinfo" class="PerkFillInfo">Fill or empty a slice with a right-click.</div>
                                </div>
                                <div id="wod-information-box-large" class="hide">
                                  <div id="wod-information-box-revelation-wrapper" class="PerkWrapper">
                                    <div id="wod-information-box-revelation-header" class="Bold UseFullWidth">Revelation Perk</div>
                                    <div class="TextCenter">
                                      <div id="wod-information-box-revelation-icon"></div>
                                    </div>
                                    <div id="wod-information-box-revelation-name" class="LargePerkName"></div>
                                    <div id="wod-information-box-revelation-description" class="LargePerkValue"></div>
                                  </div>
                                </div>
                                <div id="wod-information-box-socket" class="hide">
                                  <div id="wod-information-box-gem-wrapper" class="GemWrapper">
                                    <div id="wod-information-box-gem-modgrades" class="ModGrades">
                                      <div class="ModGradesBox">
                                        <img id="wod-information-box-gem-modgrades-1" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                        <img id="wod-information-box-gem-modgrades-2" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                        <img id="wod-information-box-gem-modgrades-3" class="hide" src="https://static.tibia.com/images/community/wheelofdestiny/icon_modgrade4.png">
                                      </div>
                                    </div>
                                    <div id="wod-information-box-gem-name" class="Bold UseFullWidth">Gem</div>
                                    <div id="wod-information-box-gem-mod-wrapper" class="GemModsWrapper">
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-information-box-gem-mod1-icon"></div>
                                        </div>
                                        <div id="wod-information-box-gem-mod1" class="ModEffectValue"></div>
                                      </div>
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-information-box-gem-mod2-icon"></div>
                                        </div>
                                        <div id="wod-information-box-gem-mod2" class="ModEffectValue"></div>
                                      </div>
                                      <div class="ModEffectWrapper">
                                        <div class="ModEffectIconWrapper">
                                          <div id="wod-information-box-gem-mod3-icon"></div>
                                        </div>
                                        <div id="wod-information-box-gem-mod3" class="ModEffectValue"></div>
                                      </div>
                                      <div class="GemModSelectionPlaceholder"></div>
                                    </div>
                                  </div>
                                  <div id="wod-information-box-vessel-wrapper" class="VesselWrapper">
                                    <div id="wod-information-box-vessel-header" class="Bold UseFullWidth">Vessel</div>
                                    <div id="wod-information-box-vessel-value" class="VesselValue"></div>
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
          <td id="WheelOfDestiny">
            <canvas id="wod-canvas" width="522" height="522">Your browser does not support HTML5 canvas!</canvas>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <div class="TableContainer">
      <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
          <span class="CaptionEdgeLeftTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
          <span class="CaptionEdgeRightTop" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-edge.gif);"></span>
          <span class="CaptionBorderTop" style="background-image:url(https://static.tibia.com/images/global/content/table-headline-border.gif);"></span>
          <span class="CaptionVerticalLeft" style="background-image:url(https://static.tibia.com/images/global/content/box-frame-vertical.gif);"></span>
          <div class="Text">Perks Summary</div>
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
                    <tr id="PerksSummary">
                      <td>
                        <div id="wod-dedication-perks-header" class="PerksSummaryHeader Bold">Dedication Perks</div>
                        <table class="UseFullWidth">
                          <tbody>
                            <tr>
                              <td>
                                <div class="TableContentContainer ">
                                  <table class="TableContent" width="100%" style="" id="wod-dedication-perks">
                                    <tr class="Even">
                                      <td>
                                        <span>Hit Points</span>
                                      </td>
                                      <td>
                                        <span class="PerksSummaryValue">+0 </span>
                                      </td>
                                    </tr>
                                    <tr class="Odd">
                                      <td>
                                        <span>Mana</span>
                                      </td>
                                      <td>
                                        <span class="PerksSummaryValue">+0 </span>
                                      </td>
                                    </tr>
                                    <tr class="Even">
                                      <td>
                                        <span>Capacity</span>
                                      </td>
                                      <td>
                                        <span class="PerksSummaryValue">+0 </span>
                                      </td>
                                    </tr>
                                    <tr class="Odd">
                                      <td>
                                        <span>Mitigation Multiplier</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">0% </span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <div id="wod-conviction-perks-header" class="PerksSummaryHeader PerkTableMarginTop Bold">Conviction Perks</div>
                        <table class="UseFullWidth">
                          <tbody>
                            <tr>
                              <td>
                                <div class="TableContentContainer ">
                                  <table class="TableContent" width="100%" style="" id="wod-conviction-perks">
                                    <tr class="Even">
                                      <td colspan="2">none</td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      <td>
                        <div id="wod-revelation-perks-header" class="PerksSummaryHeader PerkTableMarginTopOnMobile Bold">Revelation Perks</div>
                        <table class="UseFullWidth">
                          <tbody>
                            <tr>
                              <td>
                                <div class="TableContentContainer ">
                                  <table class="TableContent" width="100%" style="" id="wod-revelation-perks">
                                    <tr class="Even">
                                      <td>
                                        <span>Damage and Healing</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">+0</span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr class="Odd">
                                      <td>
                                        <span>Avatar of Steel</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">Locked</span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr class="Even">
                                      <td>
                                        <span>Combat Mastery</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">Locked</span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr class="Odd">
                                      <td>
                                        <span>Executioner's Throw</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">Locked</span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr class="Even">
                                      <td>
                                        <span>Gift of Life</span>
                                      </td>
                                      <td style="position: relative;">
                                        <span class="PerksSummaryValue">Locked</span>
                                        <div class="PerkTooltipContainer">
                                          <span class="HelperDivIndicator">
                                            <img src="https://static.tibia.com/images/global/content/info.gif" alt="tooltip icon">
                                          </span>
                                        </div>
                                      </td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <div id="wod-gem-perks-header" class="PerksSummaryHeader PerkTableMarginTop Bold">Vessels</div>
                        <table class="UseFullWidth">
                          <tbody>
                            <tr>
                              <td>
                                <div class="TableContentContainer ">
                                  <table class="TableContent" width="100%" style="" id="wod-gem-perks">
                                    <tr class="Even">
                                      <td colspan="2">none</td>
                                    </tr>
                                  </table>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td id="wod-summary-note" class="PerksSummaryNote" colspan="2">Note: The cooldown of a spell cannot be reduced to less than 50% of its base cooldown by any means.</td>
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
  <script id="wod-grid-script" type="text/javascript" src="templates/tibiacom/js/skillwheel/skillgrid.js"></script>
  <script id="wod-planner-script" type="text/javascript" src="templates/tibiacom/js/skillwheel/wheelofdestinyplanner.min.js"></script>
  <script type="text/javascript" src="templates/tibiacom/js/skillwheel/wheel.js"></script>
  <script type="text/javascript">
    runWodPlanner("templates/tibiacom/js/skillwheel/SkillwheelStringsJsonLibrary.json", {
      warning: "wod-warning",
      wrapper: "wod-wrapper",
      vocationRadio: "wod-vocation",
      reqPoints: "wod-reqpoints",
      limitPoints: "wod-limitpoints",
      code: "wod-code",
      codeCopy: "wod-code-copy",
      codeUrl: "wod-code-url",
      codeImport: "wod-code-import",
      codeReset: "wod-code-reset",
      codeInput: "wod-code-input",
      codeInvalid: "wod-code-invalid",
      codeMobile: "wod-code-mobile",
      codeCopyMobile: "wod-code-copy-mobile",
      codeUrlMobile: "wod-code-url-mobile",
      codeImportMobile: "wod-code-import-mobile",
      codeResetMobile: "wod-code-reset-mobile",
      codeInputMobile: "wod-code-input-mobile",
      codeInvalidMobile: "wod-code-invalid-mobile",
      selectionBox: "wod-selection-box",
      maxMinus: "wod-maxminus-button",
      minus: "wod-minus-button",
      maxPlus: "wod-maxplus-button",
      plus: "wod-plus-button",
      infoBox: "wod-information-box",
      canvas: "wod-canvas",
      dedicationPerks: "wod-dedication-perks",
      convictionPerks: "wod-conviction-perks",
      revelationPerks: "wod-revelation-perks",
      gemPerks: "wod-gem-perks",
      summaryNote: "wod-summary-note"
    });
  </script>
</div>
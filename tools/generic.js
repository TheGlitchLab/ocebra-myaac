$(document).ready(function() {
   $('#ConfirmationForm').submit(function(event) {
       $('#SubmitButtonContainer .BigButton input').attr('disabled', 'disabled');
       $('#SubmitButtonContainer .BigButton').hide();
       $('.HideAfterSubmit').hide();
       $('#ChangePaymentMethodBlock').closest('tr').hide();
       $('.HideBeforeSubmit').show();
   });
   $('#CreateAccountAndCharacterForm, #CreateCharacterForm').submit(function(event) {
       $("#CreateAccountAndCharacterForm, #CreateCharacterForm").unbind("submit");
       grecaptcha.execute();
       event.preventDefault();
   });
   $("tr[id^='applicationtext-']").hide();
   // var g_Now = Math.floor(new Date().getTime() / 1000); if (g_Now < JS_ANNIVERSARY_THEMEBOX_STEP_3 && g_Now >= JS_ANNIVERSARY_THEMEBOX_STEP_1) { var g_AnniversaryDate = new Date((JS_ANNIVERSARY_THEMEBOX_STEP_3 * 1000)); InitializeFancyAnniversaryCountDown(g_AnniversaryDate, g_Now); }
   if (typeof g_ActivateCapsLockWarning !== 'undefined' && g_ActivateCapsLockWarning == true) {
       AddCapsLockEventListeners();
   }
   InitAllCharacterAuctionCountDowns();
   InitAllCharacterAuctionBidListener();
   let lastScroll = 0;
   $(window).bind('scroll', function() {
       let currentScroll = window.pageYOffset;
       if ($('#MobileMenuIcon').is(':checked') != true) {
           if (currentScroll - lastScroll > 0) {
               if (currentScroll > 100) {
                   $('#MobileMenu').stop(true, false).animate({
                       'top': '-75px'
                   }, 400);
               }
           } else {
               $('#MobileMenu').stop(true, false).animate({
                   'top': '0px'
               }, 400);
           }
       }
       lastScroll = currentScroll;
   });

});
function ReCaptchaCallback(a_Response) {
   if (a_Response.length > 0) {
       let form, input;
       if (document.forms.CreateAccountAndCharacter) {
           form = document.forms.CreateAccountAndCharacter;
       } else if (document.forms.CreateCharacterForm) {
           form = document.forms.CreateCharacterForm;
       } else if (document.forms.LoginForm) {
           form = document.forms.LoginForm;
       } else if (document.forms.GlobalDonationsForm) {
           form = document.forms.GlobalDonationsForm;
       }
       input = form['g-recaptcha-response'];
       input.value = a_Response;
       form.submit();
   }
}
function UpdateTellAFriendInviteOptions(a_Selection) {
   if (a_Selection == 0) {
       $('#TAF_Link').slideDown('slow');
       $('#TAF_Email').slideUp('slow');
       $('#TAF_Facebook').slideUp('slow');
       $('#TAF_Option_Link').addClass('TAF_ActiveSelection');
       $('#TAF_Option_Email').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Facebook').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Link .TAF_Option_GoldBorder').css('visibility', 'visible');
       $('#TAF_Option_Email .TAF_Option_GoldBorder').css('visibility', 'hidden');
       $('#TAF_Option_Facebook .TAF_Option_GoldBorder').css('visibility', 'hidden');
   } else if (a_Selection == 1) {
       $('#TAF_Link').slideUp('#TAF_Link');
       $('#TAF_Email').slideDown('#TAF_Link');
       $('#TAF_Facebook').slideUp('#TAF_Link');
       $('#TAF_Option_Link').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Email').addClass('TAF_ActiveSelection');
       $('#TAF_Option_Facebook').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Link .TAF_Option_GoldBorder').css('visibility', 'hidden');
       $('#TAF_Option_Email .TAF_Option_GoldBorder').css('visibility', 'visible');
       $('#TAF_Option_Facebook .TAF_Option_GoldBorder').css('visibility', 'hidden');
   } else {
       $('#TAF_Link').slideUp('#TAF_Link');
       $('#TAF_Email').slideUp('#TAF_Link');
       $('#TAF_Facebook').slideDown('#TAF_Link');
       $('#TAF_Option_Link').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Email').removeClass('TAF_ActiveSelection');
       $('#TAF_Option_Facebook').addClass('TAF_ActiveSelection');
       $('#TAF_Option_Link .TAF_Option_GoldBorder').css('visibility', 'hidden');
       $('#TAF_Option_Email .TAF_Option_GoldBorder').css('visibility', 'hidden');
       $('#TAF_Option_Facebook .TAF_Option_GoldBorder').css('visibility', 'visible');
   }
}
function ToggleVisibility(a_ElementsToHide, a_ElementsToShow) {
   if (typeof (a_ElementsToHide) == 'object') {
       for (var i = 0; i < a_ElementsToHide.length(); ++i) {
           document.getElementById(a_ElementsToHide[i]).style.display = 'none';
       }
   } else if (typeof (a_ElementsToHide) == 'string') {
       document.getElementById(a_ElementsToHide).style.display = 'none';
   }
   if (typeof (a_ElementsToShow) == 'object') {
       for (var i = 0; i < a_ElementsToShow.length(); ++i) {
           document.getElementById(a_ElementsToShow[i]).style.display = 'block';
       }
   } else if (typeof (a_ElementsToShow) == 'string') {
       document.getElementById(a_ElementsToShow).style.display = 'block';
   }
}
function ToggleTrigger($a_This, a_TriggerName) {
   if ($a_This.checked) {
       document.getElementById(a_TriggerName).style.display = 'block';
   } else {
       document.getElementById(a_TriggerName).style.display = 'none';
   }
}
function SetLenLimit(TextAreaID, MaxLen) {
   var TextArea = document.getElementById(TextAreaID);
   if (TextArea == null) {
       CipLogError('SetLenLimit(): Input "' + TextAreaID + '" not found');
       return;
   }
   EnforceLenLimitClosure = function() {
       if (TextArea.value.length > MaxLen) {
           TextArea.value = TextArea.value.substring(0, MaxLen);
       }
   }
   ;
   AddEventHandler(TextArea, 'onkeyup', EnforceLenLimitClosure);
   AddEventHandler(TextArea, 'onblur', EnforceLenLimitClosure);
}
function SetRemainingLenCounter(TextAreaID, CounterID, MaxLen) {
   var TextArea = document.getElementById(TextAreaID);
   if (TextArea == null) {
       CipLogError('SetLenLimit(): Text area input "' + TextAreaID + '" not found');
       return;
   }
   var Counter = document.getElementById(CounterID);
   if (Counter == null) {
       CipLogError('SetLenLimit(): Counter input "' + CounterID + '" not found');
       return;
   }
   UpdateCounterClosure = function() {
       Counter.innerHTML = MaxLen - TextArea.value.length;
   }
   ;
   AddEventHandler(TextArea, 'onkeyup', UpdateCounterClosure);
   AddEventHandler(TextArea, 'onblur', UpdateCounterClosure);
   TextArea.onkeyup();
}
var EnableDebug = true;
function CipLogError(ErrMsg) {
   if (EnableDebug) {
       console.error(ErrMsg);
   }
}
function AddEventHandler(Element, EventHandlerName, Function) {
   var EventHandler = Element[EventHandlerName];
   if (EventHandler) {
       Element[EventHandlerName] = function() {
           EventHandler();
           Function();
       }
       ;
   } else {
       Element[EventHandlerName] = Function;
   }
}
var g_ActiveCharacter = -1;
function FocusCharacter(a_CharacterNumber, a_CharacterName, a_NumberOfCharacters) {
   if (a_CharacterNumber == g_ActiveCharacter) {
       return;
   } else {
       g_ActiveCharacter = a_CharacterNumber;
   }
   for (var i = 0; i <= a_NumberOfCharacters; i++) {
       if (i != a_CharacterNumber && $('#CharacterRow_' + i) != null) {
           $('#CharacterRow_' + i).css('fontWeight', 'normal');
           $('#CharacterRow_' + i).css('cursor', 'pointer');
           $('#CharacterOptionsOf_' + i).css('display', 'none');
           $('#CharacterNameOf_' + i).css('fontSize', '10pt');
       }
   }
   $('#CharacterRow_' + a_CharacterNumber).css('fontWeight', 'bold');
   $('#CharacterRow_' + a_CharacterNumber).css('cursor', 'auto');
   $('#CharacterOptionsOf_' + a_CharacterNumber).css('display', 'block');
   $('#CharacterNameOf_' + a_CharacterNumber).css('fontSize', '13pt');
   $('[name="selectedcharacter"]').each(function() {
       $(this).attr("value", $('#CharacterNameOf_' + a_CharacterNumber).innerHTML);
   });
}
function InRowWithOverEffect(a_RowID, a_Color) {
   document.getElementById(a_RowID).style.backgroundColor = a_Color;
}
function OutRowWithOverEffect(a_RowID, a_Color) {
   document.getElementById(a_RowID).style.backgroundColor = a_Color;
}
function InMiniButton(a_Button, a_IsPreviewString) {
   a_Button.src = JS_DIR_IMAGES + "account/" + a_IsPreviewString + "play-button-over.gif";
}
function OutMiniButton(a_Button, a_IsPreview) {
   a_Button.src = JS_DIR_IMAGES + "account/" + a_IsPreview + "play-button.gif";
}
function ShowHelperDiv(a_ID) {
   document.getElementById(a_ID).style.visibility = 'visible';
   document.getElementById(a_ID).style.display = 'block';
}
function HideHelperDiv(a_ID) {
   document.getElementById(a_ID).style.visibility = 'hidden';
   document.getElementById(a_ID).style.display = 'none';
}
var g_EntityMap = {
   "&": "&amp;",
   "<": "&lt;",
   ">": "&gt;",
   '"': '&quot;',
   "'": '&#39;',
   "/": '&#x2F;'
};
function escapeHtml(a_String) {
   return String(a_String).replace(/[&<>"'\/]/g, function(s) {
       return g_EntityMap[s];
   });
}
function BuildHelperDiv(a_DivID, a_IndicatorDivContent, a_Title, a_Text) {
   var l_Qutput = '';
   l_Qutput += '<span class="HelperDivIndicator" onMouseOver="ActivateHelperDiv($(this), \'' + a_Title + '\', \'' + escapeHtml(a_Text) + '\');" onMouseOut="$(\'#HelperDivContainer\').hide();" >' + a_IndicatorDivContent + '</span>';
   return l_Qutput;
}
function BuildHelperDivLink(a_DivID, a_IndicatorDivContent, a_Title, a_Text, a_SubTopic) {
   var l_Qutput = '';
   l_Qutput += '<a href="../common/help.php?subtopic=' + a_SubTopic + '" target="_blank" ><span class="HelperDivIndicator" onMouseOver="ActivateHelperDiv($(this), \'' + a_Title + '\', \'' + a_Text + '\', \'' + a_DivID + '\');" onMouseOut="$(\'#HelperDivContainer\').hide();" >' + a_IndicatorDivContent + '</span></a>';
   return l_Qutput;
}
function ActivateHelperDiv(a_Object, a_Title, a_Text, a_HelperDivPositionID) {
   var l_Left = 0;
   var l_Top = 0;
   var l_ArrowLeft = 0;
   var l_ArrowTop = 0;
   var l_ArrowRotation = '0deg';
   var l_WindowHeight = $(window).height();
   var l_PageHeight = $(document).height();
   var l_ScrollTop = $(document).scrollTop();
   $('#HelperDivHeadline').html(a_Title);
   $('#HelperDivText').html(a_Text);
   if (a_HelperDivPositionID && $('#' + a_HelperDivPositionID).length > 0) {
       l_Left = $('#' + a_HelperDivPositionID).offset().left;
       l_Top = $('#' + a_HelperDivPositionID).offset().top;
   } else {
       l_Left = (a_Object.offset().left + a_Object.width());
       l_Top = a_Object.offset().top;
   }
   var l_ToolTipHeight = $('#HelperDivContainer').outerHeight();
   if ((l_Top - l_ScrollTop + l_ToolTipHeight) > l_WindowHeight) {
       var l_TopBefore = l_Top;
       l_Top = (l_ScrollTop + l_WindowHeight - l_ToolTipHeight);
       if (l_Top < l_ScrollTop) {
           l_Top = l_ScrollTop;
       }
       l_ArrowTop = l_TopBefore - l_Top;
   } else {
       l_ArrowTop = -1;
   }
   l_ArrowLeft = -8;
   var l_InnerScreenWidth = window.innerWidth;
   var l_HelperDivWidth = $('#HelperDivContainer').outerWidth();
   var l_DoesFitRight = true;
   if (l_Left + l_HelperDivWidth > l_InnerScreenWidth) {
       l_DoesFitRight = false;
       l_Left = (a_Object.offset().left - l_HelperDivWidth - a_Object.width());
       l_ArrowLeft = l_HelperDivWidth - 2;
       l_ArrowRotation = '180deg';
   }
   var l_DoesFitLeft = true;
   if (l_Left < 0) {
       l_DoesFitLeft = false;
       l_Left = a_Object.offset().left - l_HelperDivWidth + 8;
       if (l_Left < 10) {
           l_Left = 10;
       }
       l_Top = l_Top + 1.5 * a_Object.height();
       l_ArrowRotation = '90deg';
       l_ArrowLeft = a_Object.offset().left - l_Left - parseInt($('.HelperDivArrow').css('width')) / 2;
       if (l_ArrowLeft > l_Left + l_HelperDivWidth) {
           l_Left = l_ArrowLeft - l_HelperDivWidth;
       }
       l_ArrowTop = l_ArrowTop - parseInt($('.HelperDivArrow').css('height')) + 4;
   }
   if ((l_ToolTipHeight + a_Object.offset().top) - l_ScrollTop > l_WindowHeight && !l_DoesFitRight && !l_DoesFitLeft) {
       l_Left = a_Object.offset().left - l_HelperDivWidth + 8;
       if (l_Left < 10) {
           l_Left = 10;
       }
       l_Top = a_Object.offset().top - l_ToolTipHeight - a_Object.height();
       l_ArrowLeft = a_Object.offset().left - l_Left - parseInt($('.HelperDivArrow').css('width')) / 2;
       l_ArrowTop = l_ToolTipHeight - 5;
       l_ArrowRotation = '270deg';
   }
   $('.HelperDivArrow').css('left', l_ArrowLeft);
   $('.HelperDivArrow').css('top', l_ArrowTop);
   $('.HelperDivArrow').css('rotate', l_ArrowRotation);
   $('#HelperDivContainer').css('top', l_Top);
   $('#HelperDivContainer').css('left', l_Left);
   $('#HelperDivContainer').show();
}
function DeactivateHelperDiv() {
   $('#HelperDivContainer').hide();
}
function CollapseTable(a_ID) {
   $('#' + a_ID).slideToggle('slow');
   if ($('#Indicator_' + a_ID).attr('class') == 'CircleSymbolPlus') {
       $('#Indicator_' + a_ID).css('background-image', 'url(templates/myaac/images/global/content/circle-symbol-minus.gif)');
       $('#Indicator_' + a_ID).attr('class', 'CircleSymbolMinus');
   } else {
       $('#Indicator_' + a_ID).css('background-image', 'url(templates/myaac/images/global/content/circle-symbol-plus.gif)');
       $('#Indicator_' + a_ID).attr('class', 'CircleSymbolPlus');
   }
}
function ToggleApplicationText(a_ID) {
   $("#applicationtext-" + a_ID).toggle("fast");
   if ($('#applicationcircle-' + a_ID).attr('class') == 'CircleSymbolPlus') {
       $('#applicationcircle-' + a_ID).css('background-image', 'url(templates/myaac/images/global/content/circle-symbol-minus.gif)');
       $('#applicationcircle-' + a_ID).attr('class', 'CircleSymbolMinus');
   } else {
       $('#applicationcircle-' + a_ID).css('background-image', 'url(templates/myaac/images/global/content/circle-symbol-plus.gif)');
       $('#applicationcircle-' + a_ID).attr('class', 'CircleSymbolPlus');
   }
}
function SetMinimumLayout() {
   $("#ArtworkHelper1").hide();
   $("#MenuColumn").hide();
   $("#ThemeboxesColumn").hide();
   $("#ContentColumn").css("margin", "0px");
   $("#MainHelper2").css("margin-left", "0px");
   $("#MainHelper2").css("padding-top", "0px");
   $("#MainHelper2").css("height", "0px");
   $("#DeactivationContainer").css("height", "auto");
   $("#MainHelper1").css("min-width", "auto");
   $("#Bodycontainer").css("min-width", "auto");
   $("#Bodycontainer").css("max-width", "auto");
   $("#Bodycontainer").css("height", "0px");
   $("#Footer").hide();
   $("#webshop").css("width", "560px");
   $("#webshop").css("margin", "17px");
   $("body").css("background-color", "#fff2db");
}
function getTimeRemaining(a_EndTime, a_InitOrRefresh) {
   var l_InitOrRefresh = a_InitOrRefresh;
   if (l_InitOrRefresh > 0) {
       l_InitOrRefresh = (l_InitOrRefresh);
   } else {
       l_InitOrRefresh = Math.floor(Date.parse(new Date()) / 1000);
   }
   var l_TimeStamp = (Math.floor(Date.parse(a_EndTime) / 1000) - l_InitOrRefresh);
   var l_Days = Math.floor(l_TimeStamp / (60 * 60 * 24));
   var l_Hours = Math.floor((l_TimeStamp / (60 * 60)) % 24);
   var l_Minutes = Math.floor((l_TimeStamp / 60) % 60);
   var l_Seconds = Math.floor((l_TimeStamp / 1) % 60);
   return {
       'total': l_TimeStamp,
       'days': l_Days,
       'hours': l_Hours,
       'minutes': l_Minutes,
       'seconds': l_Seconds
   };
}

function PostponeCharacterTradeManualPaymentNote() {
   var date = new Date();
   date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
   document.cookie = "postponecharactertrademanualpaymentnote" + "=1" + "; expires=" + date.toUTCString() + "; path=/";
}
function ShowOrHide(a_ID) {
   if ($('#' + a_ID).hasClass('CollapsedBlock')) {
       $('#' + a_ID).removeClass('CollapsedBlock');
       $('#' + a_ID + ' .ShowMoreOrLess a').text('show less');
       $('#' + a_ID + ' .IndicateMoreEntries').css('display', 'none');
   } else {
       $('#' + a_ID).addClass('CollapsedBlock');
       $('#' + a_ID + ' .ShowMoreOrLess a').text('show all');
       $('#' + a_ID + ' .IndicateMoreEntries').css('display', 'table-row');
   }
}
function ScrollToAnchor(a_AnchorName) {
   var l_Ancor = $('a[name="' + a_AnchorName + '"]');
   $('html, body').animate({
       scrollTop: (l_Ancor.offset().top - 100)
   }, 'slow');
}

function StartCharacterAuctionCountDown(a_Duration, a_ID, a_TimeString) {
   var l_Hours = 0;
   var l_Minutes = 0;
   var l_Seconds = 0;
   var l_IntervalID = setInterval(function() {
       if (a_Duration < (86400)) {
           var l_TempDuration = a_Duration;
           var l_Days = Math.floor(l_TempDuration / 86400);
           l_TempDuration = (l_TempDuration - (l_Days * 86400));
           var l_Hours = Math.floor(l_TempDuration / 3600);
           l_TempDuration = (l_TempDuration - (l_Hours * 3600));
           var l_Minutes = Math.floor(l_TempDuration / 60);
           l_TempDuration = (l_TempDuration - (l_Minutes * 60));
           l_Seconds = Math.floor(l_TempDuration % 60);
           l_Hours = l_Hours < 10 ? "0" + l_Hours : l_Hours;
           l_Minutes = l_Minutes < 10 ? "0" + l_Minutes : l_Minutes;
           l_Seconds = l_Seconds < 10 ? "0" + l_Seconds : l_Seconds;
           $l_TextString = 'in ';
           if (l_Days > 0) {
               $l_TextString += l_Days + 'd ';
           }
           if (l_Days > 0 || l_Hours > 0) {
               $l_TextString += l_Hours + 'h '
           }
           if (l_Days > 0 || l_Hours > 0 || l_Minutes > 0) {
               $l_TextString += l_Minutes + 'm '
           }
           $l_TextString += l_Seconds + 's';
           $l_TextString += ', ' + a_TimeString;
           a_ID.text($l_TextString);
       }
       --a_Duration;
       if (a_Duration < 0) {
           a_ID.text('Auction Ended!');
           clearInterval(l_IntervalID);
       }
   }, 1000);
}

function InitAllCharacterAuctionCountDowns() {
   var l_Auctions = $('.AuctionTimer');
   $('.AuctionTimer').each(function(l_Index, l_Element) {
       var l_Target = $('#' + l_Element.id);
       var l_AuctionEnd = $('#' + l_Element.id).attr('data-timestamp');
       var l_TimeSting = $('#' + l_Element.id).attr('date-timestring');
       var l_CurrentTimestampUTC = new Date().getTime();
       var l_Duration = (l_AuctionEnd - (l_CurrentTimestampUTC / 1000));
       if (l_Duration > 0) {
           StartCharacterAuctionCountDown(l_Duration, l_Target, l_TimeSting);
       }
   });
}

function AddThousandsSeparator(a_InputField) {
   var l_FormatedValue = a_InputField.value;
   var l_OriginalValue = a_InputField.value;
   var l_CurrentValue = (a_InputField.value).replace(/,/g, '');
   if (l_CurrentValue.length == 0) {
       a_InputField.value = '';
   } else if (/^\d+$/.test(l_CurrentValue)) {
       l_CurrentValue = parseInt(l_CurrentValue);
       a_InputField.data = l_CurrentValue;
       l_FormatedValue = (l_CurrentValue).toLocaleString('en-US');
       a_InputField.value = l_FormatedValue;
   } else {
       if (a_InputField.data != undefined) {
           a_InputField.value = (a_InputField.data).toLocaleString('en-US');
       } else {
           a_InputField.value = '';
       }
   }
   return;
}

function InitAllCharacterAuctionBidListener() {
   $('#currentcharactertrades input.MyMaxBidInput').keyup(function() {
       AddThousandsSeparator(this);
   });
}

function ToggleDeletedPostByID(a_PostID) {
   $('#Post_' + a_PostID + ' .PostBody').toggle();
   var l_ImageURL = JS_DIR_IMAGES + 'global/general/plus.gif';
   if ($('#Post_' + a_PostID + ' .PostBody').is(':visible')) {
       l_ImageURL = JS_DIR_IMAGES + 'global/general/minus.gif';
   }
   $('#Post_' + a_PostID + ' .ToggleDeletedPostImage').css('background-image', 'url(' + l_ImageURL + ')');
   return;
}

function ToggleDeletedPostByID(a_PostID) {
   $('#Post_' + a_PostID + ' .PostBody').toggle();
   var l_ImageURL = JS_DIR_IMAGES + 'global/general/plus.gif';
   if ($('#Post_' + a_PostID + ' .PostBody').is(':visible')) {
       l_ImageURL = JS_DIR_IMAGES + 'global/general/minus.gif';
   }
   $('#Post_' + a_PostID + ' .ToggleDeletedPostImage').css('background-image', 'url(' + l_ImageURL + ')');
   return;
}

function ToggleDeletedPosts() {
   var l_CookieName = 'HideDeletedPosts';
   var l_CurrentValue = GetCookieValue(l_CookieName);
   var $l_NewValue = true;
   var l_ImageURL = JS_DIR_IMAGES + 'global/general/plus.gif';
   if (l_CurrentValue == null || l_CurrentValue == false || l_CurrentValue == 'false') {
       $('.DeletedPost').hide();
       $l_NewValue = true;
       $('.HideDeletedPostsButton .BigButtonText').text('Show Deleted Posts');
   } else {
       $('.DeletedPost').show();
       $l_NewValue = false;
       $('.HideDeletedPostsButton .BigButtonText').text('Hide Deleted Posts');
       l_ImageURL = JS_DIR_IMAGES + 'global/general/minus.gif';
   }
   var l_ExpireDate = new Date;
   l_ExpireDate.setFullYear(l_ExpireDate.getFullYear() + 10);
   SetCookie(l_CookieName, $l_NewValue, l_ExpireDate.toUTCString());
   $('.ToggleDeletedPostImage').css('background-image', 'url(' + l_ImageURL + ')');
   return;
}

function CheckInputRegistration($a_Element) {
   l_Pattern = /^[ 0-9a-zA-Z-]+$/;
   if ($a_Element.name == 'housenr') {
       l_Pattern = /^[ 0-9a-zA-Z-\/]+$/;
   } else if ($a_Element.name == 'zip') {
       l_Pattern = /^[ 0-9a-zA-Z]+$/;
   }
   if ($a_Element.value.match(l_Pattern) != null || $a_Element.value == '') {
       $a_Element.style.backgroundColor = '';
   } else {
       $a_Element.style.backgroundColor = '#FF0000';
   }
   return;
}

function MouseOverBigButton(source) {
    var firstChild = $(source).children().first();
    if (firstChild.length) {
        firstChild.css('visibility', 'visible');
    }
}
function MouseOutBigButton(source) {
    var firstChild = $(source).children().first();
    if (firstChild.length) {
        firstChild.css('visibility', 'hidden');
    }
}

 function CopyContentOfFormInput(a_SourceID, a_FormInputID) {
    $("#" + a_SourceID).click(function () {
       $("#" + a_FormInputID).select();
       document.execCommand("copy");
    });
    $("#" + a_FormInputID).click(function () {
       $(this).select();
    });
 }

 function CopyTextOfElement(a_SourceID, a_ElementID) {
    $("#" + a_SourceID).click(function () {
       const elem = $("#" + a_ElementID);
       if (elem && elem[0]) {
          const text = $("#" + a_ElementID)[0].textContent;
          if (text) {
             const tempInput = document.createElement("input");
             tempInput.style = "position: absolute; left: -1000px; top: -1000px; opacity: 0;";
             tempInput.value = text;
             document.body.appendChild(tempInput);
             tempInput.select();
             document.execCommand("copy");
             document.body.removeChild(tempInput);
             $(this).focus();
          }
       }
    });
 }

 function toRomanNumeral(a_Number) {
    if (isNaN(a_Number)) {
       return a_Number;
    }
    const digits = String(+a_Number).split("");
    const key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM", "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC", "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"];
    let roman = "";
    let i = 3;
    while (i--) {
       roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    }
    return Array(+digits.join("") + 1).join("M") + roman;
 }

 function DeactivateHelperDiv() {
    $('#HelperDivContainer').hide();
}

function ShowHelperDiv(a_ID) {
    document.getElementById(a_ID).style.visibility = 'visible';
    document.getElementById(a_ID).style.display = 'block';
}
function HideHelperDiv(a_ID) {
    document.getElementById(a_ID).style.visibility = 'hidden';
    document.getElementById(a_ID).style.display = 'none';
}

/*!
* AJAX library of CipSoft GmbH
* http://www.cipsoft.com
*
* requires jQuery library
* http://jquery.com/
*
* modified version 3
*/
$(document).ready(function() {
   $('document').on('mouseover', 'body', function(event) {
       g_Event = event.originalEvent;
   });
   jQuery.ajaxSetup({
       beforeSend: function(a_XHR) {},
       cache: false
   });
   var l_DefaultConfig = {
       Target: null,
       Error: null
   };
   if (window.g_AjaxConfig === undefined) {
       g_AjaxConfig = l_DefaultConfig;
   } else {
       for (var l_Index in l_DefaultConfig) {
           if (g_AjaxConfig[l_Index] === undefined) {
               g_AjaxConfig[l_Index] = l_DefaultConfig[l_Index];
           }
       }
   }
   if (window.g_AjaxDefaultTarget === undefined) {
       g_AjaxDefaultTarget = null;
   }
   if (window.g_UseAjaxAttributes === undefined) {
       g_UseAjaxAttributes = false;
   }
   $('body').on('click.AjaxCip', 'a[ajaxcip=true]', function(event) {
       var l_Request = new AjaxCipRequest(event.currentTarget);
       l_Request.send();
       event.preventDefault();
   });
   $('body').on('mousedown.AjaxCip', 'a[ajaxcip=true]', function(event) {
       if (event.which == 2) {
           event.target.href += location.hash;
       }
   });
   g_LastHash = location.hash;
   setInterval(function() {
       if (location.hash != g_LastHash) {
           g_LastHash = location.hash;
       }
   }, 1000);
});
function SendAjaxCip(a_Parameters, a_Options) {
   var l_Target = document;
   if (l_Target.attributes === null) {
       l_Target = document.body;
   }
   try {
       l_Target = g_Event.target;
   } catch (e) {}
   var l_Request = new AjaxCipRequest(l_Target,a_Parameters,a_Options);
   l_Request.send();
   return l_Request;
}
AjaxCipParameters = function() {}
;
AjaxCipParameters.prototype = {
   initializeParameters: function() {
       this.m_Parameters = {};
       this.m_Parameters.DataType = null;
       this.m_Parameters.Target = null;
       this.m_Parameters.UpdateType = 0;
       this.m_Parameters.CreateHistoryEntry = null;
       this.m_Parameters.Template = null;
   },
   setParameters: function(a_Parameters) {
       if (a_Parameters !== undefined) {
           if (typeof (a_Parameters) == 'object') {
               for (var l_Index in a_Parameters) {
                   if (typeof (a_Parameters[l_Index]) == 'string' || typeof (a_Parameters[l_Index]) == 'number' || typeof (a_Parameters[l_Index]) == 'boolean') {
                       switch (l_Index) {
                       case 'DataType':
                       case 'Target':
                       case 'UpdateType':
                       case 'CreateHistoryEntry':
                       case 'Template':
                       case 'Errors':
                           this.m_Parameters[l_Index] = a_Parameters[l_Index];
                           break;
                       }
                   }
               }
           }
       }
   }
};
AjaxCipRequest = function(a_Element, a_Parameters, a_Options) {
   this.m_AttributeLabels = {
       Parameters: {
           'ajaxcip_datatype': 'DataType',
           'ajaxcip_target': 'Target',
           'ajaxcip_updatetype': 'UpdateType',
           'ajaxcip_createhistoryentry': 'CreateHistoryEntry'
       },
       Options: {
           'ajaxcip_link': 'Link',
           'ajaxcip_method': 'Method',
           'ajaxcip_href': 'Href',
           'ajaxcip_postdata': 'PostData',
           'ajaxcip_error': 'Error',
           'ajaxcip_beforesend': 'BeforeSend',
           'ajaxcip_aftersend': 'AfterSend',
           'ajaxcip_beforesuccess': 'BeforeSuccess',
           'ajaxcip_aftersuccess': 'AfterSuccess',
           'ajaxcip_beforehandle': 'BeforeHandle',
           'ajaxcip_afterhandle': 'AfterHandle',
           'ajaxcip_beforecomplete': 'BeforeComplete',
           'ajaxcip_aftercomplete': 'AfterComplete'
       }
   };
   this.m_Options = {};
   this.m_Element = a_Element;
   this.initializeOptions();
   this.m_Options.Href = $(this.m_Element).attr('href');
   if ($(this.m_Element).attr('type') == 'submit') {
       this.initializeByForm();
   }
   this.initializeParameters();
   this.setOptions({
       Error: g_AjaxConfig.Error
   });
   this.setOptions(this.getAttributeOptions());
   this.setOptions(a_Options);
   this.setParameters({
       Target: g_AjaxConfig.Target
   });
   this.setParameters(this.getAttributeParameters());
   if (a_Parameters !== undefined) {
       this.setParameters(a_Parameters);
   }
   this.prepareEvents();
   this.m_Response = {};
   this.parentNode = this.m_Element;
}
;
AjaxCipRequest.prototype = {
   initializeOptions: function() {
       this.m_Options.Link = null;
       this.m_Options.Method = 'GET';
       this.m_Options.Href = '';
       this.m_Options.PostData = '';
       this.m_Options.BeforeSend = '';
       this.m_Options.AfterSend = '';
       this.m_Options.BeforeSuccess = '';
       this.m_Options.AfterSuccess = '';
       this.m_Options.BeforeHandle = '';
       this.m_Options.AfterHandle = '';
       this.m_Options.BeforeComplete = '';
       this.m_Options.AfterComplete = '';
   },
   prepareEvents: function() {
       var l_EventHandler = function(a_Event, a_Handler, a_Data) {
           try {
               if (typeof (a_Handler) == 'function') {
                   var l_Params = [];
                   for (var i in a_Data) {
                       l_Params.push('a_Data[' + i + ']');
                   }
                   return eval('a_Handler(a_Event, ' + l_Params.join(',') + ');');
               } else if (typeof (a_Handler) == 'string') {
                   return eval(a_Handler);
               }
           } catch (e) {}
       };
       if (this.m_Options.BeforeSend !== '') {
           $(this).bind('AjaxCipBeforeSend', l_EventHandler);
       }
       if (this.m_Options.AfterSend !== '') {
           $(this).bind('AjaxCipAfterSend', l_EventHandler);
       }
       if (this.m_Options.BeforeSuccess !== '') {
           $(this).bind('AjaxCipBeforeSuccess', l_EventHandler);
       }
       if (this.m_Options.AfterSuccess !== '') {
           $(this).bind('AjaxCipAfterSuccess', l_EventHandler);
       }
       if (this.m_Options.BeforeHandle !== '') {
           $(this).bind('AjaxCipBeforeHandle', l_EventHandler);
       }
       if (this.m_Options.AfterHandle !== '') {
           $(this).bind('AjaxCipAfterHandle', l_EventHandler);
       }
       if (this.m_Options.BeforeComplete !== '') {
           $(this).bind('AjaxCipBeforeComplete', l_EventHandler);
       }
       if (this.m_Options.AfterComplete !== '') {
           $(this).bind('AjaxCipAfterComplete', l_EventHandler);
       }
   },
   initializeByForm: function() {
       if (this.m_Element.form) {
           this.m_Form = this.m_Element.form;
       } else if ($(this.m_Element).parents('form').length > 0) {
           this.m_Form = $(this.m_Element).parents('form')[0];
       } else {
           return false;
       }
       this.setOptions({
           Method: this.m_Form.method.toUpperCase()
       });
       if (this.m_Options.Href == '' || typeof this.m_Options.Href == 'undefined') {
           this.setOptions({
               Href: $(this.m_Form).attr('action')
           });
       }
       if (this.m_Options.Method.toUpperCase() == 'GET') {
           var l_HrefParts = this.m_Options.Href.split('#');
           l_HrefParts[0] += '&amp;' + $(this.m_Form).serialize();
           this.m_Options.Href = l_HrefParts.join('#');
       } else if (this.m_Options.Method.toUpperCase() == 'POST') {
           this.m_Options.PostData = $(this.m_Form).serialize();
       }
   },
   getAttributeParameters: function() {
       var l_Parameters = {};
       for (var l_Index in this.m_AttributeLabels.Parameters) {
           var l_Value = $(this.m_Element).attr(l_Index);
           if (l_Value !== undefined) {
               l_Parameters[this.m_AttributeLabels.Parameters[l_Index]] = l_Value;
           }
       }
       return l_Parameters;
   },
   getAttributeOptions: function() {
       var l_Options = {};
       for (var l_Index in this.m_AttributeLabels.Options) {
           var l_Value = $(this.m_Element).attr(l_Index);
           if (l_Value !== undefined) {
               l_Options[this.m_AttributeLabels.Options[l_Index]] = l_Value;
           }
       }
       return l_Options;
   },
   setOptions: function(a_Options) {
       if (a_Options !== undefined) {
           if (typeof (a_Options) == 'object') {
               for (var l_Index in a_Options) {
                   switch (l_Index) {
                   case 'Link':
                   case 'Method':
                   case 'Href':
                   case 'Error':
                       if (typeof (a_Options[l_Index]) == 'string' || typeof (a_Options[l_Index]) == 'number' || typeof (a_Options[l_Index]) == 'boolean') {
                           this.m_Options[l_Index] = a_Options[l_Index];
                       }
                       break;
                   case 'BeforeSend':
                   case 'AfterSend':
                   case 'BeforeSuccess':
                   case 'AfterSuccess':
                   case 'BeforeHandle':
                   case 'AfterHandle':
                   case 'BeforeComplete':
                   case 'AfterComplete':
                       if (typeof (a_Options[l_Index]) == 'string' || typeof (a_Options[l_Index]) == 'function') {
                           this.m_Options[l_Index] = a_Options[l_Index];
                       }
                       break;
                   case 'PostData':
                       if (typeof (a_Options[l_Index]) == 'string') {
                           if (this.m_Options[l_Index] == '') {
                               this.m_Options[l_Index] = a_Options[l_Index];
                           } else {
                               this.m_Options[l_Index] += '&' + a_Options[l_Index];
                           }
                       }
                       break;
                   }
               }
           }
       }
   },
   send: function() {
       $(this).trigger('AjaxCipBeforeSend', [this.m_Options.BeforeSend, [this]]);
       var l_AjaxOptions = {
           url: this.m_Options.Href,
           success: function(a_Data, a_Status, a_XHR) {
               $(this).trigger('AjaxCipBeforeSuccess', [this.m_Options.BeforeSuccess, [a_Data, a_Status, a_XHR, this]]);
               this.m_Response = new AjaxCipResponse(this,a_XHR,a_Status);
               this.m_Response.handleResponse();
               AjaxCipBrowserHistory.createHistoryEntry(this);
               $(this).trigger('AjaxCipAfterSuccess', [this.m_Options.AfterSuccess, [a_Data, a_Status, a_XHR, this]]);
           },
           beforeSend: function(a_XHR) {
               $(this).trigger('AjaxCipAfterSend', [this.m_Options.AfterSend, [a_XHR, this]]);
           },
           error: function(a_XHR, a_Status, a_Error) {
               if (typeof (this.m_Options.Error) == 'string' && typeof (window[this.m_Options.Error]) == 'function') {
                   window[this.m_Options.Error](a_XHR, a_Status, [a_Error]);
               }
           },
           complete: function(a_XHR, a_Status) {
               $(this).trigger('AjaxCipBeforeComplete', [this.m_Options.BeforeComplete, [a_XHR, a_Status, this]]);
               $(this).trigger('AjaxCipAfterComplete', [this.m_Options.AfterComplete, [a_XHR, a_Status, this]]);
           },
           dataFilter: function(data, type) {
               return data;
           },
           currentRequest: this,
           context: this,
           type: this.m_Options.Method
       };
       if (this.m_Options.Method.toUpperCase() == 'POST') {
           l_AjaxOptions.data = this.m_Options.PostData;
       }
       jQuery.ajax(l_AjaxOptions);
   }
};
Extend(AjaxCipRequest, AjaxCipParameters);
AjaxCipResponse = function(a_Request, a_XHR, a_TextStatus) {
   this.m_Request = a_Request;
   this.m_XHR = a_XHR;
   this.m_TextStatus = a_TextStatus;
   this.m_ResponseType = this.getResponseType();
   var l_TempRequests = this.getResponseHeader('X-Ajax-Cip-Requests');
   this.m_Requests = (l_TempRequests !== null) ? l_TempRequests.split('#') : null;
   this.m_Data = this.m_XHR.responseText;
   this.initializeParameters();
   this.setParameters(this.m_Request.m_Parameters);
   this.parentNode = this.m_Request;
}
;
AjaxCipResponse.prototype = {
   getResponseType: function() {
       var l_ResponseType = this.getResponseHeader('X-Ajax-Cip-Response-Type');
       if (l_ResponseType === null) {
           if (this.getResponseHeader('Content-Type') == 'application/json' || jQuery.trim(this.m_XHR.responseText).search(/^[{\[]/) !== -1) {
               try {
                   var l_Object = jQuery.parseJSON(this.m_XHR.responseText);
                   if (l_Object.AjaxObjects) {
                       l_ResponseType = 'Container';
                   } else {
                       l_ResponseType = 'Single';
                   }
               } catch (e) {}
           } else {
               l_ResponseType = 'Raw';
           }
       }
       return l_ResponseType;
   },
   getRequests: function() {
       var l_Requests = this.getResponseHeader('X-Ajax-Cip-Requests');
       if (l_Requests === null && (this.m_RequestType == 'Single' || this.m_RequestType == 'Container')) {
           var l_Object = jQuery.parseJSON(this.m_XHR.responseText);
           if (l_Object.Requests) {
               l_Requests = l_Object.Requests;
           }
       }
       return l_Requests;
   },
   handleResponse: function() {
       $(this).trigger('AjaxCipBeforeHandle', [this.m_Request.m_Options.BeforeHandle, [this]]);
       if (this.m_Requests !== null && this.m_Requests.length > 0) {
           for (var i = 0; i < this.m_Requests.length; i++) {
               SendAjaxCip({}, {
                   'Href': this.m_Requests[i]
               });
           }
       }
       if (this.m_ResponseType == 'Raw' || this.m_ResponseType === null) {
           this.setParameters({
               DataType: this.getResponseHeader('X-Ajax-Cip-Data-Type'),
               Target: this.getResponseHeader('X-Ajax-Cip-Target'),
               UpdateType: this.getResponseHeader('X-Ajax-Cip-Update-Type'),
               CreateHistoryEntry: this.getResponseHeader('X-Ajax-Cip-Create-HistoryEntry')
           });
       } else if (this.m_ResponseType == 'Single') {
           var l_AjaxObject = {};
           if (typeof (this.m_Data) == 'string') {
               l_AjaxObject = jQuery.parseJSON(this.m_Data);
           } else {
               l_AjaxObject = this.m_Data;
           }
           this.setParameters(l_AjaxObject);
           this.m_Data = l_AjaxObject.Data;
           if (l_AjaxObject.Errors) {
               this.handleErrors(l_AjaxObject.Errors);
           }
       } else if (this.m_ResponseType == 'Container') {
           this.m_Container = jQuery.parseJSON(this.m_Data);
           if (this.m_Container.Errors) {
               this.handleErrors(this.m_Container.Errors);
           }
       }
       if (this.m_ResponseType == 'Container') {
           for (var i in this.m_Container.AjaxObjects) {
               var l_Response = new AjaxCipResponse(this.m_Request,this.m_XHR,this.m_TextStatus);
               l_Response.m_Requests = null;
               l_Response.m_ResponseType = 'Single';
               l_Response.m_Data = this.m_Container.AjaxObjects[i];
               l_Response.handleResponse();
           }
       } else {
           if (this.m_Data !== null) {
               switch (this.m_Parameters.DataType) {
               case 'HTML':
               case null:
                   if (this.m_Parameters.Target !== null) {
                       if (this.m_Parameters.CreateHistoryEntry === 'true' || this.m_Parameters.CreateHistoryEntry === true) {
                           AjaxCipComponentHistoryContainer.add($(this.m_Parameters.Target));
                           AjaxCipBrowserHistory.registerRequestElement(this.m_Request, $(this.m_Parameters.Target));
                       }
                       this.handleHTML();
                   } else {}
                   break;
               case 'Attributes':
                   if (this.m_Parameters.Target !== null) {
                       if (this.m_Parameters.CreateHistoryEntry === 'true' || this.m_Parameters.CreateHistoryEntry === true) {
                           AjaxCipComponentHistoryContainer.add($(this.m_Parameters.Target));
                           AjaxCipBrowserHistory.registerRequestElement(this.m_Request, $(this.m_Parameters.Target));
                       }
                       this.handleAttributes();
                   } else {}
                   break;
               case 'CSS':
                   this.handleCSS();
                   break;
               case 'JavaScript':
                   try {
                       this.handleJavaScript();
                   } catch (e) {
                       console.log(e);
                   }
                   break;
               case 'Template':
                   if (this.m_Parameters.Target !== null && this.m_Parameters.Template !== null) {
                       if (this.m_Parameters.CreateHistoryEntry === 'true' || this.m_Parameters.CreateHistoryEntry === true) {
                           AjaxCipComponentHistoryContainer.add($(this.m_Parameters.Target));
                           AjaxCipBrowserHistory.registerRequestElement(this.m_Request, $(this.m_Parameters.Target));
                       }
                       this.handleTemplate();
                   } else {}
                   break;
               }
           }
       }
       $(this).trigger('AjaxCipAfterHandle', [this.m_Request.m_Options.AfterHandle, [this]]);
   },
   handleErrors: function(a_Errors) {
       window[this.m_Request.m_Options.Error](this.m_XHR, 'AjaxCipErrors', a_Errors);
   },
   getResponseHeader: function(a_Header) {
       var l_HeaderValue = this.m_XHR.getResponseHeader(a_Header);
       return l_HeaderValue;
   }
};
Extend(AjaxCipResponse, AjaxCipParameters);
function MyGetResponseHeader(a_Header) {
   var l_AllResponseHeaders = this.getAllResponseHeaders();
   if (l_AllResponseHeaders.search(new RegExp(a_Header)) === -1) {
       return null;
   }
   var l_HeaderValue = this.oldGetResponseHeader(a_Header);
   return l_HeaderValue;
}
AjaxCipHistoryComponent = function(a_TargetId, a_MaxEntries) {
   if (!a_TargetId || typeof (a_TargetId) != 'string' || this.exists()) {
       throw 'ParameterError';
   }
   this.m_TargetId = a_TargetId;
   this.m_Target = $('#' + a_TargetId);
   this.m_Entries = [];
   if (typeof (a_MaxEntries) != 'undefined' && isNaN(a_MaxEntries)) {
       this.setMaxEntries(a_MaxEntries);
   } else {
       this.m_MaxEntries = 10;
   }
   this.m_CurrentIndex = 0;
   this.parentNode = this.m_Target[0];
}
;
AjaxCipHistoryComponent.prototype = {
   exists: function(a_TargetId) {
       var l_TargetId = '';
       if (this.m_TargetId) {
           l_TargetId = this.m_TargetId;
       } else {
           l_TargetId = a_TargetId;
       }
       if ($('#' + l_TargetId).length === 0) {
           return false;
       } else {
           return true;
       }
   },
   add: function() {
       $(this).trigger('BeforeAddHistoryComponentEntry');
       if (!this.exists()) {
           throw 'ElementNotExistsError';
       }
       this.m_Target = $('#' + this.m_TargetId);
       if ((this.m_Entries.length) === this.m_MaxEntries) {
           this.m_Entries.splice(0, 1);
       } else {
           ++this.m_CurrentIndex;
       }
       var l_Factor = 0;
       if (this.m_Entries[this.m_CurrentIndex]) {
           this.m_Entries.splice(this.m_CurrentIndex, this.m_Entries.length - this.m_CurrentIndex);
           for (var i in this.m_Entries) {
               $(this.m_Entries[i]).remove();
               delete this.m_Entries[i];
           }
           l_Factor = -1;
       }
       this.m_Entries[this.m_Entries.length + l_Factor] = this.m_Target.realClone(true);
       $.cleanCache();
       $(this).trigger('AfterAddHistoryComponentEntry');
   },
   back: function() {
       $(this).trigger('BeforeBackHistoryComponentEntry');
       if (!this.exists()) {
           throw 'ElementNotExistsError';
       }
       this.m_Target = $('#' + this.m_TargetId);
       if (!this.m_Entries[this.m_CurrentIndex - 1]) {
           return false;
       }
       $(this.m_Entries[this.m_CurrentIndex]).remove();
       this.m_Entries[this.m_CurrentIndex] = this.m_Target.realClone(true);
       --this.m_CurrentIndex;
       var l_NewTarget = $(this.m_Entries[this.m_CurrentIndex]).realClone(true);
       this.m_Target.replaceWith(l_NewTarget);
       $.cleanCache();
       $(this).trigger('AfterBackHistoryComponentEntry');
   },
   forward: function() {
       $(this).trigger('BeforeForwardHistoryComponentEntry');
       if (!this.exists()) {
           throw 'ElementNotExistsError';
       }
       this.m_Target = $('#' + this.m_TargetId);
       if (this.m_Entries[this.m_CurrentIndex + 1] === undefined) {
           return false;
       }
       $(this.m_Entries[this.m_CurrentIndex]).remove();
       this.m_Entries[this.m_CurrentIndex] = this.m_Target.realClone(true);
       ++this.m_CurrentIndex;
       var l_NewTarget = $(this.m_Entries[this.m_CurrentIndex]).realClone(true);
       this.m_Target.replaceWith(l_NewTarget);
       $.cleanCache();
       $(this).trigger('AfterForwardHistoryComponentEntry');
   },
   jump: function(a_Index) {
       $(this).trigger('BeforeJumpHistoryComponentEntry');
       if (!this.exists()) {
           throw 'ElementNotExistsError';
       }
       this.m_Target = $('#' + this.m_TargetId);
       if (this.m_Entries[a_Index] === undefined) {
           return false;
       }
       $(this.m_Entries[this.m_CurrentIndex]).remove();
       this.m_Entries[this.m_CurrentIndex] = this.m_Target.realClone(true);
       this.m_CurrentIndex = a_Index;
       var l_NewTarget = $(this.m_Entries[this.m_CurrentIndex]).realClone(true);
       this.m_Target.replaceWith(l_NewTarget);
       $.cleanCache();
       $(this).trigger('AfterJumpHistoryComponentEntry');
   },
   clear: function() {
       $(this).trigger('BeforeClearHistoryComponentEntry');
       this.m_CurrentIndex = 0;
       for (var i in this.m_Entries) {
           $(this.m_Entries[i]).remove();
       }
       this.m_Entries = [];
       $(this).trigger('AfterClearHistoryComponentEntry');
   },
   setMaxEntries: function(a_MaxEntries) {
       if (typeof (a_MaxEntries) == 'number') {
           this.m_MaxEntries = a_MaxEntries;
           if (this.m_Entries.length > this.m_MaxEntries) {
               this.m_Entries.splice(0, this.m_Entries.length - this.m_MaxEntries);
           }
       }
   }
};
AjaxCipComponentHistoryContainer = new (function() {
   this.m_MaxComponentEntries = 10;
   this.m_MaxEntries = 10;
   this.m_CurrentIndex = -1;
   this.m_GlobalHistory = [];
   this.m_Components = {};
   this.ownerDocument = document;
   this.add = function(a_ElementOrId) {
       try {
           var l_TargetId = this.getId(a_ElementOrId);
           this.addContainerEntry(l_TargetId, 'add');
           if (!this.m_Components[l_TargetId]) {
               this.m_Components[l_TargetId] = new AjaxCipHistoryComponent(l_TargetId,this.m_MaxComponentEntries);
               this.setMaxEntries(this.m_MaxComponentEntries);
           }
           this.m_Components[l_TargetId].add();
       } catch (e) {
           switch (e) {
           case 'NoId':
               break;
           }
           if (typeof (g_Error) == 'undefined') {
               g_Error = [];
           }
           g_Error.push(e);
       }
   }
   ;
   this.back = function(a_ElementOrId) {
       try {
           var l_TargetId = this.getId(a_ElementOrId);
           this.addContainerEntry(l_TargetId, 'back');
           if (!this.m_Components[l_TargetId]) {
               throw 'NoComponentHistory';
           }
           this.m_Components[l_TargetId].back();
       } catch (e) {
           switch (e) {
           case 'NoId':
               break;
           case 'NoComponentHistory':
               break;
           }
           if (typeof (g_Error) == 'undefined') {
               g_Error = [];
           }
           g_Error.push(e);
       }
   }
   ;
   this.forward = function(a_ElementOrId) {
       try {
           var l_TargetId = this.getId(a_ElementOrId);
           this.addContainerEntry(l_TargetId, 'forward');
           if (!this.m_Components[l_TargetId]) {
               throw 'NoComponentHistory';
           }
           this.m_Components[l_TargetId].forward();
       } catch (e) {
           switch (e) {
           case 'NoId':
               break;
           case 'NoComponentHistory':
               break;
           }
           if (typeof (g_Error) == 'undefined') {
               g_Error = [];
           }
           g_Error.push(e);
       }
   }
   ;
   this.jump = function(a_ElementOrId, a_Index) {
       try {
           var l_TargetId = this.getId(a_ElementOrId);
           this.addContainerEntry(l_TargetId, 'jump', this.m_Components[l_TargetId].m_CurrentIndex, a_Index);
           if (!this.m_Components[l_TargetId]) {
               throw 'NoComponentHistory';
           }
           this.m_Components[l_TargetId].jump(a_Index);
       } catch (e) {
           switch (e) {
           case 'NoId':
               break;
           case 'NoComponentHistory':
               break;
           }
       }
   }
   ;
   this.clear = function(a_ElementOrId) {
       try {
           var l_TargetId = this.getId(a_ElementOrId);
           if (!this.m_Components[l_TargetId]) {
               throw 'NoComponentHistory';
           }
           this.m_Components[l_TargetId].clear();
           for (var i = 0; i < this.m_GlobalHistory.length; i++) {
               if (this.m_GlobalHistory[i].TargetId == l_TargetId) {
                   this.m_GlobalHistory.splice(i, 1);
                   --i;
                   if (i < this.m_CurrentIndex) {
                       --this.m_CurrentIndex;
                   }
               }
           }
       } catch (e) {
           switch (e) {
           case 'NoId':
               break;
           case 'NoComponentHistory':
               break;
           }
       }
   }
   ;
   this.addContainerEntry = function(a_TargetId, a_Operation, a_IndexFrom, a_IndexTo) {
       $(this).trigger('BeforeAddComponentHistoryContainerEntry');
       if ((this.m_GlobalHistory.length + 1) === this.m_MaxEntries) {
           this.m_GlobalHistory.splice(0, 1);
       } else {
           ++this.m_CurrentIndex;
       }
       if (a_Operation == 'add' || a_Operation == 'back' || a_Operation == 'forward') {
           this.m_GlobalHistory.push({
               'TargetId': a_TargetId,
               'Operation': a_Operation
           });
       } else if (a_Operation == 'jump') {
           this.m_GlobalHistory.push({
               'TargetId': a_TargetId,
               'Operation': a_Operation,
               'IndexFrom': a_IndexFrom,
               'IndexTo': a_IndexTo
           });
       }
       if (this.m_GlobalHistory[this.m_CurrentIndex + 1]) {
           this.m_GlobalHistory.splice(this.m_CurrentIndex + 1, this.m_GlobalHistory.length - this.m_CurrentIndex + 1);
       }
       $(this).trigger('AfterAddComponentHistoryContainerEntry');
   }
   ;
   this.backContainer = function() {
       $(this).trigger('BeforeBackComponentHistoryContainerEntry');
       if (!this.m_GlobalHistory[this.m_CurrentIndex]) {
           return false;
       }
       var l_OperationObj = this.m_GlobalHistory[this.m_CurrentIndex];
       try {
           switch (l_OperationObj.Operation) {
           case 'add':
           case 'forward':
               this.m_Components[l_OperationObj.TargetId].back();
               break;
           case 'back':
               this.m_Components[l_OperationObj.TargetId].forward();
               break;
           case 'jump':
               this.m_Components[l_OperationObj.TargetId].jump(l_OperationObj.IndexFrom);
               break;
           }
           --this.m_CurrentIndex;
       } catch (e) {
           if (typeof (g_Error) == 'undefined') {
               g_Error = [];
           }
           g_Error.push(e);
           this.m_GlobalHistory.splice(this.m_CurrentIndex, 1);
           if (this.m_GlobalHistory.length > 0) {
               this.backContainer();
           } else {
               return false;
           }
       }
       $(this).trigger('AfterAddComponentHistoryContainerEntry');
   }
   ;
   this.forwardContainer = function() {
       $(this).trigger('BeforeForwardComponentHistoryContainerEntry');
       if (!this.m_GlobalHistory[this.m_CurrentIndex + 1]) {
           return false;
       }
       ++this.m_CurrentIndex;
       var l_OperationObj = this.m_GlobalHistory[this.m_CurrentIndex];
       try {
           switch (l_OperationObj.Operation) {
           case 'add':
           case 'forward':
               this.m_Components[l_OperationObj.TargetId].forward();
               break;
           case 'back':
               this.m_Components[l_OperationObj.TargetId].back();
               break;
           case 'jump':
               this.m_Components[l_OperationObj.TargetId].jump(l_OperationObj.IndexTo);
               break;
           }
       } catch (e) {
           this.m_GlobalHistory.splice(this.m_CurrentIndex, 1);
           if (this.m_GlobalHistory.length > this.m_CurrentIndex) {
               this.forwardContainer();
           } else {
               return false;
           }
       }
       $(this).trigger('AfterAddComponentHistoryContainerEntry');
   }
   ;
   this.getId = function(a_ElementOrId) {
       if (typeof (a_ElementOrId) == 'string') {
           var l_Matches = /(^#?(\w+|-)+)/.exec(a_ElementOrId);
           var l_Id = '';
           if (l_Matches && l_Matches[1]) {
               return l_Matches[1];
           } else {
               throw 'NoId';
           }
       } else if (typeof (a_ElementOrId) == 'object' && $(a_ElementOrId).attr('id').length > 0) {
           return $(a_ElementOrId).attr('id');
       } else {
           throw 'NoId';
       }
   }
   ;
   this.setMaxEntries = function(a_MaxEntries) {
       this.m_MaxComponentEntries = a_MaxEntries;
       var l_ComponentCount = 0;
       for (var i in this.m_Components) {
           ++l_ComponentCount;
       }
       this.m_MaxEntries = l_ComponentCount * a_MaxEntries;
       if (typeof (a_MaxEntries) == 'number') {
           for (var i in this.m_Components) {
               this.m_Components[i].setMaxEntries(a_MaxEntries);
           }
       }
   }
   ;
}
)();
AjaxCipComponentHistoryContainer.prototype = {};
delete AjaxCipComponentHistoryContainer.prototype;
AjaxCipBrowserHistory = new (function() {
   this.registerRequestElement = function(a_Request, a_Element) {}
   ;
   this.createHistoryEntry = function(a_Request) {}
   ;
}
)();
AjaxCipBrowserHistory.prototype = {};
delete AjaxCipBrowserHistory.prototype;
var CipContentHandler = function(a_Data, a_Parameters) {
   this.m_Data = null;
   if (a_Data && a_Parameters) {
       this.init(a_Data, a_Parameters);
   } else if (a_Data) {
       this.init(a_Data);
   }
};
CipContentHandler.prototype = {
   init: function(a_Data, a_Parameters) {
       if (a_Data) {
           this.m_Data = a_Data;
       }
       if (a_Parameters) {
           this.setParameters(a_Parameters);
       }
   },
   handleHTML: function() {
       switch (parseInt(this.m_Parameters.UpdateType)) {
       case 0:
       case null:
           $(this.m_Parameters.Target).html(this.m_Data);
           break;
       case 1:
           $(this.m_Parameters.Target).replaceWith(this.m_Data);
           break;
       case 2:
           $(this.m_Parameters.Target).append(this.m_Data);
           break;
       case 3:
           $(this.m_Parameters.Target).after(this.m_Data);
           break;
       case 4:
           $(this.m_Parameters.Target).prepend(this.m_Data);
           break;
       case 5:
           $(this.m_Parameters.Target).before(this.m_Data);
           break;
       }
   },
   handleAttributes: function() {
       var l_Attributes = {};
       if (typeof (this.m_Data) == 'object') {
           l_Attributes = this.m_Data;
       } else if (typeof (this.m_Data) == 'string') {
           var l_AttributesArr = decodeURIComponent(this.m_Data).split('&');
           for (var i in l_AttributesArr) {
               var l_AttributeKeyValuePair = l_AttributesArr[i].split('=');
               l_Attributes[l_AttributeKeyValuePair[0]] = l_AttributeKeyValuePair[1];
           }
       }
       $(this.m_Parameters.Target).prop(l_Attributes);
   },
   handleCSS: function() {
       $('head').append('<style type="text/css" media="screen" rel="stylesheet" title="AjaxCipStyle_' + (new Date()).getTime() + '">' + this.m_Data + '</style>');
   },
   handleJavaScript: function() {
       jQuery.globalEval(this.m_Data);
   },
   handleTemplate: function() {
       var l_TemplateEngine = new TemplateEngine(this.m_Parameters.Template);
       this.m_Data = l_TemplateEngine.fillTemplate(this.m_Data);
       this.handleHTML();
   }
};
Extend(CipContentHandler, AjaxCipParameters);
Extend(AjaxCipResponse, CipContentHandler);
function Extend(a_TargetClass, a_SourceClass) {
   var l_SourceClass = {};
   if (a_SourceClass.prototype) {
       l_SourceClass = new a_SourceClass();
   } else {
       l_SourceClass = a_SourceClass;
   }
   for (var i in l_SourceClass) {
       try {
           if (a_TargetClass.prototype) {
               a_TargetClass.prototype[i] = l_SourceClass[i];
           } else {
               a_TargetClass[i] = l_SourceClass[i];
           }
       } catch (e) {
           var err = e;
       }
   }
}
(function($, window) {
   $.cleanCache = function() {
       for (var i in $.cache) {
           if ($.isEmptyObject($.cache[i])) {
               delete $.cache[i];
           }
       }
   }
   ;
}
)(jQuery, this);
(function($) {
   $.fn.realClone = function(a_WithEvents) {
       if (a_WithEvents !== true) {
           a_WithEvents = false;
       }
       var l_Clone = this.clone(a_WithEvents);
       var l_ClonedSelects = l_Clone.find('select');
       var l_OriginalSelects = this.find('select');
       for (var i in l_OriginalSelects) {
           l_ClonedSelects[i].selectedIndex = l_OriginalSelects[i].selectedIndex;
       }
       var l_ClonedTextareas = l_Clone.find('textarea');
       var l_OriginalTextareas = this.find('textarea');
       for (var i in l_OriginalTextareas) {
           l_ClonedTextareas[i].value = l_OriginalTextareas[i].value;
       }
       return l_Clone;
   }
   ;
}
)(jQuery);
(function($) {
   $.fn.historyButtons = function(a_Id) {
       this.data('historyButtons', $.fn.historyButtons.DefaultSettings);
       if (typeof (a_Id) === 'undefined') {
           return this.each(function() {
               var $this = $(this);
               var l_Settings = $this.data('historyButtons');
               var updateButtons = function() {
                   if (AjaxCipComponentHistoryContainer.m_CurrentIndex === -1) {
                       $this.find('.' + l_Settings.Classes.ContainerBack).css('visibility', 'hidden');
                   } else {
                       $this.find('.' + l_Settings.Classes.ContainerBack).css('visibility', 'visible');
                   }
                   if (AjaxCipComponentHistoryContainer.m_CurrentIndex === AjaxCipComponentHistoryContainer.m_GlobalHistory.length - 1 || AjaxCipComponentHistoryContainer.m_GlobalHistory.length === 0) {
                       $this.find('.' + l_Settings.Classes.ContainerForward).css('visibility', 'hidden');
                   } else {
                       $this.find('.' + l_Settings.Classes.ContainerForward).css('visibility', 'visible');
                   }
               };
               updateButtons();
               $(document).bind('AfterAddComponentHistoryContainerEntry AfterBackComponentHistoryContainerEntry AfterForwardComponentHistoryContainerEntry', updateButtons);
               $this.find('.HistoryContainerBack').bind('click.historyButtons', function(a_Event) {
                   AjaxCipComponentHistoryContainer.backContainer();
                   updateButtons();
               });
               $this.find('.HistoryContainerForward').bind('click.historyButtons', function(a_Event) {
                   AjaxCipComponentHistoryContainer.forwardContainer();
                   updateButtons();
               });
           });
       } else if (typeof (a_Id) === 'string') {
           return this.each(function() {
               var $this = $(this);
               var l_Settings = $this.data('historyButtons');
               if (!AjaxCipComponentHistoryContainer.m_Components[a_Id]) {
                   AjaxCipComponentHistoryContainer.m_Components[a_Id] = new AjaxCipHistoryComponent(a_Id);
               }
               var l_Component = AjaxCipComponentHistoryContainer.m_Components[a_Id];
               var updateButtons = function() {
                   if (l_Component.m_CurrentIndex === 0) {
                       $this.find('.' + l_Settings.Classes.ComponentBack).css('visibility', 'hidden');
                   } else {
                       $this.find('.' + l_Settings.Classes.ComponentBack).css('visibility', 'visible');
                   }
                   if (l_Component.m_CurrentIndex >= l_Component.m_Entries.length - 1 || l_Component.m_Entries.length === 0) {
                       $this.find('.' + l_Settings.Classes.ComponentForward).css('visibility', 'hidden');
                   } else {
                       $this.find('.' + l_Settings.Classes.ComponentForward).css('visibility', 'visible');
                   }
               };
               updateButtons();
               $(l_Component).bind('AfterAddHistoryComponentEntry AfterBackHistoryComponentEntry AfterForwardHistoryComponentEntry AfterJumpHistoryComponentEntry AfterClearHistoryComponentEntry', updateButtons);
               $this.find('.HistoryComponentBack').bind('click.historyButtons', function(a_Event) {
                   AjaxCipComponentHistoryContainer.back(a_Id);
                   updateButtons();
               });
               $this.find('.HistoryComponentForward').bind('click.historyButtons', function(a_Event) {
                   AjaxCipComponentHistoryContainer.forward(a_Id);
                   updateButtons();
               });
           });
       } else {
           console.log('The argument have to be a string but it was ' + typeof (a_Id));
       }
   }
   ;
   $.fn.historyButtons.DefaultSettings = {
       Classes: {
           ContainerBack: 'HistoryContainerBack',
           ContainerForward: 'HistoryContainerForward',
           ComponentBack: 'HistoryComponentBack',
           ComponentForward: 'HistoryComponentForward'
       }
   };
}
)(jQuery);


var g_IsValidPW = null;
var g_CapsLockIsEnabled = null;
if (typeof document.msCapsLockWarningOff !== 'undefined') {
    document.msCapsLockWarningOff = true;
}
function AddCapsLockEventListeners() {
    $('input[type=password]').keyup(function(e) {
        ShowOrHideCapsLockWarning(e);
    });
    $('input[type=password]').focus(function(e) {
        ShowOrHideCapsLockWarning(e);
    });
    $('input[type=password]').blur(function(e) {
        HideCapsLockWarning();
    });
    $(document).keydown(function(e) {
        CheckForCapsLockItself(e);
    })
    $(document).keypress(function(e) {
        CheckPressedKey(e);
    })
}
function CheckForCapsLockItself(e) {
    e = e || event;
    if (e.keyCode == 20 && g_CapsLockIsEnabled !== null) {
        g_CapsLockIsEnabled = !g_CapsLockIsEnabled;
    }
}
function CheckPressedKey(e) {
    e = e || event;
    var chr = GetChar(e);
    if (!chr) {
        return;
    }
    if (chr.toLowerCase() == chr.toUpperCase()) {
        return;
    }
    g_CapsLockIsEnabled = (chr.toLowerCase() == chr && e.shiftKey) || (chr.toUpperCase() == chr && !e.shiftKey);
}
function GetChar(e) {
    if (e.which == null) {
        return String.fromCharCode(e.keyCode);
    }
    if (e.which != 0 && e.charCode != 0) {
        return String.fromCharCode(e.which);
    }
    return null;
}
function ShowOrHideCapsLockWarning() {
    if (g_CapsLockIsEnabled) {
        var l_PasswordFields = $('input[type=password]');
        var l_Top = ($(':focus').offset().top + 18);
        var l_Left = ($(':focus').offset().left + 18);
        $('#CapsLockWarning').css({
            top: l_Top,
            left: l_Left
        });
        $('#CapsLockWarning').show();
    } else {
        $('#CapsLockWarning').hide();
    }
}
function HideCapsLockWarning() {
    $('#CapsLockWarning').hide();
}
$(document).ready(function() {
    if (typeof LoadMobileCSS !== 'undefined' && LoadMobileCSS) {
        CheckForMobileAdjustments();
        $(window).resize(function() {
            CheckForMobileAdjustments();
        });
        $('#MobileShortMenuIcon').click(function() {
            $('#MobileMenuIcon').prop('checked', false);
        });
        $('#MobileMenuIcon').click(function() {
            $('#MobileShortMenuIcon').prop('checked', false);
        });
        $('#MobileShortMenuIcon, #MobileMenuIcon').change(function() {
            CheckForMenuPosition();
        });
    }
});
function CheckForMenuPosition() {
    if ($('#MobileMenuIcon').is(':checked')) {
        $('#MobileMenu').css('height', '100%');
        $('#MobileMenu').css('overflow-y', 'scroll');
    } else {
        $('#MobileMenu').css('height', '70px');
        $('#MobileMenu').css('overflow-y', 'unset');
    }
}
function CheckForMobileAdjustments() {
    if (window.matchMedia('(max-width: 768px)').matches) {
        if ($('.Content > #webshop').length > 0 && $('#HelperDivContainer').length > 0) {
            $('#HelperDivContainer').remove();
        }
        var AvailableScreenWidth = window.screen.availWidth;
        if (window.matchMedia("(orientation: landscape)").matches) {
            if (window.screen.availHeight > AvailableScreenWidth) {
                AvailableScreenWidth = window.screen.availHeight;
            }
        }
        var ImageSizeBuffer = 20;
        var TableSizeBuffer = 30;
        var TableEventCalenderBuffer = 40;
        var ObserverInputBuffer = 70;
        var ObserverInnerTableBuffer = ReportTableBuffer = 50;
        var ReportTableBufferForum = 57;
        var ForumImageBuffer = 62;
        var AuctionFilterTableBuffer = 67;
        $('.BoxContent img').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - ImageSizeBuffer));
        });
        $('#soundtrack .BoxContent .AudioAmbianceScreenshot').each(function() {
            $(this).css('max-width', parseInt($('.ControlPanelImage').css('width')) - 12);
        });
        $('.TableContainer .InnerTableContainer').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - TableSizeBuffer));
        });
        $('#soundtrack .TableContainer .InnerTableContainer').each(function() {
            $(this).css('overflow', 'clip');
        });
        $('.TableContainer .TableScrollbarWrapper').each(function() {
            $(this).css('width', ((AvailableScreenWidth) - TableSizeBuffer));
        });
        $(' #EventSchedule .TableContainer .InnerTableContainer').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - TableEventCalenderBuffer));
        });
        $('.ThreadReviewPosting img, .PostText img').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - ForumImageBuffer));
        });
        $('#ConnectTibiaObserver .TableContentContainer div').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - ObserverInnerTableBuffer));
        });
        $('#ConnectTibiaObserver #TibiaObserverTokenInput').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - ObserverInputBuffer));
        });
        $('#reason_description, #translation_input, #comment_input, #reasonid_select').each(function() {
            $(this).css('width', ((AvailableScreenWidth) - ReportTableBuffer));
        });
        $('.ForumReport').each(function() {
            $(this).css('width', ((AvailableScreenWidth) - ReportTableBufferForum));
        });
        $('#WheelOfDestinySelection > td:nth-child(2)').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - TableSizeBuffer));
        });
        $('.AuctionInputSearch, .AuctionFilterCategory').each(function() {
            $(this).css('width', ((AvailableScreenWidth) - AuctionFilterTableBuffer));
            if ($(this).hasClass('AuctionFilterCategory')) {
                $(this).css('width', parseInt($(this).css('width')) + 8);
            }
        });
        $('.InInputResetButton').each(function() {
            $(this).css('left', parseInt($('.AuctionInputSearch').css('width')) - parseInt($(this).css('width')) * 0.75);
        });
        $('.TableContainer').each(function() {
            var TableScrollbarWrapper = $(this).find('.TableScrollbarWrapper');
            var InnerTableContainer = $(this).find('.InnerTableContainer');
            var ScrollWidth = $(this).find('.InnerTableContainer')[0].scrollWidth;
            if (ScrollWidth > ((AvailableScreenWidth) - TableSizeBuffer)) {
                $(this).find('.TableScrollbarContainer').width(ScrollWidth);
                InnerTableContainer.css('margin-bottom', 5);
                TableScrollbarWrapper.css('display', 'block');
                TableScrollbarWrapper.scroll(function(Event) {
                    InnerTableContainer.scrollLeft(Event.target.scrollLeft);
                });
                InnerTableContainer.scroll(function(Event) {
                    TableScrollbarWrapper.scrollLeft(Event.target.scrollLeft);
                });
            } else {
                TableScrollbarWrapper.css('display', 'none');
                InnerTableContainer.css('margin-bottom', 0);
            }
        });
        var NewsImageBuffer = 20;
        var NewsTableBuffer = 20;
        $('.Content .NewsTable img').each(function() {
            $(this).removeAttr('width');
            $(this).removeAttr('height');
            $(this).removeAttr('vspace');
            $(this).removeAttr('hspace');
        });
        $('.Content .NewsTable img').each(function() {
            $(this).css('max-width', ((AvailableScreenWidth) - NewsImageBuffer));
        });
        $('.Content .NewsTable figure').each(function() {
            $(this).css('margin-left', 0);
        });
        $('.Content .NewsTable figure').each(function() {
            $(this).css('margin-right', 0);
        });
        $('.Content .NewsTable .NewsTableContainer table').each(function() {
            $(this).css('display', 'block');
        });
        $('.Content .NewsTable .NewsTableContainer table').each(function() {
            $(this).css('width', 'unset');
        });
        $('.Content .NewsTable .NewsTableContainer table').each(function() {
            $(this).css('height', 'unset');
        });
        $('.Content .NewsTable .NewsTableContainer table').each(function() {
            $(this).css('overflow-x', 'scroll');
        });
        $('.Content .NewsTable .NewsTableContainer table').each(function() {
            $(this).css('max-width', (AvailableScreenWidth) - NewsTableBuffer);
        });
    } else {
        $('.TableContainer .InnerTableContainer').each(function() {
            $(this).css('max-width', 'unset');
        });
        $('.TableContainer .TableScrollbarWrapper').each(function() {
            $(this).css('width', 'unset');
        });
        $('.PlayButton, .PauseButton').each(function() {
            $(this).css('left', '50%' - parseInt($(this).css('width')) * 0.5);
        });
    }
    return;
}
$(document).ready(function() {
    g_PasswordToolTipIsActive = 0;
    if ($('.PWStrengthContainer').length > 0) {
        g_PasswordToolTipIsActive = 1;
    }
    if ($('#password1').length > 0) {
        $("#password1").change(function() {
            CheckPasswordStrength($('#password1').val());
        });
        $("#password1").keyup(function() {
            CheckPasswordStrength($('#password1').val());
        });
        if ($('#password1').val().length > 0) {
            CheckPasswordStrength($('#password1').val());
        }
        $(".Themeboxes").css({
            zIndex: 10
        })
    }
});
function CheckPasswordStrength(a_Password) {
    if (a_Password.length > 0) {
        $('.PWStrengthToolTip').show();
        $('#password_errormessage .CanBeHiddenWhenToolTipIsOn').hide();
        $('.BoxInputText #password_errormessage').hide();
    }
    l_Feedback = 'very weak';
    l_CSSClass = 'PWStrengthIndicator';
    l_Warning = '';
    l_Suggestions = '';
    l_Result = {
        'score': 0,
        'feedback': {
            'warning': '',
            'suggestions': Array(0)
        }
    };
    g_IsValidPW = ValidatePassword(a_Password);
    if (g_IsValidPW && typeof zxcvbn === "function") {
        l_Result = zxcvbn(a_Password);
    }
    if (l_Result.score > 3) {
        l_Feedback = 'strong';
        l_CSSClass += ' PWStrengthLevel4';
    } else if (l_Result.score == 3) {
        l_Feedback = 'medium';
        l_CSSClass += ' PWStrengthLevel3';
    } else if (l_Result.score == 2) {
        l_Feedback = 'weak';
        l_CSSClass += ' PWStrengthLevel2';
    } else if (l_Result.score == 1) {
        l_Feedback = 'very weak';
        l_CSSClass += ' PWStrengthLevel1';
    } else {
        l_Feedback = 'very weak';
        l_CSSClass += ' PWStrengthLevel0';
    }
    $('.PWStrengthIndicator').text(l_Feedback);
    $('.PWStrengthIndicator').attr('class', l_CSSClass);
    $('.PWStrengthSuggestions').text(l_Suggestions);
    $('.PWStrengthWarning').text(l_Warning);
    if (l_Result.score <= 2) {
        if (l_Result.feedback.warning.length > 0) {
            l_Warning += l_Result.feedback.warning;
            $('.PWStrengthWarning').append('<div class="PWStrengthToolTipHeadline" >Warning</div>');
            $('.PWStrengthWarning').append('<div>' + l_Warning + '</div>');
        }
        if (l_Result.feedback.suggestions.length > 0) {
            $('.PWStrengthSuggestions').append('<div class="PWStrengthToolTipHeadline" >Tip</div>');
            for (var i = 0; i < l_Result.feedback.suggestions.length; i++) {
                $('.PWStrengthSuggestions').append('<div>' + l_Result.feedback.suggestions[i] + '</div>');
            }
        }
    }
    if (g_IsValidPW) {
        $('.PWStrengthToolTip').hide();
    }
}
function ValidatePassword(a_Password) {
    var l_ReturnValue = true;
    var PWRules = [[62, ((a_Password.length >= 30 || a_Password.length < 10) ? false : true)], [63, ((a_Password.match(/[^!-~]+/) !== null) ? false : true)], [65, ((a_Password.match(/^[A-Za-z]*$/) !== null) ? false : true)], [84, ((a_Password.match(/[a-z]/) === null) ? false : true)], [85, ((a_Password.match(/[A-Z]/) === null) ? false : true)], [86, ((a_Password.match(/[0-9]/) === null) ? false : true)]];
    for (var i = 0; i < PWRules.length; i++) {
        if (PWRules[i][1] == true) {
            $('#PWRule' + PWRules[i][0]).removeClass('InputIndicatorNotOK');
            $('#PWRule' + PWRules[i][0]).addClass('InputIndicatorOK');
        } else {
            l_ReturnValue = false;
            $('#PWRule' + PWRules[i][0]).addClass('InputIndicatorNotOK');
            $('#PWRule' + PWRules[i][0]).removeClass('InputIndicatorOK');
        }
    }
    return l_ReturnValue;
}
function SetCookie(a_Name, a_Value, a_ExpireDateUTCString) {
    var l_CookieExpireString = '';
    if (a_ExpireDateUTCString != false) {
        l_CookieExpireString += ' expires=' + a_ExpireDateUTCString + ';';
    }
    document.cookie = a_Name + '=' + encodeURIComponent(a_Value) + '; domain=' + JS_COOKIE_DOMAIN + '; SameSite=None; Secure;' + l_CookieExpireString + ' path=/;';
    return;
}
function GetCookieValue(a_Name) {
    var l_RequestedCookieValue = null;
    var l_ConsentCookieEQ = a_Name + '=';
    var l_AllCookies = document.cookie.split(';');
    for (var i = 0; i < l_AllCookies.length; i++) {
        var l_SingleCookie = l_AllCookies[i];
        while (l_SingleCookie.charAt(0) == ' ') {
            l_SingleCookie = l_SingleCookie.substring(1, l_SingleCookie.length);
        }
        if (l_SingleCookie.indexOf(l_ConsentCookieEQ) == 0) {
            l_RequestedCookieValue = decodeURIComponent(l_SingleCookie.substring(l_ConsentCookieEQ.length, l_SingleCookie.length));
            break;
        }
    }
    return l_RequestedCookieValue;
}
function HideCookieDialog() {
    $('#cookiedialogbox').hide();
}
function ShowCookieDialog() {
    $('#cookiedialogbox').show();
}
function HideCookieDetails() {
    $('#cookiedetailsbox').hide();
}
function ShowCookieDetails() {
    $('#cookiedetailsbox').show();
}
function SetConsentCookie(consent, acceptall) {
    var cc_advertising = false;
    var cc_social = false;
    if (consent == true) {
        if (acceptall == true) {
            cc_advertising = true;
            cc_social = true;
        } else {
            cc_advertising = $("#cc_advertising").is(':checked');
            cc_social = $('#cc_social').is(':checked');
        }
    }
    var settings = {
        consent: consent,
        advertising: cc_advertising,
        socialmedia: cc_social
    };
    SetCookie('CookieConsentPreferences', JSON.stringify(settings), GetConsentCookieExpireDateUTCString());
    location.reload();
}
function ProlongConsentCookie() {
    var l_ConsentCookie = GetCookieValue('CookieConsentPreferences');
    if (l_ConsentCookie != null) {
        SetCookie('CookieConsentPreferences', l_ConsentCookie, GetConsentCookieExpireDateUTCString());
        $('#cookiedialogbox').hide();
    }
}
function GetConsentCookieExpireDateUTCString() {
    var l_ExpireDate = new Date;
    l_ExpireDate.setFullYear(l_ExpireDate.getFullYear() + 1);
    return l_ExpireDate.toUTCString();
}
$(document).ready(function() {
    var l_CurrentDomain = window.location.host.toString();
    var l_CookieDomain = JS_COOKIE_DOMAIN;
    if ((l_CookieDomain.includes(l_CurrentDomain) == true) || (l_CurrentDomain.includes(l_CookieDomain) == true)) {
        ProlongConsentCookie();
    }
});
function FansiteFilterAction(a_Element) {
    if (a_Element == 'Language_All' || a_Element == 'SocialMedia_All' || a_Element == 'Content_All') {
        if ($('#' + a_Element).hasClass('FilterIsActive')) {
            return;
        }
    }
    if (a_Element == 'Language_All') {
        $('.FilterElementLanguage').addClass('FilterIsActive');
    } else if (a_Element == 'SocialMedia_All') {
        $('.FilterElementSocialMedia').addClass('FilterIsActive');
    } else if (a_Element == 'Content_All') {
        $('.FilterElementContent').addClass('FilterIsActive');
    }
    if ($('#' + a_Element).hasClass('FilterIsActive')) {
        $('#' + a_Element).removeClass('FilterIsActive');
    } else {
        $('#' + a_Element).addClass('FilterIsActive');
    }
    if ($('#' + a_Element).hasClass('FilterElementLanguage')) {
        $('.FilterLanguageAll').removeClass('FilterIsActive');
    } else if ($('#' + a_Element).hasClass('FilterElementSocialMedia')) {
        $('.FilterSocialMediaAll').removeClass('FilterIsActive');
    } else if ($('#' + a_Element).hasClass('FilterElementContent')) {
        $('.FilterContentAll').removeClass('FilterIsActive');
    }
    if ($('.FilterElementLanguage').hasClass('FilterIsActive') == false) {
        $('#Language_All').addClass('FilterIsActive');
    }
    if ($('.FilterElementSocialMedia').hasClass('FilterIsActive') == false) {
        $('#SocialMedia_All').addClass('FilterIsActive');
    }
    if ($('.FilterElementContent').hasClass('FilterIsActive') == false) {
        $('#Content_All').addClass('FilterIsActive');
    }
    var l_Filter = '';
    l_Filter = '.FilterElementLanguage.FilterIsActive';
    if ($('#Language_All').hasClass('FilterIsActive')) {
        l_Filter = '.FilterElementLanguage';
    }
    var l_ActiveLanguageList = $(l_Filter).not('.FilterAll').map(function() {
        return '.Filter' + $(this).attr('id');
    }).get().join(', ');
    var l_LanguageRows = $(l_ActiveLanguageList).map(function() {
        return '#' + $(this).attr('id');
    }).get();
    l_Filter = '.FilterElementSocialMedia.FilterIsActive';
    if ($('#SocialMedia_All').hasClass('FilterIsActive')) {
        l_Filter = '.FilterElementLanguage';
    }
    var l_ActiveSocialMediaList = $(l_Filter).not('.FilterAll').map(function() {
        return '.Filter' + $(this).attr('id');
    }).get().join(', ');
    var l_SocialMediaRows = $(l_ActiveSocialMediaList).map(function() {
        return '#' + $(this).attr('id');
    }).get();
    l_Filter = '.FilterElementContent.FilterIsActive';
    if ($('#Content_All').hasClass('FilterIsActive')) {
        l_Filter = '.FilterElementLanguage';
    }
    var l_ActiveContentList = $(l_Filter).not('.FilterAll').map(function() {
        return '.Filter' + $(this).attr('id');
    }).get().join(', ');
    var l_ContentRows = $(l_ActiveContentList).map(function() {
        return '#' + $(this).attr('id');
    }).get();
    var l_FilteredListRowIDs = $(l_LanguageRows).filter(l_SocialMediaRows).filter(l_ContentRows).get().join(', ');
    $('.FilterResultRow').hide();
    $(l_FilteredListRowIDs).show();
    if (a_Element == 'Language_All') {
        $('.FilterElementLanguage').removeClass('FilterIsActive');
    } else if (a_Element == 'SocialMedia_All') {
        $('.FilterElementSocialMedia').removeClass('FilterIsActive');
    } else if (a_Element == 'Content_All') {
        $('.FilterElementContent').removeClass('FilterIsActive');
    }
    return;
}
function MouseOverBigButton(source) {
    var firstChild = $(source).children().first();
    if (firstChild.length) {
        firstChild.css('visibility', 'visible');
    }
}
function MouseOutBigButton(source) {
    var firstChild = $(source).children().first();
    if (firstChild.length) {
        firstChild.css('visibility', 'hidden');
    }
}
function CopyContentOfFormInput(a_SourceID, a_FormInputID) {
    $("#" + a_SourceID).click(function() {
        $("#" + a_FormInputID).select();
        document.execCommand("copy");
    });
    $("#" + a_FormInputID).click(function() {
        $(this).select();
    });
}
function CopyTextOfElement(a_SourceID, a_ElementID) {
    $("#" + a_SourceID).click(function() {
        const elem = $("#" + a_ElementID);
        if (elem && elem[0]) {
            const text = $("#" + a_ElementID)[0].textContent;
            if (text) {
                const tempInput = document.createElement("input");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px; opacity: 0;";
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                $(this).focus();
            }
        }
    });
}
function toRomanNumeral(a_Number) {
    if (isNaN(a_Number) || a_Number < 0 || parseInt(a_Number) !== a_Number) {
        return a_Number;
    }
    const digits = String(+a_Number).split("");
    const key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM", "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC", "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"];
    let roman = "";
    let i = 3;
    while (i--) {
        roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    }
    return Array(+digits.join("") + 1).join("M") + roman;
}
function PreventNewTab(a_Event) {
    if (a_Event && a_Event.button === 1) {
        a_Event.preventDefault();
    }
}
function MoveCursor(a_InputElem, a_NextInputElem, a_MaxInputLength) {
    if (a_InputElem && a_NextInputElem && a_InputElem.value.length >= a_MaxInputLength) {
        a_NextInputElem.focus();
    }
}

function InitializePage() {
   LoadLoginBox();
   LoadMenu();
}
function ActivateWebsiteFrame() {
   g_Deactivated = false;
   if (document.getElementById('DeactivationContainer') != null) {
       document.getElementById('DeactivationContainer').style.display = "none";
   }
   if (document.getElementById('DeactivationContainerThemebox') != null) {
       document.getElementById('DeactivationContainerThemebox').style.display = "none";
   }
}
function DeactivateWebsiteFrame() {
   if (document.getElementById('DeactivationContainer') != null) {
       document.getElementById('DeactivationContainer').style.display = "block";
   }
   if (document.getElementById('DeactivationContainerThemebox') != null) {
       document.getElementById('DeactivationContainerThemebox').style.display = "block";
   }
}
function MouseOverWebshopButton(source) {
   source.firstChild.style.visibility = "visible";
}
function MouseOutWebshopButton(source) {
   source.firstChild.style.visibility = "hidden";
}
function MouseOverMediumButton(source) {
   source.firstChild.style.visibility = "visible";
}
function MouseOutMediumButton(source) {
   source.firstChild.style.visibility = "hidden";
}
function CheckAll(form_name, checkbox_name) {
   var form = document.getElementById(form_name);
   if (form.ALL) {
       var c = form.ALL.checked;
   }
   for (var i = 0; i < form.elements.length; i++) {
       var e = form.elements[i];
       if (e.name != checkbox_name)
           continue;
       e.checked = c;
   }
}
function LoadLoginBox() {
   if (loginStatus == "false") {
       document.getElementById('PlayNowContainer').childNodes[0].childNodes[1].childNodes[1].src = JS_DIR_IMAGES + "global/buttons/mediumbutton_login.png";
       document.getElementById('LoginstatusText_1').style.backgroundImage = "url('" + JS_DIR_IMAGES + "global/loginbox/loginbox-font-create-account.gif')";
       document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + JS_DIR_IMAGES + "global/loginbox/loginbox-font-create-account-over.gif')";
   } else {
       document.getElementById('PlayNowContainer').childNodes[0].childNodes[1].childNodes[1].src = JS_DIR_IMAGES + "global/buttons/mediumbutton_myaccount.png";
       document.getElementById('LoginstatusText_1').style.backgroundImage = "url('" + JS_DIR_IMAGES + "global/loginbox/loginbox-font-logout.gif')";
       document.getElementById('LoginstatusText_2').style.backgroundImage = "url('" + JS_DIR_IMAGES + "global/loginbox/loginbox-font-logout-over.gif')";
   }
}
function MouseOverLoginBoxText(source) {
   source.lastChild.style.visibility = "visible";
   source.firstChild.style.visibility = "hidden";
}
function MouseOutLoginBoxText(source) {
   source.firstChild.style.visibility = "visible";
   source.lastChild.style.visibility = "hidden";
}
function LoginButtonAction() {
   if (loginStatus == "false") {
       window.location = JS_DIR_ACCOUNT + "?subtopic=accountmanagement";
   } else {
       window.location = JS_DIR_ACCOUNT + "?subtopic=accountmanagement";
   }
}
function LoginstatusTextAction(source) {
   if (loginStatus == "false") {
       window.location = JS_DIR_ACCOUNT + "?subtopic=createaccount";
   } else {
       window.location = JS_DIR_ACCOUNT + "?subtopic=logoutaccount";
   }
}
var menu = new Array();
menu[0] = new Object();
var unloadhelper = false;
var menuItemName = '';
function LoadMenu() {
   const submenu = document.getElementById("submenu_" + activeSubmenuItem);
   if (submenu) {
       submenu.style.color = "white";
   }
   const icon = document.getElementById("ActiveSubmenuItemIcon_" + activeSubmenuItem);
   if (icon) {
       icon.style.visibility = "visible";
   }
   if (self.name.lastIndexOf("&") == -1) {
       self.name = "news=1&abouttibia=0&gameguides=0&library=0&community=0&forum=0&account=0&charactertrade=0&support=0&";
   }
   FillMenuArray();
   if (window.matchMedia('(max-width: 768px)').matches) {
       var submenuItem = document.getElementById(activeSubmenuItem);
       if (submenuItem) {
           var ParentID = submenuItem.closest('[class="Level1Block"]').id;
           for (menuItemName in menu[0]) {
               if (menuItemName == ParentID) {
                   menu[0][menuItemName] = 1;
                   $('.MobileMenuItems #' + ParentID + ' .Level1Entry').addClass('Level1ItemOpen');
               } else {
                   menu[0][menuItemName] = 0;
               }
           }
       }
   }
   InitializeMenu();
   $('#MobileMenu .Level2Block').removeClass('MobileMenuActiveItem');
   if (activeSubmenuItem) {
       $('#MobileMenu #' + activeSubmenuItem).addClass('MobileMenuActiveItem');
   }
}
function SaveMenu() {
   if (unloadhelper == false) {
       SaveMenuArray();
       unloadhelper = true;
   }
}
function FillMenuArray() {
   var MenuCount = 0;
   var mark1 = 0;
   var mark2 = 0;
   while (self.name.length > 0) {
       MenuCount++;
       mark1 = self.name.indexOf("=");
       mark2 = self.name.indexOf("&");
       if (MenuCount > 15 || mark1 < 0 || mark2 < 0) {
           break;
       }
       menuItemName = self.name.substr(0, mark1);
       menu[0][menuItemName] = self.name.substring(mark1 + 1, mark2);
       self.name = self.name.substr(mark2 + 1, self.name.length);
   }
}
function InitializeMenu() {
   for (menuItemName in menu[0]) {
       if (menu[0][menuItemName] == "0") {
           document.getElementById(menuItemName + "_Submenu").style.visibility = "hidden";
           document.getElementById(menuItemName + "_Submenu").style.display = "none";
           document.getElementById(menuItemName + "_Lights").style.visibility = "visible";
           document.getElementById(menuItemName + "_Extend").style.backgroundImage = "url(" + JS_DIR_IMAGES + "global/general/plus.gif)";
           $('#MobileMenu #' + menuItemName + ' .Level2Block').hide();
       } else {
           document.getElementById(menuItemName + "_Submenu").style.visibility = "visible";
           document.getElementById(menuItemName + "_Submenu").style.display = "block";
           document.getElementById(menuItemName + "_Lights").style.visibility = "hidden";
           document.getElementById(menuItemName + "_Extend").style.backgroundImage = "url(" + JS_DIR_IMAGES + "global/general/minus.gif)";
           $('#MobileMenu #' + menuItemName + ' .Level2Block').show();
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
   self.name = temp;
}
function MenuItemAction(sourceId) {
   if (menu[0][sourceId] == 1) {
       CloseMenuItem(sourceId);
       $('.MobileMenuItems #' + sourceId + ' .Level1Entry').removeClass('Level1ItemOpen');
   } else {
       OpenMenuItem(sourceId);
       $('.MobileMenuItems #' + sourceId + ' .Level1Entry').addClass('Level1ItemOpen');
   }
}
function OpenMenuItem(sourceId) {
   if (window.matchMedia('(max-width: 768px)').matches) {
       for (menuItemName in menu[0]) {
           CloseMenuItem(menuItemName);
       }
   }
   menu[0][sourceId] = 1;
   document.getElementById(sourceId + "_Submenu").style.visibility = "visible";
   document.getElementById(sourceId + "_Submenu").style.display = "block";
   document.getElementById(sourceId + "_Lights").style.visibility = "hidden";
   document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + JS_DIR_IMAGES + "global/general/minus.gif)";
   $('#MobileMenu #' + sourceId + ' .Level2Block').show();
}
function CloseMenuItem(sourceId) {
   menu[0][sourceId] = 0;
   document.getElementById(sourceId + "_Submenu").style.visibility = "hidden";
   document.getElementById(sourceId + "_Submenu").style.display = "none";
   document.getElementById(sourceId + "_Lights").style.visibility = "visible";
   document.getElementById(sourceId + "_Extend").style.backgroundImage = "url(" + JS_DIR_IMAGES + "global/general/plus.gif)";
   $('#MobileMenu #' + sourceId + ' .Level2Block').hide();
}
function MouseOverMenuItem(source) {
   source.firstChild.style.visibility = "visible";
}
function MouseOutMenuItem(source) {
   source.firstChild.style.visibility = "hidden";
}
function MouseOverSubmenuItem(source) {
   source.style.backgroundColor = "#14433F";
}
function MouseOutSubmenuItem(source) {
   source.style.backgroundColor = "#0D2E2B";
}
function PaymentStandBy(a_Source, a_Case) {
   var m_Agree = false;
   if (a_Source == "setup" && a_Case != 1) {
       if (document.getElementById("CheckBoxAgreePayment").checked == true) {
           m_Agree = true;
       }
   }
   if (a_Source == "setup" && a_Case == 1) {
       if (document.getElementById("CheckBoxAgreePayment").checked == true && document.getElementById("CheckBoxAgreeSubscription").checked == true) {
           m_Agree = true;
       }
   }
   if (a_Source == "cancel") {
       m_Agree = true;
   }
   if (m_Agree == true) {
       document.getElementById("Step4MinorErrorBox").style.visibility = "hidden";
       document.getElementById("Step4MinorErrorBox").style.display = "none";
       document.getElementById("DisplayText").style.visibility = "hidden";
       document.getElementById("DisplayText").style.display = "none";
       document.getElementById("StandByMessage").style.visibility = "visible";
       document.getElementById("StandByMessage").style.display = "block";
       document.getElementById("DisplaySubmitButton").style.visibility = "hidden";
       document.getElementById("DisplaySubmitButton").style.display = "none";
       document.getElementById("DisplayBackButton").style.visibility = "hidden";
       document.getElementById("DisplayBackButton").style.display = "none";
   }
}
function NoteDownload(a_Event, a_LinkElement, a_ClientType, a_Source) {
   if (a_LinkElement.classList.contains('DisabledLink')) {
       a_Event.preventDefault();
       return;
   }
   a_LinkElement.classList.add('DisabledLink');
   if (typeof a_Source === 'undefined') {
       a_Source = '';
   }
   parent.confirmclient.location = JS_DIR_ACCOUNT + 'downloadaction.php?clienttype=' + a_ClientType + '&source=' + a_Source;
   setTimeout(function() {
       if (a_LinkElement && a_LinkElement.classList && a_LinkElement.classList.contains('DisabledLink')) {
           a_LinkElement.classList.remove('DisabledLink');
       }
   }, 3000);
}
function SetFormFocus() {
   if (g_FormName.length > 0 && g_FieldName.length > 0) {
       var l_SetFocus = true;
       if (g_FormName == 'AccountLogin') {
           if (document.getElementsByName('loginemail')[0].value.length > 0) {
               l_SetFocus = false;
           }
       }
       if (l_SetFocus == true) {
           document.forms[g_FormName].elements[g_FieldName].focus();
       }
   }
}
function SetFormFocusToArguments(a_FormName, a_FieldName) {
   if (a_FormName.length > 0 && a_FieldName.length > 0) {
       document.forms[a_FormName].elements[a_FieldName].focus();
       document.forms[a_FormName].elements[a_FieldName].focus();
       document.forms[a_FormName].elements[a_FieldName].focus();
       document.forms[a_FormName].elements[a_FieldName].blur();
       document.forms[a_FormName].elements[a_FieldName].blur();
       document.forms[a_FormName].elements[a_FieldName].blur();
   }
}
function ToggleMaskedText(a_TextFieldID) {
   m_DisplayedText = document.getElementById('Display' + a_TextFieldID).innerHTML;
   m_MaskedText = document.getElementById('Masked' + a_TextFieldID).innerHTML;
   m_ReadableText = document.getElementById('Readable' + a_TextFieldID).innerHTML;
   if (m_DisplayedText == m_MaskedText) {
       document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Readable' + a_TextFieldID).innerHTML;
       document.getElementById('Button' + a_TextFieldID).src = JS_DIR_IMAGES + 'global/general/hide.gif';
   } else {
       document.getElementById('Display' + a_TextFieldID).innerHTML = document.getElementById('Masked' + a_TextFieldID).innerHTML;
       document.getElementById('Button' + a_TextFieldID).src = JS_DIR_IMAGES + 'global/general/show.gif';
   }
}
function FormatDate(a_DateTimeStamp, a_Format) {
   l_Format = 'full';
   l_Date = new Date(a_DateTimeStamp);
   l_Output = l_Date.toString().substring(4);
   return l_Output;
}
function RedirectGET(a_Target) {
   window.location = decodeURIComponent(a_Target);
}
var PostParameters = new Object();
function RedirectPOST(a_Target, a_ParameterArray) {
   $('<form />').hide().attr({
       method: "post",
       id: "RedirectForm"
   }).attr({
       action: decodeURIComponent(a_Target)
   }).append('<input type="submit" />').appendTo($("body"));
   $.each(a_ParameterArray, function(key, value) {
       console.log(key + ": " + value);
       $('#RedirectForm').append($('<input />').attr("type", "hidden").attr({
           "name": key
       }).val(value));
   });
   $('#RedirectForm').submit();
}
var g_CurrentScreenshot = 0;
var g_NumberOfScreenshots = 0;
var g_Screenshots = new Array();
var g_ScreenshotTexts = new Array();
function SetScreenshot(a_Number) {
   g_CurrentScreenshot = a_Number;
   $("#ScreenshotContainer").fadeTo("fast", 0, function() {
       $('#ScreenshotImage').attr('src', g_Screenshots[g_CurrentScreenshot].src);
       $('.ScreenshotTextRow').text(g_ScreenshotTexts[g_CurrentScreenshot]);
       $("#ScreenshotContainer").fadeTo("fast", 1, function() {});
   });
}
function ShowNextScreenshot() {
   g_CurrentScreenshot = (g_CurrentScreenshot + 1);
   if (g_CurrentScreenshot > g_NumberOfScreenshots) {
       g_CurrentScreenshot = 1;
   }
   SetScreenshot(g_CurrentScreenshot);
}
function ShowPreviousScreenshot() {
   g_CurrentScreenshot = (g_CurrentScreenshot - 1);
   if (g_CurrentScreenshot < 1) {
       g_CurrentScreenshot = g_NumberOfScreenshots;
   }
   SetScreenshot(g_CurrentScreenshot);
}
function ShowScreenshot(a_Number, a_NumberOfScreenshots) {
   g_NumberOfScreenshots = a_NumberOfScreenshots;
   g_CurrentScreenshot = a_Number;
   $("#LightBox").fadeTo("fast", 1, function() {});
   $("#LightBoxBackground").fadeTo("fast", 0.75, function() {});
   SetScreenshot(a_Number);
}
function PreloadScreenshots(a_NumberOfScreenshots) {
   for (i = 1; i <= a_NumberOfScreenshots; i++) {
       g_Screenshots[i] = new Image();
       g_Screenshots[i].src = JS_DIR_IMAGES + 'abouttibia/tibia_screenshot_' + i + '.png'
   }
}
var player = null;
var ConsentCookie = GetCookieValue('CookieConsentPreferences');
if (ConsentCookie) {
   var ConsentObject = JSON.parse(decodeURIComponent(ConsentCookie));
   var SocialMediaConsent = ConsentObject.socialmedia;
   if (SocialMediaConsent) {
       var l_ElementTag = document.createElement('script');
       l_ElementTag.src = "https://www.youtube.com/iframe_api";
       var l_FirstScriptTag = document.getElementsByTagName('script')[0];
       l_FirstScriptTag.parentNode.insertBefore(l_ElementTag, l_FirstScriptTag);
   }
}
function onYouTubeIframeAPIReady() {
   player = new YT.Player('YouTubeVideo');
   return;
}
function StopVideoIfExists() {
   if (typeof player !== 'undefined' && !!player && typeof player.stopVideo === 'function') {
       player.stopVideo();
   }
}
function ImageInNewWindow(a_ImageSource) {
   const l_Image = new Image();
   var l_WindowWidth = 100;
   var l_WindowHeight = 100;
   var l_NewWindow = window.open('', '', 'width=' + l_WindowWidth + ', height=' + l_WindowHeight);
   l_Content = '<body style="margin: 0px; background: #0e0e0e; height: 100%; display: flex; align-items: center; justify-content: center;" >';
   l_Content += '<img src="' + a_ImageSource + '" />';
   l_Content += '</body>';
   l_NewWindow.document.write(l_Content);
   l_Image.onload = function() {
       l_BorderWidth = (l_NewWindow.outerWidth - l_NewWindow.innerWidth);
       l_BorderHeight = (l_NewWindow.outerHeight - l_NewWindow.innerHeight);
       var l_PixelSpace = 5;
       var l_WindowWidth = (l_Image.naturalWidth + l_PixelSpace + l_BorderWidth);
       var l_WindowHeight = (l_Image.naturalHeight + l_PixelSpace + l_BorderHeight);
       l_NewWindow.resizeTo(l_WindowWidth, l_WindowHeight);
       l_NewWindow.focus();
   }
   l_Image.src = a_ImageSource;
   return;
}

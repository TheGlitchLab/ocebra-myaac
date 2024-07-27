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
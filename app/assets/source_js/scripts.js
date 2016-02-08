(function(){
  "use strict";
  
  // Write all your custom JavaScript here
    
    
    function copyText(text) {
        var copyElement = document.createElement('input');
        copyElement.setAttribute('type', 'text');
        copyElement.setAttribute('value', text);
        copyElement = document.body.appendChild(copyElement);
        copyElement.select();
        try {
            if(!document.execCommand('copy')) throw 'Not allowed.';
        } catch(e) {
            copyElement.remove();
            console.log("document.execCommand('copy'); is not supported");
            prompt('Copy the text below. (ctrl c, enter)', text);
        } finally {
            if (typeof e == 'undefined') {
                copyElement.remove();
            }
        }
    }
    
    $('#copyButton').click(function(){
        var textResults = $('.results .outerDiv').text();
        copyText(textResults);
    });
  
})();



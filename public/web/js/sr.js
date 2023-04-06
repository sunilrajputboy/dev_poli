
$('.error').hide();
/************SAVE-DATA*********/
 function saveData(formId, action_url, responseDiv = '') {
formId = '#' + formId;
var formData = new FormData($(formId)[0]);
$.ajax({
url: action_url,
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
if (res.success == 1) { $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>'); } else {
$('.' + responseDiv).html('<div class="alert alert-danger">' + res.msg + '</div>');
setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
}
if(res.redirect_url != ''){
    if(res.email != undefined && res.password != undefined){
    setCookie('email',res.email,10);
     setCookie('password',res.password,10);
    }
location.href = res.redirect_url;
}
},
error: function() {
$(".loader").css("transform", 'scale(0)');
alert('An error has occurred');
}
});
}
/************END-SAVE-DATA*********/
/************SETCOOKIE*********/
function setCookie(cname,cvalue,exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
/************END-SAVE-DATA*********/
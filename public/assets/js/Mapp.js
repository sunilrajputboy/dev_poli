$(function()
{
    /**
     * SweetAlert Settings
     */
    const Toast = Swal.mixin({
        toast: false,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
    /**
     * Check OptionList selected
     */
    $(".select-css").on("change", function(e)
    {
        e.preventDefault();
        $(this).find("option:checked").each(function()
        {
            var t = $(this);
		
            if(t.val() !== '')
            {
				if(t.val()=='add_new'){
					$('#myDatafieldModal').modal('show');
				}
				if(t.val()=='edit_datafield'){
					$('#renameDataFieldsModal').modal('show');
				}
				if(t.val()=='Ignore'){
					$.post("/import/setSessionIgnore/", {"id": e.target.id});
				}
				
                var j = $('.select-css option:selected').filter("[value='" + t.val() + "']").length;
                if (j > 1 && t.val()!='Ignore' && t.val()!='add_new') {
                    t.parents().val('');
                    f('error', 'You cannot select same column multiple times.');
                    return;
                }
            }
        });
    });
/*************OUR-CUSTOM-CODE**************/
    $(".select-css1").on("change", function(e)
    {
        e.preventDefault();
        $(this).find("option:checked").each(function()
        {
            var t = $(this);
            if(t.val() !== '')
            {
				var cookie_nm=t.name;
				var cookie_id=e.target.id;
				var cookie_val=t.val();
				setCookie(cookie_id,cookie_val,1);
				t.parent().attr('name',"node_regions['"+t.val()+"']");
                var j = $('.select-css1 option:selected').filter("[value='" + t.val() + "']").length;
                if (j > 1 && t.val() != '0') {
                    t.parents().val('');
                    f('error', 'You cannot select same column multiple times.');
                    return;
                }
            }
        });
    });
	$(document).ready(function() {
		$('.select-css1').each(function(e){
			var cookie_id= $(this).attr('id');
			 var x=getCookie(cookie_id);
			 if (x != null) {
				 console.log(x);
				 $(this).val(x);
				 $('#'+cookie_id+' option').filter(':selected').text();
			 }
		});
		});
/***************COOKIE******************/		
	function setCookie(name,value,days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*60*60*1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "")  + expires + "; path=/";
	}
	function getCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}
	function eraseCookie(name) {   
		document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	}
/***************COOKIE******************/
/*******GET-TYPE******/
$('.inner-data').hide();
$('.error').hide();
$('.invert-node').hide();
$('.graph-type').hide();
$('.grouping-method').hide();
$('.average-override').hide();
$('.dataset_summary').hide();

function getType(v){
    if(v.value == 'Text'){
        $('.comparable-data').show();
        $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
         $('.inner-data').hide();
   } else if(v.value == 'Hyperlink' ){
          $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
       $('.inner-data').hide();
       $('.comparable-data').hide();
   }else{
       $('.comparable-data').show();
      $('.inner-data').show();  
   }
}

$('#dataFieldSubmitBtn').on('click', function (e) {
        e.preventDefault();
        var i = 0;
        var j = 0;
        var submit_form = true;
		 /***DATA-FIELDS****/  
        var importForm = $("#setDataFields").serialize();
       $('#setDataFields .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
          $("body").css("cursor", "progress");
        $.ajax({
            type: "POST",
            url: "/import/saveDataFields",
            data: importForm,
            dataType: "json",
            success: function(data) {
                if (data.type == 'success') {
                    Swal.fire({icon: 'success',title: data.msg,showConfirmButton: false,timer:300,onClose: () => {
                         location.reload();
                        }
                    });
                }else{
                    f(data.type, data.msg);
                }
                $("body").css("cursor", "default");
            },
            error: function()
            {
                f('error', 'error handling here');
            }
        });
    }
		
    });


$('#name').keyup(function(){
    var nameData = $(this).val();
    $('#dname').val(nameData);
    
    
});

/*******RenameDataField******/
$('#RenamedataFieldSubmitBtn').on('click', function (e) {
        e.preventDefault();
        var i = 0;
        var j = 0;
        var submit_form = true;
		 /***DATA-FIELDS****/  
        var importForm = $("#RenameDataField").serialize();
       $('#RenameDataField .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
          $("body").css("cursor", "progress");
        $.ajax({
            type: "POST",
            url: "/import/renameDataFields",
            data: importForm,
            dataType: "json",
            success: function(data) {
                if (data.type == 'success') {
                    Swal.fire({icon: 'success',title: data.msg,showConfirmButton: false,timer:300,onClose: () => {
                         location.reload();
                        }
                    });
                }else{
                    f(data.type, data.msg);
                }
                $("body").css("cursor", "default");
            },
            error: function()
            {
                f('error', 'error handling here');
            }
        });
    }
		
    });
/*******************/

$('.importNowButton').on('click', function (e) {
        e.preventDefault();
var r = confirm("All nodes and values will be updated! Are you sure you would like to proceed?");
if (r == false) {
  return falsel
} else {
 
        
        var i = 0;
        var j = 0;
		var k=0;
		var l=0;
        $('.select-css').find("option:checked").each(function()
        {
			 var t = $(this);
			if(t.val()==''){ l++; }
            (t.val() != '') ? i++ : ''
        });

        $('.select-css1').find("option:checked").each(function()
        {
			console.log($(this).val());
            var t = $(this);
			if(t.val()==''){ k++; }
            (t.val() != '') ? j++ : ''
        });

        if(i == 0)
        {
	        Swal.fire({
                        icon: 'error',
                        title: "You have not mapped any colums"
                    })
            return false;
        }
        if(j == 0)
        {
	        Swal.fire({
                        icon: 'error',
                        title: "You have not mapped any Nodes"
                    })
            return false;
        }
		
		if(k > 0)
        {
	        Swal.fire({
                        icon: 'error',
                        title: "You can't import until you sort all nodes."
                    })
       $('.errorfield').each(function(){
            console.log($(this).children('select').val());
           if($(this).children('select').val() == ''){
                jQuery.fn.scrollTo = function(elem) { 
					$(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top); 
					return this; 
				};
			$(".tbl-content").scrollTo(this);
			 return false;
           }
        });
            return false;
        }
		if(l > 0){
		  $('.errorfield').each(function(){
				console.log($(this).children('select').val());
				if($(this).children('select').val() == ''){
					jQuery.fn.scrollTo = function(elem) { 
						$(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top); 
						return this; 
					};
				$(".tbl-content").scrollTo(".errorfield");
			}
		});
          
		Swal.fire({
					icon: 'error',
					title: "You can't import until you sort all fields."
				})
            return false;
        }
		
		 /***IMPORT-NOW****/  
        $("body").css("cursor", "progress");
		$(".loader").css('display', 'flex');
        var importForm = $("#doImportForm2").serialize();
        $.ajax({
            type: "POST",
            url: "/import/importEditedFile",
            data: importForm,
            dataType: "json",
            success: function(data) {
                if (data.type == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 4500,
                        onClose: () => {
                            localStorage.setItem("tabid", '#3a');
                            localStorage.setItem("li3", 'active');
                            localStorage.setItem("activetab", 'li3');
									 $('.select-css1').each(function(e){
										var x='';
										var cookie_id= $(this).attr('id');
										 x=eraseCookie(cookie_id);
									});
                            window.location = "/projects/viewprojects/"+data.pro_key;
                        }
                    });
                }else{
                    f(data.type, data.msg);
                }
                $("body").css("cursor", "default");
            },
            error: function()
            {
                f('error', 'error handling here');
            }
        });
		}
    });

/***********END-OUR-CUSTOM-CODE-**********/	
    /**
     * Before submit upload
     */
    $(".btnUploadCSV").on("click", function (e)
    {
        e.preventDefault();
        var input = "#file_source";
        var fi = $(input).val();
        var ex = fi.substr( (fi.lastIndexOf('.') +1) );
        if(fi)
        {
            if (ex != 'csv' && ex != 'xls' && ex != 'xlsx' && ex != 'xlsm' && ex != 'xlt') 
            {
                f('error', 'File selected not valid');
                $(input).focus();
                return false;
            }
            var select_table = $('#select_table option:selected');
            if (select_table.val() == '') {
                f('error', 'Select Database Table');
                $(select_table).focus();
                return false;
            }
            $('#doImportUpload').hide();
            $('#progress').show();            
            $('#doImportUpload').submit();
        }
        else {
            f('info', 'Select file to import');
            $(input).focus();
            return false;
        }
    });

    /**
     * SaveMapp
     */
    $('.saveMapp').on('click', function (e) {
        e.preventDefault();
        var i = 0;
        $('.select-css').find("option:checked").each(function()
        {
            var t = $(this);
            (t.val() != '') ? i++ : ''
        });

        if(i == 0)
        {
            f('warning', 'You have not mapped any colums');
            return;
        }

        Swal.fire({
            title: 'Insert Name for Mapping.',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Save Mapping',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value)
            {
                var mapp_form = $("#doImportForm").serialize();
                $.ajax({
                    type: "POST",
                    url: "/import/SaveMapp",
                    data: {mapp_form:mapp_form, mapp_name:result.value, select_table: $('#select_table').val(), use_csv_header: $('#use_csv_header').val()},
                    dataType: "json",
                    success: function(data)
                    {
                        f(data.type, data.msg);
                     },
                    error: function()
                    {
                        f('error', 'error handling here');
                    }
                });
            }
        });

    });

    $('.beforeUploadToServer').on('click', function (e) {
        e.preventDefault();
        var i = 0;
        $('.select-css').find("option:checked").each(function()
        {
            var t = $(this);
            (t.val() != '') ? i++ : ''
        });

        if(i == 0)
        {
	        Swal.fire({
                        icon: 'error',
                        title: "You have not mapped any colums"
                    })
            return false;
        }
        
        $("body").css("cursor", "progress");
        var importForm = $("#doImportForm").serialize();
        $.ajax({
            type: "POST",
            url: "/import/doImport",
            data: importForm,
            dataType: "json",
            success: function(data) {
                if (data.type == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        showConfirmButton: false,
                        timer: 4500,
                        onClose: () => {
                            window.location = '/import/importlist';
                        }
                    });
                }else{
                    f(data.type, data.msg);
                }
                $("body").css("cursor", "default");
            },
            error: function()
            {
                f('error', 'error handling here');
            }
        });

    });

    $("#select_table").on("change", function() {
        var a = $(this).val();
        if (a) {
            $("body").css("cursor", "progress");
            $.ajax({
                type: "POST",
                url: "/import/Maps",
                data: {name_table: a},
                dataType: "json",
                success: function(data)
                {
                    if(data.type == 'success')
                    {
                        if(data.maps.length > 0)
                        {
                            $('#list_mapp').find('option').remove().end().append('<option value="">select...</option>');
                            $.each(data.maps, function (index, value) {
                                $('#list_mapp').append($('<option>', {
                                    value: value.id_mapping,
                                    text: value.map_name
                                }));
                            });
                        }
                        else
                        {
                            $('#list_mapp').find('option').remove().end().append('<option value="">select...</option>');
                        }
                    }
                    $("body").css("cursor", "default");
                },
                error: function()
                {
                    f('error', 'error handling here');
                }
            });
        } else {
            $('#list_mapp').find('option').remove().end().append('<option value="">select...</option>');
        }
    });
/***************************/
/////////////

function scrollToElm(container, elm, duration){
  var pos = getRelativePos(elm);
  scrollTo( container, pos.top , 2);  // duration in seconds
}

function getRelativePos(elm){
  var pPos = elm.parentNode.getBoundingClientRect(), // parent pos
      cPos = elm.getBoundingClientRect(), // target pos
      pos = {};

  pos.top    = cPos.top    - pPos.top + elm.parentNode.scrollTop,
  pos.right  = cPos.right  - pPos.right,
  pos.bottom = cPos.bottom - pPos.bottom,
  pos.left   = cPos.left   - pPos.left;

  return pos;
}
    
function scrollTo(element, to, duration, onDone) {
    var start = element.scrollTop,
        change = to - start,
        startTime = performance.now(),
        val, now, elapsed, t;

    function animateScroll(){
        now = performance.now();
        elapsed = (now - startTime)/1000;
        t = (elapsed/duration);

        element.scrollTop = start + change * easeInOutQuad(t);

        if( t < 1 )
            window.requestAnimationFrame(animateScroll);
        else
            onDone && onDone();
    };

    animateScroll();
}

function easeInOutQuad(t){ return t<.5 ? 2*t*t : -1+(4-2*t)*t };
/***************************/
    /**
     * Call SweetAlert
     * @param type
     * @param msg
     */
    function f(type, msg)
    {
        Toast.fire({
            icon: type,
            title: msg
        });
    }
});;
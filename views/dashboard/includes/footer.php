<!--footer.php-->
</div><!-- Main Content -->

<!-- Vendor: Javascripts -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery-2.1.3.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/select2.min.js"></script>
<!-- Our Website Javascripts -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/app.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/main.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/dataTables.rowReorder.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/dataTables.editor.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery.richtext.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/jquery.mjs.nestedSortable.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/common.js"></script>

<script type="text/javascript" src="<?php echo BASE_URL; ?>public/web/js/rte.js"></script>
<!--<script>RTE_DefaultConfig.url_base='richtexteditor'</script>-->
<script type="text/javascript" src='<?php echo BASE_URL; ?>public/web/js/all_plugins.js'></script>

<script src="<?php echo BASE_URL; ?>/public/assets/js/sweetalert2.all.min.js"></script>
<script>$(document).ready(function(){ $('[data-toggle="tooltip"]').tooltip(); });</script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.rows.js"></script>
<div class="modal fade bd-example-modal-sm bd-delete-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Confirm</h5>
      </div>
        
	<div class="modal-body text-center">
        <h4 class="modal-title confirmTitle" id="confirmTitle">Are You Sure ? </h4>
    </div>
	<div class="modal-footer text-center">
    <button type='button' class="btn btn-secondary" value='Yes' id='btnYes'><i class="fa fa-check"></i> Yes</button>
    <button type='button' class="btn btn-primary" value='No' id='btnNo'> <i class="fa fa-times">                                        
                                        </i> No</button>
    </div>
  </div>
</div>
</div>
  <div class="modal fade normalAlert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Confirm</h5>
      </div>
      
      <div class="modal-body">
        <h4 class="modal-title text-center" id="normalTitle">Are You Sure ? </h4>
      </div>
        
    <div class="modal-footer text-center">
    <button type='button' class="btn btn-primary" data-dismiss="modal" aria-label="Close" value='Close' id='btnNo' ><i class="fa fa-times"> </i>      Close</button>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">

// $('.hiddenDiv').hide();

// 	$('.expandEditor, .itemTitle').click(function(){
// 				var id = $(this).attr('data-id');
// 				$('#menuEdit'+id).toggle();
// 				$(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
// 			});
			
updateIndexNested = function(e, ui) {

        $('span.index', ui.item.parent().parent().parent()).each(function (i) {

            $(this).html(i + 1);

        });

    };
    	$().ready(function(){
			var ns = $('ol.sortable').nestedSortable({
				forcePlaceholderSize: true,
				handle: 'div',
				helper:	'clone',
				stop: updateIndexNested,
				items: 'li',
				opacity: .6,
				placeholder: 'placeholder',
				revert: 250,
				tabSize: 25,
				tolerance: 'pointer',
				toleranceElement: '> div',
				maxLevels: 2,
				isTree: true,
				expandOnHover: 700,
				startCollapsed: false,
        excludeRoot: true,
        rootID:"root"
			});
			
			$('.expandEditor').attr('title','Click to show/hide item editor');
			$('.disclose').attr('title','Click to show/hide children');
			$('.deleteMenu').attr('title', 'Click to delete item.');
		
			$('.disclose').on('click', function() {
				$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
				$(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
			});
			
			$('.expandEditor, .itemTitle').click(function(){
				var id = $(this).attr('data-id');
				$('#menuEdit'+id).toggle();
				$(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
			});
			
			$('.deleteMenu').click(function(){
				var id = $(this).attr('data-id');
				$('#menuItem_'+id).remove();
			});
				
			$('#serialize').click(function(){
				serialized = $('ol.sortable').nestedSortable('serialize');
				$('#serializeOutput').text(serialized+'\n\n');
			})
	
			$('#toHierarchy').click(function(e){
				hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
				hiered = dump(hiered);
				(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
				$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
			})
	
			$('#toArray').click(function(e){
			       $('.loader').fadeIn(300);
			    	hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
				hiered = dump(hiered);
			
				arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                
                	var values = [];

		var sequences = [];

		$("input[name='shortposition[]']").each(function() {

			values.push($(this).val());

			sequences.push($(this).siblings('.index').text());

		});
       
                
			var userStrarraied = JSON.stringify(arraied);
	
				var urls = "<?php echo BASE_URL; ?>projects/saveDatagroupParentChild";
				
		$.ajax({

            url: urls,

            type: 'post',
            data: {'shortingdata':userStrarraied,'shortposition': values,'sequence':sequences},
       
            success: function(response){
                var res = JSON.parse(response);
        if(res.success == 1){
            
             localStorage.setItem('message_viewprojects',res.msg);
              location.reload();
        }
       
             }

         });
				// (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
				// $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
				
			});
		});	
		
		function dump(arr,level) {
			var dumped_text = "";
			if(!level) level = 0;
	
			//The padding given at the beginning of the line.
			var level_padding = "";
			for(var j=0;j<level+1;j++) level_padding += "    ";
	
			if(typeof(arr) == 'object') { //Array/Hashes/Objects
				for(var item in arr) {
					var value = arr[item];
	
					if(typeof(value) == 'object') { //If it is an array,
            console.log("object", arr[item]);
						dumped_text += level_padding + "'" + arr[item] + "' ...\n";
						dumped_text += dump(value,level+1);
					} else {
						dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
					}
				}
			} else { //Strings/Chars/Numbers etc.
				dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
			}
			return dumped_text;
		}
/*****
jQuery.fn.scrollTo = function(elem) { 
    $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top); 
    return this; 
};

$(".tbl-content").scrollTo(".errorfield");
********/
function putdatavalue(datakey,num){
	$('.DFname').val(datakey);
	$('.DPname').val(datakey);
	$('#datakeyVal').val(datakey);
	$('#sequenceVal').val(num);
	$('#dataKeyVal2').val(datakey);
	$('.inner-data').show();
}
function mytabFun(id, tabid){
    localStorage.setItem('activetab', id);
     localStorage.setItem('tabid', tabid);
    if(tabid == '#'){
        $('.tab-pane').each(function(){
            $(this).addClass('active');
            $('.custom-tab-child').attr('aria-expanded', 'true');
        });
    }
}
window.onload = function (){
    var activetab = localStorage.getItem('activetab');
    var tabid = localStorage.getItem('tabid');
if(activetab == null){ 
  activetab = 'li1';
  tabid = '#1a';
}
    $('#' + activetab).children().attr('aria-expanded', 'true');
    $('#'+ activetab).addClass('active');
    $(tabid).addClass('active');
	  if(tabid == '#'){
			$('.tab-pane').each(function(){
				$(this).addClass('active');
			});
		}
		   if(activetab == 'li4'){
      var fieldtab = localStorage.getItem('fieldtab');
       $('#'+ fieldtab).addClass('active');
         $('#'+ 'id'+ fieldtab).css('display', 'block');
          localStorage.removeItem('fieldtab');
      }
}

// loader
jQuery(window).on('load',function() {
  	jQuery(".loader").fadeOut(1000);
}); 

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
				if (res.success == 1) { $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>');
				if(window.location.pathname == '/projects/viewprojects'){
					localStorage.setItem('message_viewprojects', res.msg);
					$('.editdatafieldvalue').modal('hide');
				}
				
				if(res.redirect_url != undefined){
					if(res.msg=='Project added.'){
						mytabFun('li6','#6a');
					}
					location.href = res.redirect_url;
				}
				  setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);  
				} else {
					$('.' + responseDiv).html('<div class="alert alert-danger">' + res.msg + '</div>');
					setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
				}
			},
			error: function(err) {
			$(".loader").css("transform", 'scale(0)');
			console.log(err);
			alert('An error has occurred...');
			}
		});

}
function ValidateEmail(email) 
{
 if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email))
  {
    return true;
  }
    
    return false;
}

function ValidatePassword(pass,cpass) 
{
 if (pass == cpass)
  {
    return true;
  }
    
    return false;
}

$('#addUserBtn').click(function(){
var submit_form = true;
    $('.required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
           
                 $(this).siblings('.error').html('Email is Invalid');
                $(this).siblings('.error').show();
             submit_form = false;
		}else if($(this).hasClass('is_password') && !CheckPassword($(this).val())){
              $(this).siblings('.error').show();
              $(this).siblings('.error').html('Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
                submit_form = false; 
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
     saveData('addUserForm','<?php echo BASE_URL; ?>users/addusers','message');
}
    
});
/******Check-Password*****/
function CheckPassword(pass) 
{ 
var passw = '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}';
var l = /[a-z]/g;
var u = /[A-Z]/g;
var n = /[0-9]/g;
 if(pass.match(l) && pass.match(u) && pass.match(n) && pass.length >= 8 ){
    return true;
 }
else{ 
return false;
}
}
/************/

$('#updateUserProfileBtn').click(function(){
console.log(ValidatePassword($('#password').val(),$('#cpassword').val()));
var submit_form = false;
    $('.required').each(function(){

        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            submit_form = true;
             $(this).siblings('.error').hide();
        }
            
    });
    
    if(!ValidatePassword($('#password').val(),$('#cpassword').val())){
            $('#password').siblings('.error').html('Password and confirm password mismatch');
            $('#password').siblings('.error').show();
            submit_form = false; 
        }else{
            $('#password').siblings('.error').show();
            submit_form = true;
        }
    
    if(submit_form){ saveData('updateuserProfile','<?php echo BASE_URL; ?>setting/updateUserProfile','message');
}
    
});


$('#addProject').click(function(){
var submit_form = true;
    $('.required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
    });
    if(submit_form){
     saveData('addProjectForm','<?php echo BASE_URL; ?>projects/addprojects','message');
     saveshorting('projects');
}
});

$('#updateProject').click(function(){
var submit_form = true;
    $('#editProject .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });

    if(submit_form){

      


      Swal.fire({icon: 'info',customClass: 'swal-wide',title: "Please note that the pre-existing datafields need updating individually, all new datafields created will use the updated colour scheme.",showConfirmButton: true,onClose: () => {
        saveData('editProject','<?php echo BASE_URL; ?>projects/update','message');
                        }
                    });
}
});

$('#updateProjectname').click(function(){
var submit_form = true;
    $('#editProjectname .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
   
    if(submit_form){
     saveData('editProjectname','<?php echo BASE_URL; ?>projects/editProjectname','message');
}
});

$('#updateProjectContent').click(function(){
var submit_form = true;
   
    if(submit_form){
     saveData('editProjectcontent','<?php echo BASE_URL; ?>projects/updateContent','message');
}
    
});



$('#uniquesubmitbtn').click(function(){
var submit_form = true;
   
    if(submit_form){
     saveData('uniquesubmitbtnform','<?php echo BASE_URL; ?>projects/updateUniqueUrl','message');
}
    
});



function selectClient(v){
    var cid = $(v).val();
    	$.ajax({
            url: '<?php echo BASE_URL; ?>analytics/filterprojectbyclient',
            type: 'post',
            data: { 'cid':cid },
            success: function(response){
        var res = JSON.parse(response);
        // console.log(res);
        $('.select_projects').html(res.options);
        $('#no_of_visits').text(res.views);
            $('#faecbook_share').text(res.facebook_share);
            $('#twitter_share').text(res.twitter_share);
            $('#linkedin_share').text(res.linkedin_share);
            $('#mp_tweets').text(res.mp_tweets);
            $('#mail_mp').text(res.mp_emails);
            $('#mail_share').text(res.mail_friend);
             }
         }); 
}

function selectprojects(v){
    var pkey = $(v).val();
     	$.ajax({

            url: '<?php echo BASE_URL; ?>analytics/filterAnalyticsbyproject',
            type: 'post',
             data: { 'pkey':pkey },
            success: function(response){
            var res = JSON.parse(response);
            // console.log(res);
            $('#no_of_visits').text(res.views);
            $('#faecbook_share').text(res.facebook_share);
            $('#twitter_share').text(res.twitter_share);
            $('#linkedin_share').text(res.linkedin_share);
            $('#mp_tweets').text(res.mp_tweets);
            $('#mail_mp').text(res.mp_emails);
            $('#mail_share').text(res.mail_friend);
             }

         });
}

function selectnovisits(v){
    var visits = $(v).val();
    var allclient = $('#allclient').val();
    var allproject = $('#allproject').val();
    if(visits == 'custom'){
      $('#from').removeAttr('disabled');
      $('#to').removeAttr('disabled');
    }else{
      $('#from').attr('disabled',true);
      $('#to').attr('disabled',true);
     	$.ajax({
            url: '<?php echo BASE_URL; ?>analytics/NumberOfvisits',
            type: 'post',
            data: {'visits': visits,'allclient':allclient, 'allproject':allproject},
            success: function(response){
            var responseData = JSON.parse(response);
            $("#no_of_visits_text").text(responseData.key);
               $("#no_of_visits").text(responseData.value);
             }
         });
    }
}

$('#from, #to').change(function() {
  var visits = $('#selectnovisit').val();
    var allclient = $('#allclient').val();
    var allproject = $('#allproject').val();
    var from = $('#from').val();
    var to = $('#to').val();
    if(from == ''){
      $('#from').focus();
    }
    if(to == ''){
      $('#to').focus();
    }
    if(from != '' && to != ''){
     	$.ajax({
            url: '<?php echo BASE_URL; ?>analytics/NumberOfvisits',
            type: 'post',
            data: {'visits': visits,'allclient':allclient, 'allproject':allproject,'from':from,'to':to},
            success: function(response){
            var responseData = JSON.parse(response);
            $("#no_of_visits_text").text(responseData.key);
               $("#no_of_visits").text(responseData.value);
             }
         });
    }
});


$('#addProjectgroupbtn').click(function(){
var submit_form = true;
    $('#addProjectgroupForm .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
            
    });
   
    if(submit_form){
     saveData('addProjectgroupForm','<?php echo BASE_URL;  ?>projectsgroup/addprojects','message');
}
    
});

$('#addDatagroupbtn').click(function(){
var submit_form = true;
    $('#addDatagroupForm .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
   
    if(submit_form){
     saveData('addDatagroupForm','<?php echo BASE_URL ?>/projects/adddatagroup','message');
}
    
});

$('#updateProjectgroupbtn').click(function(){
var submit_form = true;
    $('#updateProjectgroupForm .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
   
    if(submit_form){
     saveData('updateProjectgroupForm','<?php echo BASE_URL; ?>projectsgroup/update','message');
	}
});

$('#updateProjectingroupbtn').click(function(){
var submit_form = true;
    $('#updateProjectingroupform .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
   
    if(submit_form){
     saveData('updateProjectingroupform','<?php echo BASE_URL; ?>projectsgroup/updateprojectingroup','message');
}
    
});

$('body').on('change','#graph_type_box, #graph_type1',function(){
      console.log(this.value);
      if(this.value == 'Line'){
          $('.droptarget .colorBoxm').hide();
      }else{
            $('.droptarget .colorBoxm').show();
      }
  });

$('#addChartBtn').click(function(){
var submit_form = true;
    $('#addChart .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
    });
    if(submit_form){
        var cname = $('#addChart #cname').val();
        var graphfor = $("input[name='graphfor']:checked").val();
        var graph_type = $("#graph_type_box").val();
        console.log(graph_type);
        var pro_id = $("input[name='proid']").val();
        var map_width = $("input[name='mapwidth']:checked").val();

        var c_displayname = $('#c_displayname').val();
        var x_axis = $('#x_axis').val();
        var y_axis = $('#y_axis').val();
            var hide_average = $("input[name='hide_average']:checked").val();
        
        const selectedFields = [];
        $('#selected_fields .dfield_name').each(function(){
          var selectedFieldId = $(this).attr('id');
          selectedFields.push(selectedFieldId);
        });
        
        const field_color = [];
            $('#selected_fields input[name="field_color[]"]').each(function(){
            var selectfield_color = $(this).val();
            field_color.push(selectfield_color);
            });
            
            var average_color = $('#average_color').val();
        
        var send_url = '<?php echo BASE_URL; ?>projects/add_chart';
        	$.ajax({
			url: send_url,
			data: {'field_color':field_color,'average_color': average_color, 'cname':cname,'c_displayname':c_displayname,'x_axis':x_axis,'y_axis':y_axis, 'graphfor':graphfor,'hide_average':hide_average, 'graph_type':graph_type, 'map_width':map_width, 'selectedFields':selectedFields, 'pro_id':pro_id},
			type: 'POST',
			success: function(res) {
			var res = jQuery.parseJSON(res);
			if (res.success == 1) {
			    localStorage.setItem('message_viewprojects', 'Chart added successfully.');
			    location.reload();
			}else{
				//html_data
			}
			},
			error: function() {
			alert('An error has occurred');
			}
			});
}
    
});

function updateChart(){
        var submit_form = true;
        $('#updateChart .required').each(function(){
        if($(this).val() == ''){
        $(this).siblings('.error').show();
        submit_form = false;  
        }else{
        
        $(this).siblings('.error').hide();
        }
        
        });
        
        if(submit_form){
        
            
            var cname = $('#cname1').val();
            var chart_displayname = $('#chart_displayname').val();
            var c_x_axis = $('#c_x_axis').val();
            var c_y_axis = $('#c_y_axis').val();
            
            var graphfor = $("input[name='graphfor1']:checked").val();
            var graph_type = $("#graph_type1").val();
            
            var pro_id = $("input[name='proid']").val();
            var id = $("#id").val();
            
            var map_width = $("input[name='mapwidth1']:checked").val();
              var hide_average = $("input[name='hide_average1']:checked").val();
              
            const selectedFields = [];
            $('#selected_fields1 .dfield_name1').each(function(){
            var selectedFieldId = $(this).attr('value');
            selectedFields.push(selectedFieldId);
            });


            const field_color = [];
            $('#selected_fields1 input[name="field_color[]"]').each(function(){
            var selectfield_color = $(this).val();
            field_color.push(selectfield_color);
            });
            
            var average_color = $('#average_color1').val();
            
            var send_url = '<?php echo BASE_URL; ?>projects/update_chart';
            
            $.ajax({
            url: send_url,
            data: {'field_color': field_color,'average_color':average_color,'cname':cname,'chart_displayname':chart_displayname,'c_x_axis':c_x_axis,'c_y_axis':c_y_axis, 'graphfor':graphfor,'hide_average':hide_average, 'graph_type':graph_type, 'map_width':map_width, 'selectedFields':selectedFields, 'pro_id':pro_id, 'id':id},
            type: 'POST',
            success: function(res) {
            var res = jQuery.parseJSON(res);
            if (res.success == 1) {
            localStorage.setItem('message_viewprojects', 'Chart updated successfully');
            location.reload();
            }else{
            //html_data
            }
            },
            error: function() {
            alert('An error has occurred');
            }
            });
        
        } 
}

$('#updateUserBtn').click(function(){
var submit_form = true;
    $('.required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
                $(this).siblings('.error').html('Email is Invalid');
                $(this).siblings('.error').show();
				submit_form = false; 
        }else{
             $(this).siblings('.error').hide();
        }
            
    });
    
    if($('#password').val() != '' && !CheckPassword($('#password').val())){
             $('.passworderror').show();
              $('.passworderror').html('Password Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters');
                submit_form = false; 
    }
    
    if(submit_form){
     saveData('updateUserForm','<?php echo BASE_URL; ?>users/update','message');
}
    
});

$('#upgradeDowngrademailbtn').click(function(){
     saveData('upgradeDowngradeform','<?php echo BASE_URL; ?>/dashboard/sendmailadmin','message');
});

function CheckPassword(pass) 
{ 
var passw = '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}';
var l = /[a-z]/g;
var u = /[A-Z]/g;
var n = /[0-9]/g;
 if(pass.match(l) && pass.match(u) && pass.match(n) && pass.length >= 8 ){
    return true;
 }
else{ 
return false;
}
}

$('#savePass').click(function(){
var url = $(this).attr('page');
var submit_form = true;
    $('#passForm .required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  F
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
        
     saveData('passForm','<?php echo BASE_URL;  ?>'+url+'/addpassword','message');
}
    
});

$('.error').hide();
$(document).ready(function(){
    "use strict";
    //*** Piety Mini Charts ***//
        // $(function() {
        //     $(".bar").peity("bar", {
        //       fill: ["#ff8484"],
        //       height: ["40px"],
        //       width: ["94px"]
        //     })

        //     $(".bar2").peity("bar", {
        //       fill: ["#9797ff"],
        //       height: ["40px"],
        //       width: ["94px"]
        //     })
        // });

    });
	/******12-02-2023*****/
	$(".select2-design").select2({
			closeOnSelect : false,
			//placeholder : "Select",
			placeholder : $(".js-select2").attr('placeholder'),
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		});
	/***********/
	$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Select",
			maximumDisplayOptionsLength:"5",
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		}).on('select2:selecting', function(e) {
  var cur = e.params.args.data.id;
  var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
  $(e.target).val(old).trigger('change');
  $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
  return false;
});
		
		$(".js-select2clients").select2({
			closeOnSelect : false,
			placeholder : "Select",
			maximumDisplayOptionsLength:"5",
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		}).on('select2:selecting', function(e) {
  var cur = e.params.args.data.id;
  var old = (e.target.value == '') ? [cur] : $(e.target).val().concat([cur]);
  $(e.target).val(old).trigger('change');
  $(e.params.args.originalEvent.currentTarget).attr('aria-selected', 'true');
  return false;
});
		
// 			$(".js-select2clients").select2({
// 			closeOnSelect : false,
// 			placeholder : "Select",
// 			maximumDisplayOptionsLength:"5",
// 			allowHtml: true,
// 			allowClear: true,
// 			tags: true // создает новые опции на лету
// 		});
	
 function letsconfirm(msg,mlinks){
	confirmdialog(msg,
      function(){
		  window.location = mlinks;
	  },
	  function() {
        return false;
    }
	);
	return false;
}

function confirmdialog(message, yesCallback, noCallback) {
	console.log(message);
    $('.confirmTitle').html(message);
    //var dialog = $('#modal_dialog').dialog();
	$('.bd-example-modal-sm').modal('show');
    $('#btnYes').click(function() {
      $('.bd-example-modal-sm').modal('hide');  
   
        yesCallback();
       
    });
    $('#btnNo').click(function() {
       $('.bd-example-modal-sm').modal('hide');
       noCallback();
    });
    
    return false;
  
}

 function dowithselected(action_status,tablename){
		var values = [];
		$("input[name='chkbx[]']:checked").each(function(){
			values.push($(this).val());
		});
		if(values.length>0){
     confirmdialog("Are you sure you want to "+action_status+"?",
      function(){

		$.ajax({
            url: '<?php echo BASE_URL; ?>packages/dowithselected',
            type: 'post',
            data: {user_ids: values,'action_status':action_status,'tablename':tablename},
			dataType:'json',
            success: function(response){
				 location.reload();
             }

         });
	  },
    function() {
  
        return false;
    } );
		}else{
            $('#normalTitle').html('Please select at least one entry.');
			$('.normalAlert').modal('show');
		

		}
	
 return false;
 
	 }
	 
	 
 function saveshorting(table_name){
$('#loading').show();

		var values = [];

		var sequences = [];

		$("input[name='shortposition[]']").each(function() {

			values.push($(this).val());

			sequences.push($(this).closest('tr').find('.index').text());

		});

		$.ajax({

            url: '<?php echo BASE_URL; ?>packages/saveshorting',

            type: 'post',
            data: {shortposition: values,'sequence':sequences,'table_name':table_name},

			dataType:'json',

            success: function(response){
      
   location.reload();


             }

         });

	 }
	 
	 function saveshortingchart(table_name){


		var values = [];

		var sequences = [];

		$(".dragDrop input[name='shortposition[]']").each(function() {

			values.push($(this).val());

			sequences.push($(this).closest('li').find('.indexc').text());

		});

		$.ajax({

            url: '<?php echo BASE_URL; ?>projects/saveshortingchart',

            type: 'post',
            data: {shortposition: values,'sequence':sequences,'table_name':table_name},

			dataType:'json',

            success: function(response){
      
  location.reload();


             }

         });

	 }
	 	 	 function saveshorting2(table_name){
$('#loading').show();

		var values = [];

		var sequences = [];

// 		$("input[name='shortposition[]']").each(function() {
           
// 			values.push($(this).val());

// 			sequences.push($(this).closest('.accord-wrappers').find('.index').text());

// 		});


var urls = "<?php echo BASE_URL; ?>/dashboard/projects/saveshortingdatagroup";
		$.ajax({

            url: urls,

            type: 'post',
            data: {shortposition: values,'sequence':sequences,'table_name':table_name},

			dataType:'json',

            success: function(response){
     
  location.reload();


             }

         });

	 }
	 
	 
$(".close-btn").click(function(){
    $(this).parent().hide();
});

function editForm(){
	$('.edit-form').modal('show');
}

function editVisuals(){
  	$('.visuals-form').modal('show');
}
function editContent(){
  	$('.content-form').modal('show');
}
function editprojectname(){
  	$('.project-name-form').modal('show');
}

function addFields(id,mid){
var str = '<form action="javascript:void(0)" id="dataFields" class="edit-project" method="post">'+
'<div class="form-group">'+
'<label for="">Name</label>'+
'<input type="text" class="form-control required" name="name" id="dfname" placeholder="Name" value="">'+
'<div class="text-danger"></div>'+
'<span class="error">Name is required</span>'+
'</div>'+
'<div class="form-group">'+
'<label for="">Display Name</label>'+
'<input type="text" class="form-control" name="display_name" id="dname" placeholder="Display name" value="">'+
'</div>'+
'<div class="form-group">'+
'<label for="">Description</label>'+
'<textarea type="text" class="form-control" name="description" id="description" placeholder="Description">'+
'</textarea>'+
'</div>'+
'<div class="form-group">'+
'<label for="">Type</label>'+
'<select class="form-control" id="dataType" onchange="getType(this)" name="type">'+
'<option value="Number" >Number</option>'+
'<option value="Text" >Text</option>'+
'<option value="Percentage" >Percentage</option>'+
'<option value="Decimal" >Decimal</option>'+
'<option value="Hyperlink" >Hyperlink</option>'+
'<option value="Pound" >Pound</option>'+ 
'<option value="Euro" >Euro</option>'+
'<option value="Dollar" >Dollar</option>'+
'</select></div>'+
'<div class="form-group comparable-data">'+
'<div class="toggleWrapper">'+
'<label for="">Display data on heatmap</label>'+ 
'<input type="checkbox" name="comparable" id="comparable" class="dn" value="true" checked>'+
'<label for="comparable" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'<div class="grouping-method">'+
'<label for="">Grouping method</label>'+
'<select class="form-control" name="grouping">'+
'<option value="Percentiles" selected>Percentiles</option>'+ 
'<option value="EqualRanges" >Equal Ranges</option>'+ 
'</select>'+
'</div>'+
'</div>'+
'<div class="form-group link_and_text" style="display:none;">'+
'<label for="">Link Text</label>'+
'<input type="text" class="form-control" name="link_text" id="link_text" placeholder="Link Text" value="Click Here">'+
'</div>'+
'<div class="form-group">'+
'<div class="toggleWrapper">'+
'<label for="">Hide field on node view</label>'+  
'<input type="checkbox" name="hide_node" id="hide_node_add" class="dn" value="yes">'+
'<label for="hide_node_add" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'<div class="inner-data">'+
'<div class="form-group">'+
'<div class="toggleWrapper">'+
'<label for="">Show average</label>'+  
'<input type="checkbox" name="overall_range" id="overall_range" class="dn" value="true">'+
'<label for="overall_range" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'<div class="form-group">'+
'<div class="toggleWrapper">'+
'<label for="">Show average without empty nodes</label>'+  
'<input type="checkbox" name="average_without_empty_nodes" id="average_without_empty_nodes" class="dn" value="true">'+
'<label for="average_without_empty_nodes" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'<div class="form-group">'+
'<div class="toggleWrapper">'+
'<label for="">Override calculated average</label>'+  
'<input type="checkbox" name="override_average" id="override_average" class="dn" value="true">'+
'<label for="override_average" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'<div class="average-override">'+
'<label for="">Average Override</label>'+
'<input type="number" class="form-control" name="average_override_number" id="average_override_number" placeholder="" value="">'+
'</div>'+
'</div>'+
// '<div class="form-group">'+
// '<div class="toggleWrapper">'+
// '<label for="">Show chart in the data set summary</label>'+  
// '<input type="checkbox" name="chart_data_set_summary" id="chart_data_set_summary" class="dn" value="true">'+
// '<label for="chart_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+
// '<div class="dataset_summary">'+
// '<div class="toggleWrapper">'+
// '<label for="">Exclude minimum from data set summary chart</label>'+  
// '<input type="checkbox" name="exclude_minimum_data_set_summary" id="exclude_minimum_data_set_summary" class="dn" value="true">'+
// '<label for="exclude_minimum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+

// '<div class="toggleWrapper">'+
// '<label for="">Exclude maximum from data set summary chart</label>'+  
// '<input type="checkbox" name="exclude_maximum_data_set_summary" id="exclude_maximum_data_set_summary" class="dn" value="true">'+
// '<label for="exclude_maximum_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+

// '<div class="toggleWrapper">'+
// '<label for="">Exclude average from data set summary chart</label>'+  
// '<input type="checkbox" name="exclude_average_data_set_summary" id="exclude_average_data_set_summary" class="dn" value="true">'+
// '<label for="exclude_average_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+
// '</div>'+

// '</div>'+
// '<div class="form-group">'+
// '<div class="toggleWrapper">'+
// '<label for="">Show total in the data set summary</label>'+
// '<input type="checkbox" name="total_data_set_summary" id="total_data_set_summary" class="dn" value="true">'+
// '<label for="total_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+
// '</div>'+
// '</div>'+
// '<div class="form-group multivalued-data">'+
// '<div class="toggleWrapper">'+
// '<label for="">Multivalued</label>  '+
// '<input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true">'+
// '<label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>'+
// '</div>'+
// '<div class="graph-type">'+
// '<label for="">Graph Type</label>'+
// '<select class="form-control" name="graphtype">'+
// '<option disabled selected>Select graph</option>'+ 
// '<option value="BarGraph" >Bar graph</option>'+ 
// '<option value="LineGraph" >Line graph</option>'+ 
// '</select>'+
// '</div>'+
// '</div>'+
'</div>'+
'<div class="form-group node-ranking-data">'+
'<div class="toggleWrapper">'+
'<label for="">Display the node rankings</label>'+ 
'<input type="checkbox" name="node_ranking" id="node_ranking" class="dn" value="true">'+
'<label for="node_ranking" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'<div class="form-group invert-node">'+
'<div class="toggleWrapper">'+
'<label for="">Invert the node rankings</label>'+  
'<input type="checkbox" name="invert_node_ranking" id="invert_node_ranking" class="dn" value="true">'+
'<label for="invert_node_ranking" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'<div class="form-group">'+
'<label for="">Map Areas Border Colour</label>'+
'<input type="color" class="form-control" name="map_areas_border_colour" id="map_areas_border_colour" placeholder="Map Areas Border Colour" value="#646464">'+
'</div>'+
// '<input type="hidden" value="Percentiles" name="grouping" />'+
'<input type="hidden" value="'+mid+'" name="mid" />'+
'<input type="hidden" value="'+id+'" name="id" />'+
'<div class="text-center"><button type="button" id="datafield_btn" class="btn cus-btn">Submit</button></div>'+
'</form>';
$('.add-data-field .modal-body').html(str);
// $('.inner-data').hide();
$('.error').hide();
$('.invert-node').hide();
$('.graph-type').hide();
// $('.grouping-method').hide();
$('.average-override').hide();
$('.dataset_summary').hide();
	$('.add-data-field').modal('show');
	
}

function colorChange(v){
        $(v).siblings('.colorValueInput').val($(v).val());
        $('.display-range').click();
}
function addColor(){
    // console.log($('.color-append-box .colorBox').size());
var count = $('.color-append-box .colorBox').size() + 1;
if(count < 11){
    $('.removeBox').each(function(){
        $(this).remove();
    });
    var str = '<div class="colorBox"><label for="">Key color '+count+'</label> <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="#0000"><input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value=""/><button class="removeBox" onclick="removeColor(this)">x</button></div>';
    $(".color-append-box").append(str);
}
if(count == 10){
     $("#addBtnBox").hide();
}

}
function removeColor(v){
  var count = $('.colorBox').size();
 
  if(count > 2){
    $(v).parent('.colorBox').prev().append('<button class="removeBox" onclick="removeColor(this)">x</button>');
  }
    $(v).parent('.colorBox').remove();
 
     $("#addBtnBox").show();
   if(count <= 10){
        console.log(count);
        $("#addBtnBox").show();
   }
    
}

function addColorm(min,max,colors,fmin,fmax){

  $('#datafield_btn_update').attr('disabled',true);
    $('#datafield_btn_update').html('Loading...');
var color = [];
if ($('#save_display_range').data('value') == 'Yes') {
  var count = $('#updatemapkey .colorBoxm').size();
  
  var projectfield_id = $('#updatemapkey').find('input[name="id"]').val();
  
  var urls = "<?php echo BASE_URL; ?>/projects/updateDisplayColor";
		$.ajax({
            url: urls,
            type: 'post',
            data: {'projectfield_id':projectfield_id},
            success: function(response){
             }

         });
         
  }else{
    var count = $('#updatemapkey .colorBoxm').size() + 1;
  }

var projectfield_id = $('#updatemapkey').find('input[name="id"]').val();
if(count < 11){
    $('.removeBoxm').each(function(){
        $(this).remove();
    });
    
    $('.color-append-boxm .colorBoxm .colorInput').each(function(){
        
          color.push($(this).val());
    });
    
 if ($('#save_display_range').data('value') == 'Yes') {
  }else{
    color.push('#000');
  }


    var urls = "<?php echo BASE_URL; ?>/projects/getallcolor";
		$.ajax({

            url: urls,

            type: 'post',
            data: {'min':min,'max':max,'color':color,'fmin':fmin,'fmax':fmax,'projectfield_id':projectfield_id},

            success: function(response){
     
$('#colorm_type2').html(response);
$('#datafield_btn_update').removeAttr('disabled');
    $('#datafield_btn_update').html('Update');
$('.display-range').click();

             }

         });

         $.ajax({

url: "<?php echo BASE_URL; ?>/projects/getDisplaycolor",

type: 'post',
data: {'min':min,'max':max,'color':color,'fmin':fmin,'fmax':fmax,'projectfield_id':projectfield_id},

success: function(response){
   if ($('#save_display_range').data('value') == 'Yes') {
  // $('.messagenew').html('<div class="alert alert-success">Display range reset successfully</div>');
  //   setTimeout(function() { $('.messagenew').html(''); }, 2000);
  Swal.fire({
  position: 'top-end',
  heightAuto: false,
  icon: 'success',
  title: 'Display range reset successfully.',
  showConfirmButton: false,
  timer: 1000
})
}
  $('.display-range .map-key').empty().append(response);
  $('#save_display_range').data('value','no');
  $('#save_display_range').removeAttr('disabled');
   $('#datafield_btn_update').removeAttr('disabled');
    $('#datafield_btn_update').html('Update');
 }
});

    // var str = '<div class="colorBoxm"><label for="">Key color '+count+'</label> <input type="text" class="colorValueInput form-control" onchange="colorValueChange(this)" value="#0000"><input type="color" class="colorInput" name="color[]" onchange="colorChange(this)" id="colors" value=""/><button class="removeBoxm" onclick="removeColorm(this)">x</button></div>';
    // $(".color-append-boxm").append(str);
}else{
      console.log('limit reached');
}
if(count == 10){
     $("#addBtnBoxm").hide();
}

}
function removeColorm(v,min,max,fmin,fmax){
  $('#datafield_btn_update').attr('disabled',true);
    $('#datafield_btn_update').html('Loading...');
    var color = [];
var count = $('.colorBoxm').size();
var projectfield_id = $('#updatemapkey').find('input[name="id"]').val();
var proid = $('#updatemapkey').find('input[name="proid"]').val();
$(v).parent('.colorBoxm').remove();
  if(count > 2){
    $(v).parent('.colorBoxm').prev().append('<button class="removeBoxm" onclick="removeColorm(this)">x</button>');
  }
  
  $('.color-append-boxm .colorBoxm .colorInput').each(function(){
     color.push($(this).val());
  });
  
    var urls = "<?php echo BASE_URL; ?>projects/getallcolor";
		$.ajax({
            url: urls,
            type: 'post',
            data: {'min':min,'max':max,'color':color,'fmin':fmin,'fmax':fmax,'projectfield_id':projectfield_id,'proid':proid},
            success: function(response){
				$('#colorm_type2').html(response);
				$('.display-range').click();
             }
         });

         $.ajax({

url: "<?php echo BASE_URL; ?>/projects/getDisplaycolor",

type: 'post',
data: {'min':min,'max':max,'color':color,'fmin':fmin,'fmax':fmax,'projectfield_id':projectfield_id,'proid':proid},

success: function(response){
  $('#datafield_btn_update').removeAttr('disabled');
    $('#datafield_btn_update').html('Update');
$('.display-range .map-key').empty().append(response);
 }
});
  
  if(count <= 10){
        console.log(count);
        $("#addBtnBoxm").show();
  }
}
// new click function
 $('body').on('click', '#datafield_btn_update', function ()
{
    $('.add-data-field').modal('hide');
});

function mapKeyBtnUpdate(){
  
  formId = '#' + 'updatemapkey';
var formData = new FormData($(formId)[0]);
responseDiv = 'messagenew';
var action_url = '<?php echo BASE_URL; ?>projects/updatemapkey';
$.ajax({
url: action_url,
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
if (res.success == 1) {

  Swal.fire({
  position: 'top-end',
  heightAuto: false,
  icon: 'success',
  title: res.msg,
  showConfirmButton: false,
  timer: 1000
})

  // $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>');

  setTimeout(function() { $('.' + responseDiv).html(''); }, 80000);  
//   $('.add-data-field').modal('hide');
  		$.ajax({
            url: '<?php echo BASE_URL;  ?>projects/getmapkey',
            type: 'post',
            data: {'projectfield_id': res.fid, 'proid': res.pid},
            success: function(response){
            $('.add-data-field .modal-content').html(response);
  $('.display-range').click();

             }

         });

} else {
$('.' + responseDiv).html('<div class="alert alert-danger">' + res.msg + '</div>');
setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
}

},
error: function() {
$(".loader").css("transform", 'scale(0)');
alert('An error has occurred');
}
});
}

function getChartWizard(id,proid){
		$.ajax({

            url: '<?php echo BASE_URL; ?>projects/getchart',
            type: 'POST',
            data: {'id': id, 'proid':proid},
            success: function(response){
            $('.add-data-field .modal-content').html(response);
    	$('.add-data-field').modal('show');
// console.log(response);
             }
         });
         setTimeout(() => {
          $("#allFacets1, #selected_fields1").sortable({
  connectWith: "div",
  placeholder: "placeholder",
  delay: 150
})
.disableSelection()
.dblclick( function(e){
  var item = e.target;
  if (e.currentTarget.id === 'allFacets1') {
    //move from all to user
    $(item).fadeOut('fast', function() {
      $(item).appendTo($('#selected_fields1')).fadeIn('slow');
    });
  } else {
    //move from user to all
    $(item).fadeOut('fast', function() {
      $(item).appendTo($('#allFacets1')).fadeIn('slow');
    });
  }
});
			}, 1000);


}

 $('body').on('keyup', '.footer_content_data .richText-editor', function ()
    {
        $('.preview_footer_data').html($(this).html()); 
    }
    );

    if($('.textEditor').length>0){
      var editor1 = new RichTextEditor(".textEditor", { pasteMode: "PasteText" });
    }
    if($('.nodeEditor').length>0){
      var editor2 = new RichTextEditor(".nodeEditor", { pasteMode: "PasteText" });
    }
    if($('.footerEditor').length>0){
      var editor3 = new RichTextEditor(".footerEditor", { pasteMode: "PasteText" });
    }
      if($('.privacypolicyEditer').length>0){
      var editor3 = new RichTextEditor(".privacypolicyEditer", { pasteMode: "PasteText" });
    }
    
     if($('.printEditor').length>0){
      var editor4 = new RichTextEditor(".printEditor", { pasteMode: "PasteText" });
    }
     if($('.nodeIntroEditor').length>0){
      var editor5 = new RichTextEditor(".nodeIntroEditor", { pasteMode: "PasteText" });
    }
    
    
    
// $('.textEditor').richText({  
//     //  removeStyles: true,
//     // code: false
// });
// $('.footerEditor').richText({
// });
//      $('.nodeEditor').richText({
// });
     
function colorValueChange(v){
    $(v).siblings('.colorInput').val($(v).val());
    $('.display-range').click();
}

</script>
<script type="text/javascript">


var inputs = document.querySelectorAll('.custom-file')

for (var i = 0, len = inputs.length; i < len; i++) {
  customInput(inputs[i])
}

function customInput (el) {
  const fileInput = el.querySelector('[type="file"]')
  const label = el.querySelector('[data-js-label]')
  
  fileInput.onchange =
  fileInput.onmouseout = function () {
    if (!fileInput.value) return
    
    var value = fileInput.value.replace(/^.*[\\\/]/, '')
    el.className += ' -chosen'
    label.innerText = value
  }
}


var fixHelperModified = function(e, tr) {
var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},

    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).html(i + 1);
        });
    };
    
        var fixHelperModified2 = function(e, tr) {
var $originals = tr.children();

    var $helper = tr.clone();

    $helper.children().each(function(index) {

        $(this).width($originals.eq(index).width())

    });

    return $helper;

},

   updateIndex2 = function(e, ui) {

        $('span.indexc', ui.item.parent()).each(function (i) {

            $(this).html(i + 1);

        });

    };
    
     var fixHelperModified1 = function(e, tr) {
var $originals = tr.children();

    var $helper = tr.clone();

    $helper.children().each(function(index) {

        $(this).width($originals.eq(index).width())

    });

    return $helper;

},

    updateIndex1 = function(e, ui) {

        $('td.index', ui.item.parent()).each(function (i) {

            $(this).html(i + 1);

        });

    };

$("#packages tbody").sortable({
    helper: fixHelperModified,
    stop: updateIndex
}).disableSelection();	 

$("#dfield tbody").sortable({

    helper: fixHelperModified1,

    stop: updateIndex1

}).disableSelection();	

$(".dragDrop").sortable({

    helper: fixHelperModified2,

    stop: updateIndex2

}).disableSelection();

	 </script>
<script type="text/javascript">
$(document).ready(function() {
  $('input[type="file"]').on("change", function(){
    let filenames = [];
    let files = this.files;
    if (files.length > 1) {
      filenames.push("Total Files (" + files.length + ")");
    } else {
      for (let i in files) {
        if (files.hasOwnProperty(i)) {
          filenames.push(files[i].name);
        }
      }
    }
    $(this)
      .next(".custom-file-label")
      .html(filenames.join(","));
  });
});

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    $("#password").attr('type','text').val(pass);
       $('.togglePass').html('<i class="fa fa-eye"></i>');
  
}

var h2r = function(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? [
        parseInt(result[1], 16),
        parseInt(result[2], 16),
        parseInt(result[3], 16)
    ] : null;
};

// Inverse of the above
var r2h = function(rgb) {
    return "#" + ((1 << 24) + (rgb[0] << 16) + (rgb[1] << 8) + rgb[2]).toString(16).slice(1);
};

// Interpolates two [r,g,b] colors and returns an [r,g,b] of the result
// Taken from the awesome ROT.js roguelike dev library at
// https://github.com/ondras/rot.js
var _interpolateColor = function(color1, color2, factor) {
  if (arguments.length < 3) { factor = 0.5; }
  var result = color1.slice();
  for (var i=0;i<3;i++) {
    result[i] = Math.round(result[i] + factor*(color2[i]-color1[i]));
  }
  return result;
};

var rgb2hsl = function(color) {
  var r = color[0]/255;
  var g = color[1]/255;
  var b = color[2]/255;

  var max = Math.max(r, g, b), min = Math.min(r, g, b);
  var h, s, l = (max + min) / 2;

  if (max == min) {
    h = s = 0; // achromatic
  } else {
    var d = max - min;
    s = (l > 0.5 ? d / (2 - max - min) : d / (max + min));
    switch(max) {
      case r: h = (g - b) / d + (g < b ? 6 : 0); break;
      case g: h = (b - r) / d + 2; break;
      case b: h = (r - g) / d + 4; break;
    }
    h /= 6;
  }

  return [h, s, l];
};

var hsl2rgb = function(color) {
  var l = color[2];

  if (color[1] == 0) {
    l = Math.round(l*255);
    return [l, l, l];
  } else {
    function hue2rgb(p, q, t) {
      if (t < 0) t += 1;
      if (t > 1) t -= 1;
      if (t < 1/6) return p + (q - p) * 6 * t;
      if (t < 1/2) return q;
      if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
      return p;
    }

    var s = color[1];
    var q = (l < 0.5 ? l * (1 + s) : l + s - l * s);
    var p = 2 * l - q;
    var r = hue2rgb(p, q, color[0] + 1/3);
    var g = hue2rgb(p, q, color[0]);
    var b = hue2rgb(p, q, color[0] - 1/3);
    return [Math.round(r*255), Math.round(g*255), Math.round(b*255)];
  }
};

var _interpolateHSL = function(color1, color2, factor) {
  if (arguments.length < 3) { factor = 0.5; }
  var hsl1 = rgb2hsl(color1);
  var hsl2 = rgb2hsl(color2);
  for (var i=0;i<3;i++) {
    hsl1[i] += factor*(hsl2[i]-hsl1[i]);
  }
  return hsl2rgb(hsl1);
};

(function($) {

  var $list = $('#list'),
      $start = $('#start'),
      $end = $('#end'),
      $intype = $('input[name="intype"]'),
      $usehex = $('#usehex');

  // Add li elements between the start and end ones
  var _createSteps = function(numSteps) {
    $list.find('li.interim').remove();

    for(var i = 0; i < numSteps; i++) {
      $end.before('<li class="interim"><span class="spanmixer"></span><input type="hidden" onchange="colorMixer(this)" class="colorInput" name="colorinput[]" value="" /></li>');
    }
  };

  // Color each li by interpolating between the start and end colors
  var _styleSteps = function() {
    var $items = $('.interim, .limixer'),
        scol = h2r($start.find('input').val()),
        ecol = h2r($end.find('input').val());
    var fn = '_' + $('input[name="intype"]:checked').val();

    // console.log('fn', fn);

    var factorStep = 1 / ($items.length - 1);
    $items.each(function(idx) {
      var icol = window[fn](scol, ecol, factorStep * idx),
          hcol = r2h(icol);

      $(this).css('background-color', hcol);
      $(this).find('.spanmixer').text(hcol);
       $(this).find('.colorInput').val(hcol);
    });

  }

  // Re-render on change
  $('#usehex').on('change', function() {
    var ct = $('ul input').eq(0).attr('type');
    var scol = $start.find('input').val(),
        ecol = $end.find('input').val();

    $('ul input').attr('type', (ct == 'color') ? 'text' : 'color');

    $start.find('input').val(scol);
    $end.find('input').val(ecol);
  });
//   $('input').not('#usehex').on('change', _styleSteps);
  $('#numsteps').on('change', function() {
    _createSteps($(this).val());
    _styleSteps();
  }).trigger('change');

})(jQuery);

$('.togglePass').click(function(){
var type = $('#password').attr('type');
if(type == 'password'){
   $("#password").attr('type','text');
   $(this).html('<i class="fa fa-eye"></i>');
}else{
     $("#password").attr('type','password'); 
      $(this).html('<i class="fa fa-eye-slash"></i>');
}
});

function colorMixer(v){
    $(v).val($(v).val());
    $(v).siblings('.spanmixer').text($(v).val());
    // console.log(v);
    $(v).parent('.interim').css("background-color", $(v).val());
}

function updateprojectStatus(v,page){
   var status = 'draft';
   if(page == 'projectsgroup'){
       var url = 'projectsgroup/projectstatus';
       var msg = 'project group';
   }else{
       var url = 'projects/projectstatus';
       var msg = 'project';
   }
   var pid = $("#project_id").val();
    if($(v).prop("checked") == true){
        if($(v).val() == 'publish'){
           $('#passProtected').show();  
        }
         
            status = $(v).val();    
            }else{
              if($(v).val() == 'password_protected'){
                  var status = 'publish'; 
                 
              }
              if($(v).val() == 'publish'){
                  $('#passProtected').hide();
                  var status = 'draft'; 
              }
            }
   
    	$.ajax({
    	    
            url: '<?php echo BASE_URL; ?>'+url,
            type: 'post',
            data: {'action_status': status, 'user_ids': pid},
			dataType:'json',
            success: function(response){
			  if(response.success == 1){
					$('.message').html('<div class="alert alert-success">' + msg +' status change to '+ status + '.</div>');
					if(status == 'password_protected'){
					$('.addPassword').css('display','block');
					}else{
						  $('.addPassword').css('display','none');
					}
					  setTimeout(function() { $('.' + 'message').html(''); }, 3000); 
				}

             }

         });
}




function filterByclientUser(v){
    var clientId = $(v).val();
    	$.ajax({
            url: '<?php echo BASE_URL; ?>/users/clientfilter',
            type: 'post',
            data: { 'clientId':clientId },

			dataType:'json',

            success: function(response){
                if(response.success == 1){
                
         location.reload();
                }

             }

         });
}


function displayClientProject(v){
    var clientId = $(v).val();
     var groupId = $('#gid').val();
    	$.ajax({
            url: '<?php echo BASE_URL; ?>projectsgroup/projectfilter',
            type: 'post',
            data: { 'clientId':clientId, 'groupId':groupId },
            success: function(response){
                $('.appendData').html(response);
                // console.log(response);
             }
         }); 
}
    


function filterBygroup(v){
    var groupId = $(v).val();
    	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/groupfilter',
            type: 'post',
            data: { 'groupid':groupId },
			dataType:'json',
            success: function(response){
                if(response.success == 1){
         location.reload();
                }
             }
         });
}

$('#color_type1').hide();

$("#color_type_1").click(function(){
    $('#color_type1').show();
    $('#color_type2').hide();
});

$("#color_type_2").click(function(){
    
    $('#color_type2').show();
    $('#color_type1').hide();
});

$('#colorm_type1').hide();

$('body').on('click','#colorm_type_1',function(){
      $('#colorm_type1').show();
    $('#colorm_type2').hide();
});
$('body').on('click','#colorm_type_2',function(){
      $('#colorm_type2').show();
    $('#colorm_type1').hide();
});


function selectCompany(v){
    var id = $(v).val();
    // console.log(id);
    
    var selectedText = $(v).find("option:selected").text();
     	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/selectcompany',
            type: 'post',
            data: {'client_id': id, 'cname':selectedText},
			dataType:'json',
            success: function(response){
                // console.log(response);
      if(response.success == 1){
            $('.message').html('<div class="alert alert-success">' + response.msg + '</div>');
              setTimeout(function() { $('.' + 'message').html(''); }, 3000); 
                if(window.location.href != '<?php echo BASE_URL; ?>dashboard/' && window.location.href != '<?php echo BASE_URL; ?>dashboard/view'){
                  location.reload();
            }
}else if(response.success == 0){
    $('.message').html('<div class="alert alert-danger">' + response.msg + '</div>'); 
    setTimeout(function() { $('.' + 'message').html(''); }, 3000); 
}

             }

         });

}
$('.inner-data').show();
$('.error').hide();
$('.invert-node').hide();
$('.graph-type').hide();
// $('.grouping-method').hide();
$('.average-override').hide();
$('.dataset_summary').hide();
$('.inner-data').show(); 
function getType(v){
    if(v.value == 'Text'){
		$('#comparable').prop('checked', true);
		$('#link_text').val('');
        $('.comparable-data').show();
        $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
         $('.inner-data').hide();
		 $('.link_and_text').hide();
   } else if(v.value == 'Hyperlink' ){
	    $('#comparable').prop('checked', false);
	    $('#link_text').val('Click Here');
        $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
       $('.inner-data').hide();
       $('.comparable-data').hide();
	   $('.link_and_text').show();
   }else{
	  $('#link_text').val('');
	  $('#comparable').prop('checked',true);
      $('.comparable-data').show();
      $('.inner-data').show();  
      $('.grouping-method').show();
	  $('.link_and_text').hide();
   }
}
 $('.comparable-data').show();
      $('.inner-data').show();  

$('body').on('change','#comparable', function(){
    var selectedValue = $('#dataType').val();
    if(this.checked) {
        if(selectedValue != 'Hyperlink' && selectedValue != 'Text'){
            $('.grouping-method').show();
        }
 
    }else{
        $('.grouping-method').hide();
       
    } 
});

$('body').on('change','#multivalued', function(){
    var selectedValue = $('#dataType').val();
    if(this.checked) {
         if(selectedValue != 'Hyperlink' && selectedValue != 'Text' && selectedValue != 'Percentage'){
            $('.graph-type').show();
        }
     
          $('.node-ranking-data').hide();
    }else{
         $('.node-ranking-data').show();
         $('.graph-type').hide();
    }
});


$('body').on('change','#node_ranking', function(){
       var selectedValue = $('#dataType').val();
    if(this.checked){
   
          $('.invert-node').show();
   
         
    }else{
          $('.invert-node').hide();
    }
});

$('body').on('change','#override_average', function(){
   var selectedValue = $('#dataType').val();
    if(this.checked) {
        if(selectedValue != 'Hyperlink' && selectedValue != 'Text'){
       
          $('.average-override').show();
        }
        
    }else{
        $('.average-override').hide();
      
    }
});

$('body').on('change','#chart_data_set_summary', function(){
  var selectedValue = $('#dataType').val();
    if(this.checked) {
        if(selectedValue != 'Hyperlink' && selectedValue != 'Text'){
       
          $('.dataset_summary').show();
        }
        
    }else{
        $('.dataset_summary').hide();
      
    }
});


$('body').on('click','#datafield_btn',function(){
    var submit_form = true;
    $('#dataFields .required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){   
formId = '#' + 'dataFields';
var formData = new FormData($(formId)[0]);

$.ajax({
url: '<?php echo BASE_URL; ?>projects/adddatafields',
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
var responseDiv = 'text-danger'
if (res.success == 1) { 
    // $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>');

if(window.location.pathname == 'projects/viewprojects'){
localStorage.setItem('message_viewprojects', res.msg);
}
if(res.redirect_url != undefined){
    location.href = res.redirect_url;
}
  setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);  
 
} else {
$('.' + responseDiv).html('<span>' + res.msg + '</span>');
setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
}
},
error: function() {
$(".loader").css("transform", 'scale(0)');
alert('An error has occurred');
}
});
    // new end
}  
});

$('body').on('click','#updateCompanyDetailbtn',function(){
    var submit_form = true;
    $('#updateCompanyForm .required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else if($(this).hasClass('is_email') && !ValidateEmail($(this).val())){
              $(this).siblings('.error').show();
              $(this).siblings('.error').html('Email Invalid');
          submit_form = false; 
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
      saveData('updateCompanyForm','<?php echo BASE_URL;  ?>setting/updateCompany','message');
}  
});

function editProjectsForm(id,proid){
		$.ajax({
            url: '<?php echo BASE_URL; ?>projects/getprojectfields',
            type: 'post',
            data: {'projectfield_id': id, 'proid': proid},
            success: function(response){
				$('.add-data-field .modal-content').html(response);
				$('.add-data-field').modal('show');
             }
         });
}
function editProjectsKey(id,proid){
    $('#editkey'+id).html('Loading...');
		$.ajax({
            url: '<?php echo BASE_URL;  ?>projects/getmapkey',
            type: 'post',
            data: {'projectfield_id': id, 'proid': proid},
            success: function(response){
                // console.log(response);
            $('.add-data-field .modal-content').html(response);
    	$('.add-data-field').modal('show');
  $('.display-range').click();
  $('#editkey'+id).html('Edit Map key');
             }
         });


}

function editProjectsfieldsvalueForm(cid,pid,name){
    	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/getprojectfieldsvalue',
            type: 'post',
            data: {'cid': cid, 'proid': pid},
            success: function(response){
                // console.log(response);
				$('.editdatafieldvalue .modal-body').html(response);
				$('.editdatafieldvalue .modal-title').html(name);
				$('.editdatafieldvalue').modal('show');
             }
         });
}

function datafieldBtnUpdate(){
   var submit_form = true;
    $('#updatedataFields .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
		formId = '#' + 'updatedataFields';
		var formData = new FormData($(formId)[0]);
		$.ajax({
		url: '<?php echo BASE_URL;  ?>projects/updatedatafields',
		data: formData,
		type: 'POST',
		processData: false,
		contentType: false,
		success: function(res) {
		var res = jQuery.parseJSON(res);
		var responseDiv = 'text-danger'
			if (res.success == 1) { 
				if(window.location.pathname == 'projects/viewprojects'){
					localStorage.setItem('message_viewprojects', res.msg);
				}
				if(res.redirect_url != undefined){
					location.href = res.redirect_url;
				}
			  setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);  
			} else {
				$('.' + responseDiv).html('<span>' + res.msg + '</span>');
				setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);
			}
		},
		error: function() {
			$(".loader").css("transform", 'scale(0)');
			alert('An error has occurred');
		}
		});
    }
}


$('body').on('click','#updateProjectsFieldvalue',function(){
    saveData('dataFieldsvalue','<?php echo BASE_URL;  ?>projects/updatecountryfieldvalue','message'); 
    
    $('.editdatafieldvalue').modal('hide');
      $('#li3').click();
});

function displayClientList(pid){
    	$.ajax({
            url: '<?php echo BASE_URL; ?>packages/packagesclient',
            type: 'post',
            data: {'pid': pid},
            success: function(response){
                $('.assign-com').html(response);
				$('.client-list-popup').modal('show');
            }
         });
}

function emailMp(v){
   if($(v).prop("checked") == true){
       $('#emailMpsetting').show();
   }else{
      $('#emailMpsetting').hide(); 
   }
}

//logo function
function enablelogourl(v){
   if($(v).prop("checked") == true){
       $('#url').show();
        $('#chooselogo').hide(); 
       $("#logofile").attr("checked", false);
   }else{
      $('#url').hide();
   }
}

function enablelogofile(v){
   if($(v).prop("checked") == true){
       $('#chooselogo').show();
        $('#url').hide();
        $("#logourl").attr("checked", false);
   }else{
      $('#chooselogo').hide(); 
   }
}

function enableSocialShare(v){
   if($(v).prop("checked") == true){
       $('#socialshareSetting').show();
   }else{
      $('#socialshareSetting').hide(); 
   }
}

function enableFacebook(v){
    if($(v).prop("checked") == true){
        $('#is_fb_share').show();  
    }else{
        $('#is_fb_share').hide();
    }
}
function enableInstagram(v){
    if($(v).prop("checked") == true){
        $('#is_insta_share').show();  
    }else{
        $('#is_insta_share').hide();
     }
}
function enableTwitter(v){
    if($(v).prop("checked") == true){
           $('#is_twitter_share').show();  
            }else{
         $('#is_twitter_share').hide();
              }
}
function enableLinkedin(v){
    if($(v).prop("checked") == true){
        $('#is_linkedin_share').show();  
     }else{
        $('#is_linkedin_share').hide();
    }
}
function enableemailfriend(v){
   if($(v).prop("checked") == true){
       $('#emailfriend').show();
   }else{
      $('#emailfriend').hide(); 
   }
}
function enabletweetMP(v){
    if($(v).prop("checked") == true){
        $('#tweetMptext').show();  
    }else{
        $('#tweetMptext').hide();
    }
}
/**********************/
$(document).ready(function() {
    
     $('#table-filter').change();	
     
	if ($("#sucessMessages").length) {
      $("#sucessMessages").delay(2000).fadeOut();
    }
	if ($("#errorMessages").length) {
      $("#errorMessages").delay(2000).fadeOut();
    }
	
    if ($("#success_message").length) {
      $("#success_message").delay(2000).fadeOut();
    }
	if ($("#error_message").length) {
	$("#error_message").delay(2000).fadeOut();
	}
});
/**********************/
$('#update_datasetdetailsbtn').click(function(){
    var submit_form = true;
    $('#update_datasetdetails .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
    });
    if(submit_form){
      saveData('update_datasetdetails','<?php echo BASE_URL; ?>projects/update_datasetdetails','message');
    }
});

$('#update_visualsbtn').click(function(){
    var submit_form = true;
    $('#update_datasetvisualsForm .required').each(function(){
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
             $(this).siblings('.error').hide();
        }
    });
    if(submit_form){
      saveData('update_datasetvisualsForm','<?php echo BASE_URL;  ?>projects/update_datasetdetails','message');
    }
});

function removeMsg(id){
	    setTimeout(function(){ 
	       	document.getElementById(id).style.display = "none";
	    }, 3000);
}

function filterbyclientreflectgroup(v){
   var cid = $('option:selected', v).attr('cid');
   	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/ajaxfunctions',
            type: 'post',
            data: {'cid': cid, 'action':'filterbyclientreflectgroup'},
            success: function(response){
				$('#groupData').html(response);
             }
         });
}

$('.invert_node_ranking_data').hide();
function isnoderankinggroup(v){
     if($(v).prop("checked") == true){
       $('.invert_node_ranking_data').show();
   }else{
      $('.invert_node_ranking_data').hide(); 
   }
}
// $('.restrict_children-btn').hide();
function isdatagroup(v,id){

	if($('#menuItem_'+id).hasClass('group-true')){
		$('#menuItem_'+id).removeClass('group-true');
	}else{
		$('#menuItem_'+id).addClass('group-true');
	}
	 if($('#restrict_children'+id).prop("checked") == true){
       var restrict_children = 1;
     }else{
         var restrict_children = 0;
     }
     
     if($(v).prop("checked") == true){
       var value = $(v).val();
       $('.rcb'+id).show();
     }else{
         $('.rcb'+id).hide();
         var value = '0'; 
          var restrict_children = 1;
     }

          	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/isdatagroup',
            type: 'post',
            data: {'dvalue': value, 'id':id , 'action':'datagroup','restrict_children':restrict_children},
            success: function(response){
             }
         });     
}

// isdatagroupBYRestrictChildren
function isdatagroupBYRestrictChildren(id){
    // $('#is_datagroup'+id).trigger('click');
     if($('#restrict_children'+id).prop("checked") == true){
       var restrict_children = 1;
     }else{
         var restrict_children = 0;
     }
     
         if($('#is_datagroup'+id).prop("checked") == true){
       var value = $('#is_datagroup'+id).val();
     }else{
         var value = '0'; 
         var restrict_children = 1;
     }

          	$.ajax({
            url: '<?php echo BASE_URL; ?>projects/isdatagroup',
            type: 'post',
            data: {'dvalue': value, 'id':id , 'action':'datagroup','restrict_children':restrict_children},
            success: function(response){
             }
         });  
}

/*******************/
	function viewImportedNodes(project_id,send_url){
	    $('#loaderedit').show();
		$.ajax({
			url: send_url,
			data: {'project_id':project_id},
			type: 'POST',
			success: function(res) {
			 //   console.log(res);
			var res = jQuery.parseJSON(res);
			if (res.success == 200) {
			    
				$('#AllDataViewModel').html(res.html_data);
				$("#ViewNodesModal").modal('show');
			 $('#loaderedit').hide();
				
			}else{
				//html_data
			}
			},
			error: function() {
			alert('An error has occurred');
			}
			});
	}


  // analytic tweet mp 
  $('body').on('click', '.t-mp-tweet', function() {
	    $('.t-mp-tweet #loaderedit').show();
      var url =  '<?php echo BASE_URL; ?>analytics/gettweetmpdata';
      $.ajax({
			url: url,
			type: 'GET',
			success: function(res) {
			var res = jQuery.parseJSON(res);
			if (res.success == 200) {
        $('#exportBTN').hide();
        $('#tweet_mp_view_Modal .modal-title').empty().html('Tweet Mp View');
				$('#tweet_mp_view_data').empty().html(res.html_data);
				$("#tweet_mp_view_Modal").modal('show');
	    $('.t-mp-tweet #loaderedit').hide();
			}else{
				//html_data
        // console.log(res);
			}
			},
			error: function() {
			alert('An error has occurred');
			}
			});
});

  // analytic email mp 
  $('body').on('click', '.t-email-mp', function() {
    $('.t-email-mp #loaderedit').show();
      var url =  '<?php echo BASE_URL; ?>analytics/getemailmpdata';
      $.ajax({
			url: url,
			type: 'GET',
			success: function(res) {
			var res = jQuery.parseJSON(res);
			if (res.success == 200) {
        $('#exportBTN').show();
        $('#tweet_mp_view_Modal .modal-title').empty().html('Email Mp View');
				$('#tweet_mp_view_data').empty().html(res.html_data);
				$("#tweet_mp_view_Modal").modal('show');
     $('.t-email-mp #loaderedit').hide();
			}else{
				//html_data
        // console.log(res);
			}
			},
			error: function() {
			alert('An error has occurred');
			}
			});
});

$('body').on('click', '.cnfrm-btn', function() {
      var url =  '<?php echo BASE_URL; ?>analytics/confirmUnconfirmAnalytics';
      var id = $(this).data('id');
      var text = $(this).html();
      var datetime = '<?php echo date('Y-m-d H:i:s'); ?>';
      if(text == 'Confirm'){
      $(this).html('Unconfirm');
      $(this).css('color','green');
      $(this).addClass('btn-light-green');
      $(this).removeClass('btn-light-gray');
      $('#timeid'+id).html(datetime);
    }else{
      $(this).html('Confirm');
      $(this).css('color','red');
      $('#timeid'+id).html('');
      $(this).removeClass('btn-light-green');
      $(this).addClass('btn-light-gray');
    }
      $.ajax({
			url: url,
			type: 'POST',
      data: {'id':id},
			success: function(res) {
				var res = jQuery.parseJSON(res);
			if (res.success == 200) {
        $('.responsemsg').html(res.msg);
        setTimeout(() => {
        $('.responsemsg').html('');
        }, 3500);
      }
			},
			error: function() {
			alert('An error has occurred');
			}
			});
});

// export excel 
function exportData(){

  var img = '<img id="loaderedit" src="<?php echo BASE_URL.'public/web/'; ?>images/ajax-loader.gif">';
  $('#exportBTN').html(img);
  var url =  '<?php echo BASE_URL; ?>analytics/exportDATA';
      $.ajax({
			url: url,
			type: 'GET',
			success: function(res) {
			var res = jQuery.parseJSON(res);
			if (res.success == 200) {
        csvContent = "data:text/csv;charset=utf-8,";
         var rows = res.html_data;
        rows.forEach(function(rowArray){
            var row = rowArray.join(" ,");
            csvContent += row + "\r\n";
        });
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "export.csv");
        document.body.appendChild(link);
        link.click();
   $('#exportBTN').html('Export');

			}else{
        // console.log(res);
			}
			},
			error: function() {
			alert('An error has occurred');
			}
			});
      
}


	
// 	***************
$('body').on('keyup', '#dfname', function() {
    $("#dname").val($(this).val());
    
});

$('body').on('keyup', '#cname', function() {
    $("#c_displayname").val($(this).val());
});
$('body').on('keyup', '#cname1', function() {
    $("#chart_displayname").val($(this).val());
});


// drag 
$(function() {
    $("#allFacets, #selected_fields").sortable({
      connectWith: "div",
      placeholder: "placeholder",
      delay: 150
    })
    .disableSelection()
    .dblclick( function(e){
      var item = e.target;
      if (e.currentTarget.id === 'allFacets') {
        //move from all to user
        $(item).fadeOut('fast', function() {
          $(item).appendTo($('#selected_fields')).fadeIn('slow');
        });
      } else {
        //move from user to all
        $(item).fadeOut('fast', function() {
          $(item).appendTo($('#allFacets')).fadeIn('slow');
        });
      }
    });
  });

  // $('body').on('click','.make_pdf', function(){

  //   $("#allFacets1, #selected_fields1").sortable({
  //     connectWith: "div",
  //     placeholder: "placeholder",
  //     delay: 150
  //   })
  //   .disableSelection()
  //   .dblclick( function(e){
  //     var item = e.target;
  //     if (e.currentTarget.id === 'allFacets1') {
  //       //move from all to user
  //       $(item).fadeOut('fast', function() {
  //         $(item).appendTo($('#selected_fields1')).fadeIn('slow');
  //       });
  //     } else {
  //       //move from user to all
  //       $(item).fadeOut('fast', function() {
  //         $(item).appendTo($('#allFacets1')).fadeIn('slow');
  //       });
  //     }
  //   });
  // });


// function dragStart(event) {
//   event.dataTransfer.setData("Text", event.target.id);
// }

// function dragging(event) {
//   // document.getElementById("demo").innerHTML = "The p element is being dragged";
// }

// function allowDrop(event) {
//   event.preventDefault();
// }

// function drop(event) {
//   event.preventDefault();
//   var data = event.dataTransfer.getData("Text");
//   event.target.appendChild(document.getElementById(data));
//   // document.getElementById("demo").innerHTML = "The p element was dropped";
// }
// function dragStart1(event) {
//   event.dataTransfer.setData("Text", event.target.id);
// }

// function dragging1(event) {
//   // document.getElementById("demo").innerHTML = "The p element is being dragged";
// }

// function allowDrop1(event) {
//   event.preventDefault();
// }

// function drop1(event) {
//   event.preventDefault();
//   var data = event.dataTransfer.getData("Text");
//   event.target.appendChild(document.getElementById(data));
//   // document.getElementById("demo").innerHTML = "The p element was dropped";
// }


// **********************
$(document).ready(function() {
    setTimeout(function () {
// $('#table-filter').trigger('change');
$('#table-filter').change();
                 }, 500);
                 


    $('body').on('change paste keyup', '.minKeyvalue', function() {
      $('.display-range').click();
      if ($("#link_values").prop('checked') == true) {
        var disc = $(this).parents().next().find('.maxKeyvalue').val();
        $(this).parents().next().find('.maxKeyvalue').val($(this).val());
     var next_id =  $(this).parents().next().find('.maxKeyvalue').data('id');
     $('.max-display[data-id=' + next_id + ']').val($(this).val());
      }
     var data_id =  $(this).data('id');
      $('.min-display[data-id=' + data_id + ']').val($(this).val());
    });
    
      $('body').on('change paste keyup', '.maxKeyvalue', function() {
        $('.display-range').click();
      if ($("#link_values").prop('checked') == true) {
        $(this).parents().prev().find('.minKeyvalue').val($(this).val());
        var prev_id =  $(this).parents().prev().find('.minKeyvalue').data('id');
     $('.min-display[data-id=' + prev_id + ']').val($(this).val());
      }
      var data_id =  $(this).data('id');
    $('.max-display[data-id=' + data_id + ']').val($(this).val());
    });
    
        $('body').on('change', 'input[type=checkbox][name=show_last_key]', function ()
{
  $('.display-range').click();
  if(this.checked) {
        $('.lastkey').attr('type','text');
        $('.lasykeyplus').hide();
        $('.lasykeyminus').show();
    }else{
      $('.lastkey').attr('type','hidden');
        $('.lasykeyplus').show();
        $('.lasykeyminus').hide();
    }

});

$('body').on('click', '#save_display_range', function ()
{
  $('#save_display_range').data('value','Yes');
  $('#save_display_range').attr('disabled',true);
      $('#datafield_btn_update').html('Loading...');
       $('#datafield_btn_update').attr('disabled',true);
  $('body').find('#addColorBtnm').trigger('click');

});


         
 $('body').on('change', 'input[type=radio][name=key_value_option]', function ()
{
     $('#datafield_btn_update').html('Loading...');
     $('#datafield_btn_update').attr('disabled',true);
       
    if (this.value == 'Equal Ranges') {
       $('.minKeyvalue').attr('readonly',true);
          $('.lastkeyoption').show();
       $('.maxKeyvalue').attr('readonly',true);
       $('#l_interval').removeAttr('readonly');
      $('#f_interval').removeAttr('readonly');
            $('.linkvalues').hide();
    }
    else if (this.value == 'Custom Ranges') {
        $('.linkvalues').show();
                       $('.lastkeyoption').show();

      $('.minKeyvalue').removeAttr('readonly');
      $('.maxKeyvalue').removeAttr('readonly');
      $('#l_interval').attr('readonly',true);
      $('#f_interval').attr('readonly',true);
    }
    else if(this.value == 'Equal Count'){
             $('.linkvalues').hide();
             $('.lastkeyoption').hide();

      $('.minKeyvalue').attr('readonly',true);
      $('.maxKeyvalue').attr('readonly',true);
      $('#l_interval').attr('readonly',true);
      $('#f_interval').attr('readonly',true);
    }
    setTimeout(function() {
      mapKeyBtnUpdate();
      }, 1);  
});          
                 
$(".select-css1").select2();


}); // document ready close 
</script>

</body>
</html>
<!--footer.php end +-= this-->

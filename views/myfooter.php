<!--//myfooter.php-->

</div><!-- Main Content -->
<?php $site_url = $protocol . $_SERVER['HTTP_HOST']; ?>
<!--<footer>-->
<!--    <div class="container">-->
<!--        <p>©<?php echo date('Y'); ?> PoliMapper</p>-->
<!--        <ul>-->
<!--            <li><a href="<?php echo BASE_URL; ?>/dashboard#/" title="">Dashboard</a></li>-->
<!--            <li><a href="<?php echo BASE_URL; ?>/dashboard#/" title="">Widgets</a></li>-->
<!--            <li><a href="<?php echo BASE_URL; ?>/dashboard#/" title="">About us</a></li>-->
<!--            <li><a href="<?php echo BASE_URL; ?>/dashboard#/" title="">Contact us</a></li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</footer>-->

<!--new -->
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
<script src="<?php echo BASE_URL; ?>public/assets/js/sweetalert2.all.min.js"></script>
<script>$(document).ready(function(){ $('[data-toggle="tooltip"]').tooltip(); });</script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.js"></script>
<script src="<?php echo BASE_URL; ?>public/assets/js/Mapp.rows.js"></script>
<!--new -->

<!-- Our Website Javascripts -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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

var table = $('.tbl-content');
   table.find('tr').each(function (i, el) {
        var tds = $(this).find('td');
        if(tds.hasClass("errorfield")){
           jQuery.fn.scrollTo = function(elem) { 
    $(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top); 
    return this; 
};
$(".tbl-content").scrollTo(".errorfield"); 
return false;
        }
        // do something with productId, product, Quantity
    });

// active class script start
// let keysToRemove = ["li1", "li2","li3","li4","li5", "li6"];
function putdatavalue(datakey,num){
	console.log(datakey);
$('.DFname').val(datakey);
$('.DPname').val(datakey);
$('#datakeyVal').val(datakey);
$('#sequenceVal').val(num);
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
    $('#' + activetab).children().attr('aria-expanded', 'true');
    
    $('#'+ activetab).addClass('active');
    $(tabid).addClass('active');
  if(tabid == '#'){
        $('.tab-pane').each(function(){
            $(this).addClass('active');
        });
    }
}
// window.onload = function (){
//     var clicktab = localStorage.getItem('clicktab');
//     $('#'+ clicktab).addClass('active');
//      $('#'+ 'id'+ clicktab).css('display', 'block');
// }
     
// active class script end
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

if(window.location.pathname == '/dashboard/projects/viewprojects.php'){
localStorage.setItem('message_viewprojects', res.msg);
$('.editdatafieldvalue ').modal('hide');
}

if(res.redirect_url != undefined){
    location.href = res.redirect_url;
}
  setTimeout(function() { $('.' + responseDiv).html(''); }, 4000);  
 
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
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
     saveData('addUserForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/users/addusers.php','message');
}
    
});

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
    
    
    
    if(submit_form){
     saveData('updateuserProfile','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/setting/updateUserProfile.php','message');
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
     saveData('addProjectForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/addprojects.php','message');
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
     saveData('editProject','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/update.php','message');
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
     saveData('addProjectgroupForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projectsgroup/addprojects.php','message');
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
     saveData('updateProjectgroupForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projectsgroup/update.php','message');
}
    
});




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
    if(submit_form){
     saveData('updateUserForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/users/update.php','message');
}
    
});

$('#upgradeDowngrademailbtn').click(function(){


     saveData('upgradeDowngradeform','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/sendmailadmin.php','message');

    
});



$('#savePass').click(function(){
var url = $(this).attr('page');
var submit_form = true;
    $('#passForm .required').each(function(){
   
        if($(this).val() == ''){
            $(this).siblings('.error').show();
          submit_form = false;  
        }else{
            
             $(this).siblings('.error').hide();
        }
            
    });
    if(submit_form){
     saveData('passForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/'+url+'/addpassword.php','message');
}
    
});




$('.error').hide();
    $(document).ready(function(){

    "use strict";

    //*** Piety Mini Charts ***//
        $(function() {
            $(".bar").peity("bar", {
              fill: ["#ff8484"],
              height: ["40px"],
              width: ["94px"]
            })

            $(".bar2").peity("bar", {
              fill: ["#9797ff"],
              height: ["40px"],
              width: ["94px"]
            })
        });

    });
	$(".js-select2").select2({
			closeOnSelect : false,
			placeholder : "Select",
			maximumDisplayOptionsLength:"5",
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		});
			$(".js-select2clients").select2({
			closeOnSelect : false,
			placeholder : "Select",
			maximumDisplayOptionsLength:"5",
			allowHtml: true,
			allowClear: true,
			tags: true // создает новые опции на лету
		});
	

		
		
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
            url: '<?php echo $CurPageURL; ?>/dowithselected.php',
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

            url: '<?php echo $CurPageURL; ?>/saveshorting.php',

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
function addFields(id,mid){
var str = '<form action="javascript:void(0)" id="dataFields" class="edit-project" method="post">'+

'<div class="form-group">'+
'<label for="">Name</label>'+
'<input type="text" class="form-control required" name="name" id="name" placeholder="Name" value="">'+
'<div class="text-danger"></div>'+
'<span class="error">Name is required</span>'+
'</div>'+
'<div class="form-group">'+
'<label for="">Description</label>'+
'<textarea type="text" class="form-control" name="description" id="description" placeholder="Description">'+

'</textarea>'+

'</div>'+
'<div class="form-group">'+
'<label for="">Type</label>'+
'<select class="form-control" id="dataType" onchange="getType(this)" name="type">'+
'<option value="Text" >Text</option>'+
'<option value="Number" >Number</option>'+
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
'<input type="checkbox" name="comparable" id="comparable" class="dn" value="true">'+
'<label for="comparable" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'<div class="grouping-method">'+
'<label for="">Grouping method</label>'+
'<select class="form-control" name="grouping">'+
' <option disabled selected>Select grouping</option>'+ 
'<option value="EqualRanges" >Equal Ranges</option>'+ 
'<option value="Percentiles" >Percentiles</option>'+ 
'</select>'+
'</div>'+
'</div>'+
'<div class="form-group link_and_text" style="display:none;">'+
'<label for="">Link Text</label>'+
'<input type="text" class="form-control" name="link_text" id="link_text" placeholder="Link Text" value="Click Here">'+
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
'<div class="form-group">'+
'<div class="toggleWrapper">'+
'<label for="">Show total in the data set summary</label>'+
'<input type="checkbox" name="total_data_set_summary" id="total_data_set_summary" class="dn" value="true">'+
'<label for="total_data_set_summary" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'</div>'+
'</div>'+
'<div class="form-group multivalued-data">'+
'<div class="toggleWrapper">'+
'<label for="">Multivalued</label>  '+
'<input type="checkbox" name="multivalued" id="multivalued" class="dn" value="true">'+
'<label for="multivalued" class="toggle"><span class="toggle__handler"></span></label>'+
'</div>'+
'<div class="graph-type">'+
'<label for="">Graph Type</label>'+
'<select class="form-control" name="graphtype">'+
'<option disabled selected>Select graph</option>'+ 
'<option value="BarGraph" >Bar graph</option>'+ 
'<option value="LineGraph" >Line graph</option>'+ 
'</select>'+
'</div>'+
'</div>'+
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
'<input type="hidden" value="'+mid+'" name="mid" />'+
'<input type="hidden" value="'+id+'" name="id" />'+
'<div class="text-center"><button type="button" id="datafield_btn" class="btn cus-btn">Submit</button></div>'+
'</form>';
$('.add-data-field .modal-body').html(str);
// $('.inner-data').hide();
$('.error').hide();
$('.invert-node').hide();
$('.graph-type').hide();
$('.grouping-method').hide();
$('.average-override').hide();
$('.dataset_summary').hide();
	$('.add-data-field').modal('show');
	
}

function colorChange(v){
        $(v).siblings('.colorValueInput').val($(v).val());
}
function addColor(){
var count = $('.colorBox').size() + 1;
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
 
  
   if(count <= 10){
        console.log(count);
        $("#addBtnBox").show();
   }
    
}

 $('body').on('keyup', '.footer_content_data .richText-editor', function ()
    {
        $('.preview_footer_data').html($(this).html()); 
    }
    );





$('.textEditor').richText();

     
     $('.footerEditor').richText();

function colorValueChange(v){
    $(v).siblings('.colorInput').val($(v).val());
}




	 </script>
<script type="text/javascript">
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

$("#packages tbody").sortable({

    helper: fixHelperModified,

    stop: updateIndex

}).disableSelection();	 
	 



	 
	 </script>
	 <script type="text/javascript">
$(document).ready(function() {
  $('input[type="file"]').on("change", function() {
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
    console.log(v);
    $(v).parent('.interim').css("background-color", $(v).val());
}

function updateprojectStatus(v,page){
   var status = 'draft';
   if(page == 'projectsgroup'){
       var url = '/dashboard/projectsgroup/projectstatus.php';
       var msg = 'project group';
   }else{
       var url = '/dashboard/projects/projectstatus.php';
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

            url: '<?php echo $site_url; ?>'+url,
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

            url: '<?php echo $site_url; ?>/dashboard/users/clientfilter.php',
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

            url: '<?php echo $site_url; ?>/dashboard/projectsgroup/projectfilter.php',
            type: 'post',
            data: { 'clientId':clientId, 'groupId':groupId },


            success: function(response){
           
                $('.appendData').html(response);
                console.log(response);
             

             }

         }); 
}
    


function filterBygroup(v){
    
    var groupId = $(v).val();
    
    	$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/projects/groupfilter.php',
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

function selectCompany(v){
    var id = $(v).val();
    console.log(id);
    
    var selectedText = $(v).find("option:selected").text();
     	$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/projects/selectcompany.php',
            type: 'post',
            data: {'client_id': id, 'cname':selectedText},

			dataType:'json',

            success: function(response){
         
    
      if(response.success == 1){
            $('.message').html('<div class="alert alert-success">' + response.msg + '</div>');
       
              setTimeout(function() { $('.' + 'message').html(''); }, 3000); 
                if(window.location.href == '<?php echo $site_url; ?>/dashboard/projects/'){
                  location.reload();
            }
}else if(response.success == 0){
    $('.message').html('<div class="alert alert-danger">' + response.msg + '</div>'); 
    setTimeout(function() { $('.' + 'message').html(''); }, 3000); 
}

             }

         });

}
// $('.inner-data').hide();
$('.error').hide();
$('.invert-node').hide();
$('.graph-type').hide();
$('.grouping-method').hide();
$('.average-override').hide();
$('.dataset_summary').hide();
$('.inner-data').show();

function getType(v){
    if(v.value == 'Text'){
        $('.comparable-data').show();
        $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
         $('.inner-data').hide();
		 $('.link_and_text').hide();
   } else if(v.value == 'Hyperlink' ){
          $('.grouping-method').hide();
        $('.graph-type').hide();
        $('.average-override').hide();
        $('.dataset_summary').hide();
       $('.inner-data').hide();
       $('.comparable-data').hide();
       $('.link_and_text').show();
   }else{
	   $('.link_and_text').hide();
       $('.comparable-data').show();
       $('.inner-data').show();  
   }
}

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
        
    //   saveData('dataFields','<?php //echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/adddatafields.php','message');
     // new start
    
formId = '#' + 'dataFields';
var formData = new FormData($(formId)[0]);

$.ajax({
url: '<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/adddatafields.php',
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
var responseDiv = 'text-danger'
if (res.success == 1) { 
    // $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>');

if(window.location.pathname == '/dashboard/projects/viewprojects.php'){
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
      saveData('updateCompanyForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/setting/updateCompany.php','message');
}  
});








function editProjectsForm(id,proid){
	
		$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/projects/getprojectfields.php',
            type: 'post',
            data: {'projectfield_id': id, 'proid': proid},
            success: function(response){
            $('.add-data-field .modal-content').html(response);
    	$('.add-data-field').modal('show');
       

             }

         });
	
	
	
}




function editProjectsfieldsvalueForm(cid,pid,name){
    	$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/projects/getprojectfieldsvalue.php',
            type: 'post',
            data: {'cid': cid, 'proid': pid},


            success: function(response){
         
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
        
    //   saveData('updatedataFields','<?php //echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/updatedatafields.php','message');
    // new start
    
formId = '#' + 'updatedataFields';
var formData = new FormData($(formId)[0]);

$.ajax({
url: '<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/updatedatafields.php',
data: formData,
type: 'POST',
processData: false,
contentType: false,
success: function(res) {
var res = jQuery.parseJSON(res);
var responseDiv = 'text-danger'
if (res.success == 1) { 
    // $('.' + responseDiv).html('<div class="alert alert-success">' + res.msg + '</div>');

if(window.location.pathname == '/dashboard/projects/viewprojects.php'){
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


}

// $('body').on('click','.editdatafield',function(){
//     location.reload();
// });

$('body').on('click','#updateProjectsFieldvalue',function(){
    saveData('dataFieldsvalue','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/updatecountryfieldvalue.php','message'); 
    
});

function displayClientList(pid){
    
    	$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/packages/packagesclient.php',
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
function enableSocialShare(v){
   if($(v).prop("checked") == true){
       $('#socialshareSetting').show();
   }else{
      $('#socialshareSetting').hide(); 
   }
}

    //  $('#is_fb_share').hide();
    //  $('#is_insta_share').hide();
    //  $('#is_twitter_share').hide();
    // $('#is_linkedin_share').hide();
    // $('#tweetMptext').hide();

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
function enabletweetMP(v){
    if($(v).prop("checked") == true){
           $('#tweetMptext').show();  
            }else{
         $('#tweetMptext').hide();
              }
}
/**********************/
$(document).ready(function() {
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
      saveData('update_datasetdetails','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/update_datasetdetails.php','message');
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
      saveData('update_datasetvisualsForm','<?php echo $protocol . $_SERVER['HTTP_HOST'];  ?>/dashboard/projects/update_datasetdetails.php','message');
    }
    
});

  
    function removeMsg(id){
	    setTimeout(function(){ 
	       	document.getElementById(id).style.display = "none";
	    }, 3000);
	}

function filterbyclientreflectgroup(v){

   var cid = $('option:selected', v).attr('cid');
   console.log(cid);

   	$.ajax({

            url: '<?php echo $site_url; ?>/dashboard/projects/ajaxfunctions.php',
            type: 'post',
            data: {'cid': cid, 'action':'filterbyclientreflectgroup'},


            success: function(response){
         
        $('#groupData').html(response);
    
             }

         });
   
}

</script>
</body>
</html>
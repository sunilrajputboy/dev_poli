<table class="table table-striped nodes-table" id="constituencyNodestable">
			<thead>
				<tr>
					<th>Country</th>
					<th style="display:none"></th>
					<th style="display:none"></th>
					<?php  foreach ($dataFieldsDataWithoutGroup as $dataf){  ?>
					<th style="display:none"></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
<?php if(!empty($nodeDetails)){
	  $i=0;
	  $tdData="";
	foreach($nodeDetails as $nd){ 
	    $f_name = $nd['field_name'];
		$f_value = $nd['field_value'];
		$d_id = $nd['data_id'];
	    $i++;
	      if($is_include_empty_nodes == 'false'){
	        if(!empty($nd['field_value'])){
	    $fieldValueArray[] = $nd['field_value'];
	    	$tdData.= '<td style="display:none">'.$f_name.': <span class="mainFieldValue-'.$d_id.'" id="mainFieldValue-'.$d_id.'">'.$f_value.'</span></td>';
	
	    } 
	    }else{
	        $fieldValueArray = array('not_empty');
	        	$tdData.= '<td style="display:none">'.$f_name.': <span class="mainFieldValue-'.$d_id.'" id="mainFieldValue-'.$d_id.'">'.$f_value.'</span></td>';
	    }
		$fieldDataarr[]=array('field_name'=>$nd['field_name'], 'field_value'=>$nd['field_value'],'field_id'=>$nd['field_id'],'data_id'=>$nd['data_id']);
			$f_name = $nd['field_name'];
		$f_value = $nd['field_value'];
		$d_id = $nd['data_id'];
		if($i==$count){
		$node_arr = array(
           "name" => $nd['name'],
           'id' => $nd['id'],
           "data" => $fieldDataarr
       );
	   $i=0;
	     if(!empty($fieldValueArray)){

?>
		 <tr id="id<?php echo $nd['id']; ?>">
			<td class="details-control"><?php echo $nd['name']; ?>
			</td>
			<td style="display:none"><?php echo $nd['id']; ?></td>
			<td style="display:none"><?php echo $pid; ?></td>
			 <?php echo $tdData;?>
		</tr>
		<?php  	$fieldDataarr = array();
		$tdData = '';
		$fieldValueArray = array();
	     }
		}
	}
}
?>
</tbody>
</table>
<script>                              
    var table2 = $('#constituencyNodestable').DataTable({
    "DisplayLength" : 5 ,
     lengthMenu: [[100, 200, -1], [100, 200, 'All']],
   });
     function format ( d ) {
         var str = '';
         for(i = 0;i<d.length;i++){
             if(d[i+3] != undefined){
            str = str + '<tr><td>'+d[i+3]+'</td><tr>';
             }
         if(i == d.length-1){
          localStorage.setItem("tableData", str);
         }
            }

var tdata = '<tr>'+localStorage.getItem("tableData")+'</tr>';
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            tdata
    +'</table><div class="btn-rounded"><a class="btn btn-info tool" data-tip="Edit" onclick="editProjectsfieldsvalueForm('+d[1]+','+d[2]+',`'+d[0]+'`)" href="javascript:void(0)"><i class="fa green fa-edit"></i></a></div>';
}
  
    $('#constituencyNodestable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table2.row( tr );

        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
  </script>
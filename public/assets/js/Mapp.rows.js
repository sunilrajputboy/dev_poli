$(document).ready(function(){
	$(document).on('click', '#getRow', function(e){
		$("#view-row").appendTo("body").modal();
		e.preventDefault();		
		var uid = $(this).attr("data-id").split(",");
		var uniquid = uid[0];
		var selected_table = uid[1];
		$('#dynamic-content1').html('');
		$('#modal-loader1').show();
		$.ajax({
			url: '/import/getRows',
			type: 'POST',
			data: {uniquid: uniquid, selected_table: selected_table},
			dataType: 'html'
		})
		.done(function(data){
			console.log(data);	
			$('#dynamic-content1').html('');    
			$('#dynamic-content1').html(data); 
			$('#modal-loader1').hide();	
		})
		.fail(function(){
			$('#dynamic-content1').html('Error');
			$('#modal-loader1').hide();
		});
		
	});
	
});;
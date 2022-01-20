<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Home</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
        	$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
        	function post(){
                var urls = $('input[name="mytext[]"]').map(function(){ 
                    return this.value; 
                }).get();
        		$.ajax({
			        url: "crawler",
			        type: "post",
			        data: JSON.stringify({"urls": urls}),
			        dataType: "json",
			        contentType: "application/json; charset=UTF-8",
			        success: function(data) {
						$('#mycount').empty();
			            console.log(data);
						for(item of data){
							var resslt = Object.values(item);
							var h = 'http://localhost/crawler/'+resslt[3]
							console.log(resslt);
							$('#mycount').append(`<div>title : <a href="http://localhost/crawler/public/detail?url=${resslt[0]}">  ${resslt[1]}  </a><br> description : <a> ${resslt[2]} </a><br>created_at : <a> ${resslt[4]} </a><br> Screenshot : <img src= ${h} / ></div>`)
						}
			        },
			        error: function(XMLHttpRequest, textStatus, errorThrown) {
			            console.log(errorThrown);
			        }
			    });
        	}
        </script>
		<script>
			$(document).ready(function() {
				var max_fields      = 10; //maximum input boxes allowed
				var wrapper         = $(".input_fields_wrap"); //Fields wrapper
				var add_button      = $(".add_field_button"); //Add button ID
				 
				var x = 1; //initlal text box count
				$(add_button).click(function(e){ //on add input button click
					e.preventDefault();
					if(x < max_fields){ //max input box allowed
						x++; //text box increment
						$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
					}
				});
				 
				$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
					e.preventDefault(); $(this).parent('div').remove(); x--;
				})
			});
		</script>
    </head>
    <body>
		<div class="input_fields_wrap">
			<button class="add_field_button">Add More Urls</button>
			<div><input type="text" name="mytext[]"></div>
		</div>
		
        <input type="button" value="post" onclick="post();"/>
		
		<span id="mycount"></span> 
    </body>
</html>
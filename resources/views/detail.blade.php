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
				const queryString = window.location.search;
				console.log(queryString);
				const urlParams = new URLSearchParams(queryString);
				const url = urlParams.get('url');
				const urls = url.split(',');
				console.log(urls);
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
							$('#mycount').append(`<div>title : <a href=  ${resslt[0]}  >  ${resslt[1]}  </a><br> description : <a> ${resslt[2]} </a><br>created_at : <a> ${resslt[4]} </a><br> Screenshot : <img src= ${h} / ></div>`)
						}
			        },
			        error: function(XMLHttpRequest, textStatus, errorThrown) {
			            console.log(errorThrown);
			        }
			    });
        	}
        </script>
    </head>
    <body onload="post()">
		<span id="mycount"></span> 
		
    </body>
</html>
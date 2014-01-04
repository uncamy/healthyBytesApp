var url_base = "http://54.200.197.190";

$(document).ready(function(){
  $(".category").change(function() {
 	$.ajax(url_base + "/entry_edit.php",
					  {type: "POST",
						  data: {category:$(this).val(), date:$(this).attr('date')},
						  success: function(data, status, jqXHR) {
					      },
						  error: function(jqXHR, status, error) {
						  alert('failed: ' + status);
					      }});
  });
  $(".portion").change(function() {
 	$.ajax(url_base + "/entry_edit.php",
					  {type: "POST",
						  data: {portion:$(this).val(), date:$(this).attr('date')},
						  success: function(data, status, jqXHR) {
					      },
						  error: function(jqXHR, status, error) {
						  alert('failed: ' + status);
					      }});
  });
  $(".calories").change(function() {
  	if(isNaN($(this).val())) {alert('Calories must be entered as a number!');}
 	$.ajax(url_base + "/entry_edit.php",
					  {type: "POST",
						  data: {calories:$(this).val(), date:$(this).attr('date')},
						  success: function(data, status, jqXHR) {
					      },
						  error: function(jqXHR, status, error) {
						  alert('failed: ' + status);
					      }});
  });
  $(".feel").change(function() {
 	$.ajax(url_base + "/entry_edit.php",
					  {type: "POST",
						  data: {feel:$(this).val(), date:$(this).attr('date')},
						  success: function(data, status, jqXHR) {
					      },
						  error: function(jqXHR, status, error) {
						  alert('failed: ' + status);
					      }});
  });
});

function logout() {
document.cookie = 'session_id' + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT';
var frame = document.createElement("iframe");
frame.src = 'http://instagram.com/accounts/logout/';
frame.onload = function() {
    location.reload();
};
document.body.appendChild(frame);
}

function deleteRow(row_id, url) {
	$('#'+row_id).remove();
	console.log(url);
	$.ajax(url_base + "/entry_edit.php?delete=yes&url="+url,
	       {type: "GET",
		       dataType: "json",
		       success: function(json, status, jqXHR) {
			   alert('Image Deleted!');
		   },
		   error: function(jqXHR, status, error) {
		   	alert(status);
		   }
	       });
}

function edit() {
	window.location.href = "http://54.200.197.190/customer_edit.html";
}


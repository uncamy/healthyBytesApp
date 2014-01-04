var url_base = "http://54.200.197.190";

$(document).ready(function () {
$.ajax(url_base + "/customer_edit.php",
	       {type: "GET",
		       dataType: "json",
		       success: function(json, status, jqXHR) {
			   display_page(json);
		   },
		   error: function(jqXHR, status, error) {
		   	alert(status);
		   }
	       });
$('#edit_form').on('submit',
			       function (e) {
				   e.preventDefault();
				   $.ajax(url_base + "/customer_edit.php",
					  {type: "POST",
						  dataType: "json",
						  data: $(this).serialize(),
						  success: function(json, status, jqXHR) {
						  submission_success(json);
					      },
						  error: function(jqXHR, status, error) {
						  alert('Invalid form submission!');
					      }});
			       });
});

function display_page (json) {
	$('#full_name').append(json.full_name);
	$('#head').append('<img src=\"' + json.profile_picture+ '\">');
	$("select[name='type']").val(json.type);
	$("select[name='sex']").val(json.sex);
	$("input[name='weight']").val(json.weight);
	$("input[name='height']").val(json.height);

}
function submission_success (json) {
	alert("Information Updated Successfully!");
}
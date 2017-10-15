$(function(){
	$("#notif").hide(0);
	updateStudentTimeList();
	setInterval(updateStudentTimeList, 10000);
});

function applyListeners(){
	$(".flex>span>button").click(function(){
		var name = $(this).val();

		$.post("studentTimes.php", {action:"reset", student:name}, function(data){
			$("#notif").html(name + " was reset.");
			$("#notif").show(400, function(){
				setTimeout(function(){
					$("#notif").hide(400)
				}, 3000);
			});
		});
	});
}

function updateStudentTimeList(){
	$.post("studentTimes.php", {action:"fetch"}, function(data){

		var studentInfo = JSON.parse(data);
			
		$("#studentListView").html("");
		$("#studentListView").append("<li class='list-group-item'><h3>Students</h3></li>");

		for (var key in studentInfo) {
		    if (studentInfo.hasOwnProperty(key)) {
				studentInfo[key] = new Date(studentInfo[key]);
				$("#studentListView").append("<li class='flex list-group-item'>" + 
						"<span>" + key + "</span>" + 
						"<span><span>" + getDiffString(new Date(), studentInfo[key]) + "</span>" +
						"<button type='button' value='" + key + "' class='btn btn-danger' aria-label='Left Align'>" +
						"<span class='glyphicon glyphicon-remove'></span>" + 
						"</button></span></li>");
			}
		}

		applyListeners();
	});
}

function getDiffString(date1, date2){

	var dif = date1.getTime() - date2.getTime();

	var secDiff = Math.abs(Math.floor(dif / 1000)) % 60;	
	var secDiffString = (secDiff < 10) ? "0" + secDiff : secDiff; 
	var minDiff = Math.abs(Math.floor(dif / 60000)) % 60;	
	var minDiffString = (minDiff < 10) ? "0" + minDiff : minDiff; 
	var hourDiff = Math.abs(Math.floor(dif / 3600000));	
	var hourDiffString = (hourDiff < 10) ? "0" + hourDiff : hourDiff; 

	return hourDiffString + ":" + minDiffString + ":" + secDiffString;
}

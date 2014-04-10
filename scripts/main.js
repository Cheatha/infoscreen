"use strict";
var graph_source;

function updateData() {
	$.ajax({
		url: 'ajax.php',
		success: function(data) {
			$("#temperature").html(data.temperature);
			$("#devices").html(data.devices);
			$("#power").html(data.power);
			$("#members").html(data.members);
			$("#memberratio").html(data.memberratio);
			$("#account").html(data.account);
			$("#internet_down").html(data.internet_down);
			$("#internet_up").html(data.internet_up);
			$("#payback").html(data.payback);
			if (data.door == 1) {
				$("#door").removeClass('open closed unknown').addClass('open');
				$("#door").html("Offen");
			} else if (data.door == 0) {
				$("#door").removeClass('open closed unknown').addClass('closed');
				$("#door").html("Geschlossen");
			} else {
				$("#door").removeClass('open closed unknown').addClass('unknown');
				$("#door").html("Unbekannt");
			}
			$('#frame').attr('src', function ( i, val ) { return val; });
			setTimeout('updateData()',30000);
		}
	}).fail(function() {
		alert("Something went wrong. Please try again.");
	});
}

function updateGraph() {
	$('.graph').attr('src', function ( i, val ) { return graph_source + "?v=" + new Date().getTime()});
	setTimeout('updateGraph()',120000);
}

function updateRnv(){
	$('.rnvtable').remove();
	$.ajax({
		url: "rnv.php"
	}).done(function(res){
		var data = $.parseHTML(res);
		var abfahrten = [[]];
		var block = 0;
		$(data).find('.ergebnis_txt').each(function(){
		    if(abfahrten[block].length>3){
		        block++;
		        abfahrten[block]=[];
		    }
		    abfahrten[block].push(this);
		});

		var tbl = $('<table class="rnvtable">')
		for(var i in abfahrten){
		    var row = $("<tr>");
		    row.append(abfahrten[i])
		    tbl.append(row)
		}
		$('#rnvcontent').append(tbl);

	});
	setTimeout('updateData()',30000);
}

function startClock() {
	var today=new Date();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();

	// add a zero in front of numbers<10
	m = checkTime(m);
	s = checkTime(s);
	$('#clock').html(h+":"+m+":"+s);
	setTimeout(function(){startClock()},500);
}

function checkTime(i) {
	if (i<10)	{
		i="0" + i;
	}
	return i;
}

$(document).ready(function() {
	startClock()
	updateData();
	updateRnv();
	graph_source = $('#graph').attr('src');
	setTimeout('updateGraph()',120000);
	document.body.style.zoom=document.documentElement.clientHeight/800;
});

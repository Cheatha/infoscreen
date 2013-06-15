<?php
include("ajax.php");
$data = getInfoscreenData();

// Send header
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 19 Jul 1997 00:00:00 GMT');
header('Content-type: application/json; charset=utf-8');

// Fill data
$data = array(
	"api" => "0.13",
	"space" => "RaumZeitLabor",
	"logo" => "http://raumzeitlabor.de/w/images/8/85/RaumZeitLabor_-_Logo_-_Schwarz.png",
	"url" => "http://raumzeitlabor.de",
	"location" => array(
		"address" => "Boveristrasse 22-24, 68309 Mannheim, Germany",
		"lon" => 8.4994033,
		"lat" => 49.5079481
	),
	"spacefed" => array(
		"spacenet" => false,
		"spacesaml" => false,
		"spacephone" => false
	),
	"contact" => array(
		"email" => "info@raumzeitlabor.de",
		"irc" => "irc://irc.hackint.eu/raumzeitlabor",
		"ml" => "raumzeitlabor@raumzeitlabor.de",
		"twitter" => "@RaumZeitLabor",
		"phone" => "+4962176231370",
		"issue-mail" =>  base64_encode("hello@tiefpunkt.com")
	),
	"issue_report_channels" => array("issue_mail"),
	"sensors" => array(
		"temperature" => array(
			array(
				"value"  => $data["temperature"],
				"unit" => "°C",
				"location" => "above the conference table"
			)
		),
		"power_consumption" => array(
			array(
				"value" => $data["power"],
				"unit" => "W",
				"location" => "Main room"
			)
		),
		"space_members" => array(
			array( "value" => $data["members"])
		),
		"network_connections" =>array( 
			array( "value" => $data["devices"])
		),
		"account_balance" => array(
			array(
				"value" => $data["account"],
				"unit" => "EUR"
			)
		) ,
	),
	"feeds" => array(
		"blog" => array(
			"type" => "application/rss+xml",
			"url" => "https://raumzeitlabor.de/feed/"
		),
		"log" => array(
			"type" => "application/rss+xml",
			"url" => "http://log.raumzeitlabor.de/rss"
		),
		"calendar" => array(
			"type" => "text/calendar",
			"url" => "https://raumzeitlabor.de/events.ics"
		)
	),
	"cache" => array( "schedule" => "m.02" ),
	"state" => array(
		"icon" => array(
			"open" => "http://status.raumzeitlabor.de/images/green.png",
			"closed" => "http://status.raumzeitlabor.de/images/red.png"
		),
		"open" => ($data["door"] == 1)
	),
	"projects" => array(
		"http://github.com/raumzeitlabor",
		"http://wiki.raumzeitlabor.de/wiki/Kategorie:Projekt"
	)
);

echo json_encode($data);
?>

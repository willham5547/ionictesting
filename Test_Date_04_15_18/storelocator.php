<?php
	require("phpsqlsearch_dbinfo.php");
	
	// Get parameters from URL
	$center_lat = $_GET["lat"];
	$center_lng = $_GET["lng"];
	$radius = $_GET["radius"];
	
	// Start XML file, create parent node
	$dom = new DOMDocument( "1.0", "UTF-8" );
	$dom->formatOutput = true;
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);
	
	// Opens a connection to a mySQL server
	$conn = new mysqli("localhost:3308", $username, $password, $database);
	//$conn = new mysqli("localhost", "root");
	if ($conn->connect_error) 
	{
	  printf( "<p>not connected</p>" );
	}
	
		
	// Search the rows in the laundrySense table
	$query = sprintf("SELECT id, name, address, locationType, lat, lng, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM laundrysense HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
	  $conn->real_escape_string($center_lat),
	  $conn->real_escape_string($center_lng),
	  $conn->real_escape_string($center_lat),
	  $conn->real_escape_string($radius));
		
	
	//$result = $conn->query( $query )
	$result = $conn->query( $query );
	if ( $result->num_rows > 0 ) 
	{
		
		// Iterate through the rows, adding XML nodes for each
		while ($row = $result->fetch_assoc())
		{
			$node = $dom->createElement("marker", "place holder");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("id", $row['id']);
			$newnode->setAttribute("name", $row['name']);
			$newnode->setAttribute("address", $row['address']);
			//$newnode->setAttribute("num_of_devices", $row['num_of_devices']);
			$newnode->setAttribute("lat", $row['lat']);
			$newnode->setAttribute("lng", $row['lng']);
			$newnode->setAttribute("distance", $row['distance']);
			$newnode->SetAttribute("locationType", $row['locationType']);
			
			$query_wash_status = sprintf("SELECT status FROM devices where id = '%s' AND status = 'available' AND type = 'washer' ", $row['id']);
			$result_wash_status = $conn->query( $query_wash_status);
			$newnode->setAttribute("number_of_available_wash", $result_wash_status->num_rows );
			
			$query_wash_dev = sprintf("SELECT id FROM devices where id = '%s' AND type = 'washer' ", $row['id']);
			$result_wash_dev = $conn->query( $query_wash_dev);
			$newnode->setAttribute("num_of_wash_devices", $result_wash_dev->num_rows );

			$query_dry_status = sprintf("SELECT status FROM devices where id = '%s' AND status = 'available' AND type = 'dryer' ", $row['id']);
			$result_dry_status = $conn->query( $query_dry_status);
			$newnode->setAttribute("number_of_available_dry", $result_dry_status->num_rows );
			
			$query_dry_dev = sprintf("SELECT id FROM devices where id = '%s' AND type = 'dryer' ", $row['id']);
			$result_dry_dev = $conn->query( $query_dry_dev);
			$newnode->setAttribute("num_of_dry_devices", $result_dry_dev->num_rows );			

		}
	
		
		echo $dom->saveXML();
		
		
	}
	else
	{
	  printf( "No rows returned<br />" );
	}
	
?>
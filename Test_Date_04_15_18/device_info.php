<!DOCTYPE html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>LaundrySense</title>
		<style>
			/* Optional: Makes the sample page fill the window. */
			html, body {
			  height: 95%;
			  text-align: center;
			  background: rgb(225, 225, 225);
			}
			
			/* Modal Content */
			table {
			  margin: auto;
			  border: 1px solid #888;
			  width: 80%;
			  background: rgb(255, 255, 255);
			}
			
			.colorRed {
			  background-color: red;
			}
			
			.colorYellow {
			  background-color: yellow;
			}		

			.colorGreen {
			  background-color: green;
			}				
			
		</style>
	</head>
	<body>
	
		<?php 
			$temp1 = $_GET["name"];
			$search = "\"" ;
			$temp2 = str_replace($search, "", $temp1);
			$search1 = "\%20" ;
			$name = str_replace($search1, " ", $temp2);
			$title = "Available Washers and Dryers at ";
			echo "<h1> " . $title . $name . "</h1>"; 
		
		?>
		
		<table border="1" cellspacing="1" cellpadding="1">
			<tr>
				<th>&nbsp;address&nbsp;</th>
				<th>&nbsp;status&nbsp;</th>
				<th>&nbsp;timestamp&nbsp;</th>
				<th>&nbsp;type&nbsp;</th>
			</tr>

		  <?php 
			require("phpsqlsearch_dbinfo.php");
			
			// retrieve id info
			$temp = $_GET[ "id" ];
			$search = "\"" ;
			$id = str_replace($search, "", $temp) ;
			
			
			// Create connection
			$conn = new mysqli("localhost:3308", $username, $password, $database);
			// Check connection
			if ($conn->connect_error) 
			{
				printf( "<p>" . $id . "</p>");
				printf( "<p>not connected</p>" );
				die("Connection failed: " . $conn->connect_error);
			}	
			else
			{
				//printf( "DB connection successful<br />" );
				
			}
			
			// create SQL select statement
			$sql_select = "select * from devices where id = '" . $id . "';" ;
			$result = $conn->query($sql_select);
			//printf("Select returned %d rows.\n", $result->num_rows);
			
			if( $result->num_rows > 0 )
			{
				while($row = $result->fetch_assoc()) 
				{
					if( $row["status"] == "idle"){
						printf("	<tr class='colorYellow' >
								<td> &nbsp;%s </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
							</tr>"
							,$row["mac_address"], $row["status"], $row["timestamp"], $row["type"]);						
					}elseif( $row["status"] == "available"){
							printf("	<tr class='colorGreen' >
								<td> &nbsp;%s </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
							</tr>"
							,$row["mac_address"], $row["status"], $row["timestamp"], $row["type"]);						
					}else{
							printf("	<tr class='colorRed' >
								<td> &nbsp;%s </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
								<td> &nbsp;%s&nbsp; </td>
							</tr>"
							,$row["mac_address"], $row["status"], $row["timestamp"], $row["type"]);						
					}

				}
				mysqli_free_result($result);
				
			}
			else
			{
				printf( "No rows returned<br />" );
				echo "'" . $sql_select . "'";
			}
			
			mysqli_close($conn);
		  ?>

	   </table>
	   
	   
	   
	</body>
</html>
<!DOCTYPE html >
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>The Wash Store Locator</title>
  <style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
      height: 100%;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    #legend {
      font-family: Arial, sans-serif;
      background: #fff;
      padding: 10px;
      margin: 10px;
      border: 3px solid #000;
    }
    #legend h3 {
      margin-top: 0;
    }
	#legend img {
      vertical-align: middle;
    }
 </style>
  </head>
  <body style="margin:0px; padding:0px;" onload="initMap()">
    <div>
         <label for="raddressInput">Search location:</label>
         <input type="text" id="addressInput" size="15"/>
        <label for="radiusSelect">Radius:</label>
        <select id="radiusSelect" label="Radius">
          <option value="50" selected>50 kms</option>
          <option value="30">30 kms</option>
          <option value="20">20 kms</option>
          <option value="10">10 kms</option>
        </select>

        <input type="button" id="searchButton" value="Search"/>
		
		<script>
		var input = document.getElementById("addressInput");
		input.addEventListener("keyup", function(event) {
			event.preventDefault();
			if (event.keyCode === 13) {
				document.getElementById("searchButton").click();
			}
		});
		</script>
		
    </div>
    <div><select id="locationSelect" style="width: 10%; visibility: hidden"></select></div>
    <div id="map" style="width: 100%; height: 72.5%"></div>
	<div id="legend"><h3>Legend</h3></div>
    <script>
      var map;
      var markers = [];
      var infoWindow;
      var locationSelect;
	  
	  var customLabel = {
        school: {
          label: 'S',
		  name: 'School',
        },
        dorm: {
          label: 'D',
		  name: 'Dorm'
        },		
        apartment: {
          label: 'A',
		  name: 'Apartment'
        },
		laundromat: {
          label: 'M',
		  name: 'Laundromat'
        }
      };
	  
      var legend = document.getElementById('legend');
      for (var key in customLabel) {
        var type = customLabel[key];
        var name = type.name;
        var label = type.label;
        var div = document.createElement('div');
        div.innerHTML = '<b>' + label + '</b>' + ' ' + name;
        legend.appendChild(div);
      }

        function initMap() 
		{
          var losAngeles = {lat: 34.0529334, lng: -118.2687909};
          map = new google.maps.Map(document.getElementById('map'), {
            center: losAngeles,
            zoom: 11,
            mapTypeId: 'roadmap',
            mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
          });
          infoWindow = new google.maps.InfoWindow();
          searchButton = document.getElementById("searchButton").onclick = searchLocations;
          locationSelect = document.getElementById("locationSelect");
          locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            if (markerNum != "none"){
              google.maps.event.trigger(markers[markerNum], 'click');
            }
          };
        }

       function searchLocations() 
	   {
         var address = document.getElementById("addressInput").value;
         var geocoder = new google.maps.Geocoder();
         geocoder.geocode({address: address}, function(results, status) {
           if (status == google.maps.GeocoderStatus.OK) {
            searchLocationsNear(results[0].geometry.location);
           } else {
             alert(address + ' not found');
           }
         });
       }

       function clearLocations() 
	   {
         infoWindow.close();
         for (var i = 0; i < markers.length; i++) 
		 {
           markers[i].setMap(null);
         }
         markers.length = 0;
         locationSelect.innerHTML = "";
         var option = document.createElement("option");
         option.value = "none";
         option.innerHTML = "See all results:";
         locationSelect.appendChild(option);
       }

       function searchLocationsNear(center) 
	   {
			clearLocations();
			var radius = document.getElementById('radiusSelect').value;
			var searchUrl = 'storelocator.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
			downloadUrl(searchUrl, parseXml );
       }

         function createMarker(latlng, name, wash_devices, dry_devices, address, available_wash, available_dry, id, locationType) 
	   {	
			var html = '<b>' + name + '</b> <br/>' + address + ' <br/>' + 'Number of Washers: ' + wash_devices  + '<br/>' + 'Number of Available Washers: ' + available_wash + '<br/>' + 'Number of Dryers: ' + dry_devices + '<br/>'  + 'Number of Available Dryers: ' + available_dry + '<br/> <a href="device_loader.php?id=' + id + '&name=' + name + '"target = "blank"> See Availability </a>';
			var icon = customLabel[locationType] || {};
			var marker = new google.maps.Marker({	map: map,
													position: latlng,
													label: icon.label
												});
			google.maps.event.addListener(marker, 'click', function() {	infoWindow.setContent(html);
																		infoWindow.open(map, marker);
																		});
																		markers.push(marker);
        }
		
       function createOption(name, distance, num) 
	   {
          var option = document.createElement("option");
          option.value = num;
          option.innerHTML = name;
          locationSelect.appendChild(option);
       }

       function downloadUrl(url, callback) 
	   {
          var request = window.ActiveXObject ?
              new ActiveXObject('Microsoft.XMLHTTP') :
              new XMLHttpRequest;
          request.onreadystatechange = function() 
		  {
            if (request.readyState == 4) 
			{
              request.onreadystatechange = doNothing;
              callback(request);//, request.status);
            }
          };
          request.open('GET', url, true);
          request.send(null);
       }

		function parseXml(data)
		{
			var parser = new DOMParser();
			var xml = parser.parseFromString(data.responseText, 'text/xml');
			var markerNodes = xml.documentElement.getElementsByTagName("marker");
			var bounds = new google.maps.LatLngBounds();
			for (var i = 0; i < markerNodes.length; i++) 
			{
				var id = markerNodes[i].getAttribute("id");
				var name = markerNodes[i].getAttribute("name");
				var address = markerNodes[i].getAttribute("address");
				var wash_devices = markerNodes[i].getAttribute("num_of_wash_devices");
				var dry_devices = markerNodes[i].getAttribute("num_of_dry_devices");
				var locationType = markerNodes[i].getAttribute("locationType");
				var distance = parseFloat(markerNodes[i].getAttribute("distance"));
				var available_wash = markerNodes[i].getAttribute("number_of_available_wash");
				var available_dry = markerNodes[i].getAttribute("number_of_available_dry");
				var latlng = new google.maps.LatLng(
													parseFloat(markerNodes[i].getAttribute("lat")),
													parseFloat(markerNodes[i].getAttribute("lng"))
													);
				createOption(name, distance, i);
				createMarker(latlng, name, wash_devices, dry_devices, address, available_wash, available_dry, id, locationType);
				bounds.extend(latlng);
			}
			map.fitBounds(bounds);
			locationSelect.style.visibility = "visible";
			locationSelect.onchange = function() 
			{
				var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
				google.maps.event.trigger(markers[markerNum], 'click');
			};
		}
		
		// JavaScript popup window function
		function basicPopup(url) {
			popupWindow = window.open(url,'popUpWindow','height=300,width=500,left=400,top=300,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes')
		}	
	
		function get_device_status( name, address, id )
		{
			// request device info
			// calculate total machines available and in use
			
			// Open the Code in New Tab
			//var html = ' <a href="' + id + '.php" target = "blank"> <b>' + name + '</b> </a> <br/>'+ address;
			var html = '<b>' + name + '</b> <br/><p>' + address + '</p> <br/> <a href="device_info.php?id=' + id + '"target = "blank"> availability </a>';
			
			// Open the Code in a Pop-Up Window
			//var html = '<a href="' + id + '.php" onclick="basicPopup(this.href);return false"> ' + name + '</a> <br/>'+ address;
			//var html = '<b>' + name + '</b> <br/><p>' + address + '</p> <br/> <a href="device_info.php?id=' + id + '"onclick="basicPopup(this.href);return false"> availability </a>';
			return html;
		}

		function doNothing() {}
  </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGtMjljq4HbS4fZ09WS2zbZmpORP4K2CE&callback=initMap">
    </script>
  </body>
</html>
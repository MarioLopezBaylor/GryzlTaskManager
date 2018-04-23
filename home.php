<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>User Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="./css/tablestyles.css">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>
	
  <!-- Navbar with Logout button -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
      <button class="btn btn-outline-success my-2 my-sm-0" id="logout_button" type="submit">Logout</button>
      <script>
        var btn = document.getElementById('logout_button');
        btn.addEventListener('click', function() {
          document.location.href = 'login.html';
        });
      </script>
    </div>
  </nav>
  
  <div class="jumbotron">
    <h1 class="display-4">Welcome to the home screen, <?php echo ucwords($_COOKIE['current_user']) ?>!</h1>
    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
    <hr class="my-4">
    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
    <p class="lead">
      <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
    </p>
  </div>

	<p>Choose what you would like to do:</p>

  <!-- Allows user to make selection of the action they'd like to perform -->
	<form action="./php/home_action.php" method="POST">
		Add Group: <input type="radio" name="homeAction" value="addGroup"><br>
		Add Task:  <input type="radio" name="homeAction" value="addTask"><br>
		<input type="submit">
	</form>
	
		<h4>Current Groups You Manage:</h4>
		
		<?php
		require './php/functions.php';
	
		$link = connectToServer();

    // Selecting all groups the current user is the owner of
		$qry = "SELECT gro_ID GroupID, gro_ownerID OwnerID, gro_Status Status 
						FROM Groups WHERE gro_ownerID = '" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr> 
			<th>GroupID</th> 
			<th>OwnerID</th> 
			<th>Status</th>       
			<th>Edit Group</th> 
			<th>Delete Group</th> 
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["GroupID"] .
				"</td><td>" . $row["OwnerID"] .
				"</td><td>" . $row["Status"] .
				"</td><td> <input type=\"Submit\" name=\"".$row["GroupID"] . "\" value=\"Edit\">" .
				"</td><td> <input type=\"Submit\" name=\"Submit\" value=\"Delete\">"  .
				"</td></tr>";
			}
			echo "</table>";
			} else {
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>
		
		<h4>Current Groups You're A Part Of (But Do Not Manage):</h4>

		<?php
		$link = connectToServer();

    // Select using join to show groups one is involved in
    // But removing any groups they manage (since they're already
    // shown above in the other table)
		$qry = "SELECT gro_ID GroupID, gro_ownerID OwnerID, gro_Status Status 
					FROM Groups INNER JOIN Group_Members ON gro_ID = grm_gro_ID 
					WHERE Group_Members.grm_usr_ID ='" . $_COOKIE['current_user'] . "' AND gro_ID NOT IN (
					SELECT gro_ID FROM Groups WHERE gro_ownerID = '" . $_COOKIE['current_user'] . "')";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
			echo "<table> <tr>
			<th>GroupID</th>
			<th>OwnerID</th>
			<th>Status</th>
			<th>Leave Group</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>" . $row["GroupID"] .
				"</td><td>" . $row["OwnerID"] .
				"</td><td>" . $row["Status"] .
				"</td><td> <input type=\"Submit\" name=\"Submit\" value=\"Leave\">"  .
				"</td></tr>";
			}
			echo "</table>";
			} else {
      // No tuples returned - show empty table
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>

		  	<h4>Your Current Tasks:</h4>

		<?php
		$link = connectToServer();

    // Select statement for presenting relevant user data
		$qry = "SELECT tas_ID TaskID, tas_Category Category, tas_DueDate DueDate, tas_Priority Priority, tas_Progress Progress
						FROM Tasks WHERE tas_usr_ID='" . $_COOKIE['current_user'] . "'";
		$result = mysqli_query($link, $qry);

		if(mysqli_num_rows($result) > 0) {
      // Embed image to signify which tables you can sort (right now it's just alpha)
      echo "<table id=\"taskTable\"> <tr> 
			<th>TaskID</th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(1)\">Category <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(2)\">DueDate <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th> 
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(3)\">Priority <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th style=\"white-space:nowrap;\" onclick=\"sortTable(4)\">Progress <img src=\"./res/sort-by-attributes.svg\" alt=\"SortColumn\"> </th>
			<th>Edit Task</th>
			<th>Delete Task</th>
			</tr>";

			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr id=\"prio-" . $row["Priority"] . "\"><td>" . $row["TaskID"] .
				"</td><td>" . $row["Category"] .
				"</td><td>" . $row["DueDate"] .
				"</td><td>" . $row["Priority"] .
				"</td><td>" . $row["Progress"] .
				
        // This chunk of HTML allows us to edit or delete selected entries from the database
        "<form action=\"./php/editTask.php\" method=\"POST\">" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Edit\"/>" .
          "</td><td>" .
          "<input type=\"submit\" name=\"action\" value=\"Delete\"/>" .
          "<input type=\"hidden\" name=\"id\" value=\"" . $row['TaskID'] . "\"/>" .
          "<input type=\"hidden\" name=\"cat\" value=\"" . $row['Category'] . "\"/>" .
        "</form>" .
          
				"</td></tr>";
			}
			echo "</table>";
			} else {
      // No tuples returned - show empty table
			echo "<table> <tr><td>None!</td></tr> </table>";
		}

		mysqli_free_result($result);
		mysqli_close($link);
		?>
  
    <!-- Sorting Function -->
    <script>
    function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("taskTable");
    switching = true;
    // Set the sorting direction to ascending:
    dir = "asc"; 
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.getElementsByTagName("TR");
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = 1; i < (rows.length - 1); i++) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[n];
        y = rows[i + 1].getElementsByTagName("TD")[n];
        /* Check if the two rows should switch place,
        based on the direction, asc or desc: */
        if (dir == "asc") {
          if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        } else if (dir == "desc") {
          if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
            // If so, mark as a switch and break the loop:
            shouldSwitch= true;
            break;
          }
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        // Each time a switch is done, increase this count by 1:
        switchcount ++; 
      } else {
        /* If no switching has been done AND the direction is "asc",
        set the direction to "desc" and run the while loop again. */
        if (switchcount === 0 && dir == "asc") {
          dir = "desc";
          switching = true;
        }
      }
    }
  }
  </script>
  </div>
  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
</body>
</html>
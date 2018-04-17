<!DOCTYPE html>
<html>
<head>
	<title>Edit Task</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>
<body>

	<h2>Edit Task</h2>

	<?php
  require 'functions.php';
  
  $link = connectToServer();
  
  /* Use post request to get current task data */
  
	?>

	<form action="./php/createTask_action.php" method="post">
	Task Name: <input type="text" name="taskname" maxlength="100" required><br><br>
	Priority: <br>
	  <input type="radio" name="priority" value="h" checked> RIGHT NOW! <br>
	  <input type="radio" name="priority" value="m"> Sometime Soon. <br>
	  <input type="radio" name="priority" value="l"> it can wait <br>
	<br>Category: <br>
	  <input type="radio" name="category" value="school" checked> School <br>
	  <input type="radio" name="category" value="work"> Work <br>
	  <input type="radio" name="category" value="family"> Family <br>
	  <input type="radio" name="category" value="organization"> Organization <br>
	  <input type="radio" name="category" value="miscellaneous"> Miscellaneous <br>
	<br>Progress: <br>
	  <input type="radio" name="progress" value="done" checked> D O N E <br>
	  <input type="radio" name="progress" value="close"> Literally So Close <br>
	  <input type="radio" name="progress" value="half"> Halfway. Glass Half Full? <br>
	  <input type="radio" name="progress" value="started"> Could Be Worse <br>
	  <input type="radio" name="progress" value="begin"> Lowkey Haven't Started <br>

	<div>
	  <!--Only 6 Months in Advance-->
	    <br>
	    <label for="duedate">Due Date:</label>
	    <input id="datetime" type="datetime-local" name="duedate" required>
	    <span class="validity"></span> <br> <br>
	</div>
	  <input type="Submit" name="Submit1" value="Assign Groups?">
	  <input type="Submit" name="Submit2" value="Create Task without Groups">
	</form>

</body>
</html>
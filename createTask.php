<!DOCTYPE html>
<html>

<head>
  <title>Create Task</title>
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
</head>

<body>

  <h2>Make New Task</h2>
  <p>So What Do You Need to Do? <br><br></p>

  <form action="./php/createTask_action.php" method="post">
    Task Name: <input type="text" name="taskname" maxlength="100" required><br><br> Priority: <br>
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
      <input id="datetime" type="datetime-local" name="duedate" 
             min="<?php echo date("Y-m-d h:ia"); ?>" 
             max="<?php $d = strtotime("+6 months"); echo date("Y-m-d h:ia", $d); ?>" 
             step="3600" required>
      <span class="validity"></span> <br> <br>
    </div>
    <input type="Submit" name="Submit" value="Assign Groups?">
    <input type="Submit" name="Submit" value="Create Task without Groups">
  </form>

</body>

</html>
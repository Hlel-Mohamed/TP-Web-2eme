<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement1 = $pdo->prepare('select * from cals');
$statement1->execute();
$infos= $statement1->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $height= $_POST['height'];
  $weight= $_POST['weight'];
  $age= $_POST['age'];
  $gender= $_POST['gender'];
  if ($_POST['bmr']==1) {
    $bmr='At rest';
  }elseif ($_POST['bmr']==1.2) {
    $bmr='Sedentary';
  }
  elseif ($_POST['bmr']==1.375) {
    $bmr='Lightly active';
  }
  elseif ($_POST['bmr']==1.55) {
    $bmr='Moderately active';

  }elseif ($_POST['bmr']==1.725) {
    $bmr='Very active';
  }
  elseif ($_POST['bmr']==1.9) {
    $bmr='Extra active';
  }
  $res= $_POST['result'];
  $date = date('y-m-d h:i:s');

  $statement2 = $pdo->prepare("insert into cals(height,weight,age,gender,bmr,res) 
      values(:height,:weight,:age,:gender,:bmr,:res)
  ");

  $statement2->bindValue(':height', $height);
  $statement2->bindValue(':weight', $weight);
  $statement2->bindValue(':age', $age);
  $statement2->bindValue(':gender', $gender);
  $statement2->bindValue(':bmr', $bmr);
  $statement2->bindValue(':res', $res);
  $statement2->execute();

}
?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Calories</title>
    <link rel="icon" href="images/favicon.png">
    <link rel="stylesheet" href="CSS/bootstrap.min.css" />
    <link rel="stylesheet" href="CSS/style.css" />
  </head>

  <body>
  
    <div class="m-container">
    <div class="form-check">
      <form action="index.php" method="POST">
        Height :
        <div class="input-group">
          <input type="number" step="0.1" class="form-control" id="height" name="height"/>
          <select id="height-unit" class="input-group-text">
            <option value="cm">cm</option>
            <option value="in">in</option>
          </select>
        </div>
        <!--------------------->
        Weight :
        <div class="input-group">
          <input type="number" step="0.1" class="form-control" id="weight" name="weight"/>
          <select id="weight-unit" class="input-group-text">
            <option value="kg">kg</option>
            <option value="lb">lb</option>
          </select>
        </div>
        <!-------------------->
        Age :
        <div class="input-group">
          <input type="number" class="form-control" id="age" name="age"/>
        </div>
        <!-------------------->
        Gender :
        <div class="center">
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            id="male"
            value="male"
          />
          <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="gender"
            id="female"
            value="female"
          />
          <label class="form-check-label" for="female">Female</label>
        </div>
      </div>
        <!-------------------->
        <div>
          <select id="bmr" name="bmr">
            <option value="1">At rest (BMR)</option>
            <option value="1.2">Sedentary (little or no exercise)</option>
            <option value="1.375">Lightly active (light exercise/sports 1-3 days/week)</option>
            <option value="1.55">Moderately active (moderate exercise/sports 3-5 days/week)</option>
            <option value="1.725">Very active (hard exercise/sports 6-7 days a week)</option>
            <option value="1.9">If you are extra active (very hard exercise/sports & a physical job)</option>
          </select>
        </div>
        <!-------------------->
        <div class="center">
          <button type="button" class="btn btn-success" onclick="calculate()">
            Calculate
          </button>
          <button type="reset" class="btn btn-danger">Reset</button>
        </div>
        <!--------------------->
        <div class="input-group" style="margin-top: 20px;">
          <input
            class="form-control"
            type="text"
            placeholder="Your result here"
            
            id="result"
            name="result"
          />
          <button type="submit" class="btn btn-dark btn-outline-light" onclick="save()">Save</button>
          <!--<input type="checkbox" hidden id="show-saved">
          <label for="show-saved" class="btn btn-dark btn-outline-light">Show Saved</label>-->
          <div id="table">
          <table class="table" style="color: white;">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Height</th>
              <th scope="col">Weight</th>
              <th scope="col">Age</th>
              <th scope="col">Gender</th>
              <th scope="col">bmr</th>
              <th scope="col">Result</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($infos as $i => $info){?>
                <tr>
              <th scope="row"><?php echo $i +1 ?></th>
              <td><?php echo $info['height'] ?></td>
              <td><?php echo $info['weight'] ?></td>
              <td><?php echo $info['age'] ?></td>
              <td><?php echo $info['gender']?></td>
              <td><?php echo $info['bmr']?></td>
              <td><?php echo $info['res']?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
          </div>
        </div>
        <!---------------------->
      </form>
    </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>

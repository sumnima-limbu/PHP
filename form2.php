<!DOCTYPE html>
<head>
    <style>
        .error{
            color: #FF0000;
        }
    </style>
</head>
<body>
    <div>
    <?php
    $nameErr = $emailErr = $phoneErr = $genderErr  = $hobbiesErr = "";
    $name = $email = $phone = $gender = $hobbies = $values = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
        }

        $v_Email = $_POST["email"];
        if (empty($v_Email)) {
            $emailErr = "Email is required";
        } 
        else if (!filter_var($v_Email, FILTER_VALIDATE_EMAIL)) {
            $emailErr ="Invalid email format";
        }
        else {
            $email = test_input($v_Email);
        }

        if (empty($_POST["phoneno"])) {
            $phoneErr = "Phone Number is required";
        }
         else if (strlen($_POST["phoneno"]) < 10) {
            $phoneErr = "Phone number should be of 10 digits";
        } 
        else if (!preg_match("/^[0-9]\d{10}$/", $_POST["phoneno"])) {
            $phoneErr = "Invalid Phone number";              
        } 
        

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }

        $checkedHobby = 0;
        
        $values = $_POST['web'];

        $checkedHobby = count($values);

        if ($checkedHobby < 1) {
            $hobbiesErr = "Please check at least one Hobby";
        } else if ($checkedHobby >= 5) {
            $hobbiesErr = "You can only check up to four Hobbies";
        } else {
            $hobbies = test_input($_POST["web"]);
        }

    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    </div>
    <div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container">
                <h1>Form Validation</h1>
                <p>Please fill up the form with correct values only.</p>
                <p><span class="error">* required field</span></p>
                <b>Name:</b><input type="text" name="name" minlength="5">
                <span class="error">* <?php echo $nameErr;?></span>
                <br><br>

                <b>Email:</b> <input type="text" name="email">
                <span class="error">* <?php echo $emailErr;?></span>
                <br><br>

                <b>Phone:</b><input type="text" name="phoneno">
                <span class="error">* <?php echo $phoneErr;?></span>
                <br><br>

                <b>Gender:</b>
                <input type="radio" name="gender" value="female">Female
                <input type="radio" name="gender" value="male">Male
                <input type="radio" name="gender" value="other">Other
                <span class="error">* <?php echo $genderErr;?></span>
                <br><br>

                <b>Hobbies: </b>
                <input type="checkbox" name="web[1]" value="read">Reading
                <input type="checkbox" name="web[2]" value="travel">Travelling
                <input type="checkbox" name="web[3]" value="music">Listening to Music
                <input type="checkbox" name="web[4]" value="game">Gaming
                <span class="error">* <?php echo $hobbiesErr; ?></span>
                <br><br>
                
                <input type="submit" name="submit" value="Submit">
        </form> 
    </div> 
    <div>
    <?php
        echo "<h3>Your Input:</h3>";
        echo "Name: ".$name;
        echo "<br>";
        echo "Email: ".$email;
        echo "<br>";
        echo "Phone Number: ".$phone;
        echo "<br>";
        echo "Gender: ".$gender;
        echo "<br>";
        echo 'Checked Hobbies: '.var_dump($values);
        ?>
    </div>   
</body>
</html>
<?php
$name = "";
$email = "";
$phone_no = "";
$gender = "";
$hobbies = [];
$errors = [];
$checked_hobby = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["name"])) {
        $errors['name'] = "Name is required";
    } else {
        $name = sanitize_input($_POST["name"]);
    }

    $v_email = $_POST["email"];
    if (empty($v_email)) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($v_email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] ="Invalid email format";
    }
    else {
        $email = sanitize_input($v_email);
    }

    if (empty($_POST["phone_no"])) {
        $errors['phone_no'] = "Phone Number is required";
    /* } else if (strlen($_POST["phone_no"]) < 10) { */
    /*     $erros['phone_no'] = "Phone number should be of 10 digits"; */
    } 
    else if (!preg_match("/^98[0-9]{8}$/", $_POST["phone_no"])) {
        $errors['phone_no'] = "Invalid Phone number, must start with 98..";              
    } else {
        $phone_no = sanitize_input($_POST['phone_no']);
    }
    

    if (empty($_POST["gender"])) {
        $errors['gender']= "Gender is required";
    } else {
        $gender = sanitize_input($_POST["gender"]);
    }

    $checked_hobby = isset($_POST['hobbies']) ? count($_POST['hobbies']) : 0;
    if ($checked_hobby < 1) {
        $errors['hobbies'] = "Please check at least one Hobby";
    } else if ($checked_hobby >= 5) {
        $errors['hobbies'] = "You can only check up to four Hobbies";
    } else {
        foreach ($_POST['hobbies'] as $hobby) {
            $hobbies[] = sanitize_input($hobby);
        }
    }

}

function sanitize_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
?>


<!DOCTYPE html>
<head>
    <style>
        body {
            font-family: "Arial", Sans-serif;
        }

        .error {
            color: #FF0000;
        }

        .success {
            color: green;
        }

        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            margin: 10px auto;
        }

        .label{
            font-weight: bold;
        }

        form {
            width: 100%;
            border: 1px solid lightgray;
            padding: 25px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1>Form Validation</h1>
            <p>Please fill up the form with correct values only.</p>

            <?php if(! empty($errors)): ?>
                <p><span class="error">Something went wrong.</span></p>
                <?php endif; ?>
            
            <?php if(! empty($_POST) && empty($errors)): ?>
                <p><span class="success">Form was submitted successfully.</span></p>
            <?php endif; ?>

            <div class="form-group">
                <label class="label">Name:
                    <input type="text" name="name" minlength="5" />
                </label>
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?php echo $errors['name'];?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="label">Email:
                    <input type="text" name="email" />
                </label>
                <?php if (isset($errors['email'])): ?>
                    <span class="error"> <?php echo $errors['email'];?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="label">Phone:
                    <input type="text" name="phone_no">
                </label>
                <?php if (isset($errors['phone_no'])): ?>
                    <span class="error"><?php echo $errors['phone_no'];?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <span class="label">Gender: </span>
                <label><input type="radio" name="gender" value="female">Female</label>
                <label><input type="radio" name="gender" value="male">Male</label>
                <label><input type="radio" name="gender" value="other">Other</label>
                <?php if(isset($errors['gender'])): ?>
                    <span class="error"><?php echo $errors['gender'];?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <span class="label">Hobbies: </span>
                <label><input type="checkbox" name="hobbies[]" value="Reading">Reading</label>
                <label><input type="checkbox" name="hobbies[]" value="Travelling">Travelling</label>
                <label><input type="checkbox" name="hobbies[]" value="Music">Listening to Music</label>
                <label><input type="checkbox" name="hobbies[]" value="Game">Gaming</label>
                <?php if(isset($errors['hobbies'])): ?>
                    <span class="error"><?php echo $errors['hobbies']; ?></span>
                <?php endif; ?>
            </div>
                
            <input type="submit" name="submit" value="Submit">
        </form> 
    
    
        <?php
            echo "<h3>Your Input:</h3>";
            echo "Name            : ". $name;
            echo "<br>";
            echo "Email           : ". $email;
            echo "<br>";
            echo "Phone Number    : ". $phone_no;
            echo "<br>";
            echo "Gender          : ". $gender;
            echo "<br>";
            echo 'Checked Hobbies : '. implode(',' , $hobbies);
            ?>
    </div>   
</body>
</html>
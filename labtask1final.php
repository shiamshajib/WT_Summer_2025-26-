<?php
$name = $age = $email = $membership = $department = $phone = $successMessage = "";
$nameErr = $ageErr = $emailErr = $membershipErr = $deptErr = $phoneErr = "";

function sanitizeInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = sanitizeInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z\s]+$/", $name))
            $nameErr = "Only letters and spaces are allowed.";
    }

    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age = sanitizeInput($_POST["age"]);
        if (!is_numeric($age) || $age < 18 || $age > 30)
            $ageErr = "Age must be between 18 and 30.";
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitizeInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $emailErr = "Invalid email format.";
    }

    if (empty($_POST["membership"])) {
        $membershipErr = "Please select a membership type.";
    } else {
        $membership = sanitizeInput($_POST["membership"]);
    }

    if (empty($_POST["department"]) || $_POST["department"] == "-- Select Department --") {
        $deptErr = "Please select your department.";
    } else {
        $department = sanitizeInput($_POST["department"]);
    }

    if (empty($_POST["phone"])) {
        $phoneErr = "Phone number is required";
    } else {
        $phone = sanitizeInput($_POST["phone"]);
        if (!preg_match("/^[0-9]{11}$/", $phone))
            $phoneErr = "Phone number must contain exactly 11 digits.";
    }

    if (!$nameErr && !$ageErr && !$emailErr && !$membershipErr && !$deptErr && !$phoneErr) {
        $successMessage = "Registration successful! Welcome to the Student Technology Club.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
</head>

<body>

    <h2>Student Technology Club Registration</h2>

    <?php if ($successMessage) echo "<h3>$successMessage</h3>"; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <p>
            <label>Student Name </label><br>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span style="color:red;"><?php echo $nameErr; ?></span>
        </p>

        <p>
            <label>Student Age </label><br>
            <input type="number" name="age" value="<?php echo $age; ?>">
            <span style="color:red;"><?php echo $ageErr; ?></span>
        </p>

        <p>
            <label>University Email </label><br>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span style="color:red;"><?php echo $emailErr; ?></span>
        </p>

        <p>
            <label>Membership Type </label><br>
            <input type="radio" name="membership" value="Regular Member" <?php if ($membership == "Regular Member") echo "checked"; ?>> Regular Member
            <input type="radio" name="membership" value="Executive Member" <?php if ($membership == "Executive Member") echo "checked"; ?>> Executive Member
            <input type="radio" name="membership" value="Volunteer" <?php if ($membership == "Volunteer") echo "checked"; ?>> Volunteer
            <br><span style="color:red;"><?php echo $membershipErr; ?></span>
        </p>

        <p>
            <label>Department </label><br>
            <select name="department">
                <option value="">-- Select Department --</option>
                <option value="CSE" <?php if ($department == "CSE") echo "selected"; ?>>CSE</option>
                <option value="EEE" <?php if ($department == "EEE") echo "selected"; ?>>EEE</option>
                <option value="BBA" <?php if ($department == "BBA") echo "selected"; ?>>BBA</option>
                <option value="English" <?php if ($department == "English") echo "selected"; ?>>English</option>
                <option value="Architecture" <?php if ($department == "Architecture") echo "selected"; ?>>Architecture</option>
            </select>
            <br><span style="color:red;"><?php echo $deptErr; ?></span>
        </p>

        <p>
            <label>Contact Number </label><br>
            <input type="text" name="phone" value="<?php echo $phone; ?>">
            <span style="color:red;"><?php echo $phoneErr; ?></span>
        </p>

        <p>
            <input type="submit" value="Register">
        </p>

    </form>
</body>

</html>
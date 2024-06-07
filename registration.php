<?php
require_once('header.php');

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}

$error_message = '';  // Initialize error message variable

if (isset($_POST['form1'])) {
    $valid = 1;

    // Validation checks...
    if (empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123 . "<br>";
    }

    if (empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131 . "<br>";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134 . "<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                            
            if ($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147 . "<br>";
            }
        }
    }

    if ($valid == 1) {
        // Insert the validated data into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
            cust_name,
            cust_email,
            cust_phone,
            cust_address,
            cust_country,
            cust_city,
            cust_state,
            cust_zip,
            cust_password
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $statement->execute(array(
            $_POST['cust_name'],
            $_POST['cust_email'],
            $_POST['cust_phone'],
            $_POST['cust_address'],
            $_POST['cust_country'],
            $_POST['cust_city'],
            $_POST['cust_state'],
            $_POST['cust_zip'],
            password_hash($_POST['cust_password'], PASSWORD_BCRYPT)  // Ensure passwords are hashed
        ));

        // Redirect or show success message
    }
}
?>

<form action="" method="post">
    <!-- Form fields for user input -->
    <input type="text" name="cust_name" value="<?php if (isset($_POST['cust_name'])) { echo $_POST['cust_name']; } ?>">
    <input type="email" name="cust_email" value="<?php if (isset($_POST['cust_email'])) { echo $_POST['cust_email']; } ?>">
    <input type="text" name="cust_phone" value="<?php if (isset($_POST['cust_phone'])) { echo $_POST['cust_phone']; } ?>">
    <input type="text" name="cust_address" value="<?php if (isset($_POST['cust_address'])) { echo $_POST['cust_address']; } ?>">
    <input type="text" name="cust_country" value="<?php if (isset($_POST['cust_country'])) { echo $_POST['cust_country']; } ?>">
    <input type="text" name="cust_city" value="<?php if (isset($_POST['cust_city'])) { echo $_POST['cust_city']; } ?>">
    <input type="text" name="cust_state" value="<?php if (isset($_POST['cust_state'])) { echo $_POST['cust_state']; } ?>">
    <input type="text" name="cust_zip" value="<?php if (isset($_POST['cust_zip'])) { echo $_POST['cust_zip']; } ?>">
    <input type="password" name="cust_password">
    <input type="password" name="cust_re_password">
    <input type="submit" name="form1" value="<?php echo LANG_VALUE_15; ?>">
</form>

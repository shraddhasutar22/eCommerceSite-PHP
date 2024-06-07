<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}
?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123 . "<br>";
    }

    if(empty($_POST['cust_email'])) {
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
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147 . "<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124 . "<br>";
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125 . "<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126 . "<br>";
    }

    if(empty($_POST['cust_city'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_127 . "<br>";
    }

    if(empty($_POST['cust_state'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_128 . "<br>";
    }

    if(empty($_POST['cust_zip'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_129 . "<br>";
    }

    if(empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_139 . "<br>";
    } else if($_POST['cust_password'] != $_POST['cust_re_password']) {
        $valid = 0;
        $error_message .= LANG_VALUE_140 . "<br>";
    }

    if($valid == 1) {
        // Hash the password before storing
        $password = password_hash($_POST['cust_password'], PASSWORD_BCRYPT);

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
            $password
        ));

        // Redirect or show success message
        header('Location: success.php');
        exit;
    }
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1>Registration</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if($error_message != ''): ?>
                <div class="error" style="margin-bottom: 20px;"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="user-content">
                    <form action="" method="post">
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_102; ?> *</label>
                            <input type="text" class="form-control" name="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_94; ?> *</label>
                            <input type="email" class="form-control" name="cust_email" value="<?php if(isset($_POST['cust_email'])){echo $_POST['cust_email'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_103; ?> *</label>
                            <input type="text" class="form-control" name="cust_phone" value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_105; ?> *</label>
                            <input type="text" class="form-control" name="cust_address" value="<?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_106; ?> *</label>
                            <input type="text" class="form-control" name="cust_country" value="<?php if(isset($_POST['cust_country'])){echo $_POST['cust_country'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_107; ?> *</label>
                            <input type="text" class="form-control" name="cust_city" value="<?php if(isset($_POST['cust_city'])){echo $_POST['cust_city'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_108; ?> *</label>
                            <input type="text" class="form-control" name="cust_state" value="<?php if(isset($_POST['cust_state'])){echo $_POST['cust_state'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_109; ?> *</label>
                            <input type="text" class="form-control" name="cust_zip" value="<?php if(isset($_POST['cust_zip'])){echo $_POST['cust_zip'];} ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                            <input type="password" class="form-control" name="cust_password">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""><?php echo LANG_VALUE_98; ?> *</label>
                            <input type="password" class="form-control" name="cust_re_password">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for=""></label>
                            <input type="submit" class="btn btn-danger" value="<?php echo LANG_VALUE_15; ?>" name="form1">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>

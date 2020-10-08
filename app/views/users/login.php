<?php require APP_ROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php flash('register_success'); ?>
            <h2>Login</h2>
            <p>Please fill in your credentials to log in</p>
            <form action="<?php echo URL_ROOT; ?>/users/login" method="post">
                <div class="form-group">
                    <label for="name">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg
                    <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>"
                           value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg
                    <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="login" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a href="<?php echo URL_ROOT; ?>/users/register">No account? Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<input id="page-name" type="hidden" name="page" value="login">

<?php require APP_ROOT . '/views/inc/footer.php';?>
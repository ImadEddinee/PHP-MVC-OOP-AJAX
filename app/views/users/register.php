<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Create An Account</h2>
            <p>Please fill out this form to register with us</p>
            <form action="<?= ROOT."/Users/register" ?>" method="POST">
                <div class="form-group">
                    <label for="name" class="label-control">Name: <sup>*</sup></label>
                    <input type="text" id="name" name="name" class="form-control form-control-lg <?php !empty($data['name_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['name_error'] ?></span>
                </div>
                <div class="form-group">
                    <label for="email" class="label-control">Email: <sup>*</sup></label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg <?php !empty($data['email_erro']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['email_error'] ?></span>
                </div>
                <div class="form-group">
                    <label for="password" class="label-control">Password: <sup>*</sup></label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg <?php !empty($data['password_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['password_error'] ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="label-control">Confirm Password: <sup>*</sup></label>
                    <input type="password" id="confirm-password" name="confirm-password" class="form-control form-control-lg <?php !empty($data['confirm_password_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['confirm_password_error'] ?></span>
                </div>
                <div class="row">
                    <div class="col d-grid gap-2">
                        <input type="submit" value="Register" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a class="btn btn-light" href="<?= ROOT."Users/login" ?>">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

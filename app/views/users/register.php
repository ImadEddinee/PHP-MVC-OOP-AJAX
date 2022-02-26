<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="fw-light">Create An Account</h2>
            <p class="fw-light">Please fill out this form to register with us</p>
            <form action="<?= ROOT."/Users/register" ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name: <sup>*</sup></label>
                    <input type="text" id="name" name="name" class="form-control form-control-lg <?= !empty($data['name_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['name_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email: <sup>*</sup></label>
                    <input type="email" id="email" name="email" class="form-control form-control-lg <?= !empty($data['email_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['email_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password: <sup>*</sup></label>
                    <input type="password" id="password" name="password" class="form-control form-control-lg <?= !empty($data['password_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['password_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password: <sup>*</sup></label>
                    <input type="password" id="confirm-password" name="confirm_password" class="form-control form-control-lg <?= !empty($data['confirm_password_error']) ? 'is-invalid' : ''; ?>">
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

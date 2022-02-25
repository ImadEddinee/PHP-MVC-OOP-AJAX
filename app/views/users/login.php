<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body mt-5">
            <h2>Login</h2>
            <p>Please fill in your credentials to Log in</p>
            <form action="<?= ROOT."/Users/login" ?>" method="POST">
                <div>
                    <label for="email" class="label-control">Email: <sup>*</sup></label>
                    <input type="email" id="email" name="email" class="form-control from-control-lg <?php !empty($data['email_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['email_error'] ?></span>
                </div>
                <div>
                    <label for="password" class="label-control">Password: <sup>*</sup></label>
                    <input type="email" id="password" name="password" class="form-control from-control-lg <?php !empty($data['password_error']) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?= $data['password_error'] ?></span>
                </div>
                <div class="row">
                    <div class="col d-grid gap-2">
                        <input type="submit" value="Login" class="btn btn-success">
                    </div>
                    <div class="col">
                        <a href="<?= ROOT."/Users/register" ?>" class="btn btn-light">No account? Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
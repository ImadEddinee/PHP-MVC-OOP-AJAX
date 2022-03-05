<div class="row">
    <div class="col-col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Reset Password</h2>
            <p>it's time to choose a new strong password</p>
            <form action="<?= ROOT."users/reset" ?>" method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password: <sup>*</sup></label>
                    <input type="password" id="password" name="password"
                        class="form-control <?= empty($data['password_error']) ? '':'is-invalid' ?>"
                        value="<?= $data['password'] ?>">
                    <span class="invalid-feedback"><?= $data['password_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Verify Password: <sup>*</sup></label>
                    <input type="password" id="confirm-password" name="confirm_password"
                           class="form-control <?= empty($data['confirm_password_error']) ? '':'is-invalid' ?>"
                           value="<?= $data['confirm_password'] ?>">
                    <span class="invalid-feedback"><?= $data['confirm_password_error'] ?></span>
                </div>
                <div>
                    <input type="submit" class="btn btn-success" value="Reset">
                    <input type="reset" class="btn btn-warning" value="Effacer">
                </div>
            </form>
        </div>
    </div>
</div>

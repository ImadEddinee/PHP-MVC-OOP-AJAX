<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <?php flash("email_code"); ?>
            <h2>Account Recovery</h2>
            <p>An email with a verification code was just sent</p>
            <form action="<?= ROOT."users/code" ?>" method="POST">
                <div>
                    <label for="code" class="form-label">Enter Code: <sup>*</sup></label>
                    <input type="text" id="code" name="code"
                            class="form-control <?= !empty($data['code_error']) ? 'is-invalid' : '' ?>"
                            value="<?= $data['code'] ?>">
                    <span class="invalid-feedback"><?= $data['code_error'] ?></span>
                    <a href="<?= ROOT."users/resend" ?>" class="btn btn-light text-muted">Resend Password ?</a>
                </div>
                <div>
                    <input type="submit" class="btn btn-success" value="Send">
                </div>
            </form>
        </div>
    </div>
</div>
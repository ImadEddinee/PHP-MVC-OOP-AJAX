<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="fw-light mx-auto">Reset Password</h2>
            <p class="text-muted mx-auto">Enter your email address associated with your account</p>
            <form action="<?= ROOT."users/password" ?>" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email: <sup>*</sup> </label>
                    <input type="email" id="email" name="email"
                           placeholder="youremail@gmail.com"
                           class="form-control <?= !empty($data['email_error']) ? 'is-invalid' : '' ?>"
                            value="<?= $data['email']?>">
                    <span class="invalid-feedback"><?= $data['email_error'] ?></span>
                </div>
                <input type="submit" value="Envoyer" class="btn btn-success">
            </form>
        </div>
    </div>
</div>

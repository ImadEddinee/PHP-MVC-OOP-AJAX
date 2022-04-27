<div class="row">
    <div class="col-md-3 mt-5">
        <form action="<?= ROOT."categories/add" ?>" method="POST">
            <div class="input-group mb-3">
                <input type="text" name="name"
                       value="<?= isset($data['category']) ? $data['category'] : '';?>"
                       class="form-control <?= isset($data['category_error']) ? 'is-invalid' : ''; ?> "
                       placeholder="Add new Categorie">
                <input type="submit" value="Add    " class="btn btn-outline-secondary">
                <span><?= isset($data['category_error']) ? $data['category_error'] : '';?></span>
            </div>
        </form>
        <form action="<?= ROOT."users/search" ?>" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Enter a username">
                <input type="submit" value="Search" class="btn btn-outline-secondary">
            </div>
        </form>
    </div>
    <div class="col-md-9 mt-5">
        <div class="card">
            <?php flash("post_added"); ?>
            <div class="card-header fw-light" style="text-align: center">
                Ajouter une photo à ma collection
            </div>
            <div class="card-body">
                <form action="<?= ROOT."pictures/add" ?>" enctype="multipart/form-data" method="POST">
                    <div style="margin-bottom: 10px">
                        <label for="photo" class="form-label">Ajouter une photo :</label>
                        <input type="file" id="photo" name="photo"
                               class="form-control <?= isset($data['photo_error']) ? 'is-invalid' : ''; ?>" required />
                        <span class="invalid-feedback"><?= $data['photo_error']; ?></span>
                    </div>
                    <?php if (count($data['categories']) == 0) : ?>
                        <div class="alert alert-danger" role="alert">
                            Vous devez Créer une catégorie tout d'abbord !
                        </div>
                    <?php else : ?>
                        <label for="">Sélectionner une ou plusieurs Catégorie : </label>
                        <span><?= isset($data['checkbox_error']) ? $data['checkbox_error'] : ''; ?></span>
                        <div style="margin-bottom: 10px;height: 80px;overflow: auto">
                            <?php for ($i=0;$i<count($data['categories']);$i++): ?>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           name="categories[]"
                                           type="checkbox"
                                           value="<?= $data['categories'][$i]->id ?>"
                                           id="<?= $i ?>">
                                    <label class="form-check-label" for="<?= $i ?>">
                                        <?= $data['categories'][$i]->name ?>
                                    </label>
                                </div>
                            <?php endfor; ?>
                        </div >
                    <?php endif; ?>

                    <div class="form-floating" style="margin-bottom: 10px">
                        <textarea class="form-control" aria-required="true" name="description" required placeholder="Leave a comment here" id="floatingTextarea">
                            <?= $data['picture_description'] ?>
                        </textarea>
                        <label for="floatingTextarea">Ajouter une description ici</label>
                    </div>
                    <div style="margin-bottom: 10px">
                        <label class="form-label" for="link">Ajouter un lien : </label>
                        <input type="text" id="link"
                               value="<?= $data['picture_link']; ?>"
                               class="form-control" name="link">
                    </div>
                    <div>
                    </div>
                    <div class="row">
                        <div class="col-10">
                            <div class="d-grid gap-2" style="margin-top: 5px">
                                <?php if (count($data['categories']) == 0) : ?>
                                    <input type="submit" name="submit" class="btn btn-success" disabled value="Ajouter la photo">
                                <?php else : ?>
                                    <input type="submit" name="submit" class="btn btn-success" value="Ajouter la photo">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="d-grid gap-2" style="margin-top: 5px">
                                <input type="reset" value="Reset" class="btn btn-outline-danger">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
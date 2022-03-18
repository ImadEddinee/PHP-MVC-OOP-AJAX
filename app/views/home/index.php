<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header fw-light" style="text-align: center">
                    Découvrir les photos des autres
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php for ($i=0;$i<count($data['users']);$i++) :
                            if ($data['users'][$i]->login != $_SESSION['user_name']): ?>
                                <li class="list-group-item">
                                    <form action="<?= ROOT."home/user"?>" method="POST">
                                        <input type="submit" class="btn btn-outline-info" style="width: 200px" name="submit" value="<?= rawurldecode($data['users'][$i]->login) ?>">
                                    </form>
                                </li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
            <div style="margin-top: 10px">
                <div class="card">
                    <div class="card-header fw-light" style="text-align: center">
                        Ajouter une catégorie
                    </div>
                    <div class="card-body">
                        <form action="<?= ROOT."categorie/add" ?>" method="GET">
                            <div style="margin-bottom: 10px">
                                <label for="categorie" class="form-label">Nom : </label>
                                <input type="text" id="categorie" name="categorie" required class="form-control">
                            </div>
                            <div class="d-grid gap-2">
                                <input type="submit" class="btn btn-outline-success" name="submit" value="Creer">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header fw-light" style="text-align: center">
                    Ajouter une photo à ma collection
                </div>
                <div class="card-body">
                    <form action="<?= ROOT."picture/add_photo" ?>" enctype="multipart/form-data" method="POST">
                        <div style="margin-bottom: 10px">
                            <label for="photo" class="form-label">Fichier de la photo :</label>
                            <input type="file" id="photo" name="photo" class="form-control" required size=30 />
                        </div>
                        <?php if (count($data['categories']) == 0) : ?>
                            <div class="alert alert-danger" role="alert">
                                Vous devez Créer une catégorie tout d'abbord !
                            </div>
                        <?php else : ?>
                            <label for="">Sélectionner une ou plusieurs Catégorie : </label>
                            <div style="margin-bottom: 10px;height: 80px;overflow: auto">
                                <?php for ($i=0;$i<count($data['categories']);$i++): ?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               name="categories[]"
                                               type="checkbox"
                                               value="<?= $data['categories'][$i]->id ?>"
                                               id="<?= $i ?>">
                                        <label class="form-check-label" for="<?= $i ?>">
                                            <?= $data['categories'][$i]->nom ?>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div >
                        <?php endif; ?>
                        <div class="form-floating" style="margin-bottom: 10px">
                            <textarea class="form-control" aria-required="true" name="description" required placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Ajouter une description ici</label>
                        </div>
                        <div style="margin-bottom: 10px">
                            <label class="form-label" for="date">Date de la photo : </label>
                            <input type="date" id="date" required class="form-control" name="date_photo">
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
</div>
<script>
    // To initialize the input date with the current date
    document.getElementById('date').valueAsDate = new Date();
</script>
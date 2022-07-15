<div class="container" style="margin-top: 20px;margin-bottom: 15px">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header fw-light" style="text-align: center">
                    détails de la photo
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img width="250px"
                                 src='<?= ASSETS . $data['post']->photo?>'
                                 alt="photo">
                        </div>
                        <div class="col-6" style="margin-top: 40px">
                            <p class="fw-light">Propriétaire : <?= $data['username']; ?></p>
                            <p class="fw-light">Prise le : <?= $data['post']->created_at; ?></p>
                            <p class="fw-light">Modifier le : <?= $data['post']->updated_at; ?></p>
                            <p class="fw-light">Description : <?= $data['post']->description; ?></p>
                            <p class="fw-light text-break">Catégorie :
                                <?php for ($i = 0; $i < count($data['categories']); $i++) :
                                    echo $data['categories'][$i][0]->name;
                                    if ($i < count($data['categories']) - 1):
                                        echo " et  ";
                                    endif;
                                endfor; ?>
                            </p>
                            <span class="fw-light"><?= $data['post']->likes; ?>  <a href="<?= ROOT . "pictures/vote/". $data['post']->id . "/1" ?>"><i class="fa-regular fa-thumbs-up"></i></a></span>
                            <span class="fw-light"><?= $data['post']->dislike; ?>  <a href="<?= ROOT . "pictures/vote/". $data['post']->id . "/-1" ?>"><i class="fa-regular fa-thumbs-down"></i></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="<?= ROOT . "users" ?>" method="GET">
                        <div class="d-grid gap-2">
                            <input type="submit" class="btn btn-outline-dark" value="Revenir a la Liste des photos">
                        </div>
                        <input type="hidden" name="submit" value="<?= $data['post']->user_id ?>">
                    </form>
                    <?php if ($_SESSION['user_id'] == $data['post']->user_id) : ?>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="d-grid gap-2" style="margin-top: 5px">
                                    <a class="btn btn-outline-dark"
                                       href='<?= ROOT . "pictures/update/" . $data['post']->id; ?>'>Modifier les
                                        informations sur cette photo</a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-outline-danger" style="margin-top: 5px"
                                    href="<?= ROOT . "pictures/delete/" . $data['post']->id?>">
                                Supprimer
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="d-grid gap-2" style="margin-top: 5px">
                                    <a></a>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-6" style="height: 350px;overflow: auto">
            <?php if (isset($data['comments'])): ?>
                <ul class="list-group">
                    <?php for ($i = 0; $i < count($data['comments']); $i++) : ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-10">
                                    <p><b><?= $data['comments'][$i]->username ?></b> <span class="fw-light">(<?= $data['comments'][$i]->created_at ?>)</span>
                                    </p>
                                    <p class="fw-normal text-break"><?= $data['comments'][$i]->contenu ?></p>
                                </div>
                                <div class="col-2">
                                    <form action="<?= ROOT . "home/user" ?>" method="POST">
                                        <input type="hidden" name="submit"
                                               value="<?= $data['comments'][$i]->user_id ?>">
                                        <input type="submit" class="btn btn-light" value="Profile">
                                    </form>
                                    <?php if ($_SESSION['user_id'] == $data['comments'][$i]->user_id) { ?>
                                        <a class="btn btn-outline-danger"
                                           href="<?= ROOT . "comments/delete/" . $data['comments'][$i]->id;  ?>">
                                            Delete
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                    <?php endfor; ?>
                </ul>
            <?php else : ?>
                <div class="alert alert-warning" role="alert">
                    No comments to show
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <div class="card border-dark" style="margin-top: 20px;">
                <div class="card-header fw-light" style="text-align: center;">
                    Ajouter un commentaire
                </div>
                <div class="card-body">
                    <form action="<?= ROOT . "comments/add/" . $data['post']->id ?>" method="POST">
                        <div class="form-floating" style="margin-bottom: 10px">
                            <textarea class="form-control" name="contenu" required placeholder="Leave a comment here"
                                      id="floatingTextarea"></textarea>
                            <label for="floatingTextarea">Ecrire commentaire ici</label>
                        </div>
                        <div>
                            <input type="submit" name="submit" class="btn btn-success" value="Ajouter">
                            <input type="reset" value="Vider" class="btn btn-outline-danger">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6"></div>
    </div>
</div>



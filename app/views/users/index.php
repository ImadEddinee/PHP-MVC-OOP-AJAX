<div style="display: flex;justify-content: space-around;align-items: center;margin-bottom: 40px;margin-top: 20px">
    <h1 class="fs-1 fw-light">
        Les photos de <?= $data['username'] ?>
    </h1>
    <a  class="btn btn-outline-success" href="<?= ROOT . "users/index/1" ?>">
        Trier
    </a>
</div>
<?php if ($data['posts']): ?>
    <div class="container" style="margin-bottom: 20px;">
        <div class="row">
            <?php for ($i=0;$i<count($data['posts']);$i++): ?>
                <div class="col-3">
                    <div class="card" style="height: 29rem;margin-bottom: 10px">
                        <div style="min-height: 260px">
                            <img src='<?= ASSETS . $data['posts'][$i]->photo?>' class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title" style="text-align: center">
                                <?= stripslashes($data['posts'][$i]->description); ?>
                            </h5>
                            <p class="card-text fw-light" style="text-align: center">
                                Liked By : <?= $data['posts'][$i]->likes ?> users
                            </p>
                            <p style="text-align: center">
                                <a class="link-secondary fw-light" href="<?= ROOT."pictures/get/".$data['posts'][$i]->id ?>">
                                    Voir détails
                                </a>
                            </p>
                        </div>
                        <div class="card-footer text-muted" style="text-align: center">
                            <?= $data['posts'][$i]->updated_at; ?>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-danger" role="alert">
        No Posts to show
    </div>
<?php endif;?>





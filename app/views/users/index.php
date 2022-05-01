<h1 class="fs-1 fw-light" style="text-align: center;margin-bottom: 40px;margin-top: 20px">
    Les photos de <?= $data['username'] ?>
</h1>
<div class="container" style="margin-bottom: 20px;">
    <div class="row">
        <?php for ($i=0;$i<count($data['posts']);$i++): ?>
            <div class="col-3">
                <div class="card" style="height: 29rem;margin-bottom: 10px">
                    <div style="min-height: 260px">
                        <img src='<?= $data['posts'][$i]->picture?>' class="card-img-top" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center">
                            <?= $data['posts'][$i]->id; ?>
                        </h5>
                        <p class="card-text" style="text-align: center">
                            <?= stripslashes($data['posts'][$i]->description); ?>
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




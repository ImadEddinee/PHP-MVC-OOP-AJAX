<h1 class="fs-1 fw-light" style="text-align: center;margin-bottom: 40px;margin-top: 20px">Les photos de <?= rawurldecode($data['user'])?></h1>
<div class="container" style="margin-bottom: 20px;">
    <div class="row">
        <?php for ($i=0;$i<count($data['photos']);$i++): ?>
            <div class="col-3">
                <div class="card" style="height: 29rem;margin-bottom: 10px">
                    <div style="min-height: 260px">
                        <img src='<?= str_replace("/assets","",ASSETS).$data['photos'][$i]->fichier?>' class="card-img-top" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="text-align: center">
                            <?= $data['photos'][$i]->id; ?>
                        </h5>
                        <p class="card-text" style="text-align: center">
                            <?= stripslashes($data['photos'][$i]->description); ?>
                        </p>
                        <p style="text-align: center">
                            <a class="link-secondary fw-light" href="<?= ROOT."picture/get_photo/".$data['photos'][$i]->id ?>">
                                Voir détails
                            </a>
                        </p>
                    </div>
                    <div class="card-footer text-muted" style="text-align: center">
                        <?= $data['photos'][$i]->date_photo; ?>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>



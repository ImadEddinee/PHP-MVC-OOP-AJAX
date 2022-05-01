<div class="container" style="margin-top: 80px">
    <div class="row">
        <div class="col-8">
            <div class="card border-danger">
                <div class="card-header bg-danger fw-light" style="text-align: center;color:white">
                    Modification de la photo
                </div>
                <div class="card-body">
                    <form action="<?= ROOT."picture/save" ?>" method="POST">
                        <div class="form-floating" style="margin-bottom: 10px">
                    <textarea class="form-control" name="description" required placeholder="Leave a comment here" id="floatingTextarea">
                        <?= $data['post']->description; ?>
                    </textarea>
                            <label for="floatingTextarea">Description de la photo</label>
                        </div>
                        <div style="margin-bottom: 10px">
                            <label for="">Modifier les catégories de la photo :</label>
                            <div style="margin-bottom: 10px;height: 80px;overflow: auto">
                                <?php for ($i=0;$i<count($data['categories']);$i++): ?>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               name="categories[]"
                                               type="checkbox"
                                            <?php if (in_array($data['categories'][$i]->id ,$data['post_categories'])) echo "checked"?>
                                               value="<?= $data['categories'][$i]->id ?>"
                                               id="<?= $i ?>">
                                        <label class="form-check-label" for="<?= $i ?>">
                                            <?= $data['categories'][$i]->name ?>
                                        </label>
                                    </div>
                                <?php endfor; ?>
                            </div >
                        </div >
                        <input type='hidden' name='id' value='<?=$data['post']->id;?>'>
                        <div class="row">
                            <div class="col-10">
                                <div class="d-grid gap-2" style="margin-top: 5px">
                                    <input type='submit' class="btn btn-danger" value='Changer'>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="d-grid gap-2" style="margin-top: 5px">
                                    <input type='reset' class="btn btn-outline-dark" value='Effacer'>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <img width="450px" src='<?= $data['post']->picture ?>'>
        </div>
    </div>
</div>


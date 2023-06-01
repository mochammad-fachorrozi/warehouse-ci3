<?php
foreach ($datas as $key => $data) :
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

        <div class="row">
            <div class="col-lg-6">

                <!-- form upload ci -->
                <?= form_open_multipart('item/updateItem'); ?>

                <div class="form-group row">
                    <label for="code" class="col-sm-2 col-sm-form-label"> Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="code" id="code" value="<?= $data->code ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-sm-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" value="<?= $data->name; ?>">
                    </div>
                </div>
                <?php if ($user['role_id'] == 1) { ?>

                    <div class="form-group row">
                        <label for="stock" class="col-sm-2 col-sm-form-label">Stock</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="stock" id="stock" value="<?= $data->stock; ?>">
                        </div>
                    </div>

                <?php } else { ?>
                    <div class="form-group row">
                        <label for="stock" class="col-sm-2 col-sm-form-label">Stock</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="stock" id="stock" value="<?= $data->stock; ?>" readonly>
                        </div>
                    </div>
                <?php } ?>



                <!-- Category -->
                <?php if ($sumCategory > 0) : ?>
                    <div class="form-group row">

                        <label for="category_id" class="col-sm-2 col-sm-form-label">Category</label>

                        <div class="col-sm-10">

                            <select name="category_id" class="form-control chosen">
                                <?php foreach ($categories as $category) : ?>

                                    <?php if ($data->category_id == $category->id) : ?>
                                        <option value="<?= $category->id ?>" selected><?= $category->name ?></option>
                                    <?php else : ?>
                                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="form-group"><label>Category</label>
                        <input type="hidden" name="jenis">
                        <div class="d-sm-flex justify-content-between">
                            <span class="text-danger"><i>(Not Found Category!)</i></span>
                            <a href="<?= base_url() ?>item" class="btn btn-sm btn-primary btn-icon-split">
                                <span class="icon text-white">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="form-group row">
                    <div class="col-sm-2">Image</div>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/img/item/') . $data->image; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="image">
                                    <label for="image" class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- just = agar mepet ke kanan -->
                <div class="form-group row justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>


                </form>


            </div>
        </div>

    </div>
    <!-- /.container-fluid -->


<?php endforeach; ?>
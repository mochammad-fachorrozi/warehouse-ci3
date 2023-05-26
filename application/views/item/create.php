<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <!-- form upload ci -->
            <?= form_open_multipart('item/create'); ?>

            <div class="form-group row">
                <label for="name" class="col-sm-2 col-sm-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name"> <!-- agar user cuma bisa liat -->
                </div>
            </div>
            <div class="form-group row">
                <label for="stock" class="col-sm-2 col-sm-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="stock" id="stock">
                </div>
            </div>

            <!-- category -->
            <?php if ($sumCategory > 0) : ?>
                <div class="form-group row">
                    <label for="category_id" class="col-sm-2 col-sm-form-label">Category</label>

                    <div class="col-sm-10">

                        <select id="category_id" name="category_id" class="form-control chosen">
                            <option value="">--Choose--</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->id ?>"><?= $category->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group"><label>Item Category</label>
                    <input type="hidden" name="category_id">
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
                            <img src="<?= base_url('assets/img/profile/test.jpg'); ?>" class="img-thumbnail">
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
                <button type="submit" class="btn btn-primary">Save</button>
            </div>


            </form>


        </div>
    </div>

</div>
<!-- /.container-fluid -->
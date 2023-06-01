<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

    <?= $this->session->flashdata('message'); ?>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            <a href="<?= base_url() ?>item/create" class="btn btn-primary mb-3">Add New Item</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 1%;">No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($datas as $data) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data->code; ?></td>
                                <td><?= $data->name; ?></td>
                                <td><?= $data->stock; ?></td>
                                <td><?= $data->cate_name ?></td>
                                <td><img src="<?= base_url('assets/img/item/') . $data->image; ?>" alt="image <?= $data->name; ?>" class="img-thumbnail" width="100"></td>
                                <td>
                                    <a href="<?= base_url('item/edit/' . $data->code) ?>" class="btn btn-sm btn-success">Edit</a>

                                    <?php if ($user['role_id'] == 1) { ?>

                                        <a data-toggle="modal" data-target="#deleteItem<?= $data->code ?>" class="btn btn-sm btn-danger">Delete</a>

                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<!-- Delete Modal -->
<?php foreach ($datas as $key => $data) : ?>
    <div class="modal fade" id="deleteItem<?= $data->code ?>" tabindex="-1" aria-labelledby="deleteItemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('item/delete'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <input type="hidden" class="form-control" id="code" name="code" placeholder="ID" value="<?= $data->code ?>">

                            <h6>Are you Sure ?</h6>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>
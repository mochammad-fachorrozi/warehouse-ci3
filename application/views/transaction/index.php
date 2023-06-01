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
            <a href="<?= base_url() ?>transaction/create" class="btn btn-primary mb-3">Add Input Item</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 1%;">No</th>
                            <th>Code Transaction</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>User</th>
                            <?php if ($user['role_id'] == '3') { ?>

                            <?php } else { ?>
                                <th>Action</th>

                            <?php } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($datas as $data) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data->code; ?></td>
                                <td><?= $data->name_item; ?></td>
                                <td><?= $data->qty; ?></td>
                                <td>
                                    <?php if ($data->is_approved == 2) { ?>
                                        <a href="" class="badge badge-danger">Reject</a>

                                    <?php } else if ($data->is_approved == 1) { ?>
                                        <a href="" class="badge badge-success">Approve</a>

                                    <?php } else { ?>
                                        <a href="" class="badge badge-warning">Pending</a>

                                    <?php } ?>
                                </td>
                                <td><?= $data->date ?></td>
                                <td><?= $data->name ?></td>
                                <td>

                                    <?php if ($user['role_id'] == '3') { ?>

                                    <?php } else { ?>
                                        <a data-toggle="modal" data-target="#approve<?= $data->code ?>" class="btn btn-sm btn-warning">Approved ?</a>
                                        <a href="<?= base_url('transaction/edit/' . $data->code) ?>" class="btn btn-sm btn-success">Edit</a>
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
                    <h5 class="modal-title" id="deleteItemLabel">Delete Input Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('transaction/destroy'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <input type="hidden" class="form-control" id="code" name="code" value="<?= $data->code ?>">

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


<!-- Approve Modal -->
<?php foreach ($datas as $key => $data) : ?>

    <?php $result = $data->stock + $data->qty;    ?>


    <div class="modal fade" id="approve<?= $data->code ?>" tabindex="-1" aria-labelledby="aprroveModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aprroveModal">Approve Input Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('transaction/approve'); ?>" method="post">
                    <div class="modal-body">

                        <input type="hidden" class="form-control" id="code" name="code" value="<?= $data->code ?>">

                        <div class="form-group row">
                            <label for="code_item" class="col-sm-2 col-sm-form-label">Item</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="code_item" id="code_item" value="<?= $data->name_item ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stock" class="col-sm-2 col-sm-form-label">Stock</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="stock" id="stock" value="<?= $data->stock ?>" readonly>
                            </div>

                            <label for="" class="col-sm-1 col-sm-form-label">+</label>

                            <label for="qty" class="col-sm-2 col-sm-form-label">Qty</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" name="qty" id="qty" value="<?= $data->qty ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="result" class="col-sm-2 col-sm-form-label">Result</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="result" id="result" value="<?= $result ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a data-toggle="modal" data-target="#reject<?= $data->code ?>" class="btn btn-danger" data-dismiss="modal">Reject</a>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>


<!-- Reject Modal -->
<?php foreach ($datas as $key => $data) : ?>
    <div class="modal fade" id="reject<?= $data->code ?>" tabindex="-1" aria-labelledby="deleteItemLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemLabel">Reject Input Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('transaction/reject'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <input type="hidden" class="form-control" id="code" name="code" value="<?= $data->code ?>">

                            <h6>Are you sure for reject data ?</h6>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>


<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print'
            ]
        });
    });
</script>
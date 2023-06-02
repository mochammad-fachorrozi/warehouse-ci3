<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th style="width: 1%;">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Image</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($test as $t) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $t->name; ?></td>
                                <td><?= $t->email; ?></td>
                                <td><img src="<?= base_url('assets/img/profile/') . $t->image; ?>" alt="image <?= $t->name; ?>" class="img-thumbnail" width="100"></td>
                                <td><?= $t->role; ?></td>
                                <td>
                                    <a data-toggle="modal" data-target="#edit<?= $t->id ?>" class="btn btn-sm btn-success">Edit</a>
                                    <a data-toggle="modal" data-target="#delete<?= $t->id ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- End of Main Content -->


<!-- Edit Modal -->
<?php foreach ($test as $key => $t) : ?>
    <div class="modal fade" id="edit<?= $t->id ?>" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/update'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $t->id ?>">
                            <div class="form-group row">

                                <label for="role_id" class="col-sm-2 col-sm-form-label">Role</label>

                                <div class="col-sm-10">

                                    <select name="role_id" class="form-control chosen">
                                        <?php foreach ($role as $r) : ?>

                                            <?php if ($t->role_id == $r->id) : ?>
                                                <option value="<?= $r->id ?>" selected><?= $r->role ?></option>
                                            <?php else : ?>
                                                <option value="<?= $r->id ?>"><?= $r->role ?></option>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>


<!-- Delete Modal -->
<?php foreach ($test as $key => $t) : ?>
    <div class="modal fade" id="delete<?= $t->id ?>" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Delete Item</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/destroy'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <input type="hidden" class="form-control" id="id" name="id" value="<?= $t->id ?>">

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
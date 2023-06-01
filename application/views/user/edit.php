<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">

            <!-- form upload ci -->
            <?= form_open_multipart('user/edit'); ?>

            <div class="form-group row">
                <label for="email" class="col-sm-2 col-sm-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" readonly> <!-- agar user cuma bisa liat -->
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-sm-form-label">Full name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" value="<?= $user['name']; ?>">
                    <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">Picture</div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
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
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>


            </form>


        </div>
    </div>


</div>
<!-- End of Main Content -->
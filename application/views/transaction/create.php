<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <!-- form upload ci -->
            <?= form_open_multipart('transaction/create'); ?>

            <!-- item -->
            <?php if ($sumItem > 0) : ?>
                <div class="form-group row">
                    <label for="code_item" class="col-sm-2 col-sm-form-label">Item</label>

                    <div class="col-sm-10">

                        <select id="code_item" name="code_item" class="form-control chosen">
                            <option value="">--Choose--</option>
                            <?php foreach ($items as $item) : ?>
                                <option value="<?= $item->code ?>"><?= $item->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group"><label>Item</label>
                    <input type="hidden" name="code_item">
                    <div class="d-sm-flex justify-content-between">
                        <span class="text-danger"><i>(Not Found Category!)</i></span>
                        <a href="<?= base_url() ?>transaction" class="btn btn-sm btn-primary btn-icon-split">
                            <span class="icon text-white">
                                <i class="fas fa-plus"></i>
                            </span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>


            <div class="form-group row">
                <label for="qty" class="col-sm-2 col-sm-form-label">Qty</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="qty" id="qty">
                </div>
            </div>
            <div class="form-group row">
                <label for="date" class="col-sm-2 col-sm-form-label">date</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="date" id="date">
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
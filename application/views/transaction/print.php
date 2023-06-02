<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        td,
        h2 {
            text-align: center;
        }
    </style>
    <title>Print Data</title>
</head>

<body>

    <div class="container">

        <h2><?= $title; ?></h2>

        <table border="1">
            <tr>
                <th style="width: 1%;">No</th>
                <th>Code Transaction</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Date</th>
                <th>User</th>
            </tr>

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
                            Reject

                        <?php } else if ($data->is_approved == 1) { ?>
                            Approve

                        <?php } else { ?>
                            Pending

                        <?php } ?>
                    </td>
                    <td><?= $data->date ?></td>
                    <td><?= $data->name ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
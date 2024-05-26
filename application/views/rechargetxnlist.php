<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="example" class="table table-bordered key-buttons text-nowrap">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">MEMBER ID</th>
                        <th class="border-bottom-0">TXNID</th>
                        <th class="border-bottom-0">API-TXNID</th>
                        <th class="border-bottom-0">MOBILE</th>
                        <th class="border-bottom-0">OPERATOR</th>
                        <th class="border-bottom-0">AMOUNT</th>
                        <th class="border-bottom-0">STATUS</th>
                        <th class="border-bottom-0">DATE</th>
                    </tr>
                </thead>
               
                <tbody>
                    <?php $ind = 1; ?>
<?php foreach ($resdata as $dat) : ?>
                        <tr>
                            <td><?php echo $ind; ?></td>
                            <td><?php echo $dat->username; ?></td>
                            <td><?php echo $dat->txnid; ?></td>
                            <td><?php echo $dat->apitxnid; ?></td>
                            <td><?php echo $dat->mobile; ?></td>
                            <td><?php echo $dat->operator_name; ?></td>
                            <td><?php echo $dat->amount; ?></td>
                            <td>
                            <?php 
                            echo $dat->status;
                            ?>
                            </td>
                            <td><?php echo $dat->date; ?></td>
                        </tr>
                        <?php $ind++; ?>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
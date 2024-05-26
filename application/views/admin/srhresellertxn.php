
<div class="row">
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered text-nowrap">
            <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">Narration</th>
                    <th class="border-bottom-0">AMOUNT</th>
                    <th class="border-bottom-0">OPENING</th>
                    <th class="border-bottom-0">CLOSING</th>
                    <th class="border-bottom-0">DATE</th>
                </tr>
            </thead>

            <tbody>
                <?php $ind = 1; ?>
                <?php foreach ($rwallets as $dat) : ?>
                    <tr>
                        <td><?php echo $ind; ?></td>
                        <td><?php echo $dat->type . "  Txnid: " . $dat->txnid; ?></td>
                        <td><?php echo $dat->amount; ?></td>
                        <td><?php echo $dat->opening; ?></td>
                        <td><?php echo $dat->closing; ?></td>
                        <td><?php echo $dat->date; ?></td>
                    </tr>
                    <?php $ind++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
</div> 

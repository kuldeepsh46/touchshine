<!-- row opened -->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="example" class="table table-bordered key-buttons text-nowrap">
                <thead>
                    <tr>
                        <th class="border-bottom-0">#</th>
                        <th class="border-bottom-0">MEMBER ID</th>
                        <th class="border-bottom-0">TXNID</th>
                        <th class="border-bottom-0">MOBILE</th>
                        <th class="border-bottom-0">OPERATOR</th>
                        <th class="border-bottom-0">AMOUNT</th>
                        <th class="border-bottom-0">STATUS</th>
                        <th class="border-bottom-0">Response</th>
                        <th class="border-bottom-0">DATE</th>
                    </tr>
                </thead>
                <?php
                $uid = $_SESSION['uid'];
                $data = $this->db->from("rechargetxn")->where("uid", $uid)->where('date >=', $from)->where('date <=', $to)->order_by('id', "DESC")->get()->result();
                ?>
                <tbody>
                    <?php $ind = 1; ?>
<?php foreach ($data as $dat) : ?>
                        <tr>
                            <td><?php echo $ind; ?></td>
                            <td><?php echo $this->db->get_where('users', array('id' => $dat->uid))->row()->username; ?></td>
                            <td><?php echo $dat->txnid; ?></td>
                            <td><?php echo $dat->mobile; ?></td>
                            <td><?php echo $this->db->get_where('rechargev2op', array('id' => $dat->operator))->row()->name; ?></td>
                            <td><?php echo $dat->amount; ?></td>
                            <td>
                                <?php
                                 echo $dat->status;
                                ?>
                            </td>
                             <td>
    <?php
    // Decode the JSON response
    $response = json_decode($dat->response);
    
    // Check if decoding was successful and if errorMessage exists
    if ($response && isset($response->errorMessage)) {
        echo $response->errorMessage;
    } else {
        // Handle the case where the JSON response is invalid or doesn't contain the expected fields
        echo "Error retrieving error message.";
    }
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
</div>
</div>

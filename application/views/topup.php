<?php $this->load->view('header'); ?>
					<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Money Load</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                        <div class="card  box-shadow-0 ">
                            <div class="card-header">
                                <h4 class="card-title">Load Main Wallet Balance</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo base_url('main/create_order'); ?>" method="post">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Amount</label>
                                            <!-- Added min and max attributes for amount input -->
                                            <input class="form-control" placeholder="Ex. 100 rs" name="amount" type="number" value="" required min="1" max="10000">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3 mb-0" name="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        okkk
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<?php $this->load->view('footer'); ?>
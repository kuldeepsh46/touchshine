<style>
    .wrapper_m {
    position: relative;
    margin: 0 auto;
    overflow-x: scroll;
    padding: 26px;
   
}

.list {
    position: absolute;
    left: 0px;
    top: 0px;
    min-width: 1000px!important;
    margin-top: 0px;
}

.nav{
    padding: 0px 5px 0px 5px !important;
    
}

.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-radius: 0;
    color: inherit;
    color: #000000;
    transition: .3s border-color;
    font-weight: 500;
    font-weight: bold;
    padding: 0.4rem 0.6rem;
    font-size: 13px;
    text-align: center;
}
.nav-tabs .nav-item {
    margin-bottom: -1px;
    position: relative;
}
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0;
    border-top-right-radius:0;
}
.nav-tabs .nav-item {
    margin-bottom: -1px;
}
.nav-item {
    min-width: 1.6rem;
    transition: .3s color;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: pointer;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
}
</style>

<div class="row">
    <div class="col-md-5"  style="background-color:lightblue; ">
        <h5 style="text-align:center; margin-top:20px;">Operator :- <i><?php echo $op; ?></i></h5>
    </div>
    <div class="col-md-7"  style="background-color:lightblue; ">
        <h5 style="text-align:center; margin-top:20px;">Circle :- <i><?php echo $circle; ?></i></h5>
    </div>
    <hr>
    <div class="w-100 pt-3">
    
    <div class="wrapper_m">
        <nav class="nav nav-tabs list mt-2" id="myTab" role="tablist">
            <?php 
            $i=0;
            foreach($data as $dav) : 
                $i=$i+1;
            if($i==1){
                ?>
            <a class="nav-item nav-link active" data-toggle="tab" href="#tab<?php echo $i;?>" role="tab" aria-controls="public" aria-expanded="true"><?php echo $dav->name;?></a>
            <?php }else{?>
            <a class="nav-item nav-link" data-toggle="tab" href="#tab<?php echo $i;?>" role="tab" data-toggle="tab"><?php echo $dav->name;?></a>
           
            <?php } endforeach;?>
        </nav>
    </div>
    <div class="tab-content p-3" id="myTabContent">
        <?php
        $j=0;
        foreach($data as $dav) : 
          $j=$j+1;
        $tabopncls=($j==1)?'active show':'';
        $aria_expanded=($j==1)?'true':'false';
        $aria_labelled=($j==1)?'public-tab':'group-dropdown2-tab';
            ?>
        <div role="tabpanel" class="tab-pane fade  mt-2 <?php echo $tabopncls;?>" id="tab<?php echo $j;?>" aria-labelledby="<?php echo $aria_labelled;?>" aria-expanded="<?php echo $aria_expanded;?>">
             <?php
                         foreach ($dav->productList as $vpl) {
                             $amount= (int)filter_var($vpl->price, FILTER_SANITIZE_NUMBER_INT);
                             ?>
                          <div class="list-group mb-3">
 
  <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="setamount('<?php echo $amount; ?>');">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Rs. <?php echo $amount; ?> <button type="button" class="btn btn-success btn-sm ml-3">Select</button></h5>
      <small class="text-muted">Data |<?php echo '<b>'.$vpl->data.'</b>';?> <i class="fa fa-chevron-right"></i></small>
    </div>
    <p class="mb-1">Plan Name:<?php echo $vpl->displayName; ?></p>
    <p class="mb-1">*Validity:<?php echo $vpl->validity; ?></p>
    <p class="mb-1">*Talktime:<?php echo $vpl->talktime; ?></p>
    <p class="mb-1">*Data:<?php echo $vpl->data; ?></p>
    <small class="text-muted"><?php echo $vpl->description; ?></small>
    
  </a>
  
</div>   
                       <?php  }
             ?>
            
        </div>
        
        
       <?php endforeach;?>
    </div>
</div>
</div>
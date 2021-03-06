<div class="container order_conf">Please wait you are being redirected...  <img style="width:50px" src="<?php echo base_url('assets/images/loading_spinner.gif') ?>" alt="Please Wait ...">
<div class="container order_conf" style="display:none;">
  <div class="row">
    <?php if($this->session->flashdata('update_msg')){ ?>
    <div class="alert alert-success alert-dismissible" id="success-alert" role="alert">
    <strong><?php echo $this->session->flashdata('update_msg'); ?></strong>
    </div>
    <?php } ?>
    <?php $this->load->view('common/breadcrumb');?>
    <?php if($this->cart->total_items()>0){ ?>
 <form name="processorder" id="processorder" action="<?php echo base_url('cart/process')?>" method="post"> 
    <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <div class="cart_container">
                <div class="totel-box">
                  <h2>
                    <label class="cart-count"><?php echo count($this->cart->contents());?></label>item(s) in your Cart <i class="material-icons">shopping_cart</i> </h2>
                  <div class="cartValue">Total Cart Value : <span><i class="fa fa-inr"></i></span><span class="cartprice"> <?php echo number_format($this->cart->total(),2);?></span></div>
                </div>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="col-md-12">
                
  <div class="col-sm-5 col-xs-12 col-md-5"> 
      <div class="panel panel-default">
      <div class="panel-heading"><h3 class="panel-title">Product Info</h3>
  </div>
      <div class="mob_cont_conf">
                <div class="table-responsive">
                  <table class="table table-hover" cellspacing="5" cellpadding="5">
                    <tbody>
                      <?php
                              $i = 1;                              
                              foreach($this->cart->contents() as $items){
                              //$product = $this->Products_model->getProductDetails($items['id']);
                              ?>
                      <tr id="pro_<?php echo $items['rowid']; ?>" class="cartitems">
                        <!-- <td>
                                 <div class="image_box"><?php //echo show_thumb($product->image,200,200,'class="media-object" alt="'.$product->name.'"')?></div>
                              </td>-->
                        <td><div class="prod_panel"><a class="bold_txt" href="#"><?php echo $items['name'];?></a></div></td>
                        <!--    <td>
                                <div class="quantity"><span>Qty</span>
                                    <input class="form-control quantity" name="" id="<?php echo $items['rowid']; ?>" value="<?php echo $items['qty']; ?>">
                                 </div>
                              </td>
                        <td><div class="bold_txt"><b>Unit Price : <span><?php echo $items['price']; ?></span></b>
                            <div class="red"></div>
                          </div></td>-->
                        <td><div class="price_area"> <i class="fa fa-inr"></i>
                            <label id="pprice_<?php echo $items['rowid']; ?>"> <?php echo number_format($items['qty']*$items['price'],2);?></label>
                            <div class="clear"></div>
                            <!--<span class="strike" ><?php //echo $items['price'];?></span><br>-->
                            <!--<div class="discount">37%</div>-->
                          </div></td>
                        <td>&nbsp;</td>
                      </tr>
                      <!------hidden order------->
                      <!---/hidden order---------->
                      <?php $i++;
                              } ?>
                    </tbody>
                  </table>
                </div>
              </div>
      </div>
  </div>
  <div class="col-sm-4 col-xs-12 col-md-4">
      <div class="ship_amt_details">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Payment Summary</h3>
              </div>
              <div class="panel-body">
                
            <ul class="row">
            <li>
            <label class="col-xs-12 col-md-6 text-right">Sub-Total</label>
            <div class="col-xs-12 col-md-6"><i class="fa fa-inr"></i> <?php echo number_format($this->cart->total(),2);?></div>
            </li>            
            <li class="text-warning">
            <label class="col-xs-12 col-md-6 text-right">Other Charges</label>
            <div class="col-xs-12 col-md-6"><i class="fa fa-inr"></i> <?php echo $shipping_charges > 0?number_format($shipping_charges,2):'0'?></div>
            </li>
            <li>
            <label class="col-xs-12 col-md-6 text-right"><strong>Total</strong></label>
            <div class="col-xs-12 col-md-6"><strong><i class="fa fa-inr"></i> <?php echo number_format($this->cart->total()+$shipping_charges,2);?></strong></div>
            </li>
            </ul>            
             </div>
            </div>
            <!--<div class="cart_ship_btn">
             <div class="row">
              <div class="col-md-12 text-center"> <a href="#" class="btn btn-success btn-raised">Place Order</a> </div>
             </div>
            </div>-->
            </div> </div>
                
                
         <div class="col-sm-3 col-xs-12 col-md-3">
      <div class="ship_amt_details">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Place Order</h3>
              </div>
              <div class="panel-body">
                   <div class="pull-right">    
                       <h3 class="panel-title"><input type="checkbox" name="agree_terms" value="yes" checked="checked" /> &nbsp; Agree with the <a target="_blank" href="<?php echo base_url("payment_terms")?>">terms & conditions</a></h3>
           <button type="submit" class="btn btn-success btn-raised">Place Order</button>
            </div>       
             </div>
            </div>
            </div> </div>         
                
        </div>
  <input type="hidden" name="shipping_charges"  value="<?php echo $shipping_charges; ?>">
  </div>
</div>  
               
               
            <!--
               
               <div class="col-md-12 pull-right"><h3 class="panel-title">Agree with the terms & conditions</h3><input type="checkbox" name="agree_terms" value="yes" checked="checked" /> 
        <button type="submit" class="btn btn-success btn-raised">Place Order</button></div>
               --> 
              <?php if(isset($shipping_address)){ ?>
              <!-- check out details -->
            <!-- <div class="col-xs-12 col-md-6">
              <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Shipping Address</h3>
              </div>
              <div class="panel-body">
                <h4><strong><?php echo $shipping_address->address_name;?></strong></h4>
            	<p><?php echo $shipping_address->address. ' '.$shipping_address->address2;?>
                    <br/> <?php echo $shipping_address->city_name?> (<?php echo $shipping_address->state_name?>) <?php echo $shipping_address->zipcode?>
                    <br/><?php echo $shipping_address->mobile;?></p>    
              </div>
            </div>
            </div>-->
              <?php } ?> 
            </div>
          </div>
        </div>
<?php 
if($payment_mode>0){
    $payment_mode_type=$payment_mode;
}else{    
    $payment_mode_type=3;
} ?>
  <input type="hidden" name="paymentmethod" value="<?php echo $payment_mode_type; ?>">
  <input type="hidden" name="cart_id" value="<?php echo $cart_in_db->id; ?>">
  <input type="hidden" name="shipping_address_id" value="<?php echo $shipping_id; ?>">
 </form>
    
    <script type="text/javascript">
    //document.getElementById('processorder').submit(); // SUBMIT FORM
    document.forms["processorder"].submit();
</script>
    <?php }else{ ?>
    <div class="col-md-12">
      <div class="panel panel-default well">
          <div class="panel-body ">
              <h3 class="center">Your shopping cart is empty</h3>
              <p><a class="btn btn-success btn-raised btn-lg" href="<?php echo base_url()?>">
                    Continue Shopping
                  </a></p>
          </div>
      </div>
    </div>
    
    <?php } ?>
    <div class="clearfix"></div>
  
    
  </div>
</div>

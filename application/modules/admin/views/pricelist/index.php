<div id="page-wrapper" class="row">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Price List</h1>
        </div>
                <!-- /.col-lg-12 -->
    </div>
            <!-- /.row -->
    <div class="row">
        <form name="pricelistform" id="pricelistform" action="<?php echo base_url('admin/pricelist/addPrice')?>" method="post" enctype="multipart/form-data">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Content Type</label>
                    <?php echo generateSelectBox('content_type',$content_type,'id','name',1,'class="form-control" onChange="resetSelect();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Exam</label>
                    <?php echo generateSelectBox('category',$exams,'id','name',1,'class="form-control" onchange="getContent();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Subject</label>
                    <?php echo generateSelectBox('subject',$subjects,'id','name',1,'class="form-control" onchange="getContent();"');?>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Select Chapter</label>
                    <?php echo generateSelectBox('chapter','','id','name',1,'class="form-control" onchange="getContent(1);"');?>
                </div>
            </div>
            <div class="col-lg-12 alert alert-success" id="pricedata" style="display: none;">
           
                  <div class="col-sm-12">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Product Name</label>        
                    <textarea required="true" name="modules_item_name" value=""  id="modules_item_name"></textarea>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Product Price</label>
                    <input required="true"  type="text" name="price" value=""  id="price"/>                
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                <label>Discounted Price</label>
                <input required="true"  type="text" name="discounted_price" value=""  id="discounted_price"/>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">    
                    <label>Product Description</label>
                    <textarea name="description" value=""  id="description"></textarea>
                </div>
            </div>
                  </div>
               <div class="col-sm-12">  
            <div class="col-sm-3">
                <div class="form-group">    
                <label>Product Image</label>
                <div id="proimage" style="display: none"></div>
                <input type="file" name="image" value=""  id="image"/>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">    
                <label>App Image</label>
                <div id="appimage"></div>
                <input type="text" name="appimage" value=""  id="appimage"/>
                </div>
            </div>
                <div class="col-sm-3">
                <div class="form-group">    
                <label>Available Offline</label>
                <input type="radio" name="offline_status" value="1"  id="offline_status1"/>Yes
                <input type="radio" name="offline_status" checked value="0"  id="offline_status0"/>No
                </div>
             </div>          
             <div class="col-sm-3" > 
                <div class="form-group">
                        <label>Number of Lectures/Packages</label>
                        <input required="true" type="text" name="number_of_lectures" value=""  id="number_of_lectures"/>
                </div>
            </div>
            <div class="col-sm-3" > 
                <div class="form-group">
                          <label>Total DVD's</label>
                           <input  type="text" name="total_dvds" value=""  id="total_dvds"/>
                </div>
            </div>                   
               </div>
                  <div class="col-sm-12">
                
                   <div class="col-sm-4"> 
                <div class="form-group">
                          <label>Lecture Duration</label>
                           <input type="text" name="lecture_duration" value=""  id="lecture_duration"/>
                </div>
            </div> 
           <div class="col-sm-4" > 
            <div class="form-group">
                          <label>Subscription Validity</label>
                           <input type="text" name="subscription_validity" value=""  id="subscription_validity"/>
                </div>
            </div>
            <div class="col-sm-4"> 
                <div class="form-group">
                          <label>Total Subscribers</label>
                           <input type="text" name="total_subscribers" value=""  id="total_subscribers"/>
                </div>
            </div>
               </div>   
            <input type='hidden' name='faction' id='faction' value='0'/>
            <div class="col-sm-6 pull-left">
                <div class="form-group">    
                <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
            <div class="col-sm-6 pull-right">
                <div class="form-group">    
                    <a class="btn btn-primary" href="" id="orderlist_url" target="_blank">Order List</a>
                    <a class="btn btn-primary" href="" id="cartlist_url" target="_blank">Cart List</a>
                </div>
            </div>
            
            <div class="col-lg-12">Price List SQL ID<input type='input' disabled="disabled" id='faction_pricelist_id' value='0'/></div>
        </div>
        </div>
        </form>
        <div class="col-lg-12" id="contentdata" style="display: none;">
            <div class="panel">
            <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr><th>#</th>
                                    <th>Sql ID.</th>
                                    <th>Name</th>
                                    <th>Class</th>    
                                    <th>Subject</th>    
                                    <th>Chepter</th>
                                    <th>Total Price Rs.<p id="priiceTable"></p></th>    
                                    <th>Total Qty.<p id="totalproduct" ></p></th>
                                </tr>
                            </thead>
                            <tbody>                                
                            </tbody>
                        </table>
                    </div>
                </div>
                    <!-- /.panel -->
            </div>
                <!-- /.col-lg-6 -->
        </div>
    </div>
</div>

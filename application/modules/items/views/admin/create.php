<div class="col-md-8">

<!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">Items</h4>
    <div class="heading-elements">
       <?php echo anchor( 'admin/items/create/'.$page, '<i class="glyphicon glyphicon-plus">                </i>'.lang('web_add_t', array(':name' => 'Items')), 'class="btn btn-primary"');?>
          <?php echo anchor( 'admin/items/' , '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"');?>
        <div class="btn-group">
          <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i> Options</button>
          
          <ul class="dropdown-menu pull-right">
            <li><a class=""  href="<?php echo base_url('admin/items'); ?>"><i class="glyphicon glyphicon-list-alt"></i> Manage Items</a></li>
             <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/items_category'); ?>"><i class="glyphicon glyphicon-fullscreen"></i> Manage Items Category</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/add_stock/create'); ?>"><i class="glyphicon glyphicon-plus"></i> Add Stock</a></li>
              <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/stock_taking'); ?>"><i class="glyphicon glyphicon-edit"></i> Stock Taking</a></li>
             <li class="divider"></li>
            <li><a href="<?php echo base_url('admin/inventory'); ?>"><i class="glyphicon glyphicon-folder-open"></i> Inventory Listing</a></li>
          </ul>
        </div>
    </div>
  </div>
  
  <div class="panel-body">
                    

<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
  <div class="col-md-3" for='item_name'>Item Name <span class='required'>*</span></div><div class="col-md-6">
  <?php echo form_input('item_name' ,$result->item_name , 'id="item_name_"  class="form-control" ' );?>
  <?php echo form_error('item_name'); ?>
</div>
</div>

<div class='form-group'>
  <div class="col-md-3" for='category'>Category <span class='required'>*</span></div>
<div class="col-md-6">
                <?php     
     echo form_dropdown('category', $category,  (isset($result->category)) ? $result->category : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('category'); ?>
    
</div></div>

<div class='form-group'>
  <div class="col-md-3" for='reorder_level'>Reorder Level </div><div class="col-md-6">
  <?php echo form_input('reorder_level' ,$result->reorder_level , 'id="reorder_level"  class="form-control" ' );?>
  <?php echo form_error('reorder_level'); ?>
</div>
</div>

<div class="form-group">
                    <div class="head dark">
                        <div class="icon"><i class="icos-pencil"></i></div>
                        <h2>Description</h2>
                    </div>
                    <div class="block-fluid editor">
                        
                        <textarea id="" class="wysihtml5 wysihtml5-min " name="description" style="height: 300px;">
                          <?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
  <?php echo form_error('description'); ?>
                        
                    </div>
                   
                </div> 

<div class='form-group'><div class="control-div"></div>
<div class="col-md-12 text-right p-10">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
  <?php echo anchor('admin/items','Cancel','class="btn btn-danger"');?>
</div>
</div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
       
  </div>
    <div class="col-md-4">
    
        <!-- Pager -->
        <div class="panel panel-white animated fadeIn">
          <div class="panel-heading">
            <h4 class="panel-title">Add Item Category</h4>
            <div class="heading-elements">
            
            </div>
          </div>
          
          <div class="panel-body">
                       
                         <?php echo form_open('admin/items_category/quick_add','class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-9">                                      
                                 <?php echo form_input('name','', 'id="title_1" class="form-control" placeholder=" e.g Electronics,Vehicle etc"' );?>
                             <?php echo form_error('title'); ?>
                            </div>
                        </div>
                                                    
                        <div class="form-group">
             <div class="col-md-3">Description:</div>
                            <div class="col-md-9">
                                <textarea class="form-control" name="description"></textarea> 
                            </div>
                        </div>                        
                   
                    <div class="toolbar TAR text-right p-10">
                        <button class="btn btn-primary">Add</button>
                    </div>
             <?php echo form_close(); ?> 
             </div>
                </div>
  
  
  </div>
  

  
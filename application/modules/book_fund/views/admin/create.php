<div class="col-md-8">
  <!-- Pager -->
  <div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
      <h4 class="panel-title">Book Fund</h4>
      <div class="heading-elements">
         <?php echo anchor( 'admin/book_fund/create' , '<i class="glyphicon glyphicon-plus">
                </i> '.lang('web_add_t', array(':name' => 'Book Fund')), 'class="btn btn-primary"');?> 
              <?php echo anchor( 'admin/book_fund' , '<i class="glyphicon glyphicon-list">
                </i> '.lang('web_list_all', array(':name' => 'Books Fund')), 'class="btn btn-primary"');?>
      </div>
    </div>
    
    <div class="panel-body">  
           
<?php 
$attributes = array('class' => 'form-horizontal', 'id' => '');
echo   form_open_multipart(current_url(), $attributes); 
?>
<div class='form-group'>
  <div class="col-md-2" for='title'>Title <span class='required'>*</span></div><div class="col-md-6">
  <?php echo form_input('title' ,$result->title , 'id="title_"  class="form-control" ' );?>
  <?php echo form_error('title'); ?>
</div>
</div>

<div class='form-group'>
  <div class="col-md-2" for='category'>Category <span class='required'>*</span></div>
<div class="col-md-6">
                <?php    echo form_dropdown('category', $category,  (isset($result->category)) ? $result->category : ''     ,   ' class="select" data-placeholder="Select Options..." ');
     echo form_error('category'); ?>
</div></div>

<div class='form-group'>
  <div class="col-md-2" for='pages'>Pages <span class='required'>*</span></div><div class="col-md-6">
  <?php echo form_input('pages' ,$result->pages , 'id="pages_"  class="form-control" ' );?>
  <?php echo form_error('pages'); ?>
</div>
</div>

<div class='form-group'>
  <div class="col-md-2" for='author'>Author </div><div class="col-md-6">
  <?php echo form_input('author' ,$result->author , 'id="author_"  class="form-control" ' );?>
  <?php echo form_error('author'); ?>
</div>
</div>

<div class='form-group'>
  <div class="col-md-2" for='edition'>Edition </div><div class="col-md-6">
  <?php echo form_input('edition' ,$result->edition , 'id="edition_"  class="form-control" ' );?>
  <?php echo form_error('edition'); ?>
</div>
</div>

<div class='widget'>
  <div class='head dark'>
        <div class='icon'><i class='icos-pencil'></i></div>
  <h2>Description </h2></div>
   <div class="block-fluid editor">
  <textarea id="description"   style="height: 300px;" class=" wysihtml5 wysihtml5-min"  name="description"  /><?php echo set_value('description', (isset($result->description)) ? htmlspecialchars_decode($result->description) : ''); ?></textarea>
  <?php echo form_error('description'); ?>
</div>
</div>

<div class='form-group col-md-12'><div class="col-md-2"></div><div class="col-md-12 text-right">
    

    <?php echo form_submit( 'submit', ($updType == 'edit') ? 'Update' : 'Save', (($updType == 'create') ? "id='submit' class='btn btn-primary''" : "id='submit' class='btn btn-primary'")); ?>
  <?php echo anchor('admin/book_fund','Cancel','class="btn  btn-default"');?>
</div></div>
 
<?php echo form_close(); ?>
<div class="clearfix"></div>
 </div>
            </div>
</div>
      
 <div class="col-md-4">
    
       <!-- Pager -->
<div class="panel panel-white animated fadeIn">
  <div class="panel-heading">
    <h4 class="panel-title">Add Book Category</h4>
    <div class="heading-elements">
    
    </div>
  </div>
  
  <div class="panel-body">
                       
                         <?php echo form_open('admin/books_category/add','class=""'); ?>
                        <div class="form-group">
                            <div class="col-md-3">Name:</div>
                            <div class="col-md-9">                                      
                                 <?php echo form_input('name','', 'id="title_1" class="form-control" placeholder=" e.g Social Studies, Primary English etc"' );?>
                             <?php echo form_error('title'); ?>
                            </div>
                        </div>
                                                    
                        <div class="form-group ">
             <div class="col-md-3">Description:</div>
                            <div class="col-md-9">
                                <textarea class="form-control" placeholder="Description" name="description"></textarea> 
                            </div>
                        </div>                        
                   
                    <div class="toolbar TAR text-right col-md-12 p-10">
                        <button class="btn btn-primary">Add</button>
                    </div>
             <?php echo form_close(); ?> 
             </div>
                </div>
  
  
  </div>
<div class="head">
<?php $post = (object) $post; ?>	

        <!-- tabular listing -->
        <?php echo form_open_multipart($this->uri->uri_string(), ' id="form"  class="form-horizontal"'); ?>
  
            <div class="form-group">
                <label class="col-md-2" for="title">Title</label>
                <div class="col-md-4">
                    <?php echo form_input('title', $post->title, ' class="input-xlarge focused"'); ?>
                </div>
            </div>											
            <div class="form-group">
                <label class="col-md-2" for="slug">Slug</label>
                <div class="col-md-4">
                    <?php echo form_input('slug', $post->slug, ' class="input-xlarge focused"'); ?>
                </div>
            </div>	
            <div class="widget">
         

            <div class="form-group">
                <label class="col-md-2" for="status">Status</label>
                <div class="col-md-10">
<?php echo form_dropdown('status', array('draft' => 'Draft', 'live' => 'Live'), $post->status); ?>
                    <span class="help-inline">Whether to publish or not</span>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="" class="btn btn-primary blue">Save changes</button>
                <button class="btn">Cancel</button>
            </div>
<?php echo form_close(); ?>
    </div><!--/span-->

<?php echo form_open(current_url(), 'class="form-inline" id="fextra"'); ?>

<div class="col-md-6">
    <div class="widget">
        <div class="head dark">
            <div class="icon"><span class="icosg-newtab"></span></div>
            <h2>Range</h2>
        </div>
        <div class="block-fluid">
            <div class='form-group'>
                <div class="col-md-3">Minimum Balance<span class='required'>*</span></div>
                <div class="col-md-9">
                    <?php
                    $bals = array(
                        '999999' => 'Any Balance',
                        '1000' => '1000',
                        '2000' => '2000',
                        '5000' => '5000',
                        '8000' => '8000',
                        '10000' => '10000',
                        '12000' => '12000',
                        '15000' => '15000',
                        '18000' => '18000',
                        '20000' => '20000',
                        '25000' => '25000',
                        '30000' => '30000',
                        '35000' => '35000',
                        '40000' => '40000',
                        '45000' => '45000',
                        '50000' => '50000'
                    );
                    echo form_dropdown('bal', array('' => '') + $bals, '', ' class="select" data-placeholder="Select Minimum Balance" ');
                    echo form_error('bal');
                    ?>
                </div>
            </div>
            <div class="p-action">
                <input type="submit" class="btn btn-sm btn-success pull-right" value="Send SMS" onClick="return confirm('Confirm Send SMS?')" />
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<style>
    .p-action{margin: 7px;}
</style>
<script type = "text/javascript">
        $(document).ready(function () {


        });
</script>
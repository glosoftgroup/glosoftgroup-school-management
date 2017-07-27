<div class="col-md-10">
<!-- Pager -->
<div class="panel panel-white animated fadeIn">
    <div class="panel-heading">
        <h4 class="panel-title"> Event Details</h4>
        <div class="heading-elements">
          <button onClick="return false" id="printBtn" class="btn btn-primary" type="button"><span class="glyphicon glyphicon-print"></span> Print </button>
                <?php echo anchor('admin/school_events/list_view/', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    
    <div class="panel-body">
    

    <div class="block invoice1" id="printme">

        <div class="clearfix"></div>
        <div class="col-md-11 view-title text-center">
            <h1><img src="<?php echo base_url('assets/themes/admin/img/logo-sm.png'); ?>" />
                <h5><?php $settings = $this->ion_auth->settings();
                echo ucwords($settings->motto);
                ?>
                    <br>
                    <span style="font-size:0.6em !important"><?php echo $settings->postal_addr . '<br> Tel:' . $settings->tel . ' Cell:' . $settings->cell ?></span>
                </h5>
            </h1>

        </div>
        <div class="clearfix"></div>

        <div class="col-md-2 dates">
            <div class="pane">
                <div class="panelbody dark">
                    <div class="icon"><i class="icos-user3"></i></div>
                    <h2 class='border-lg'>Events Dates</h2>
                                                                     
                </div>                    
                <div class="panel-body events">
                    <div class="item" style="min-height:80px;">
                        <div class="date ">
                            <div class="caption"><span class="glyphicon glyphicon-tags glyphicon glyphicon-calendar"></span></div>
                            <span class="day"><?php echo date('d', $post->start_date); ?></span>
                            <span class="month"><?php echo date('M, Y', $post->start_date); ?></span>
                        </div>

                    </div>                        

                    <div class="item" style="min-height:80px;">
                        <div class="date" >
                            <div class="caption red"><span class="glyphicon glyphicon-info-sign glyphicon glyphicon-calendar"></span></div>
                            <span class="day"><?php echo date('d', $post->end_date); ?></span>
                            <span class="month"><?php echo date('M, Y', $post->end_date); ?></span>
                        </div>

                    </div>                         

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="widget">
                <div class="head dark">
                    <div class="icon"><i class="icos-user3"></i></div>
                    <h2>Events Details</h2>
                    <div class="heading-elements">
                        
                    </div>                                               
                </div>                    
                <div class="block-fluid events">

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="strong">Title:</td>
                                <td><?php echo $post->title; ?></td>
                            </tr>
                             <tr>
                                <td class="strong">Start Date:</td>
                                <td><?php echo date('d M Y', $post->start_date); ?></td>
                            </tr>
                             <tr>
                                <td class="strong">End Date:</td>
                                <td><?php echo date('d M Y', $post->end_date); ?></td>
                            </tr>
                             <tr>
                                <td class="strong">Venue:</td>
                                <td><?php echo $post->venue; ?></td>
                            </tr>
                             <tr>
                                <td class="strong">Guests:</td>
                                <td><?php echo $post->visibility; ?></td>
                            </tr>
                            <tr>
                                <td class="strong">Description</td>
                                <td><?php echo $post->description; ?></td>
                            </tr>

                        </tbody>
                    </table> 

                                          

                </div>
            </div>
        </div>

    </div>

</div>
</div>
<style>
    @media print{

        .navigation{
            display:none;
        }
        .head{
            display:none;
        }

        .tip{
            display:none !important;
        }
        .dates{
            display:none;
        } 
        .date{
            display:none;
        }
        .item{
            display:none;
        }
        .view-title h1{border:none !important; }
        .view-title h3{border:none !important; }

        .split{

            float:left;
        }
        .header{display:none}
        .invoice { 
            width:100%;
            margin: auto !important;
            padding: 0px !important;
        }
        .invoice table{padding-left: 0; margin-left: 0; }

        .smf .content {
            margin-left: 0px;
        }
        .content {
            margin-left: 0px;
            padding: 0px;
        }
    }
</style>   

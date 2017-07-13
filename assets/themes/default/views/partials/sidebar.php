<aside class="col-md-3 col-sm-4 col-xs-12 sidebar">
    <div class="widget">
        <div class="panel-group custom-accordion sm-accordion" id="category-filter">
            <div class="panel">
                <div class="accordion-header">
                    <div class="accordion-title"><span>Menu</span></div><!-- End .accordion-title -->
                    <a class="accordion-btn opened" data-toggle="collapse" data-target="#category-list-2"></a>
                </div><!-- End .accordion-header -->

                <div id="category-list-2" class="collapse in" style="height: auto;">
                    <div class="panel-body">
                        <ul class="category-filter-list jscrollpane">
                            <li><?php echo anchor('account', 'Home'); ?></li>
                            <li><?php echo anchor('exams/results', 'Exam Results'); ?></li>
                            <li><?php echo anchor('fee_payment/fee', 'Fee Payment Status'); ?></li>
                            <li><?php echo anchor('fee_structure/view', 'Fee Structure'); ?></li>
                            <li><?php echo anchor('reports/student_report', 'Student Full Report'); ?></li>
                            <li><?php echo anchor('enquiry_meetings/meetings', 'My Meetings'); ?></li>
                            <li><?php echo anchor('my_sms', 'My Messages'); ?></li>
                            <li><?php echo anchor('feedbacks/add', 'Feedback/Comment'); ?></li>
                        </ul>
                    </div><!-- End .panel-body -->
                </div><!-- #collapse -->
            </div><!-- End .panel -->

        </div><!-- .panel-group -->
    </div><!-- End .widget -->

</aside>
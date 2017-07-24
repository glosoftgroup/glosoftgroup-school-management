<div class="col-md-12  ng-cloak" ng-controller="calcctr" ng-cloak>
    <div class="alert alert-danger hidden-print" ng-if='errors.length'>
        <ul>
            <li ng-repeat='e in errors'>{{ e}}</li>
        </ul>
    </div>
    <div class="alert alert-success hidden-print" ng-if='success'>
        <ul>
            <li>{{ messg}}</li>
        </ul>
    </div>
   <!-- Pager -->
    <div class="panel panel-white animated fadeIn">
        <div class="panel-heading">
            <h4 class="panel-title">Expense Requisitions</h4>
            <div class="heading-elements">
                <?php echo anchor('admin/expenses/create_req', '<i class="glyphicon glyphicon-plus"> </i>' . lang('web_add_t', array(':name' => 'Requisitions')), 'class="btn btn-primary"'); ?>
             <?php echo anchor('admin/expenses/requisitions', '<i class="glyphicon glyphicon-list">
                </i> List All', 'class="btn btn-primary"'); ?>
            </div>
        </div>
    
    <div class="panel-body">
        
    <div class="slip">
        <script> window.rl = <?php echo json_encode($req); ?></script>
        <div class="invoicelist-body">
            <table class="table table-hover stable">
                <thead contenteditable>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="50%">Item</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in rq.items">
                        <td><a class="control removeRow" href="" ng-click="removeItem(item)"><i class="icon-trash"></i></a>  {{$index + 1}}.</td>
                        <td><input type="text" ng-model="item.descr" placeholder="Description" class="form-control"></td>
                        <td><input type="text" ng-model="item.qty" value="1" size="4" ng-required ng-validate="integer" placeholder="qty" class="form-control"></td>
                        <td><input type="text" ng-model="item.cost" value="0.00" ng-required ng-validate="number" size="6" placeholder="cost" class="form-control cost"></td>
                        <td class="sum" align="right">{{ item.cost * item.qty| currency: '' : 2  }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-primary control newRow" href="" ng-click="addItem()" >+ New ROW</a>
        </div><!--.invoice-body-->
        <div class="panel-footer">
            <div class="text-right">
                <strong>Total:</strong>
                    <span id="total_price">{{ calc_total() | currency:'KES. ' : 2}}</span>
               
            </div>
         </div>
        <div class="clearfix"></div>
        <div class='form-group'>
            <div class='col-md-12'>
                <div class="control-div">
                    <div class="col-md-6">&nbsp;</div>
                    <div class="col-md-12 text-right">
                        <button id='submit' class='btn btn-primary' ng-click="saveReq(<?php echo $id; ?>)">Save</button>
                        <?php echo anchor('admin/expenses/requisitions', 'Cancel', 'class="btn btn-danger"'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
   
    .removeRow:hover {
        color: red; 
        display: hidden;       
    }

</style>
<style type="text/css">
   /*body.vertical-layout.vertical-menu.menu-collapsed .main-menu{
      width: 110px;
   }
    body.vertical-layout.vertical-menu.menu-collapsed .main-menu .navigation>li>a>span{
      display: block;
      text-align: center;
      padding: 10px 0px!important;
    }
body.vertical-layout.vertical-menu.menu-collapsed .content, body.vertical-layout.vertical-menu.menu-collapsed .footer, body.vertical-layout.vertical-menu.menu-collapsed .navbar .navbar-container {
    margin-left: 110px;
}
body.vertical-layout.vertical-menu.menu-collapsed .main-menu .navigation>li>a>i{
  text-align: -webkit-center;
  text-align: center;
  display: block!important; 
}*/
</style>
<?php 
  $sessRole = getSessionData();
  $permission = $sessRole['permissions'];
?>
<div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true">
   <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item">
            <a data-id="dashboard" href="<?= base_url('/dashboard')?>">
              <i class="icon-grid"></i><span class="menu-title " data-i18n="nav.dash.main">Dashboard</span>
            </a>
         </li>
         <?php if(isset($permission->customers) && $permission->customers == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/customers') ?>"><i class="ft-users"></i> <span class="menu-title"  data-i18n="nav.customers.main">Customers</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" href="<?= base_url('/customers') ?>" data-id="#gift-cards"data-i18n="nav.customers.customer"> <i class="fa fa-minus"></i> Customers</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/customers') ?>" data-i18n="nav.customers.giftcard"><i class="fa fa-minus"></i> Gift Cards</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/customers') ?>" data-i18n="nav.customers.loyaltypoints"><i class="fa fa-minus"></i>  Loyalty Points</a>
               </li>
            </ul>
         </li>
         <?php } if(isset($permission->items) && $permission->items == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/items') ?>"><i class="ft-package"></i><span class="menu-title" data-i18n="nav.items.main">Items</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.item"><i class="fa fa-minus"></i> Items List</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.department"><i class="fa fa-minus"></i> Department</a></li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.category"><i class="fa fa-minus"></i> Category</a></li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.subcategory"><i class="fa fa-minus"></i> Subcategory</a></li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.modifiers"><i class="fa fa-minus"></i> Modifiers</a>
               </li>
                <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.recipes"><i class="fa fa-minus"></i> Recipes</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.uom"><i class="fa fa-minus"></i> UOM</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.brand"><i class="fa fa-minus"></i> Brand</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/items') ?>" data-i18n="nav.items.variant"><i class="fa fa-minus"></i> Variant</a>
               </li>
            </ul>
         </li>
        <?php } if(isset($permission->purchases) && $permission->purchases == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/purchases') ?>"><i class="icon-bag"></i><span class="menu-title" data-i18n="nav.purchases.main">Purchases</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.supplier"><i class="fa fa-minus"></i> Supplier</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.purchaseorder"><i class="fa fa-minus"></i> Purchase Order</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.preview"><i class="fa fa-minus"></i> Purchase Order Review</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.received"><i class="fa fa-minus"></i> Goods Received</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.returned"><i class="fa fa-minus"></i> Goods Return</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.directreceived"><i class="fa fa-minus"></i> Direct Goods Received</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/purchases') ?>" data-i18n="nav.purchases.backorder"><i class="fa fa-minus"></i> Back Order</a>
               </li>
            </ul>
         </li>
         <?php } ?>
         <li class=" nav-item">
            <a href="<?= base_url('/inventory') ?>"><i class="ft-repeat"></i><span class="menu-title" data-i18n="nav.inventory.main">Inventory</span></a>
           <ul class="menu-content">
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.current"><i class="fa fa-minus"></i> Current Total Stock</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.movement"><i class="fa fa-minus"></i> Stock Movement</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.adjreason"><i class="fa fa-minus"></i> Stock Adjustment Reason</a>
               </li>
               <?php if(isset($permission->stock_adjustment) && $permission->stock_adjustment == 1) { ?>
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.adj"><i class="fa fa-minus"></i> Stock Adjustments</a>
               </li>
              <?php } if(isset($permission->stock_transfer) && $permission->stock_transfer == 1) { ?>
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.transfers"><i class="fa fa-minus"></i> Transfers</a>
               </li>
              <?php } ?>
               <li><a class="menu-item" href="<?= base_url('/inventory') ?>" data-i18n="nav.inventory.prod"><i class="fa fa-minus"></i> Pre Production</a>
               </li>
            </ul>
         </li>
         <?php if(isset($permission->sales) && $permission->sales == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/sales') ?>"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="nav.sales.main">Sales</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" href="<?= base_url('/sales') ?>" data-i18n="nav.sales.quotes"><i class="fa fa-minus"></i> Quotes</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/sales') ?>" data-i18n="nav.sales.invoice"><i class="fa fa-minus"></i> Invoice</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/sales') ?>" data-i18n="nav.sales.creditnote"><i class="fa fa-minus"></i> Credit Note</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/sales') ?>" data-i18n="nav.sales.payments"><i class="fa fa-minus"></i> Payments</a>
               </li>
            </ul>
         </li>
          <?php } if(isset($permission->layby) && $permission->layby == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/layby') ?>"><i class="ft-shopping-cart"></i><span class="menu-title" data-i18n="nav.layby.main">Lay-by</span></a>
            <ul class="menu-content">
                <li><a class="menu-item" href="<?= base_url('/layby') ?>" data-i18n="nav.layby.contract"><i class="fa fa-minus"></i> Contract</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/layby') ?>" data-i18n="nav.layby.payment"><i class="fa fa-minus"></i> Payment</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/layby') ?>" data-i18n="nav.layby.refund"><i class="fa fa-minus"></i> Refund</a>
               </li>
               <li><a class="menu-item" href="<?= base_url('/layby') ?>" data-i18n="nav.layby.cancel"><i class="fa fa-minus"></i> Cancel</a>
               </li>
                <li><a class="menu-item" href="<?= base_url('/layby') ?>" data-i18n="nav.layby.cancelrefund"><i class="fa fa-minus"></i> Cancellation Refund</a>
               </li>
            </ul>
         </li>
          <?php } if(isset($permission->view_all_reports) && $permission->view_all_reports == 1) { ?>
         <li class=" nav-item"><a href="#"><i class="icon-note"></i><span class="menu-title" data-i18n="nav.reports.main">Reports</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.sbyitem"><i class="fa fa-minus"></i> Sales by Item</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.sbyterminal"><i class="fa fa-minus"></i> Sales by Terminal</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.creditnote"><i class="fa fa-minus"></i> Credit Notes</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.stockonhand"><i class="fa fa-minus"></i> Stock on Hand</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.stockval"><i class="fa fa-minus"></i> Stock Valuation</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.stockprice"><i class="fa fa-minus"></i> Stock Price</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.stockwithqty"><i class="fa fa-minus"></i> Stock Take with Qty</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports') ?>" data-i18n="nav.reports.laybysales"><i class="fa fa-minus"></i> Layby Sales</a>
              </li>
            </ul>
         </li>
         <?php } ?>
         <li class=" nav-item">
            <a href="<?= base_url() ?>"><i class="icon-settings"></i><span class="menu-title" data-i18n="nav.email-application.main">Settings</span></a>
            <ul class="menu-content">
               <?php if(isset($permission->edit_general_settings) && $permission->edit_general_settings == 1) { ?>
               <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_light"><i class="fa fa-minus"></i> General</a>
               </li>
               <?php } ?>
               <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Features</a>
               </li>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Subscriptions</a>
               </li>
               <?php if(isset($permission->payment_types) && $permission->payment_types == 1) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Payments Types</a>
               </li>
               <?php } ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Receipt</a>
               </li>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Weighing Scale</a>
               </li>
               <?php if(isset($permission->tax) && $permission->tax == 1) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Taxes</a>
               </li>
               <?php } ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Aggregator</a>
               </li>
               <?php if(isset($permission->store_terminal) && $permission->store_terminal == 1) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Stores</a>
                </li>
                <?php } if(isset($permission->location) && $permission->location == 1) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Location</a>
                </li>
                <?php } if(isset($permission->store_terminal) && $permission->store_terminal == 1) { ?>
               <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Terminals</a>
               </li>
               <?php } if(isset($permission->employees) && $permission->employees == 1) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Employees</a>
               </li>
               <?php } if(isset($sessRole['is_super_user']) && $sessRole['is_super_user']) { ?>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Roles</a>
               </li>
                <li><a class="menu-item" href="<?= base_url("settings")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Currency</a>
               </li>
               <?php } ?>
            </ul>
         </li>
      </ul>
   </div>
</div>
<div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true">
   <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item">
            <a data-id="dashboard" href="<?= base_url('/dashboard')?>">
              <i class="icon-grid"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span>
            </a>
         </li>
         <?php if(isset($permission->customers) && $permission->customers == 1) { ?>
         <li class="nav-item">
            <a href="<?= base_url('/customers') ?>"><i class="ft-users"></i> <span class="menu-title" data-i18n="nav.customers.main">Customers</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" data-id="#customer-list" href="<?= base_url('/customers#customer-list') ?>" data-i18n="nav.customers.customer"> <i class="fa fa-minus"></i> Customers</a>
               </li>
               <li><a class="menu-item" data-id="#gift-cards" href="<?= base_url('/customers#gift-cards') ?>" data-i18n="nav.customers.giftcard"><i class="fa fa-minus"></i> Gift Cards</a>
               </li>
               <li><a class="menu-item" data-id="#loyalty-points" href="<?= base_url('/customers#loyalty-points') ?>" data-i18n="nav.customers.loyaltypoints"><i class="fa fa-minus"></i>  Loyalty Points</a>
               </li>
            </ul>
         </li>
         <?php } if(isset($permission->items) && $permission->items == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/items') ?>"><i class="ft-package"></i><span class="menu-title" data-i18n="nav.items.main">Items</span></a>
            <ul class="menu-content">
               <li><a class="menu-item"  style="top:120px!important";data-id="#items-list" href="<?= base_url('/items#items-list') ?>" data-i18n="nav.items.item"><i class="fa fa-minus"></i> Items List</a>
               </li>
               <li><a class="menu-item" data-id="#department" href="<?= base_url('/items#department') ?>" data-i18n="nav.items.department"><i class="fa fa-minus"></i> Department</a></li>
               <li><a class="menu-item" data-id="#category" href="<?= base_url('/items#category') ?>" data-i18n="nav.items.category"><i class="fa fa-minus"></i> Category</a></li>
               <li><a class="menu-item" data-id="#subcategory" href="<?= base_url('/items#subcategory') ?>" data-i18n="nav.items.subcategory"><i class="fa fa-minus"></i> Subcategory</a></li>
               <li><a class="menu-item" data-id="#modifiers" href="<?= base_url('/items#modifiers') ?>" data-i18n="nav.items.modifiers"><i class="fa fa-minus"></i> Modifiers</a>
               </li>
                <li><a class="menu-item" data-id="#recipes" href="<?= base_url('/items#recipes') ?>" data-i18n="nav.items.recipes"><i class="fa fa-minus"></i> Recipes</a>
               </li>
               <li><a class="menu-item" data-id="#uom" href="<?= base_url('/items#uom') ?>" data-i18n="nav.items.uom"><i class="fa fa-minus"></i> UOM</a>
               </li>
               <li><a class="menu-item" data-id="#brand" href="<?= base_url('/items#brand') ?>" data-i18n="nav.items.brand"><i class="fa fa-minus"></i> Brand</a>
               </li>
               <li><a class="menu-item" data-id="#variants" href="<?= base_url('/items#variants') ?>" data-i18n="nav.items.variant"><i class="fa fa-minus"></i> Variant</a>
               </li>
            </ul>
         </li>
         <?php } if(isset($permission->purchases) && $permission->purchases == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/purchases') ?>"><i class="icon-bag"></i><span class="menu-title" data-i18n="nav.purchases.main">Purchases</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" data-id="#supplier" href="<?= base_url('/purchases#supplier') ?>" data-i18n="nav.purchases.supplier"><i class="fa fa-minus"></i> Supplier</a>
               </li>
               <li><a class="menu-item" data-id="purchase-order"  href="<?= base_url('/purchases#purchase-order') ?>" data-i18n="nav.purchases.purchaseorder"><i class="fa fa-minus"></i> Purchase Order</a>
               </li>
               <li><a class="menu-item" data-id="purchase-order-review" href="<?= base_url('/purchases#purchase-order-review') ?>" data-i18n="nav.purchases.preview"><i class="fa fa-minus"></i> Purchase Order Review</a>
               </li>
               <li><a class="menu-item" data-id="#goods-received" href="<?= base_url('/purchases#goods-received') ?>" data-i18n="nav.purchases.received"><i class="fa fa-minus"></i> Goods Received</a>
               </li>
               <li><a class="menu-item" data-id="goods-returned" href="<?= base_url('/purchases#goods-returned') ?>" data-i18n="nav.purchases.returned"><i class="fa fa-minus"></i> Goods Return</a>
               </li>
               <li><a class="menu-item" data-id="#direct-goods-received" href="<?= base_url('/purchases#direct-goods-received') ?>" data-i18n="nav.purchases.directreceived"><i class="fa fa-minus"></i> Direct Goods Received</a>
               </li>
               <li><a class="menu-item" data-id="back-order" href="<?= base_url('/purchases#back-order') ?>" data-i18n="nav.purchases.backorder"><i class="fa fa-minus"></i> Back Order</a>
               </li>
            </ul>
         </li>
         <?php } ?>
         <li class=" nav-item">
            <a href="<?= base_url('/inventory') ?>"><i class="ft-repeat"></i><span class="menu-title" data-i18n="nav.inventory.main">Inventory</span></a>
           <ul class="menu-content">
               <li><a class="menu-item" data-id="#current-stock" href="<?= base_url('/inventory#current-stock') ?>" data-i18n="nav.inventory.current"><i class="fa fa-minus"></i> Current Total Stock</a>
               </li>
               <li><a class="menu-item" data-id="#stock" href="<?= base_url('/inventory#stock') ?>" data-i18n="nav.inventory.movement"><i class="fa fa-minus"></i> Stock Movement</a>
               </li>
               <li><a class="menu-item" data-id="#adjustment-reason" href="<?= base_url('/inventory#adjustment-reason') ?>" data-i18n="nav.inventory.adjreason"><i class="fa fa-minus"></i> Stock Adjustment Reason</a>
               </li>
               <?php if(isset($permission->stock_adjustment) && $permission->stock_adjustment == 1) { ?>
               <li><a class="menu-item" data-id="#adjustment" href="<?= base_url('/inventory#adjustment') ?>" data-i18n="nav.inventory.adj"><i class="fa fa-minus"></i> Stock Adjustments</a>
               </li>
               <?php } if(isset($permission->stock_transfer) && $permission->stock_transfer == 1) { ?>
               <li><a class="menu-item" data-id="#transfer" href="<?= base_url('/inventory#transfer') ?>" data-i18n="nav.inventory.transfers"><i class="fa fa-minus"></i> Transfers</a>
               </li>
               <?php } ?>
               <li><a class="menu-item" data-id="#production" href="<?= base_url('/inventory#production') ?>" data-i18n="nav.inventory.prod"><i class="fa fa-minus"></i> Pre Production</a>
               </li>
            </ul>
         </li>
         <?php if(isset($permission->sales) && $permission->sales == 1) { ?>
         <li class=" nav-item">
            <a href="<?= base_url('/sales') ?>"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="nav.sales.main">Sales</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" data-id="#quotes" href="<?= base_url('/sales#quotes') ?>" data-i18n="nav.sales.quotes"><i class="fa fa-minus"></i> Quotes</a>
               </li>
               <li><a class="menu-item" data-id="#invoice-list" href="<?= base_url('/sales#invoice-list') ?>" data-i18n="nav.sales.invoice"><i class="fa fa-minus"></i> Invoice</a>
               </li>
               <li><a class="menu-item" data-id="#credit-debit-note" href="<?= base_url('/sales#credit-debit-note') ?>" data-i18n="nav.sales.creditnote"><i class="fa fa-minus"></i> Credit Note</a>
               </li>
               <li><a class="menu-item" data-id="#payments" href="<?= base_url('/sales#payments') ?>" data-i18n="nav.sales.payments"><i class="fa fa-minus"></i> Payments</a>
               </li>
            </ul>
         </li>
         <?php } if(isset($permission->layby) && $permission->layby == 1) { ?>
         <li class="nav-item">
            <a href="<?= base_url('/layby') ?>"><i class="ft-shopping-cart"></i><span class="menu-title" data-i18n="nav.layby.main">Lay-by</span></a>
            <ul class="menu-content">
                <li><a class="menu-item" data-id="#layby-contract" href="<?= base_url('/layby#layby-contract') ?>" data-i18n="nav.layby.contract"><i class="fa fa-minus"></i> Contract</a>
               </li>
               <li><a class="menu-item" data-id="#layby-payment" href="<?= base_url('/layby#layby-payment') ?>" data-i18n="nav.layby.payment"><i class="fa fa-minus"></i> Payment</a>
               </li>
               <li><a class="menu-item" data-id="#layby-refund" href="<?= base_url('/layby#layby-refund') ?>" data-i18n="nav.layby.refund"><i class="fa fa-minus"></i> Refund</a>
               </li>
               <li><a class="menu-item" data-id="#layby-cancel" href="<?= base_url('/layby#layby-cancel') ?>" data-i18n="nav.layby.cancel"><i class="fa fa-minus"></i> Cancel</a>
               </li>
                <li><a class="menu-item" data-id="#layby-cancellation-refund" href="<?= base_url('/layby#layby-cancellation-refund') ?>" data-i18n="nav.layby.cancelrefund"><i class="fa fa-minus"></i> Cancellation Refund</a>
               </li>
               <li><a class="menu-item" data-id="#layby-completed" href="<?= base_url('/layby#layby-completed') ?>" data-i18n="nav.layby.completed"><i class="fa fa-minus"></i> Completed Layby</a>
               </li>
            </ul>
         </li>
         <?php } if(isset($permission->view_all_reports) && $permission->view_all_reports == 1) { ?>
         <li class=" nav-item">
          <a href="<?=base_url('reports')?>"><i class="icon-note"></i><span class="menu-title" data-i18n="nav.reports.main">Reports</span></a>
          <ul class="menu-content">
              <li><a class="menu-item" href="<?= base_url('/reports/sales-by-item') ?>" data-i18n="nav.reports.sbyitem"><i class="fa fa-minus"></i> Sales by Item</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/sales-by-terminal') ?>" data-i18n="nav.reports.sbyterminal"><i class="fa fa-minus"></i> Sales by Terminal</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/credit-notes') ?>" data-i18n="nav.reports.creditnote"><i class="fa fa-minus"></i> Credit Notes</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/stock-on-hand') ?>" data-i18n="nav.reports.stockonhand"><i class="fa fa-minus"></i> Stock on Hand</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/stock-valuation') ?>" data-i18n="nav.reports.stockval"><i class="fa fa-minus"></i> Stock Valuation</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/stock-price') ?>" data-i18n="nav.reports.stockprice"><i class="fa fa-minus"></i> Stock Price</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/stock-take-with-qty') ?>" data-i18n="nav.reports.stockwithqty"><i class="fa fa-minus"></i> Stock Take with Qty</a>
              </li>
              <li><a class="menu-item" href="<?= base_url('/reports/layby-sales') ?>" data-i18n="nav.reports.laybysales"><i class="fa fa-minus"></i> Layby Sales</a>
              </li>
            </ul>
         </li>
         <?php } ?>
         <li class="nav-item">
            <a data-id="settings" href="<?= base_url('settings')?>"><i class="icon-settings"></i><span class="menu-title"  data-i18n="nav.settings.main">Settings</span></a>
            <ul class="menu-content">
               <?php if(isset($permission->edit_general_settings) && $permission->edit_general_settings == 1) { ?>
               <li><a class="menu-item" data-id="#general" href="<?= base_url("settings#general")?>" data-i18n="nav.settings.general"><i class="fa fa-minus"></i> General</a>
               </li>
               <?php } ?>
               <li><a class="menu-item" data-id="#features" href="<?= base_url("settings#features")?>" data-i18n="nav.settings.features"><i class="fa fa-minus"></i> Features</a>
               </li>
                <li><a class="menu-item" data-id="#subscriptions" href="<?= base_url("settings#subscriptions")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Subscriptions</a>
               </li>
               <?php if(isset($permission->payment_types) && $permission->payment_types == 1) { ?>
                <li><a class="menu-item" data-id="#payment" href="<?= base_url("settings#payment")?>" data-i18n="nav.settings.paymenttypes"><i class="fa fa-minus"></i> Payments Types</a>
               </li>
               <?php } ?>
                <li><a class="menu-item" data-id="#receipt" href="<?= base_url("settings#receipt")?>" data-i18n="nav.settings.receipt"><i class="fa fa-minus"></i> Receipt</a>
               </li>
                <li><a class="menu-item" data-id="#weighing_scale" href="<?= base_url("settings#weighing_scale")?>" data-i18n="nav.footers.footer_dark"><i class="fa fa-minus"></i> Weighing Scale</a>
               </li>
               <?php if(isset($permission->tax) && $permission->tax == 1) { ?>
                <li><a class="menu-item" data-id="#tax" href="<?= base_url("settings#tax")?>" data-i18n="nav.settings.tax"><i class="fa fa-minus"></i> Taxes</a>
               </li>
               <?php } ?>
                <li><a class="menu-item" data-id="#aggregator" href="<?= base_url("settings#aggregator")?>" data-i18n="nav.settings.aggregator"><i class="fa fa-minus"></i> Aggregator</a>
               </li>
               <?php if(isset($permission->store_terminal) && $permission->store_terminal == 1) { ?>
                <li><a class="menu-item" data-id="#stores" href="<?= base_url("settings#stores")?>" data-i18n="nav.settings.stores"><i class="fa fa-minus"></i> Stores</a>
               </li>
                <?php } if(isset($permission->location) && $permission->location == 1) { ?>
                <li><a class="menu-item" data-id="#location" href="<?= base_url("settings#location")?>" data-i18n="nav.settings.location"><i class="fa fa-minus"></i> Location</a>
               </li>
               <?php } if(isset($permission->store_terminal) && $permission->store_terminal == 1) { ?>
               <li><a class="menu-item" data-id="#terminals" href="<?= base_url("settings#terminals")?>" data-i18n="nav.settings.terminals"><i class="fa fa-minus"></i> Terminals</a>
               </li>
               <?php } if(isset($permission->employees) && $permission->employees == 1) { ?>
                <li><a class="menu-item" data-id="#employees" href="<?= base_url("settings#employees")?>" data-i18n="nav.settings.employees"><i class="fa fa-minus"></i> Employees</a>
               </li>
               <?php } if(isset($sessRole['is_super_user']) && $sessRole['is_super_user'] == "1") { ?>
                <li><a class="menu-item" data-id="#roles" href="<?= base_url("settings#roles")?>" data-i18n="nav.settings.roles"><i class="fa fa-minus"></i> Roles</a>
               </li>
                <li><a class="menu-item" data-id="#currency" href="<?= base_url("settings#currency")?>" data-i18n="nav.settings.currency"><i class="fa fa-minus"></i> Currency</a>
               </li>
               <?php } ?>
            </ul>
         </li>
      </ul>
   </div>
</div>
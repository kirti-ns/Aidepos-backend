<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/','AuthController::Login');

$routes->get('login','AuthController::Login');
$routes->post('post-login','AuthController::PostLogin');
$routes->get('logout','AuthController::Logout');
$routes->get('store','AuthController::askStore');
$routes->post('postEmpStore','AuthController::postEmpStore');
$routes->get('/forgot_password','AuthController::ForgotPassword');
$routes->post('/post-forgot_password','AuthController::PostForgotPassword');
$routes->get('/reset_password/(:any)','AuthController::ResetPassword/$1');
$routes->post('/post-reset_password','AuthController::PostResetPassword');
$routes->post('/post-change_password','AuthController::ChangePassword');
$routes->get('/otp','AuthController::OTP');

$routes->get('dashboard','DashboardController::index');
$routes->get('store_based_sales','DashboardController::StoreBasedSalesData');
$routes->get('daily_terminal_sales','DashboardController::DailyTerminalBasedSalesData');

$routes->get('/customers','CustomersController::index');
$routes->get('/customers/add_customer','CustomersController::Add_Customer');
$routes->get('/customers/edit_customer/(:num)','CustomersController::Edit_customer/$1');
$routes->get('/customers/view_customer/(:num)','CustomersController::View_customer/$1');
$routes->post('/customers/getCustomers','CustomersController::getCustomers');
$routes->post('/customers/getGiftCards','CustomersController::getGiftCards');
$routes->post('/customers/getViewCustomers','CustomersController::getViewCustomers');
$routes->post('/customers/getCustomerById','CustomersController::getCustomerById');
$routes->get('/customers/add_gift_card_master','CustomersController::Add_GiftCard_Master');
$routes->get('/customers/add_gift_card','CustomersController::Add_GiftCard');
$routes->get('/customers/edit_gift_card/(:num)','CustomersController::Edit_gift_card/$1');
$routes->get('/customers/add_loyalty_points','CustomersController::Add_LoyaltyPoints');
$routes->post('post_data','CustomersController::Post_Customers_Data');
$routes->post('/customers/importCustomers','CustomersController::importCustomers');

$routes->get('/items','ItemsController::index');
$routes->post('/items/itemExportOptions','ItemsController::itemExportOptions');
$routes->post('/items/synchronizeStorePrices','ItemsController::synchronizeStorePrices');
$routes->post('/items/copyLocationItems','ItemsController::copyLocationItems');
$routes->post('/items/itemDeleteOptions','ItemsController::itemDeleteOptions');
$routes->post('/items/getItem','ItemsController::getItem');
$routes->post('/items/getCategory','ItemsController::getCategory');
$routes->post('/items/getSubcategory','ItemsController::getSubcategory');
$routes->post('/items/getDepartment','ItemsController::getDepartment');
$routes->post('/items/getCategoryDataById','ItemsController::getCategoryDataById');
$routes->post('/items/getSubcategoryDataById','ItemsController::getSubcategoryDataById');
$routes->post('/items/getModifiers','ItemsController::getModifiers');
$routes->post('/items/getUom','ItemsController::getUom');
$routes->post('/items/getBrand','ItemsController::getBrand');
$routes->post('/items/getVariants','ItemsController::getVariants');
$routes->post('/items/getLocation','ItemsController::getLocation');
$routes->post('/items/getExpiryItems','ItemsController::getExpiryItems');
$routes->post('/items/getItemDataById','ItemsController::getItemDataById');
$routes->post('getItemsByCategoryId','ItemsController::getItemsByCategoryId');
$routes->get('searchItems','ItemsController::searchItems');
$routes->get('items/add_uom','ItemsController::AddUom');
$routes->get('items/edit_uom/(:num)','ItemsController::EditUom/$1');
$routes->get('items/add_category','ItemsController::AddCategory');
$routes->get('items/edit_category/(:num)','ItemsController::EditCategory/$1');
$routes->get('items/add_subcategory','ItemsController::AddSubcategory');
$routes->get('items/edit_subcategory/(:num)','ItemsController::EditSubcategory/$1');
$routes->get('items/add_department','ItemsController::AddDepartment');
$routes->get('items/edit_department/(:num)','ItemsController::EditDepartment/$1');
$routes->get('items/add_brand','ItemsController::AddBrand');
$routes->get('items/edit_brand/(:num)','ItemsController::EditBrand/$1');
$routes->get('items/add_modifier','ItemsController::AddModifier');
$routes->get('items/edit_modifier/(:num)','ItemsController::EditModifier/$1');
$routes->post('getSubcategory','CommonController::getSubcategory');
$routes->post('getTerminal','CommonController::getTerminal');
$routes->post('get_location_by_store','CommonController::getLocationByStore');
$routes->get('items/add_item','ItemsController::AddItem');
$routes->get('items/edit_item/(:num)','ItemsController::EditItem/$1');
$routes->post('post_items_data','ItemsController::Post_Data');
$routes->get('get_variant','ItemsController::getVariant');
$routes->get('get_composite','ItemsController::getComposite');
$routes->post('/items/getRecipe','ItemsController::getRecipe');
$routes->post('/items/getRecipeItemsDataById','ItemsController::getRecipeItemsDataById');
$routes->get('items/add_recipe','ItemsController::AddRecipe');
$routes->get('items/edit_recipe/(:num)','ItemsController::EditRecipe/$1');

$routes->get('/purchases','PurchasesController::index');
$routes->post('/purchases/getSupplier', 'PurchasesController::getSupplier');
$routes->post('/purchases/getPurchaseOrder', 'PurchasesController::getPurchaseOrder');
$routes->post('/purchases/getPurchaseOrderReview', 'PurchasesController::getPurchaseOrderReview');
$routes->post('/purchases/getGoodsReceived', 'PurchasesController::getGoodsReceived');
$routes->post('/purchases/getGoodsReturned', 'PurchasesController::getGoodsReturned');
$routes->post('/purchases/getDirectGoodsReceived', 'PurchasesController::getDirectGoodsReceived');
$routes->post('/purchases/getBackOrder', 'PurchasesController::getBackOrder');
$routes->post('getPurchase','PurchasesController::getPurchase');

$routes->get('/purchases/add_supplier','PurchasesController::Add_Supplier');
$routes->get('/purchases/edit_supplier/(:num)','PurchasesController::Edit_Supplier/$1');
$routes->get('/purchases/add_purchase_order','PurchasesController::Add_Purchase_Order');
$routes->get('/purchases/edit_purchase_order/(:num)','PurchasesController::Edit_Purchase_Order/$1');
$routes->get('/purchases/view_purchase_order/(:num)','PurchasesController::ViewPurchaseOrder/$1');

$routes->get('/purchases/add_goods_received/(:num)','PurchasesController::Add_Goods_Rec/$1');
$routes->get('/purchases/add_goods_received','PurchasesController::Add_Goods_Received');
$routes->get('/purchases/edit_goods_received/(:num)','PurchasesController::Edit_Goods_Received/$1');
$routes->get('/purchases/view_goods_received/(:num)','PurchasesController::View_Goods_Received/$1');
$routes->get('/purchases/direct_goods_received','PurchasesController::Add_Direct_Goods_Received');
$routes->get('/purchases/view_direct_goods_received/(:num)','PurchasesController::View_Direct_Goods_Received/$1');
$routes->get('/purchases/add_goods_returned','PurchasesController::Add_Goods_Returned');
$routes->get('/purchases/add_goods_returned/(:num)','PurchasesController::Add_Goods_Ret/$1');
$routes->post('/purchases/get-purchase-data-by-order-id','PurchasesController::GetPurchaseDataByOrderId');
$routes->get('/purchases/edit_goods_returned/(:num)','PurchasesController::Edit_Goods_Returned/$1');
$routes->get('/purchases/add_back_order','PurchasesController::Add_Back_Order');
$routes->get('/purchases/edit_back_order/(:num)','PurchasesController::Edit_Back_Order/$1');

$routes->post('post_data_purchase','PurchasesController::Post_Data_Purchase');
$routes->post('getItemDetail','PurchasesController::get_Item_Detail');

$routes->get('/inventory','InventoryController::index');
$routes->post('/inventory/getCurrentStock','InventoryController::getCurrentStock');
$routes->get('/inventory/view_stock/(:num)','InventoryController::ViewCurrentStock/$1');

$routes->post('/inventory/getTransferStock','InventoryController::getTransferStock');
$routes->post('/inventory/getStockAdjustmentReason','InventoryController::getStockAdjustmentReason');
$routes->post('/inventory/getProductionStock','InventoryController::getProductionStock');
$routes->post('/inventory/getStockAdjustment','InventoryController::getStockAdjustment');
$routes->post('/inventory/getStockMovement','InventoryController::getStockMovement');
$routes->post('/inventory/getInventoryDetails','InventoryController::getInventoryDetails');
$routes->post('/inventory/submitInventoryDetails','InventoryController::submitInventoryDetails');
$routes->get('/inventory/add_stock_adjustment','InventoryController::AddStockAdjustment');
$routes->get('/inventory/edit_stock_adjustment/(:num)','InventoryController::EditStockAdjustment/$1');
$routes->get('/inventory/add_production','InventoryController::AddProduction');
$routes->get('/inventory/add_transfer','InventoryController::AddTransfer');
$routes->get('/inventory/edit_transfer/(:num)','InventoryController::EditTransfer/$1');
$routes->post('post_data_inventory','InventoryController::Post_Data_Inventory');
$routes->post('/inventory/getAdjustmentDataById','InventoryController::getAdjustmentDataById');
$routes->get('/inventory/transfer_view/(:num)','InventoryController::ViewTransfer/$1');
$routes->post('/getInventoryDetailsByLocation','InventoryController::getInventoryDetailsByLocation');

$routes->get('/sales','SalesController::index');
$routes->post('/sales/getStockSell','SalesController::getStockSell');
$routes->post('/sales/getQuotes','SalesController::getQuotes');
$routes->post('/sales/getCreditNotes','SalesController::getCreditNotes');
$routes->get('/sales/add_invoice','SalesController::AddInvoice');
$routes->get('/sales/edit_invoice/(:num)','SalesController::EditInvoice/$1');
$routes->post('/sales/view_invoice','SalesController::ViewInvoice');
$routes->post('/sales/view_quote','SalesController::ViewQuote');
$routes->post('/sales/view_credit_note','SalesController::ViewCreditNote');
$routes->get('/sales/printInvoicePDF/(:num)','SalesController::printInvoicePDF/$1');
$routes->get('/sales/add_quote','SalesController::AddQuote');
$routes->get('/sales/edit_quote/(:num)','SalesController::EditQuote/$1');
$routes->get('/sales/convert_quote_to_invoice/(:num)','SalesController::convertToInvoice/$1');
$routes->post('/sales/record_new_payment','SalesController::recordNewPayment');
$routes->post('/sales/get_customer_credits','SalesController::getCustomerCredits');
$routes->post('sales/send_invoice_mail','SalesController::sendInvoiceMail');
$routes->get('/sales/add_credit_note/(:num)','SalesController::AddCreditNote/$1');
$routes->get('/sales/add_debit_note/(:num)','SalesController::AddDebitNote/$1');
$routes->get('/sales/add_payment_invoice','SalesController::AddPaymentInvoice');
$routes->get('/sales/edit_payment_invoice/(:num)','SalesController::EditPaymentInvoice/$1');
$routes->get('/sales/view_payment/(:num)','SalesController::ViewPayment/$1');
$routes->post('post_data_sales','SalesController::Post_Data_Sales');
$routes->post('post_data_credits','SalesController::Post_Data_credits');
$routes->post('post_data_refund','SalesController::Post_Data_refund');

$routes->get('/layby','LayByController::index');
$routes->post('/layby/getLaybyContract','LayByController::getLaybyContract');
$routes->post('/layby/getLaybyContractPayment','LayByController::getLaybyContractPayment');
$routes->post('/layby/getLaybyContractTxn','LayByController::getLaybyContractTxn');
$routes->post('/layby/getLaybyPayment','LayByController::getLaybyPayment');
$routes->post('/layby/getCompletedLaybyContract','LayByController::getCompletedLaybyContract');
$routes->get('/layby/add_contract','LayByController::addContract');
$routes->get('/layby/edit_contract/(:num)','LayByController::editContract/$1');
$routes->post('/layby/getContractDepositData','LayByController::getContractDepositData');
$routes->post('post_layby_data','LayByController::post_Layby_Data');

$routes->get('/settings','SettingsController::index');
$routes->post('/settings/clear-stock-transaction','SettingsController::clearStockandTransaction');  
$routes->get('/settings/add_role','RoleController::Add_role');
$routes->post('post_role','RoleController::Post_role');
$routes->post('delete_data','CommonController::Delete_data');
$routes->post('change_password','CommonController::change_password');
$routes->post('check_pin','CommonController::checkPin');

$routes->post('/get_table_row_data','CommonController::getDataByTableName');
$routes->post('/update_status','CommonController::updateStatus');
$routes->post('/update_field','CommonController::updateField');
$routes->post('/update_transfer_status','CommonController::updateTransferStatus');

$routes->get('/settings/add_store','StoreController::Add_store');
$routes->get('/settings/edit_store/(:num)','StoreController::Edit_store/$1');
$routes->post('post-store-data','StoreController::PostStoreData');
$routes->get('/settings/edit_role/(:num)','RoleController::Edit_role/$1');

$routes->get('/settings/add_currency','SettingsController::Add_currency');
$routes->get('/settings/edit_currency/(:num)','SettingsController::Edit_currency/$1');

$routes->get('/settings/add_terminal','SettingsController::Add_Terminal');
$routes->get('/settings/edit_terminal/(:num)','SettingsController::Edit_terminal/$1');
$routes->get('/settings/add_tax','SettingsController::Add_Tax');
$routes->get('/settings/edit_tax/(:num)','SettingsController::Edit_tax/$1');
$routes->get('/settings/add_payment_type','SettingsController::Add_Payment');
$routes->get('/settings/edit_payment/(:num)','SettingsController::Edit_payment/$1');

$routes->get('/settings/add_employee','EmployeeController::Add_employee');
$routes->get('/settings/edit_employee/(:num)','EmployeeController::Edit_employee/$1');
$routes->post('post-employee-data','EmployeeController::PostEmployeeData');
$routes->get('/my-profile','EmployeeController::Profile'); 
$routes->get('/edit_profile/(:num)','EmployeeController::Edit_Profile/$1');
$routes->post('post-profile-data','EmployeeController::PostProfileData');

$routes->get('/settings/add_weighing_scale','SettingsController::Add_WeighingScale');
$routes->get('/settings/add_general','SettingsController::Add_General');
$routes->post('/settings/getGeneralSettings','SettingsController::getGeneralSettings');
$routes->post('/settings/getPaymenttype','SettingsController::getPaymenttype');
$routes->post('/settings/getTax','SettingsController::getTax');
$routes->post('/settings/getStore','SettingsController::getStore');
$routes->post('/settings/getTerminal','SettingsController::getTerminal');
$routes->post('/settings/getEmployee','EmployeeController::getEmployee');
$routes->post('/settings/getRole','RoleController::getRole');
$routes->post('/settings/getCurrency','SettingsController::getCurrency');
$routes->post('/settings/getReceipt','SettingsController::getReceipt');
$routes->post('/settings/add_receipt','SettingsController::AddReceipt');

$routes->get('/faq','CommonController::faq');
$routes->get('/send_mail','CommonController::send_mail');
$routes->get('/help_documents','CommonController::help_documents');

$routes->post('post_data_settings','SettingsController::Post_Data_Settings');
$routes->post('getGraphSale','SalesController::getGraphSale');
$routes->post('getGraphTopItem','SalesController::getGraphTopItem');

$routes->get('/reports','ReportsController::reports/sales-by-item');
$routes->get('/reports/(:any)','ReportsController::reports/$1');
$routes->get('/print-reports','ReportsController::printReport');
$routes->post('/reports/sales-by-item','ReportsController::salesByItem');
$routes->post('/reports/sales-by-terminal','ReportsController::salesByTerminal');
$routes->post('/reports/credit-notes','ReportsController::creditNotes');
$routes->post('/reports/stock-on-hand','ReportsController::stockOnHand');
$routes->post('/reports/stock-valuation','ReportsController::stockValuation');
$routes->post('/reports/stock-price','ReportsController::stockPrice');
$routes->post('/reports/stock-take-with-qty','ReportsController::stockTakeWithQty');
$routes->post('/reports/layby-sales','ReportsController::laybySales');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

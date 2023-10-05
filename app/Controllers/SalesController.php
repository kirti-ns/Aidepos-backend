<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SellordersModel;
use App\Models\CustomersModel;
use App\Models\CurrencyModel;
use App\Models\GeneralModel;
use App\Models\SalesPaymentModel;
use App\Models\ItemModel;
use App\Models\CommonModel;
use App\Models\EmployeeModel;
use App\Models\StoreModel;
use App\Models\StoreItemsModel;
use App\Models\CurrentInventory;
use App\Models\CurrentInventoryDetails;
use App\Models\SellItemsModel;
use App\Models\TerminalsModel;
use App\Models\PaymentMasterModel;
use App\Models\PaymentModel;
use App\Models\CreditsModel;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\CreditNote;

class SalesController extends BaseController
{
    public function index()
    {
        $data = [];
        $data['title'] = 'Sales';
        $sessData = getSessionData();

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->GetInvoiceData();

        $paymentinvoiceModel = new SalesPaymentModel();
        $data['payment_invoice'] = $paymentinvoiceModel->select('sales_payment.*,customers.registerd_name,payment_type')->join('customers','sales_payment.customer_id = customers.id','left')->join('payment_type_master','sales_payment.payment_id = payment_type_master.id','left')->orderBy('payment_date','DESC')->findAll();
        
        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->findAll();

        $data['currency_symbol'] = '';
        if($sessData['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$sessData['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['currency_symbol'] = $generalData['currency_symbol'];
            }
        }
        
        $storeModel = new StoreModel();
        if($sessData['role_name'] == 'Staff') {
            $storeModel->where('id',$sessData['store_id']);
        } else if($sessData['role_name'] == 'Owner') {
            $storeModel->where('pos_id',$sessData['pos_id']);
        }
        $data['stores'] = $storeModel->findAll();
        return $this->template->render('pages/sales/sales', $data); 
    }

    public function AddInvoice()
    {
        $data = [];
        $data['title'] = 'Add Invoice'; 
        $data['main_menu'] = 'Sales';
        $data['main_menu_url'] = base_url('sales'); 

        $sessData = getSessionData();

        $sellOrder = new SellordersModel();
        $data['invoice'] = $sellOrder->GetInvoiceData();

        $customerModel = new CustomersModel();
        $customerModel->where('status',1);
        $data['customer'] = $customerModel->findAll();

        $currencyModel = new CurrencyModel();
        $storeModel = new StoreModel();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];

        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }

        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $data['s_name'] = $storeModel->select('store_name')->where('id',$sessData['store_id'])->first();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        $paymentmasterModel = new PaymentMasterModel();
        $data['payment_mode'] = $paymentmasterModel->findAll();
        
        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);
        
        return $this->template->render('pages/sales/invoice_add', $data);
    }

    public function EditInvoice($id)
    {
        $data = [];
        $data['title'] = 'Edit Invoice'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales');
        $sessData = getSessionData(); 

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->select('sell_orders.*, c.currency_code')->join('currencies c','sell_orders.currency_id = c.id','left')->where("sell_orders.id",$id)->first();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];
        $data['status'] = $this->getInvoiceStatus($data['invoice']['id'],$data['invoice']['due_date'],$data['invoice']['total_amount'],$data['invoice']['balance_due'],$data['invoice']['is_sent']);
        
        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $sellerItemsModel = new SellItemsModel;
        $data['sell_items'] = $sellerItemsModel->where("s_o_id",$id)->findAll();
        
        $customerModel = new CustomersModel();
        $customerModel->where('status',1);
        $data['customer'] = $customerModel->findAll();
        
        $paymentmasterModel = new PaymentMasterModel();
        $data['payment_mode'] = $paymentmasterModel->findAll();
        
        $currencyModel = new CurrencyModel();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/sales/invoice_add', $data);
    }

    public function ViewInvoice()
    {
        $data = [];
        /*$data['title'] = 'View Invoice'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales');*/
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $invoiceModel = new SellordersModel();
        $data['module'] = $invoiceModel->select('sell_orders.*,customers.registerd_name,customers.address,payment_type as p_mode')->join('customers','sell_orders.customer_id = customers.id','left')->join('payment_type_master','sell_orders.payment_mode = payment_type_master.id','left')->where("sell_orders.id",$post['id'])->first();

        $sellerItemsModel = new SellItemsModel();
        $data['items'] = $sellerItemsModel->select('sell_items.*, items.item_name')->join('items','items.id = sell_items.item_id')->where("s_o_id",$post['id'])->findAll();

        $paymentModel = new SalesPaymentModel(); 
        $data['payments'] = $paymentModel->select('sales_payment.*, payment_type as p_mode')->join('payment_type_master','payment_type_master.id = sales_payment.payment_id')->where('invoice_id',$post['id'])->findAll();

        $creditsModel = new CreditsModel();
        $data['credits'] = $creditsModel->where('invoice_id',$post['id'])->findAll();

        $data['is_appl_credits'] = false;
        if(count($data['credits']) > 0) {
            $data['is_appl_credits'] = true;
            $cr_appl = array_column($data['credits'], 'credit_applied');
            $data['cr_applied'] = number_format(array_sum($cr_appl),2);
        }

        $creditNote = new CreditNote();
        $getCredits = $creditNote->where('customer_id',$data['module']['customer_id'])->where('credits_available >',0)->selectSum('credits_available','credits_available')->first();
        $data['credits_available'] = $getCredits['credits_available'];
        
        $data['is_payment_flg'] = true;
        $data['payment_made'] = 0;
        //0 - Draft; 1- Partially Paid; 2 - Paid
        $data['is_paid_status'] = "0";
        if(count($data['payments']) > 0) {
            $amt_received = array_column($data['payments'], 'amount_received');
            $total = array_sum($amt_received);
            $data['is_paid_status'] = "1";
            $data['payment_made'] = $total;
            if($data['is_appl_credits']) {
                $total = $total + $data['cr_applied'];
            }
            if($total == $data['module']['total_amount']) {
                $data['is_payment_flg'] = false;
                $data['is_paid_status'] = "2";
            }
        } else if($data['is_appl_credits']) {
            $total = $data['cr_applied'];
            if($total == $data['module']['total_amount']) {
                $data['is_payment_flg'] = false;
                $data['is_paid_status'] = "2";
            }
        }

        return json_encode([
            "status" => "true",
            "message" => "Invoice details get successfully",
            "data" => $data
        ]);
    }

    public function ViewQuote()
    {
        $data = [];
        /*$data['title'] = 'View Invoice'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales');*/
        $post = $this->request->getVar();
        $sessData = getSessionData();

        $quoteMdl = new Quote();
        $data['module'] = $quoteMdl->select('quotes.*,customers.registerd_name,customers.address')->join('customers','quotes.customer_id = customers.id','left')->where("quotes.id",$post['id'])->first();

        $qItemMdl = new QuoteItem();
        $data['items'] = $qItemMdl->select('quote_items.*, items.item_name')->join('items','items.id = quote_items.item_id')->where("quote_id",$post['id'])->findAll();

        return json_encode([
            "status" => "true",
            "message" => "Quote details get successfully",
            "data" => $data
        ]);
    }

    public function convertToInvoice($id)
    {
        $data = [];
        $data['title'] = 'Add Invoice'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales');
        $sessData = getSessionData(); 

        $mdl = new Quote();
        $data['quote'] = $mdl->select('quotes.*, c.currency_code')->join('currencies c','quotes.currency_id = c.id','left')->where("quotes.id",$id)->first();

        $data['quote_id'] = $id;

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];
        
        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $items = new QuoteItem;
        $data['quote_items'] = $items->where("quote_id",$id)->findAll();

        $invoice = new SellordersModel();
        $lastID = $invoice->getRowCounts($sessData['pos_id']);
        $data['invoice'] = $lastID + 1;

        $customerModel = new CustomersModel();
        $customerModel->where('status',1);
        $data['customer'] = $customerModel->findAll();
        
        $currencyModel = new CurrencyModel();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/sales/convert_to_invoice', $data);
    }

    public function EditQuote($id)
    {
        $data = [];
        $data['title'] = 'Edit Quote'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales');
        $sessData = getSessionData(); 

        $invoiceModel = new Quote();
        $data['quotes'] = $invoiceModel->select('quotes.*, c.currency_code')->join('currencies c','quotes.currency_id = c.id','left')->where("quotes.id",$id)->first();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];
        // $data['status'] = $this->getInvoiceStatus($data['invoice']['id'],$data['invoice']['due_date'],$data['invoice']['total_amount'],$data['quotes']['balance_due'],$data['invoice']['is_sent']);
        
        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $items = new QuoteItem;
        $data['quote_items'] = $items->where("quote_id",$id)->findAll();
        
        $customer = new CustomersModel();
        $customer->where('status',1);
        $data['customer'] = $customer->findAll();
        
        $currency = new CurrencyModel();
        $currency->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currency->findAll();

        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/sales/quote_add', $data);
    }

    public function printInvoicePDF($id){
        // $post = $this->request->getVar();

        $data = [];
        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->select('sell_orders.*,customers.registerd_name,customers.address,payment_type as p_mode')->join('customers','customers.id = sell_orders.customer_id')->join('payment_type_master','payment_type_master.id = sell_orders.payment_mode')->where("sell_orders.id",$id)->first();

        $sellerItemsModel = new SellItemsModel();
        $data['sell_items'] = $sellerItemsModel->select('sell_items.*, items_master.item_name')->join('items','items.id = sell_items.item_id')->join('items_master','items_master.id = items.item_master_id')->where("s_o_id",$id)->findAll();

        $filename = "INV-000".$data['invoice']['id'].'.pdf';
        $dompdf = new \Dompdf\Dompdf(); 
        $dompdf->loadHtml(view('pages/sales/invoice_to_pdf', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->set_option('isFontSubsettingEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->render();
        $dompdf->stream($filename);
    }

    public function sendInvoiceMail(){

        $post = $this->request->getVar();

        $genrModel = new GeneralModel();
        $getFromMail = $genrModel->where('store_id',$post['store_id'])->first();

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->select('sell_orders.*, stores.store_name, customers.registerd_name,customers.address,employees.first_name,employees.last_name,payment_type as p_mode')->join('customers','customers.id = sell_orders.customer_id')->join('stores','sell_orders.store_id = stores.id')->join('employees','stores.owner_id = employees.id')->join('payment_type_master','payment_type_master.id = sell_orders.payment_mode')->where('sell_orders.id',$post['id'])->first();

        $sellerItemsModel = new SellItemsModel();
        $data['sell_items'] = $sellerItemsModel->select('sell_items.*, items_master.item_name')->join('items','items.id = sell_items.item_id')->join('items_master','items_master.id = items.item_master_id')->where("s_o_id",$post['id'])->findAll();

        if(!empty($getFromMail) && $getFromMail['from_email'] != "") {

                $mailData = array(
                    'id' => $data['invoice']['id'],
                    'customer_name' => $data['invoice']['registerd_name'],
                    'owner_name' => $data['invoice']['first_name'].' '.$data['invoice']['last_name'],
                    'store_name' => $data['invoice']['store_name']
                );

                $filename = "INV-000".$data['invoice']['id'].'.pdf';
                $dompdf = new \Dompdf\Dompdf(); 
                $dompdf->loadHtml(view('pages/sales/invoice_to_pdf', $data));
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->set_option('isFontSubsettingEnabled', true);
                $dompdf->set_option('isPhpEnabled', true);
                $dompdf->render();
                $pdf = $dompdf->output();

                /*$email = \Config\Services::email();
                $email->setTo($to);
                $email->setFrom($getFromMail['from_email'], $data['invoice']['store_name']);
                $email->setSubject('Invoice for INV-000'.$data['invoice']['id']);
                $email->setMessage(view('pages/sales/invoice_mail', $mailData));
                $email->attach($pdf,'application/pdf',$filename);

                if ($email->send()) 
                {*/
                    return json_encode([
                        "status" => "true",
                        "message" => "Email Sent successfully"
                    ]);
                // } 
                /*else 
                {
                    $data = $email->printDebugger(['headers']);
                    print_r($data);
                }*/

        } else {
            return json_encode([
                "status" => "false",
                "message" => "Please set from email in your General settings for <strong>".$data['invoice']['store_name']."</strong>"
            ]);
        }
    }

    public function recordNewPayment()
    {
        $post = $this->request->getVar();

        $paymentmasterModel = new PaymentMasterModel();
        $data['payments'] = $paymentmasterModel->findAll();

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->select('sell_orders.*,customers.registerd_name,customers.address,payment_type as p_mode')->join('customers','sell_orders.customer_id = customers.id','left')->join('payment_type_master','payment_type_master.id = sell_orders.payment_mode','left')->where("sell_orders.id",$post['id'])->first();

        $paymentModel = new SalesPaymentModel(); 
        $payment_record = $paymentModel->select('sales_payment.*, payment_type as p_mode')->join('payment_type_master','payment_type_master.id = sales_payment.payment_id')->where('invoice_id',$post['id'])->findAll();

        $data['remaining_amt'] = $data['invoice']['total_amount'];
        if(count($payment_record) > 0) {
            $amt_received = array_column($payment_record, 'amount_received');
            $total_payments = array_sum($amt_received);

            $remaining = (float)$data['invoice']['total_amount'] - (float)$total_payments;
            $data['remaining_amt'] = number_format($remaining, 2);
        }

        return json_encode([
            "status" => "true",
            "data" => $data
        ]);
    }

    public function getCustomerCredits()
    {
        $post = $this->request->getVar();
        $invoiceModel = new SellordersModel();
        $invoice = $invoiceModel->where("sell_orders.id",$post['id'])->first();

        $credits = new CreditNote();
        $data['credit_note'] = $credits->where('customer_id',$invoice['customer_id'])->where('credits_available >',0)->findAll();
        $data['customer_id'] = $invoice['customer_id'];
        $data['balance_due'] = $invoice['balance_due'];
        return json_encode([
            "status" => "true",
            "data" => $data
        ]);
    }

    public function Post_Data_credits()
    {
        $post = $this->request->getVar();

        $db = db_connect();
        $commonModel = new CommonModel($db);
        $totalCredits = 0;
        foreach ($post['credit'] as $key => $value) {
            if($value['credit_applied'] != "" && $value['credit_applied'] > 0) {
                $amount = $value['credit_applied'];
                if($value['credit_applied'] > $post['balance_due']) {
                    $amount  = $post['balance_due'];
                }
                $data = [
                    'invoice_id' => $post["invoice_id"],
                    'customer_id'  => $post['customer_id'],
                    'crn_id'=>$value['crn_id'],
                    'credit_date' => date('Y-m-d'),
                    'credit_applied' => $amount
                ];
                $result = $commonModel->AddData('credits',$data);

                $cNote = new CreditNote();
                $cData = $cNote->where('id',$value['crn_id'])->first();

                $credits_available = abs($cData['credits_available'] - $amount);
                $uData = ['credits_available' => $credits_available];
                $commonModel->UpdateData('credit_notes',$value['crn_id'],$uData);
                $totalCredits += $amount;
            }
        }
        if($totalCredits > 0) {
            $balDue = abs($post['balance_due'] - $totalCredits);
            $invoiceBal = ['balance_due' => number_format($balDue,2)];

            $commonModel->UpdateData('sell_orders',$post['invoice_id'],$invoiceBal);
        }   

        return json_encode([
            "status" => "true",
            "message" => 'Credits Applied successfully'
        ]);
    }

    public function AddQuote()
    {
        $data = [];
        $data['title'] = 'Add Quote'; 
        $data['main_menu'] = 'Sales';
        $data['main_menu_url'] = base_url('sales'); 

        $sessData = getSessionData();

        $quote = new Quote();
        $lastID = $quote->getInsertID();
        $data['quote_number'] = $lastID + 1;

        $customerModel = new CustomersModel();
        $customerModel->where('status',1);
        $data['customer'] = $customerModel->findAll();

        $currencyModel = new CurrencyModel();
        $storeModel = new StoreModel();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];

        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }

        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $data['s_name'] = $storeModel->select('store_name')->where('id',$sessData['store_id'])->first();
        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();
        $data['stores'] = $storeModel->where('status', 1)->findAll();
        
        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);
        
        return $this->template->render('pages/sales/quote_add', $data);
    }

    public function AddCreditNote($id){
        $data = [];
        $data['title'] = 'Add Credit Note'; 
        $data['main_menu'] = 'Sales';
        $data['main_menu_url'] = base_url('sales');
        $sessData = getSessionData();

        $invoiceModel = new SellordersModel();
        $invoiceData = $invoiceModel->select('sell_orders.*, c.currency_code')->join('currencies c','sell_orders.currency_id = c.id','left')->where("sell_orders.id",$id)->first();
        $data['invoice'] = $invoiceData;

        $mdl = new CreditNote();
        $creditnotes = $mdl->where("pos_id",$sessData['pos_id'])->countAll();
        $data['creditnote'] = $creditnotes;

        $currencyModel = new CurrencyModel();
        $storeModel = new StoreModel();
        $data['s_name'] = $storeModel->select('store_name')->where('id',$sessData['store_id'])->first();

        $customerModel = new CustomersModel();
        $customerModel->where('id',$invoiceData['customer_id']);
        $data['customer'] = $customerModel->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];

        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }

        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $sellerItemsModel = new SellItemsModel;
        $data['sell_items'] = $sellerItemsModel->select('sell_items.*,items.item_name')->join('items','sell_items.item_id = items.id')->where("s_o_id",$id)->findAll();

        return $this->template->render('pages/sales/credit_note_add', $data);
    }

    public function AddDebitNote($id)
    {
        $data = [];
        $data['title'] = 'Add Debit Note'; 
        $data['main_menu'] = 'Sales';
        $data['main_menu_url'] = base_url('sales');
        $sessData = getSessionData();

        $invoiceModel = new SellordersModel();
        $invoiceData = $invoiceModel->select('sell_orders.*, c.currency_code')->join('currencies c','sell_orders.currency_id = c.id','left')->where("sell_orders.id",$id)->first();
        $data['invoice'] = $invoiceData;

        $mdl = new SellordersModel();
        $debitnotes = $mdl->where("pos_id",$sessData['pos_id'])->where('invoice_type',2)->countAll();
        $data['debitnote'] = $debitnotes;

        $currencyModel = new CurrencyModel();
        $storeModel = new StoreModel();
        $data['s_name'] = $storeModel->select('store_name')->where('id',$sessData['store_id'])->first();

        $customerModel = new CustomersModel();
        $customerModel->where('id',$invoiceData['customer_id']);
        $data['customer'] = $customerModel->findAll();

        $data['base_currency_id'] = '';
        $data['currency_symbol'] = '';
        $data['currency_code'] = '';
        $data['store_id'] = $sessData['store_id'];

        if($sessData['role_name'] == "Staff") {
            $storeModel->where('id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $storeModel->where('pos_id',$sessData['pos_id']);
            $currencyModel->where('pos_id',$sessData['pos_id']);
        }

        if($data['store_id'] != '') {
            $general = new GeneralModel();
            $generalData = $general->where('store_id',$data['store_id'])->join('currencies','currencies.id = general.currency_id')->first();
            if(!empty($generalData)) {
                $data['base_currency_id'] = $generalData['currency_id'];
                $data['currency_symbol'] = $generalData['currency_symbol'];
                $data['currency_code'] = $generalData['currency_code'];
            }
        }

        $currencyModel->where('id !=',$data['base_currency_id']);
        $data['currency'] = $currencyModel->findAll();

        $sellerItemsModel = new SellItemsModel;
        $data['sell_items'] = $sellerItemsModel->select('sell_items.*,items.item_name')->join('items','sell_items.item_id = items.id')->where("s_o_id",$id)->findAll();

        $items = new ItemModel();
        $itemlist =  $items->getCanSaleItems($sessData['pos_id']);
        $data['items'] = json_encode($itemlist);

        return $this->template->render('pages/sales/debit_note_add', $data);
    }

    public function AddPaymentInvoice()
    {
        $data = [];
        $data['title'] = 'Add Payment'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales'); 

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->GetInvoiceData();

        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->findAll();

        $currencyModel = new CurrencyModel();
        $data['currency'] = $currencyModel->findAll();

        return $this->template->render('pages/sales/payment_add', $data);
    }

    public function EditPaymentInvoice($id)
    {
        $data = [];
        $data['title'] = 'Edit Payment'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales'); 

        $paymentinvoiceModel = new SalesPaymentModel();
        $data['payment_invoice'] = $paymentinvoiceModel->where("id",$id)->first();

        $invoiceModel = new SellordersModel();
        $data['invoice'] = $invoiceModel->GetInvoiceData();

        $customerModel = new CustomersModel();
        $data['customer'] = $customerModel->findAll();

        $currencyModel = new CurrencyModel();
        $data['currency'] = $currencyModel->findAll();

        return $this->template->render('pages/sales/payment_add', $data);
    }

    public function ViewPayment($id)
    {
        $data = [];
        $data['title'] = 'View Payment Details'; 
        $data['main_menu'] = 'Sales'; 
        $data['main_menu_url'] = base_url('sales'); 

        $paymentModel = new SalesPaymentModel();
        $data['payment'] = $paymentModel->GetSalesInvoiceDataById($id);
        return $this->template->render('pages/sales/payment_view', $data);
    }
    public function Post_Data_Sales()
    {
        if ($this->request->getMethod() == "post") 
        {
                $sessData = getSessionData();
                $post = $this->request->getVar();

                $db = db_connect();
                $commonModel = new CommonModel($db);

                switch($post['table_name'])
                {
                    case 'quotes':
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'store_id' => isset($post["store_id"])?$post["store_id"]:0,
                            'total_tax' => $post['total_tax'],
                            'currency_tax' => $post['currency_tax'],
                            'sub_curr_total' => $post['sub_curr_total'],
                            'sub_total'  => $post['sub_total'],
                            'total_discount' => $post['total_discount'],
                            'currency_discount' => $post['currency_discount'],
                            'currency_total' => $post['conv_total_amount'],
                            'total_amount' => $post['total_amount'],
                            'adjustment_value' => $post['adjustment_value'],
                            'customer_note' => $post['note'],
                            'customer_id' => isset($post["customer_id"])?$post["customer_id"]:"0",
                            'quote_number' => isset($post["quote_number"])?$post["quote_number"]:"0",
                            'quote_date' => isset($post["quote_date"])?$post["quote_date"]:"0",
                            "terms" => isset($post["terms"])?$post["terms"]:"",
                            'due_date' => isset($post["due_date"])?$post["due_date"]:"0",
                            'base_currency_id' => $post['base_currency_id'],
                            'currency_id' => isset($post["currency_id"])?$post["currency_id"]:"0",
                            'currency_rate' => isset($post["currency_rate"])?$post["currency_rate"]:"0"
                        ];
                    break;
                    /*case 'sales_payment':
                        $data = [
                            'invoice_id' => $post["invoice_id"],
                            'payment_id' => $post['type_id'],
                            'customer_id'  => $post['customer_id'],
                            'payment_date' => $post['payment_date'],
                            'receipt_name' => $post['customer'],
                            'amount_received' => $post['amount_received'],
                            'store_id' => $post['store_id'],
                            'notes' => isset($post["notes"])?$post["notes"]:""
                        ];
                    break;*/
                    case 'credit_notes':
                        $total_credits = $post['total_amount'];
                        $credits_available = 0.00;
                        $paymentModel = new SalesPaymentModel(); 
                        $payments = $paymentModel->select('amount_received')->where('invoice_id',$post['invoice_id'])->findAll();

                        if(count($payments) > 0) {
                            $amt_received = array_column($payments, 'amount_received');
                            $total = array_sum($amt_received);

                            if($total == $post['pre_total_amount']) {
                                $credits_available = $total;
                            } else {
                                $amtToPay = abs($post['pre_total_amount'] - $total);

                                $creditstoinv = [
                                    'pos_id' => $sessData['pos_id'],
                                    'invoice_id' => $post['invoice_id'],
                                    'customer_id' => $post['customer_id'],
                                    'credit_date' => $post['credit_date'],
                                    'credit_applied' => number_format($amtToPay,2),
                                    'store_id' => $post['store_id']
                                ];
                                $applyCR = $commonModel->AddData('credits',$creditstoinv);

                                $balDue = abs($post['pre_total_amount'] - ($total + $amtToPay));
                                $invoiceBal = ['balance_due' => number_format($balDue,2)];
                                $commonModel->UpdateData('sell_orders',$post['invoice_id'],$invoiceBal);

                                $credits_available = abs($amtToPay - $post['total_amount']);
                            }
                        }

                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'invoice_id' => $post['invoice_id'],
                            'store_id' => isset($post["store_id"])?$post["store_id"]:0,
                            'customer_id' => isset($post["customer_id"])?$post["customer_id"]:"0",
                            'credit_date' => isset($post["credit_date"])?$post["credit_date"]:"0",
                            'base_currency_id' => $post['base_currency_id'],
                            'currency_id' => isset($post["currency_id"])?$post["currency_id"]:"0",
                            'currency_rate' => isset($post["currency_rate"])?$post["currency_rate"]:"0",
                            'currency_tax' => $post['currency_tax'],
                            'total_tax' => $post['total_tax'],
                            'sub_total'  => $post['sub_total'],
                            'sub_curr_total' => $post['sub_curr_total'],
                            'total_discount' => $post['total_discount'],
                            'currency_discount' => $post['currency_discount'],
                            'adjustment_value' => $post['adjustment_value'],
                            'total_amount' => $post['total_amount'],
                            'currency_total' => $post['conv_total_amount'],
                            'note' => $post['note'],
                            'credits_available' => number_format($credits_available,2)
                        ];
                    break;
                    case 'credits':
                        $data = [
                            'invoice_id' => $post["invoice_id"],
                            'customer_id'  => $post['customer_id'],
                            'credit_date' => $post['credit_date'],
                            'receipt_name' => $post['customer'],
                            'credit_applied' => $post['amount'],
                            'store_id' => $post['store_id'],
                            'notes' => isset($post["notes"])?$post["notes"]:""
                        ];
                    break;
                    case 'sell_orders':
                        foreach($post['items'] as $item) {
                            $inventory = new CurrentInventory();
                            $itemData = $inventory->select('current_inventory.quantity,items.item_name')->join('items','items.id = current_inventory.item_id')->where('current_inventory.store_id',$post['store_id'])->where('current_inventory.item_id',$item['item_id'])->where('location_id',1)->first();

                            if($item['quantity'] > $itemData['quantity']) {
                                return json_encode([
                                        "status" => "false",
                                        "message" => $itemData['item_name']." quantity available: ".$itemData['quantity'],
                                ]);
                            }
                        }
                        // $terminalModel = new TerminalsModel();
                        // $terminal = $terminalModel->select('terminals.id')->where('store_id',$post["store_id"])->first();
                        
                        $data = [
                            'pos_id' => $sessData['pos_id'],
                            'store_id' => isset($post["store_id"])?$post["store_id"]:0,
                            'invoice_type' => isset($post['invoice_type'])?$post['invoice_type']:1,
                            'total_tax' => $post['total_tax'],
                            'currency_tax' => $post['currency_tax'],
                            'sub_curr_total' => $post['sub_curr_total'],
                            'sub_total'  => $post['sub_total'],
                            'total_discount' => $post['total_discount'],
                            'currency_discount' => $post['currency_discount'],
                            'currency_total' => $post['conv_total_amount'],
                            'total_amount' => $post['total_amount'],
                            'adjustment_value' => $post['adjustment_value'],
                            'customer_note' => $post['note'],
                            'is_include_tax' => 1,
                            'customer_id' => isset($post["customer_id"])?$post["customer_id"]:"0",
                            'order_number' => isset($post["order_number"])?$post["order_number"]:"0",
                            'invoice_date' => isset($post["invoice_date"])?$post["invoice_date"]:"0",
                            "terms" => isset($post["terms"])?$post["terms"]:"",
                            'due_date' => isset($post["due_date"])?$post["due_date"]:"0",
                            'base_currency_id' => $post['base_currency_id'],
                            'currency_id' => isset($post["currency_id"])?$post["currency_id"]:"0",
                            'currency_rate' => isset($post["currency_rate"])?$post["currency_rate"]:"0",
                            'payment_status' => isset($post["payment_status"])?$post["payment_status"]:"0",
                            'payment_mode' => isset($post["payment_mode"])?$post["payment_mode"]:"1",
                            'invoice_type' => isset($post["invoice_type"])?$post["invoice_type"]:"0",
                            "terminal_id"=>isset($sessData['terminal_id'])?$sessData['terminal_id']:""
                        ];
                        if($post['invoice_type'] == "2") {
                            $data['main_invoice_id'] = $post['main_invoice_id'];
                        } //else if($post['invoice_type'] == "1") {
                        if($post['id'] == "") {
                            $data['balance_due'] = $post['total_amount'];
                        }else {
                            $paymentModel = new SalesPaymentModel(); 
                            $payment_record = $paymentModel->select('sum(amount_received) as sm')->where('invoice_id',$post['id'])->first();
                            $data['balance_due'] = isset($payment_record) ? $post['total_amount'] - (float) $payment_record['sm'] : $post['total_amount'];
                        }
                        //}
                        if(isset($post['quote_id']) && $post['quote_id'] != "") {
                            $uQuote = ['is_invoiced' => 1];
                            $commonModel->UpdateData('quotes',$post['quote_id'],$uQuote);
                        }
                    break;
                    case 'sales_payment':
                        $data = [
                            'invoice_id' => $post["invoice_id"],
                            'store_id' => $post['store_id'],
                            'customer_id' => isset($post["customer_id"])?$post["customer_id"]:"0",
                            'amount_received' => isset($post["amount_received"])?$post["amount_received"]:"0",
                            'bank_charge' => isset($post["bank_charge"])?$post["bank_charge"]:"0",
                            'receipt_name' => $post['customer'],
                            'payment_date' => isset($post["payment_date"])?$post["payment_date"]:"0",
                            'payment_id' => isset($post["type_id"])?$post["type_id"]:"0",
                            'payment_mode' => isset($post["payment_mode"])?$post["payment_mode"]:"0",
                            'reference_id' => isset($post["reference_id"])?$post["reference_id"]:"0",
                            'currency_id' => isset($post["currency_id"])?$post["currency_id"]:"0",
                            'notes' => isset($post["notes"])?$post["notes"]:""

                        ];
                    break;
                    case 'sell_order_editnote':
                        $data = [
                            's_o_id' => isset($post['invoice_id'])?$post['invoice_id']:"",
                            'notes' => isset($post['edit_notes'])?$post['edit_notes']:""
                        ];
                    break;
                }
            }
            
            if(isset($post['id']) && empty($post['id']))
            {
                $result = $commonModel->AddData($post['table_name'],$data);
                switch($post['table_name'])
                {
                    case 'sell_orders':
                        foreach($post['items'] as $item) {
                            $storeItemModel = new StoreItemsModel();

                            $store_data = [
                                'pos_id'=>$sessData['pos_id'],
                                'item_id'=>$item['item_id'],
                                'store_id'=>$post['store_id'],
                                'qty'=>$item['quantity'],
                                'location_id'=>1,
                                'type'=>'sold'
                            ];

                            $store_item = $storeItemModel->soldItem($store_data);
                            
                            $items = array(
                                's_o_id' => $result,
                                'item_id' => $item['item_id'],
                                'uom_id' => $item['uomid'],
                                'uom_value' => $item['uom'],
                                'qty' => $item['quantity'],
                                'rate' => $item['rate'],
                                'discount' => $item['discount'],
                                'discount_type' => $item['discount_type'],
                                'discount_amount' => $item['discount_amount'],
                                'tax_value' => $item['tax'],
                                'tax_name' => $item['tax_type'],
                                'tax_amount' => $item['tax_amount'],
                                'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                'total_amount' => $item['tax_amount'] + $item['amount'] ,
                                'item_amount' => $item['amount'],
                            );

                            $addOrderItem = $commonModel->AddData('sell_items',$items);       
                        }
                    break;
                    case 'quotes':
                        foreach($post['items'] as $item) {

                            $items = array(
                                'quote_id' => $result,
                                'item_id' => $item['item_id'],
                                'uom_id' => $item['uomid'],
                                'uom_value' => $item['uom'],
                                'qty' => $item['quantity'],
                                'rate' => $item['rate'],
                                'discount' => $item['discount'],
                                'discount_type' => $item['discount_type'],
                                'discount_amount' => $item['discount_amount'],
                                'tax_value' => $item['tax'],
                                'tax_name' => $item['tax_type'],
                                'tax_amount' => $item['tax_amount'],
                                'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                'total_amount' => $item['tax_amount'] + $item['amount'] ,
                                'item_amount' => $item['amount'],
                            );

                            $addOrderItem = $commonModel->AddData('quote_items',$items);       
                        }
                    break;
                    case 'credit_notes':
                        foreach($post['items'] as $item) {
                            $items = array(
                                'crn_id' => $result,
                                'item_id' => $item['item_id'],
                                'uom_id' => $item['uomid'],
                                'uom_value' => $item['uom'],
                                'qty' => $item['quantity'],
                                'rate' => $item['rate'],
                                'discount' => $item['discount'],
                                'discount_type' => $item['discount_type'],
                                'discount_amount' => $item['discount_amount'],
                                'tax_value' => $item['tax'],
                                'tax_name' => $item['tax_type'],
                                'tax_amount' => $item['tax_amount'],
                                'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                'total_amount' => $item['tax_amount'] + $item['amount'] ,
                                'item_amount' => $item['amount'],
                            );
                            $commonModel->AddData('credit_notes_items',$items);       
                        }
                    break;
                    case 'sales_payment':
                        $paymentModel = new SalesPaymentModel(); 
                        $payment_record = $paymentModel->select('sum(amount_received) as sm')->where('invoice_id',$post['invoice_id'])->first();

                        $invoiceModel = new SellordersModel();
                        $invoice = $invoiceModel->select('sell_orders.total_amount as total')->where("sell_orders.id",$post['invoice_id'])->first();

                        $balance_due = $payment_record['sm'] == $invoice['total'] ? '0.00' : (float) $payment_record['sm'] - (float) $invoice['total'];

                        $uData['balance_due'] = number_format(abs($balance_due),2);
                        $uData['is_sent'] = 1;
                        $uBalDue = $commonModel->UpdateData('sell_orders',$post['invoice_id'],$uData);
                    break;
                }
                return json_encode([
                    "status" => "true",
                    "message" => "New Data added successfully",
                ]);
            }
            else
            {
                $id = $post['id'];
                $result = $commonModel->UpdateData($post['table_name'],$id,$data);

                switch($post['table_name'])
                {
                    case 'sell_orders':
                    if(isset($post['items'])) {
                         foreach($post['items'] as $item) {
                            $storeItemModel = new StoreItemsModel();
                            $store_data = [
                                'pos_id'=>$sessData['pos_id'],
                                'item_id'=>$item['item_id'],
                                'store_id'=>$post['store_id'],
                                'qty'=>$item['quantity'],
                                'location_id'=>1,
                                'type'=>'sold'
                            ];

                            $store_item = $storeItemModel->soldItem($store_data);

                            $items = array(
                                    's_o_id' => $post['id'],
                                    'item_id' => $item['item_id'],
                                    'uom_id' => $item['uomid'],
                                    'uom_value' => $item['uom'],
                                    'qty' => $item['quantity'],
                                    'rate' => $item['rate'],
                                    'discount' => $item['discount'],
                                    'discount_type' => $item['discount_type'],
                                    'discount_amount' => $item['discount_amount'],
                                    'tax_value' => $item['tax'],
                                    'tax_name' => $item['tax_type'],
                                    'tax_amount' => $item['tax_amount'],
                                    'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                    'total_amount' => $item['tax_amount'] + $item['amount'] ,
                                    'item_amount' => $item['amount'],
                                );
                                
                                 if(isset($item['id'])) {
                                        $updateOrderItem = $commonModel->UpdateData('sell_items',$item['id'],$items);
                                    } else {
                                        $addOrderItem = $commonModel->AddData('sell_items',$items);
                                    }
                               
                            }
                        }
                        if(isset($post['deleted_items']) && $post['deleted_items'] != "") {
                            $delItems = json_decode($post['deleted_items']);
                            foreach ($delItems as $k => $v) {
                                $model = new SellItemsModel();
                                $model->where('id',$v->id)->delete();

                                $storeItemModel = new StoreItemsModel();
                                $store_data = [
                                    'item_id'=>$v->item_id,
                                    'store_id'=>$post['store_id'],
                                    'qty'=>$v->qty,
                                    'type'=>'received'
                                ];
                                $store_item = $storeItemModel->GetStoreItemId($store_data);
                            }
                        }
                        break;
                        case 'quotes':
                            foreach($post['items'] as $item) {

                                $items = array(
                                    'quote_id' => $post['id'],
                                    'item_id' => $item['item_id'],
                                    'uom_id' => $item['uomid'],
                                    'uom_value' => $item['uom'],
                                    'qty' => $item['quantity'],
                                    'rate' => $item['rate'],
                                    'discount' => $item['discount'],
                                    'discount_type' => $item['discount_type'],
                                    'discount_amount' => $item['discount_amount'],
                                    'tax_value' => $item['tax'],
                                    'tax_name' => $item['tax_type'],
                                    'tax_amount' => $item['tax_amount'],
                                    'tax_excl' => isset($item['tax_excl'])?$item['tax_excl']:0,
                                    'total_amount' => $item['tax_amount'] + $item['amount'] ,
                                    'item_amount' => $item['amount'],
                                );

                                if(isset($item['id'])) {
                                    $updateItem = $commonModel->UpdateData('quote_items',$item['id'],$items);
                                } else {
                                    $addItem = $commonModel->AddData('quote_items',$items);
                                }    
                            }
                        break;
                    }
                return json_encode([
                    "status" => "true",
                    "message" => "Data updated successfully",
            ]);
            } 
    }
    function getStockSell(){
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $sell = new SellordersModel();
        $totalRecords = $sell->select('id')->countAllResults();
        $sellF = new SellordersModel();
        $sellF->select('id');

        $sell->select('sell_orders.*,stores.store_name,customers.registerd_name as customer_name')
            ->join('stores', 'sell_orders.store_id = stores.id')
            ->join('customers', 'sell_orders.customer_id = customers.id');

        if($sessData['role_name'] == "Staff") {
            $sell->where('stores.id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $sell->where('sell_orders.pos_id',$sessData['pos_id']);
        }
        
        if($filter['store_id'] != "") {
            $sell->where('store_id',$filter['store_id']);
            $sellF->where('store_id',$filter['store_id']);
        }
        if($filter['customer_id'] != 0 && $filter['customer_id'] != "") {
            $sell->where('customer_id',$filter['customer_id']);
            $sellF->where('customer_id',$filter['customer_id']);
        }
        if($filter['search'] != "") {
            $sell->orLike('stores.store_name',$filter['search'])
                ->orLike('order_number',$filter['search']);
        }

        // $sell->where('invoice_type',1);
        $sell->orderBy('id','desc');
        $records = $sell->findAll($rowperpage, $start);
        $totalRecordwithFilter = $sellF->countAllResults();

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "invoice_type"=>$record['invoice_type'],
               "store_name"=>$record['store_name'],
               "order_number"=>$record['order_number'],
               "customer_name"=>$record['customer_name'],
               "status"=>$this->getInvoiceStatus($record['id'],$record['due_date'],$record['total_amount'],$record['balance_due'],$record['is_sent']),
               "date"=>dateFormat($record['invoice_date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount'],
               "balance_due"=>$record['balance_due']
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }
    
    function getQuotes(){
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $mdl = new Quote();
        $totalRecords = $mdl->select('id')->countAllResults();
        $flt = new Quote();
        $flt->select('id')->join('stores', 'quotes.store_id = stores.id')
            ->join('customers', 'quotes.customer_id = customers.id');

        $mdl->select('quotes.*,stores.store_name,customers.registerd_name as customer_name')
            ->join('stores', 'quotes.store_id = stores.id')
            ->join('customers', 'quotes.customer_id = customers.id');
        
        if($sessData['role_name'] == "Staff") {
            $mdl->where('stores.id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $mdl->where('quotes.pos_id',$sessData['pos_id']);
        }

        if($filter['store_id'] != "") {
            $mdl->where('store_id',$filter['store_id']);
            $flt->where('store_id',$filter['store_id']);
        }
       
        if($filter['customer_id'] != 0 && $filter['customer_id'] != "") {
            $mdl->where('customer_id',$filter['customer_id']);
            $flt->where('customer_id',$filter['customer_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search'])
                ->orLike('quote_number',$filter['search']);
          }
         // $purchase->where('order_status',0);
          
          $mdl->orderBy('id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        $totalRecordwithFilter = $flt->countAllResults();

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "customer_name"=>$record['customer_name'],
               "date"=>dateFormat($record['quote_date']),
               "due_date"=>dateFormat($record['due_date']),
               "total_amount"=>$record['total_amount']
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }
    function getCreditNotes(){
        $postData = $this->request->getVar();

        $dtpostData = $postData['data'];
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = 10; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $filter = $postData['filter'];

        $sessData = getSessionData();

        $mdl = new CreditNote();
        $totalRecords = $mdl->select('id')->where('pos_id',$sessData['pos_id'])->countAllResults();
        $flt = new CreditNote();
        $flt->select('id')->join('stores', 'credit_notes.store_id = stores.id')
            ->join('customers', 'credit_notes.customer_id = customers.id');

        $mdl->select('credit_notes.*,stores.store_name,customers.registerd_name as customer_name')
            ->join('stores', 'credit_notes.store_id = stores.id')
            ->join('customers', 'credit_notes.customer_id = customers.id');
        
        if($sessData['role_name'] == "Staff") {
            $mdl->where('stores.id',$sessData['store_id']);
        } else if ($sessData['role_name'] == "Owner") {
            $mdl->where('credit_notes.pos_id',$sessData['pos_id']);
        }
  
       if($filter['store_id'] != "") {
            $mdl->where('store_id',$filter['store_id']);
            $flt->where('store_id',$filter['store_id']);
        }
       
        if($filter['customer_id'] != 0 && $filter['customer_id'] != "") {
            $mdl->where('customer_id',$filter['customer_id']);
            $flt->where('customer_id',$filter['customer_id']);
        }
        if($filter['search'] != "") {
            $mdl->orLike('stores.store_name',$filter['search']);
        } 
        
        $mdl->where('credit_notes.pos_id',$sessData['pos_id'])->orderBy('id','desc');
        $records = $mdl->findAll($rowperpage, $start);
        $totalRecordwithFilter = $flt->where('credit_notes.pos_id',$sessData['pos_id'])->countAllResults();

        $data = array();

        foreach($records as $record ){

            $data[] = array( 
               "id"=>$record['id'],
               "store_name"=>$record['store_name'],
               "credit_note"=>$record['id'],
               "customer_name"=>$record['customer_name'],
               "invoice"=>$record['invoice_id'],
               "date"=>dateFormat($record['credit_date']),
               "total_amount"=>$record['total_amount'],
               'balance'=>$record['credits_available']
            ); 
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash() // New token hash
         );

         return $this->response->setJSON($response);
    }
    public function getGraphSale($value='')
    {
        $post = $this->request->getVar();
        //0- Yearly
        //1- Monthly
        //2- Weekly
        $sellOrderModel = new SellordersModel();
        $data['sales'] = [];
        if($post['value'] == 0){
            $year = date('Y');
            $sales = $sellOrderModel->getSalesByYear($year);
            $total_sales = $sellOrderModel->getTotalSalesByYear($year);

            $month_names = array( 'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct',  'Nov','Dec');
            $sale = array();
            foreach($month_names as $key=>$row){
                $sale[$key]['date'] = $row;
                $sale[$key]['current'] = "0";
                $sale[$key]['previous'] = "0";
                foreach ($sales as $k => $v) {
                    if($row == $v['month_name']){
                        $sale[$key]['date'] = $row;
                        $sale[$key]['current'] = number_format((float)$v['total'], 2, '.', '');
                        $sale[$key]['previous'] = number_format((float)$v['total'], 2, '.', ''); ;
                    }
                }
            }
            $previous_year = date("Y",strtotime("-1 year"));
            $previous_sales = $sellOrderModel->getSalesByYear($previous_year); 
            $previous_total_sales = $sellOrderModel->getTotalSalesByYear($previous_year);  
            $previous_sale = array();
            foreach($sale as $key=>$row){  
                $previous_sale[$key]['date'] = $row['date'];
                $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                $previous_sale[$key]['previous'] = "0";
                foreach ($previous_sales as $k => $v) {
                    if($row['date'] == $v['month_name']){
                        $previous_sale[$key]['date'] = $row['date'];
                        $previous_sale[$key]['current'] = $row['current'];
                        $previous_sale[$key]['previous'] = number_format((float)$v['total'], 2, '.', '');;
                    }
                }
            }
                  
                     
            $data['sales'] = json_encode($previous_sale);
            $data['total_sales'] = numberFormat($total_sales['total']);
            $data['previous_total_sales'] = numberFormat($previous_total_sales['total']);

            $sales_text = array("Current Year","Previous Year");
            $data['sales_text'] = json_encode($sales_text); 
            $data['current_text'] = "Current Year";
            $data['previous_text'] = "Previous Year";

        }else if($post['value'] == 1){
            for($i = 1; $i <=  date('t'); $i++)
            {
                $dates_array[] = str_pad($i, 2, '0', STR_PAD_LEFT);
            }
            $date = date('Y-m-01'); // first day of current month
            $month = date('m');
            $sales = $sellOrderModel->getSalesByMonths($month);
            $total_sales = $sellOrderModel->getTotalSalesByMonths($month);

            $sale = array();
            foreach($dates_array as $key=>$row){
                  $sale[$key]['date'] = $row;
                  $sale[$key]['current'] = "0";
                  $sale[$key]['previous'] = "0.00";
                   
                foreach ($sales as $k => $v) {
                  if($row == $v['date']){
                     $sale[$key]['date'] = $row;
                     $sale[$key]['current']= number_format((float)$v['total'], 2, '.', '');
                   }
                }
            }

            $previouse_month = date("m",strtotime("-1 month"));

            $previous_sales = $sellOrderModel->getSalesByMonths($previouse_month);
            $previous_total_sales = $sellOrderModel->getTotalSalesByMonths($previouse_month);
            $previous_sale = array();
                  foreach($sale as $key=>$row){ 
                          $previous_sale[$key]['date'] = $row['date'];
                          $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                          $previous_sale[$key]['previous'] = "0.00";
                      foreach ($previous_sales as $k => $v) {
                        if($row['date'] == $v['date']){
                          $previous_sale[$key]['date'] = $row['date'];
                          $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                          $previous_sale[$key]['previous'] = number_format((float)$v['total'], 2, '.', '');;
                         }
                       }
                  }
          
            $data['sales'] = json_encode($previous_sale);  
            $sales_text = array("Current Month","Previous Month");
            $data['sales_text'] = json_encode($sales_text);
            $data['total_sales'] = numberFormat($total_sales['total']);
            $data['previous_total_sales'] = numberFormat($previous_total_sales['total']);
            $data['current_text'] = "Current Month";
            $data['previous_text'] = "Previous Month";
        
        }else{
            
            $days_array = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
            $startday = date('Y-m-d',strtotime('last Monday'));    
            $finishday = date('Y-m-d',strtotime('next Sunday'));
         
            $sales = $sellOrderModel->getSalesByWeek($startday,$finishday);
            $total_sales = $sellOrderModel->getTotalSalesByWeek($startday,$finishday);

             $sale = array();
             foreach($days_array as $key=>$row){
                  $sale[$key]['date'] = $row;
                  $sale[$key]['current'] = "0.00";
                  $sale[$key]['previous'] = "0.00";
                   
                foreach ($sales as $k => $v) { 
                  if($row == $v['day_name']){
                     $sale[$key]['date'] = $row;
                     $sale[$key]['current']= number_format((float)$v['total'], 2, '.', '');
                   }
                }
            }

            $previouse_week = $this->getLastWeekDates();

            $previous_sales = $sellOrderModel->getSalesByWeek($previouse_week[0],$previouse_week[6]);
            $previous_total_sales = $sellOrderModel->getTotalSalesByWeek($previouse_week[0],$previouse_week[6]);
            $previous_sale = array();
                  foreach($sale as $key=>$row){ 
                          $previous_sale[$key]['date'] = $row['date'];
                          $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                          $previous_sale[$key]['previous'] = "0.00";
                      foreach ($previous_sales as $k => $v) {
                        if($row['date'] == $v['day_name']){
                          $previous_sale[$key]['date'] = $row['date'];
                          $previous_sale[$key]['current'] = number_format((float)$row['current'], 2, '.', '');
                          $previous_sale[$key]['previous'] = number_format((float)$v['total'], 2, '.', '');;
                         }
                       }
                  }

            
            $data['sales'] = json_encode($previous_sale);;  
            $sales_text = array("Current Week","Previous Week");
            $data['sales_text'] = json_encode($sales_text); 
            $data['total_sales'] = numberFormat($total_sales['total']);
            $data['previous_total_sales'] = numberFormat($previous_total_sales['total']);
            $data['current_text'] = "Current Week";
            $data['previous_text'] = "Previous Week";
        }   
        return json_encode(['status'=>true,'message'=>'Fetch Data successfully','data'=>$data]);
    } 
    function getInvoiceStatus($id,$due_date,$total_amt,$due_balance,$is_sent)
    {
        $today = date('Y-m-d');

        $paymentModel = new SalesPaymentModel(); 
        $payments = $paymentModel->select('SUM(amount_received) as total_sum')->where('invoice_id',$id)->first();

        $status = "Draft";
        if($is_sent == "0" || $is_sent == "1" && $payments['total_sum'] == "" && $due_balance > 0) {
            $status = "<span class='text-bold-500 grey'>Draft</span>";
        }
        else if($due_balance > 0 && $today < $due_date && $payments['total_sum'] != "") {
            $status = "<span class='text-bold-500 success'>Partially Paid</span>";
        }
        else if($due_balance > 0 && $today > $due_date) {
            $status = "<span class='text-bold-500 deep-orange'>Overdue</span>";
        }
        else{
            $status = "<span class='text-bold-500 success'>Paid</span>";
        }
        return $status;

    }
    function getLastWeekDates()
    {
        $lastWeek = array();
     
        $prevMon = abs(strtotime("previous monday"));
        $currentDate = abs(strtotime("today"));
        $seconds = 86400; //86400 seconds in a day
     
        $dayDiff = ceil( ($currentDate-$prevMon)/$seconds ); 
     
        if( $dayDiff < 7 )
        {
            $dayDiff += 1; //if it's monday the difference will be 0, thus add 1 to it
            $prevMon = strtotime( "previous monday", strtotime("-$dayDiff day") );
        }
     
        $prevMon = date("Y-m-d",$prevMon);
     
        // create the dates from Monday to Sunday
        for($i=0; $i<7; $i++)
        {
            $d = date("Y-m-d", strtotime( $prevMon." + $i day") );
            $lastWeek[]=$d;
        }
     
        return $lastWeek;
    }
    public function getGraphTopItem(){
        $post = $this->request->getVar();
        //0- Yearly
        //1- Monthly
        //2- Weekly
        $sellItemsModel = new SellItemsModel();
        $top_items = $top_items_total = [];
        
        if($post['value'] == 0){
            $year = date('Y');
            $items_data = $sellItemsModel->getSaleItemsByYear($year);
        }else if($post['value'] == 1){
            $month = date('m');
            $items_data = $sellItemsModel->getSaleItemsByMonths($month);
        }else{
            $days_array = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
            $startday = date('Y-m-d',strtotime('last Monday'));    
            $finishday = date('Y-m-d',strtotime('next Sunday'));
            $items_data = $sellItemsModel->getSaleItemsByWeek($startday,$finishday);
        }
         foreach($items_data as $row){
                $top_items[] = $row['item_name'];
                $top_items_total[] = $row['total_qty'];
        }
           
            
            $data['top_items'] = json_encode($top_items);
            $data['top_items_total'] = json_encode($top_items_total);
        
        if(!empty($top_items)){
            return json_encode(['status'=>'true','message'=>'Fetch Data successfully','data'=>$data]);
        }else{
            return json_encode(['status'=>'false','message'=>'Data Not Found']);
        }
    } 
}

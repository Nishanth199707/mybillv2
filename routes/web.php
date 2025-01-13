<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\FinancierController;
use App\Http\Controllers\FrontendLoginController;
use App\Http\Controllers\FrontLoginController;
use App\Http\Controllers\GstReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\userController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SubUserController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;

Route::post('/front-logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to home or any page after logout
})->name('front.logout');
// Route::get('/', function () {
//     return view('front.frontpage');
// });
Route::get('/', [FrontendLoginController::class, 'homepage'])->name('frontpage');
Route::get('/login', [FrontendLoginController::class, 'frontlogin'])->name('login');
// Route::get('/front/register', [FrontendLoginController::class, 'index'])->name('front.register');
Route::get('/front/login', [FrontendLoginController::class, 'frontlogin'])->name('front.login');
Route::get('/front/dashboard', [FrontendLoginController::class, 'frontdashboard'])->name('front.dashboard');

Route::get('/terms-condition', [FrontendLoginController::class, 'terms'])->name('front.terms');
Route::get('/privacy-policy', [FrontendLoginController::class, 'privacy'])->name('front.privacy');
Route::get('/refund-policy', [FrontendLoginController::class, 'refund'])->name('front.refund');

// Route::post('registerpost', [FrontendLoginController::class, 'registerpost'])->name('front.registerpost');
Route::post('loginpost', [FrontendLoginController::class, 'loginpost'])->name('front.loginpost');
Route::get('loginpartner', [PartnerController::class, 'partnerlogin'])->name('partner.login');
Route::get('registerpartner', [PartnerController::class, 'partnerregister'])->name('partner.register');
Route::post('partnersignin', [PartnerController::class, 'partnersignin'])->name('partner.signin');
Route::post('partnersignup', [PartnerController::class, 'partnersignup'])->name('partner.signup');

Route::get('/search/{gstin}', [ApiController::class, 'search']);
Route::get('/gst-auth', [ApiController::class, 'gstAuth']);
Route::middleware(['web'])->group(function () {
    Route::get('account/verify/{token}', [FrontendLoginController::class, 'verifyAccount'])->name('front.user.verify');
});


// Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
// Route::get('/', [HomeController::class, 'index'])->name('front.index');
// Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login.form');
// Route::post('/login', [LoginController::class, 'login'])->name('login');


//PAYMENT FORM
Route::get('payment', [PaymentController::class, 'index'])->name('front.payment');

//SUBMIT PAYMENT FORM ROUTE
// Route::post('pay-now', [PaymentController::class, 'submitPaymentForm'])->name('front.pay-now');
Route::match(['get', 'post'], 'pay-now', [PaymentController::class, 'submitPaymentForm'])->name('front.pay-now');

//CALLBACK ROUTE
Route::match(['get', 'post'], 'confirm', [PaymentController::class, 'confirmPayment'])->name('front.confirm');

Route::post('/check-login', [PaymentController::class, 'checkLogin'])->name('check-login');
Route::get('/front-purchase-register', [PaymentController::class, 'showRegisterForm'])->name('front_purchase_register');
Route::post('/front-purchase-register', [PaymentController::class, 'register'])->name('register.submit');
// Route::get('/front-payment', [PaymentController::class, 'showPaymentPage'])->name('payment');
// dd('hi');

Route::get('cart', [TransactionController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [TransactionController::class, 'update'])->name('update.cart');
Route::delete('remove-from-cart', [TransactionController::class, 'remove'])->name('remove.from.cart');
Route::post('/saregisterpost', [FrontLoginController::class, 'registerpost'])->name('sadamin.saregisterpost');

Route::post('request-otp', [FrontLoginController::class, 'sendOtp'])->name('request.otp');


Route::prefix('wp-admin')->group(function () {
    Route::post('/saregisterpost', [FrontLoginController::class, 'registerpost'])->name('sadamin.saregisterpost');

    Route::get('/salogin', [SuperAdminController::class, 'salogin'])->name('sadamin.login');
    Route::post('/saloginpost', [SuperAdminController::class, 'saloginpost'])->name('sadamin.saloginpost');

    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('sa.home');
        } else {
            return view('saauth.login');
        }
    });

    Route::middleware('superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'superadminHome'])->name('sa.home');
        Route::get('/saregister', [SuperAdminController::class, 'saregister'])->name('sadamin.register');
        Route::get('/sausers', [SuperAdminController::class, 'sausers'])->name('sadamin.user');
        Route::resource('plans', PlanController::class);
        Route::post('/sausers/{id}/status', [SuperAdminController::class, 'updateStatus'])->name('sadamin.updateStatus');
        Route::post('/salogout', [SuperAdminController::class, 'salogout'])->name('sadamin.logout')->middleware('clear.all');
    });
});




Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::get('/example', function () {
    return 'Example route';
});

Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'user-access:admin', 'is_verify_email'])->group(function () {

    // Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    Route::get('/superadmin/home', [HomeController::class, 'superadminHome'])->name('superadmin.home');
    Route::resource('/superadmin/business', BusinessController::class);
    // Route::resource('/superadmin/users', UserController::class);
    Route::get('/superadmin/users/', [UserController::class, 'index'])->name('users.index');
    Route::resource('/superadmin/productcategory', ProductCategoryController::class);
    Route::resource('/superadmin/product', ProductController::class);
    Route::resource('/superadmin/party', PartyController::class);
    Route::resource('/superadmin/sale', SaleController::class);
    Route::resource('/superadmin/purchase', PurchaseController::class);
    Route::resource('/superadmin/gstreport', GstReportController::class);
    // Route::get('/superadmin/sale/invoice', [SaleController::class, 'showdata'])->name('sale.invoice');
    Route::get('autocomplete', [SaleController::class, 'autocomplete'])->name('autocomplete');
    Route::get('purchaseautocomplete', [PurchaseController::class, 'purchaseautocomplete'])->name('purchaseautocomplete');
    Route::get('partyautocomplete', [PartyController::class, 'partyautocomplete'])->name('partyautocomplete');

    Route::post('/superadmin/product/ajaxsave', [ProductController::class, 'storeAjax'])->name('product.ajaxsave');
    Route::post('/superadmin/party/ajaxsave', [PartyController::class, 'ajaxstore'])->name('party.ajaxsave');
    // Route::get('/superadmin/invoice/{invoice_id}', [SaleController::class, 'invoice'])->name('invoice');
    Route::get('gst-export', [GstReportController::class, 'export'])->name('gst.export');

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('clear.all');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:manager'])->group(function () {

    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:superadmin', 'is_verify_email'])->group(function () {
    Route::post('superadmin/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('superadmin.logout')->middleware('clear.all');

    Route::get('/subscription/expired', [App\Http\Controllers\Auth\LoginController::class, 'expired'])->name('subscription.expired');
    Route::get('/pricing', function () {

        $plan = Plan::all();
        return view('front.payment_home', compact('plan'));
    })->name('pricing');


    Route::get('/superadmin/home', [HomeController::class, 'superadminHome'])->name('superadmin.home');
    Route::resource('/superadmin/business', BusinessController::class);
    Route::get('/superadmin/myprofile', [BusinessController::class, 'indexshow'])->name('business.indexshow');
    Route::resource('/superadmin/users', UserController::class);
    Route::get('/superadmin/settings', [BusinessController::class, 'ebillsettings'])->name('ebill.settings');
    Route::get('/superadmin/users/', [UserController::class, 'index'])->name('users.index');
    Route::resource('/superadmin/productcategory', ProductCategoryController::class);
    Route::resource('/superadmin/productsubcategory', ProductSubCategoryController::class);
    Route::get('productsubcategory', [ProductController::class, 'getSubcategories'])->name('productsubcategory.index');
    Route::get('productcategory', [ProductController::class, 'getCategories'])->name('productcategory.index');
    Route::get('/productsubcategory', [ProductSubCategoryController::class, 'subcategoryindex'])->name('productsubcategory.subcategoryindex');
    Route::get('/productcategory', [ProductCategoryController::class, 'categoryindex'])->name('productcategory.categoryindex');

    Route::resource('/superadmin/product', ProductController::class);
    Route::get('/get-brands/{categoryId}', [ProductController::class, 'getBrandsByCategory']);

    Route::resource('/superadmin/party', PartyController::class);
    Route::post('/superadmin/party/ajax', [PartyController::class, 'partypayment'])->name('partypayment.ajaxsave');
    Route::get('/superadmin/receivepayment', [PartyController::class, 'receivePayment'])->name('partypayment.receivePayment');
    Route::get('/superadmin/addpayment', [PartyController::class, 'addPayment'])->name('partypayment.addPayment');
    Route::get('/superadmin/viewreceipt', [PartyController::class, 'viewReceipt'])->name('payment.receipt');
    Route::get('/superadmin/viewpayment', [PartyController::class, 'viewPayment'])->name('payment.payment');
    Route::get('/superadmin/viewCheque', [PartyController::class, 'viewCheque'])->name('payment.cheque');

    Route::post('/party/filter/transactions/{party}', [PartyController::class, 'filterTransactions'])->name('party.filter.transactions');
    Route::post('/party/filter/ledger/{party}', [PartyController::class, 'filterLedger'])->name('party.filter.ledger');
    Route::post('/superadmin/payments/{id}', [PartyController::class, 'paymentdestroy'])->name('payments.paydestroy');

    Route::resource('/superadmin/sale', SaleController::class);
    Route::get('/sales/cash-received-ledger', [SaleController::class, 'cashReceivedLedger'])->name('sales.cash_received_ledger');
    Route::get('/BankLedger', [SaleController::class, 'bankLedger'])->name('sales.bankLedger');


    Route::resource('/superadmin/salereturns', SaleReturnController::class);
    Route::resource('/superadmin/purchase', PurchaseController::class);
    Route::resource('/superadmin/purchasereturns', PurchaseReturnController::class);

    Route::resource('/superadmin/quotations', QuotationController::class);
    Route::get('/expense/index', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('/superadmin/expense', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/superadmin/store', [ExpenseController::class, 'store'])->name('expense.store');

    Route::get('/superadmin/category', [ExpenseController::class, 'category'])->name('expense.category');
    Route::post('/expense/store', [ExpenseController::class, 'categorystore'])->name('expensecategory.store');
    Route::post('/expense/distroy', [ExpenseController::class, 'categorydestroy'])->name('expensecategory.distroy');
    Route::get('/expense/categoryedit/{id}', [ExpenseController::class, 'categoryedit'])->name('expense.categoryedit');
    Route::get('/expense/view/{id}', [ExpenseController::class, 'view'])->name('expense.view');
    Route::get('/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::get('/expense/delete/{id}', [ExpenseController::class, 'delete'])->name('expense.delete');
    Route::post('/expense/update', [ExpenseController::class, 'update'])->name('expense.update');
    // Route::get('/report/profit', [ExpenseController::class, 'profit_report'])->name('expense.profit');
    Route::resource('repairs', RepairController::class);
    Route::get('/cash-received', [RepairController::class, 'cashReceived'])->name('repairs.cashReceived');
    Route::get('repairs/{repair}/bill', [RepairController::class, 'showBill'])->name('repairs.bill');
    Route::post('/repairs/{id}/update_status', [RepairController::class, 'updateStatus']);

    Route::resource('/superadmin/financiers', FinancierController::class);
    Route::put('/emi-received/{id}', [FinancierController::class, 'updateStatus'])->name('emi-received.update');

    Route::get('/superadmin/financiers/', [FinancierController::class, 'index'])->name('financiers.index');
    Route::post('/superadmin/financiers/ajaxsave', [FinancierController::class, 'ajaxstore'])->name('financiers.ajaxsave');

    Route::get('fetch-financiers', [FinancierController::class, 'fetchfinanciers']);

    Route::get('/superadmin/salereturn', [SaleController::class, 'salesreturnindex'])->name('salesreturn.index');
    Route::get('/superadmin/salereturn/store', [SaleController::class, 'salereturnstore'])->name('salesreturn.store');

    Route::get('/superadmin/purchasereturn', [PurchaseController::class, 'purchasereturnindex'])->name('purchasereturn.index');
    // Route::get('/superadmin/purchasereturn', [PurchaseController::class,'purchasereturnstore'])->name('purchasereturn.store');

    // Route::resource('/superadmin/gstreport', GstReportController::class);
    Route::get('/superadmin/salereport', [GstReportController::class, 'salereport'])->name('sale.gstreport');
    Route::get('/superadmin/purchasereport', [GstReportController::class, 'purchasereport'])->name('purchase.gstreport');
    Route::get('/superadmin/stockreport', [GstReportController::class, 'stockreport'])->name('stock.gstreport');

    Route::get('gst-sale-export', [GstReportController::class, 'saleexport'])->name('gst.salereport');
    Route::get('gst-purchase-export', [GstReportController::class, 'purchaseexport'])->name('gst.purchasereport');
    Route::get('gst-stock-export', [GstReportController::class, 'stockexport'])->name('gst.stockreport');
    Route::get('party-export', [GstReportController::class, 'partyexport'])->name('gst.Partyreport');
    Route::get('service-export', [GstReportController::class, 'serviceexport'])->name('gst.Servicereport');
    Route::get('/export/stock-pdf', [GstReportController::class, 'generatePdf'])->name('stock.pdf.export');

    // Route::get('/superadmin/sale/invoice', [SaleController::class, 'showdata'])->name('sale.invoice');
    Route::get('autocomplete', [SaleController::class, 'autocomplete'])->name('autocomplete');
    Route::get('partyautocomplete', [PartyController::class, 'partyautocomplete'])->name('partyautocomplete');
    Route::get('purchaseautocomplete', [PurchaseController::class, 'purchaseautocomplete'])->name('purchaseautocomplete');

    Route::post('/superadmin/product/ajaxsave', [ProductController::class, 'storeAjax'])->name('product.ajaxsave');
    Route::post('/superadmin/party/ajaxsave', [PartyController::class, 'ajaxstore'])->name('party.ajaxsave');
    // Route::get('/superadmin/invoice/{invoice_id}', [SaleController::class, 'invoice'])->name('invoice');
    Route::get('gst-export', [GstReportController::class, 'export'])->name('gst.export');

    // API CALL

    // Route::get('/search', [ApiController::class, 'search']);
    Route::resource('settings', SettingController::class);

    // Sub-User Management Routes
    Route::group(['prefix' => 'subusers', 'as' => 'subusers.'], function () {
        Route::get('/', [SubUserController::class, 'index'])->name('index');
        Route::get('/create', [SubUserController::class, 'create'])->name('create');
        Route::post('/', [SubUserController::class, 'store'])->name('store');
        Route::get('/{subuser}/edit', [SubUserController::class, 'edit'])->name('edit');
        Route::put('/{subuser}', [SubUserController::class, 'update'])->name('update');
        Route::delete('/{subuser}', [SubUserController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'user-access:partner'])->group(function () {
    Route::post('/logout', [PartnerController::class, 'logout'])->name('logout')->middleware('clear.all');

    Route::get('/partner/home', [PartnerController::class, 'PartnerHome'])->name('partner.home');
    Route::get('/DSC', [PartnerController::class, 'Dsc'])->name('partner.dsc');
});

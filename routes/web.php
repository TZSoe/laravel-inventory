<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\UnitController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\PurchaseController;
use App\Http\Controllers\Pos\InvoiceController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\StockController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});


 // Admin All Route 
Route::controller(AdminController::class)->middleware('auth')->group(function () {
    Route::get('/logout', 'destroy')->name('admin.logout');
    Route::get('/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');
     
});


Route::controller(SupplierController::class)->middleware('auth')->group(function () {
    Route::get('/supplier/all', 'allSupplier')->name('supplier.all');
    Route::get('/supplier/create', 'createSupplier')->name('supplier.create');
    Route::post('/supplier/store', 'storeSupplier')->name('supplier.store');

    Route::get('/supplier/edit/{supplier}', 'editSupplier')->name('supplier.edit');
    Route::put('/supplier/edit/{supplier}', 'updateSupplier')->name('supplier.update');

    Route::get('/supplier/delete/{supplier}', 'deleteSupplier')->name('supplier.delete');
});


Route::controller(CustomerController::class)->middleware('auth')->group(function () {
    Route::get('/customer/all', 'allCustomers')->name('customer.all');
    Route::get('/customer/create', 'createCustomer')->name('customer.create');
    Route::post('/customer/store', 'storeCustomer')->name('customer.store');

    Route::get('/customer/edit/{customer}', 'editCustomer')->name('customer.edit');
    Route::put('/customer/edit/{customer}', 'updateCustomer')->name('customer.update');

    Route::get('/customer/delete/{customer}', 'deleteCustomer')->name('customer.delete');

    Route::get('/customer/credit', 'creditCustomers')->name('customer.credit');
    Route::get('/customer/credit/print', 'printCreditCustomers')->name('customer.credit.print');

    Route::get('/customer/invoice/edit/{invoice}', 'customerEditInvoice')->name('customer.edit.invoice');
    Route::post('/customer/invoice/update/{invoice}', 'customerUpdateInvoice')->name('customer.update.invoice');

    Route::get('/customer/invoice/details/{invoice}', 'customerInvoiceDetailsPdf')->name('customer.invoice.details.pdf');

    Route::get('/paid/customer', 'paidCustomer')->name('paid.customer');
    Route::get('/paid/customer/print/pdf', 'paidCustomerPrintPdf')->name('paid.customer.print.pdf');


    Route::get('/customer/wise/report', 'customerWiseReport')->name('customer.wise.report');
    Route::get('/customer/wise/credit/report', 'customerWiseCreditReport')->name('customer.wise.credit.report');
    Route::get('/customer/wise/paid/report', 'customerWisePaidReport')->name('customer.wise.paid.report');
});


Route::controller(UnitController::class)->middleware('auth')->group(function () {
    Route::get('/unit/all', 'allUnits')->name('unit.all');

    Route::get('/unit/create', 'createUnit')->name('unit.create');
    Route::post('/unit/store', 'storeUnit')->name('unit.store');

    Route::get('/unit/edit/{unit}', 'editUnit')->name('unit.edit');
    Route::put('/unit/edit/{unit}', 'updateUnit')->name('unit.update');

    Route::get('/unit/delete/{unit}', 'deleteUnit')->name('unit.delete');
});

Route::controller(CategoryController::class)->middleware('auth')->group(function () {
    Route::get('/category/all', 'allCategories')->name('category.all');

    Route::get('/category/create', 'createCategory')->name('category.create');
    Route::post('/category/store', 'storeCategory')->name('category.store');

    Route::get('/category/edit/{category}', 'editCategory')->name('category.edit');
    Route::put('/category/edit/{category}', 'updateCategory')->name('category.update');

    Route::get('/category/delete/{category}', 'deleteCategory')->name('category.delete');
});


Route::controller(ProductController::class)->middleware('auth')->group(function () {
    Route::get('/product/all', 'allProducts')->name('product.all');

    Route::get('/product/create', 'createProduct')->name('product.create');
    Route::post('/product/store', 'storeProduct')->name('product.store');

    Route::get('/product/edit/{product}', 'editProduct')->name('product.edit');
    Route::put('/product/edit/{product}', 'updateProduct')->name('product.update');

    Route::get('/product/delete/{product}', 'deleteProduct')->name('product.delete');
});

Route::controller(PurchaseController::class)->middleware('auth')->group(function () {
    Route::get('/purchase/all', 'allPurchases')->name('purchase.all');

    Route::get('/purchase/create', 'createPurchase')->name('purchase.create');
    Route::post('/purchase/store', 'storePurchase')->name('purchase.store');

    Route::get('/purchase/delete/{purchase}', 'deletePurchase')->name('purchase.delete');
    Route::get('/purchase/pending', 'pendingPurchases')->name('purchase.pending');
    Route::get('/purchase/approve/{purchase}', 'approvePurchase')->name('purchase.approve');

    Route::get('/purchase/daily/report', 'dailyPurchaseReport')->name('purchase.report.daily');
    Route::get('/purchase/daily/report/pdf', 'dailyPurchaseReportPdf')->name('purchase.daily.pdf');


});


Route::controller(InvoiceController::class)->middleware('auth')->group(function () {
    Route::get('/invoice/all', 'allInvoices')->name('invoice.all');

    Route::get('/invoice/create', 'createInvoice')->name('invoice.create');
    Route::post('/invoice/store', 'storeInvoice')->name('invoice.store');

    Route::get('/invoice/delete/{invoice}', 'deleteInvoice')->name('invoice.delete');
    Route::get('/invoice/pending', 'pendingInvoices')->name('invoice.pending');
    Route::get('/invoice/approve/{invoice}', 'approveInvoice')->name('invoice.approve');
    Route::post('/invoice/approve/{invoice}', 'storeInvoiceApprove')->name('invoice.approve.store');

    Route::get('/invoice/print/list', 'printInvoiceList')->name('invoice.print.list');
    Route::get('/invoice/print/{invoice}', 'printInvoice')->name('invoice.print');

    Route::get('/invoice/daily/report', 'dailyInvoiceReport')->name('invoice.daily.report');
    Route::get('/invoice/daily/pdf', 'dailyInvoicePdf')->name('invoice.daily.pdf');
});

Route::controller(StockController::class)->middleware('auth')->group(function(){
    Route::get('/stock/report', 'stockReport')->name('stock.report');
    Route::get('/stock/report/pdf', 'stockReportPdf')->name('stock.report.pdf');

    Route::get('/stock/supplier/wise', 'stockSupplierWise')->name('stock.supplier.wise');
    Route::get('/stock/supplier/wise/pdf', 'stockSupplierWisePdf')->name('stock.supplier.wise.pdf');

    Route::get('/stock/product/wise/pdf', 'stockProductWisePdf')->name('stock.product.wise.pdf');
});

Route::controller(DefaultController::class)->middleware('auth')->group(function(){
    Route::get('/get-category', 'getCategory')->name('get-category');
    Route::get('/get-product', 'getProduct')->name('get-product');
    Route::get('/get-product-stock', 'getStock')->name('get-product-stock');
});


Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });

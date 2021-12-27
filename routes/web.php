<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  Route::get('/','FrontendController@index')->name('front.index');
  Route::get('/products','FrontendController@products')->name('front.products');
  Route::get('/product/{id}','FrontendController@product')->name('front.product');
  Route::get('/our-services','FrontendController@services')->name('front.services');
  Route::get('/service/{id}','FrontendController@service')->name('front.service');
  Route::get('/products-by-id', 'FrontendController@productsById')->name('all-products-by-id');
  Route::get('/handymanproducts-by-id', 'FrontendController@handymanproductsById');
  Route::get('/products-model-number-by-model', 'FrontendController@productsModelNumberByModel')->name('all-products-model-number-by-model');
  Route::get('/products-models-by-brands', 'FrontendController@productsModelsByBrands')->name('all-products-models-by-brands');
  Route::get('/products-brands-by-category', 'FrontendController@productsBrandsByCategory')->name('all-products-brands-by-category');
  Route::get('/products-data-by-category', 'FrontendController@productsDataByCategory')->name('all-products-data-by-category');
  Route::get('/account-products-models-by-brands', 'FrontendController@accountProductsModelsByBrands')->name('products-models-by-brands');
  Route::get('/account-products-brands-by-category', 'FrontendController@accountProductsBrandsByCategory')->name('products-brands-by-category');
  Route::get('/get-questions','FrontendController@GetQuestions');
  Route::get('/get-service-questions','FrontendController@GetServiceQuestions');
  Route::get('/thankyou/{id}','FrontendController@Thankyou');
  Route::get('/thankyou-page/{id}','FrontendController@ThankyouPage');
  Route::post('/lang-change','FrontendController@LanguageChange')->name('lang.change');
  Route::post('/lang-client-change','FrontendController@LanguageClientChange')->name('lang.clientchange');
  Route::post('/lang-handyman-change','FrontendController@LanguageHandymanChange')->name('lang.handymanchange');
  Route::get('/cart','FrontendController@Cart')->name('cart');
  Route::post('/update-rate','FrontendController@UpdateRate');
  Route::post('/delete-cart','FrontendController@DeleteCart');
  Route::get('/services', 'UserController@Services');
  Route::get('/get-quotation-data', 'UserController@GetQuotationData');
  Route::get('/sub-services', 'UserController@SubServices');
  Route::get('/get-id', 'UserController@GetID');
  Route::get('/user-services', 'UserController@UserServices');
  Route::get('/user-subservices', 'UserController@UserSubServices');
  Route::get('/payment-mollie','CategoryController@preparePayment')->name('payment-mollie');
  Route::name('webhooks.mollie')->post('webhooks/mollie', 'MollieWebhookController@handle');
  Route::name('webhooks.first')->post('/mollie', 'MollieFirstPayment@handle');
  Route::name('webhooks.last')->post('/mollie1', 'MollieLastPayment@handle');
  Route::name('webhooks.quotation_payment')->post('/webhooks/quotation_payment', 'MollieQuotationPaymentController@handle');
  Route::get('/handymans','FrontendController@users')->name('front.users');
  Route::get('/handymans/featured','FrontendController@featured')->name('front.featured');
  Route::get('/handyman-profile/{id}','FrontendController@user')->name('front.user');
  Route::get('/category/{slug}','FrontendController@types')->name('front.types');
  Route::get('/handymans/search/','FrontendController@search')->name('user.search');
  Route::post('/quote','FrontendController@quote')->name('user.quote');
  Route::post('/handymans/filter/','FrontendController@FilterHandymans')->name('filter-handymans');
  Route::get('/veel-gestelde-vragen','FrontendController@faq')->name('front.faq');
  Route::get('/ads/{id}','FrontendController@ads')->name('front.ads');
  Route::get('/over-ons','FrontendController@about')->name('front.about');
  Route::get('/contact','FrontendController@contact')->name('front.contact');
  Route::get('/blog','FrontendController@blog')->name('front.blog');
  Route::get('/blog/{id}','FrontendController@blogshow')->name('front.blogshow');
  Route::post('/contact','FrontendController@contactemail')->name('front.contact.submit');
  Route::post('/subscribe','FrontendController@subscribe')->name('front.subscribe.submit');
  Route::post('/aanbieder/contact','FrontendController@useremail')->name('front.user.submit');
  Route::get('/aanbieder/refresh_code','FrontendController@refresh_code');
  Route::get('/login', 'Auth\UserLoginController@showLoginForm')->name('user-login');
  Route::post('/login', 'Auth\UserLoginController@login')->name('user-login-submit');
  Route::get('/logout', 'Auth\UserLoginController@logout')->name('user-logout');
  Route::get('/compress-images','UserController@compress_image');


  Route::prefix('aanbieder')->group(function() {

  Route::get('/new-quotations', 'UserController@NewQuotations')->name('new-quotations');
  Route::get('/new-orders', 'UserController@NewOrders')->name('new-orders');
  Route::get('/new-invoices', 'UserController@NewInvoices')->name('new-invoices');
  Route::get('/edit-new-quotation/{id}', 'UserController@EditNewQuotation');
  Route::get('/download-new-quotation/{id}', 'UserController@DownloadNewQuotation');
  Route::get('/download-invoice-pdf/{id}', 'UserController@DownloadInvoicePDF');
  Route::get('/download-order-pdf/{id}', 'UserController@DownloadOrderPDF');
  Route::get('/download-order-confirmation-pdf/{id}', 'UserController@DownloadOrderConfirmationPDF');
  Route::get('/offerte-type', 'UserController@SelectQuotationsType')->name('select-quotations-type');
  Route::get('/facturen-type', 'UserController@SelectInvoicesType')->name('select-invoices-type');
  Route::get('/offerte/binnen-zonwering', 'UserController@CreateNewQuotation')->name('create-new-quotation');
  Route::post('/store-new-quotation', 'UserController@StoreNewQuotation')->name('store-new-quotation');
  Route::get('/get-supplier-products', 'UserController@GetSupplierProducts');
  Route::get('/get-colors', 'UserController@GetColors');
  Route::get('/get-price', 'UserController@GetPrice');
  Route::get('/get-feature-price', 'UserController@GetFeaturePrice');
  Route::get('/get-sub-products-sizes', 'UserController@GetSubProductsSizes');
  Route::get('/klanten', 'UserController@Customers')->name('customers');
  Route::get('/klant-bewerken/{id}', 'UserController@EditCustomer')->name('edit-customer');
  Route::get('/klant-verwijderen/{id}', 'UserController@DeleteCustomer')->name('delete-customer');
  Route::post('/klanten','UserController@PostCustomer')->name('post-create-customer');
  Route::get('/employee-permissions/{id}', 'UserController@EmployeePermissions')->name('employee-permissions');
  Route::post('/employee-permission-store', 'UserController@EmployeePermissionStore')->name('employee-permission-store');
  Route::get('/employees', 'UserController@Employees')->name('employees');
  Route::get('/employee-create', 'UserController@CreateEmployeeForm')->name('employee-create');
  Route::post('/employee-create','UserController@PostEmployee')->name('post-create-employee');
  Route::get('/edit-employee/{id}', 'UserController@EditEmployee')->name('edit-employee');
  Route::get('/delete-employee/{id}', 'UserController@DeleteEmployee')->name('delete-employee');
  Route::get('/klant-aanmaken', 'UserController@CreateCustomerForm')->name('handyman-user-create');
  Route::get('/handleiding','UserController@InstructionManual')->name('instruction-manual');
  Route::post('/create-customer','UserController@CreateCustomer');
  Route::get('/get-customer-email','UserController@GetCustomerEmail');
  Route::get('/email-templates','UserController@EmailTemplates')->name('email-templates');
  Route::post('/save-email-template','UserController@SaveEmailTemplate')->name('save-email-template');
  Route::get('/aanvrager-offerte/{id?}', 'UserController@CustomerQuotations')->name('customer-quotations');
  Route::get('/aanvrager-facturen/{id?}', 'UserController@CustomerInvoices')->name('customer-invoices');
  Route::get('/offerte/vloeren', 'UserController@HandymanCreateQuote')->name('create-custom-quotation');
  Route::get('/aanbieder-opstellen-directe-verkoopfactuur', 'UserController@HandymanCreateQuote')->name('create-direct-invoice');
  Route::post('/opstellen-eigen-offerte', 'UserController@StoreCustomQuotation')->name('store-custom-quotation');
  Route::post('/create-direct-invoice', 'UserController@StoreCustomQuotation')->name('store-direct-invoice');
  Route::get('/quotation-requests', 'UserController@QuotationRequests')->name('client-quotation-requests');
  Route::get('/aanbieder-offerte-aanvragen', 'UserController@HandymanQuotationRequests')->name('handyman-quotation-requests');
  Route::get('/aanbieder-offertes/{id?}', 'UserController@HandymanQuotations')->name('quotations');
  Route::get('/aanbieder-verkoopfacturen/{id?}', 'UserController@HandymanQuotationsInvoices')->name('quotations-invoices');
  Route::get('/aanbieder-commissiefacturen/{id?}', 'UserController@HandymanQuotationsInvoices')->name('commission-invoices');
  Route::get('/offertes/{id?}', 'UserController@Quotations')->name('client-quotations');
  Route::get('/client-new-quotations', 'UserController@ClientNewQuotations')->name('client-new-quotations');
  Route::get('/download-client-new-quotation/{id}', 'UserController@DownloadClientNewQuotation');
  Route::get('/Offerte-op-maat/{id?}', 'UserController@CustomQuotations')->name('client-custom-quotations');
  Route::get('/Offerte-verkoopfactuur/{id?}', 'UserController@QuotationsInvoices')->name('client-quotations-invoices');
  Route::get('/bekijk-offerte-aanvraag/{id}', 'UserController@QuoteRequest');
  Route::get('/download-quote-request/{id}', 'UserController@DownloadQuoteRequest');
  Route::get('/download-quote-invoice/{id}', 'UserController@DownloadQuoteInvoice');
  Route::get('/download-commission-invoice/{id}', 'UserController@DownloadCommissionInvoice');
  Route::get('/download-custom-quotation/{id}', 'UserController@DownloadCustomQuotation');
  Route::get('/download-client-quote-invoice/{id}', 'UserController@DownloadClientQuoteInvoice');
  Route::get('/download-client-custom-quotation/{id}', 'UserController@DownloadClientCustomQuoteInvoice');
  Route::post('/ask-customization', 'UserController@AskCustomization');
  Route::post('/accept-quotation', 'UserController@AcceptQuotation');
  Route::post('/pay-quotation', 'UserController@PayQuotation');
  Route::get('/quotation-payment-redirect-page/{id}', 'FrontendController@QuotationPaymentRedirectPage');
  Route::get('/versturen-eigen-offerte/{id}', 'UserController@SendCustomQuotation');
  Route::post('/send-new-quotation', 'UserController@SendNewQuotation')->name('send-new-quotation');
  Route::post('/send-order', 'UserController@SendOrder')->name('send-new-order');
  Route::get('/change-delivery-dates/{id}', 'UserController@ChangeDeliveryDates');
  Route::get('/supplier-order-delivered/{id}', 'UserController@SupplierOrderDelivered');
  Route::get('/retailer-mark-delivered/{id}', 'UserController@RetailerMarkDelivered');
  Route::get('/create-new-invoice/{id}', 'UserController@CreateNewInvoice');
  Route::post('/change-delivery-dates', 'UserController@UpdateDeliveryDates')->name('change-delivery-date');
  Route::post('/aangepaste-offerte/ask-customization', 'UserController@CustomQuotationAskCustomization');
  Route::get('/eigen-offerte/accepteren-offerte/{id}', 'UserController@CustomQuotationAcceptQuotation');
  Route::get('/accept-new-quotation/{id}', 'UserController@AcceptNewQuotation');
  Route::get('/accept-new-quotation-mail/{id}', 'UserController@AcceptNewQuotationMail')->name('accept-new-quotation-mail');
  Route::post('/send-invoice', 'UserController@SendInvoice')->name('send-new-invoice');
  Route::get('/bekijk-offerteaanvraag-aanbieder/{id}', 'UserController@HandymanQuoteRequest');
  Route::get('/download-handyman-quote-request/{id}', 'UserController@DownloadHandymanQuoteRequest');
  Route::get('/opstellen-offerte/{id}', 'UserController@CreateQuotation');
  Route::post('/opstellen-offerte', 'UserController@StoreQuotation')->name('store-quotation');
  Route::post('/update-quotation', 'UserController@StoreQuotation')->name('update-quotation');
  Route::post('/update-custom-quotation', 'UserController@StoreCustomQuotation')->name('update-custom-quotation');
  Route::post('/opstellen-factuur', 'UserController@StoreQuotation')->name('create-invoice');
  Route::post('/opstellen-eigen-factuur', 'UserController@StoreCustomQuotation')->name('post-custom-invoice');
  Route::get('/bekijk-offerte/{id}', 'UserController@ViewQuotation')->name('view-handyman-quotation');
  Route::get('/bekijk-eigen-offerte/{id}', 'UserController@ViewCustomQuotation')->name('view-custom-quotation');
  Route::get('/bewerk-offerte/{id}', 'UserController@ViewQuotation')->name('edit-handyman-quotation');
  Route::get('/bewerk-eigen-offerte/{id}', 'UserController@ViewCustomQuotation')->name('edit-custom-quotation');
  Route::get('/opstellen-factuur/{id}', 'UserController@ViewQuotation')->name('create-handyman-invoice');
  Route::get('/opstellen-eigen-factuur/{id}', 'UserController@ViewCustomQuotation')->name('create-custom-invoice');
  Route::get('/offerte/{id}', 'UserController@ViewClientQuotation')->name('view-client-quotation');
  Route::get('/aangepaste-offerte/{id}', 'UserController@ViewClientCustomQuotation')->name('view-client-custom-quotation');
  Route::get('/handyman-panel', 'UserController@HandymanPanel')->name('handyman-panel');
  Route::get('/dashboard', 'UserController@index')->name('user-dashboard');
  Route::get('/experience-years', 'UserController@ExperienceYears')->name('experience-years');
  Route::post('/post-experience-years', 'UserController@PostExperienceYears')->name('post-experience-years');

  Route::post('/insurance-upload', 'UserController@InsuranceUpload')->name('insurance-upload');

  Route::get('/insurance', 'UserController@Insurance')->name('insurance');
  Route::get('/ratings', 'UserController@Ratings')->name('ratings');
  Route::get('/client-dashboard', 'UserController@ClientIndex')->name('client-dashboard');
  Route::get('/handyman-bookings', 'UserController@HandymanBookings')->name('handyman-bookings');
  Route::get('/purchased-bookings', 'UserController@PurchasedBookings')->name('purchased-bookings');
  Route::get('/client-bookings', 'UserController@ClientBookings')->name('client-bookings');
  Route::get('/reset', 'UserController@resetform')->name('user-reset');
  Route::post('/reset', 'UserController@reset')->name('user-reset-submit');
  Route::get('/profile', 'UserController@profile')->name('user-profile');
  Route::get('/retailer-company-info', 'UserController@profile')->name('retailer-company-info');
  Route::get('/availability-manager', 'UserController@AvailabilityManager')->name('user-availability');
  Route::get('/radius-management', 'UserController@RadiusManagement')->name('radius-management');
  Route::get('/client-profile', 'UserController@ClientProfile')->name('client-profile');
  Route::get('/my-products', 'UserController@MyProducts')->name('user-products');
  Route::get('/product-create', 'UserController@MyProducts')->name('product-create');
  Route::post('/product-store', 'UserController@ProductStore')->name('product-store');
  Route::get('/product-edit/{id}', 'UserController@ProductEdit')->name('product-edit');
  Route::get('/product-delete/{id}', 'UserController@ProductDelete')->name('product-delete');
  Route::get('/product-details', 'UserController@ProductDetails');
  Route::get('/my-services', 'UserController@MyServices')->name('my-services');
  Route::get('/service-create', 'UserController@MyServices')->name('service-create');
  Route::post('/service-store', 'UserController@ServiceStore')->name('service-store');
  Route::get('/service-edit/{id}', 'UserController@ServiceEdit')->name('service-edit');
  Route::get('/service-delete/{id}', 'UserController@ServiceDelete')->name('service-delete');
  Route::get('/my-items', 'UserController@MyItems')->name('user-items');
  Route::get('/create-item', 'UserController@CreateItem')->name('create-item');
  Route::post('/store-item', 'UserController@StoreItem')->name('store-item');
  Route::get('/edit-item/{id}', 'UserController@EditItem')->name('edit-item');
  Route::post('/update-item/{id}', 'UserController@UpdateItem')->name('update-item');
  Route::get('/delete-item/{id}', 'UserController@DestroyItem')->name('delete-item');
  Route::get('/my-subservices', 'UserController@MySubServices')->name('user-subservices');
  Route::get('/delete-services', 'UserController@DeleteServices');
  Route::get('/delete-subservices', 'UserController@DeleteSubServices');
  Route::post('/profile-update', 'UserController@TemporaryProfileUpdate')->name('user-temp-profile-update');
  Route::post('/profile', 'UserController@profileupdate')->name('user-profile-update');
  Route::post('/availability-manager', 'UserController@AvailabilityUpdate')->name('user-availability-update');
  Route::post('/radius-manager', 'UserController@RadiusUpdate')->name('user-radius-update');
  Route::post('/client-profile-update', 'UserController@ClientProfileUpdate')->name('client-profile-update');
  Route::post('/my-services-update', 'UserController@MyServicesUpdate')->name('user-services-update');
  Route::post('/my-subservices-update', 'UserController@MySubServicesUpdate')->name('user-subservices-update');
  Route::post('/complete-profile', 'UserController@CompleteProfileUpdate')->name('user-complete-profile-update');
  Route::get('/forgot', 'Auth\UserForgotController@showforgotform')->name('user-forgot');
  Route::post('/forgot', 'Auth\UserForgotController@forgot')->name('user-forgot-submit');
  Route::get('/register', 'Auth\UserRegisterController@showRegisterForm')->name('user-register');
  Route::get('/complete-profile', 'UserController@CompleteProfile')->name('user-complete-profile');
  Route::get('/registreren-aanbieder', 'Auth\UserRegisterController@showHandymanRegisterForm')->name('handyman-register');
  Route::post('/register', 'Auth\UserRegisterController@register')->name('user-register-submit');
  Route::post('/aanbieder-registreren', 'Auth\UserRegisterController@HandymanRegister')->name('handyman-register-submit');
  Route::post('/aanbieder-status-update', 'UserController@HandymanStatusUpdate')->name('handyman-status-update');
  Route::post('/client-status-update', 'UserController@ClientStatusUpdate')->name('client-status-update');
  Route::post('/add-cart', 'UserController@AddCart')->name('add-cart');
  Route::post('/book-handyman', 'UserController@BookHandyman')->name('book-handyman');

  Route::get('/invoice/{id}', 'UserController@Invoice');
  Route::get('/cancelled-invoice/{id}', 'UserController@CancelledInvoice');
  Route::get('/view-images/{id}', 'UserController@Images');


  Route::post('/payment', 'PaymentController@store')->name('payment.submit');
  Route::get('/payment/cancle', 'PaymentController@paycancle')->name('payment.cancle');
  Route::get('/payment/return', 'PaymentController@payreturn')->name('payment.return');

  Route::get('/publish', 'UserController@publish')->name('user-publish');
  Route::get('/feature', 'UserController@feature')->name('user-feature');
  Route::get('/mark-delivered/{id}', 'UserController@MarkDelivered');
  Route::get('/mark-received/{id}', 'UserController@MarkReceived');


  Route::get('/custom-mark-delivered/{id}', 'UserController@CustomMarkDelivered');
  Route::get('/custom-mark-received/{id}', 'UserController@CustomMarkReceived');

  Route::get('/products', 'ProductController@index')->name('admin-product-index');
  Route::get('/product/create', 'ProductController@create')->name('admin-product-create');
  Route::get('/product/import', 'ProductController@import')->name('admin-product-import');
  Route::post('/product/upload', 'ProductController@PostImport')->name('admin-product-upload');
  Route::get('/product/export', 'ProductController@PostExport')->name('admin-product-export');
  Route::post('/product/create', 'ProductController@store')->name('admin-product-store');
  Route::get('/product/edit/{id}', 'ProductController@edit')->name('admin-product-edit');
  Route::get('/product/copy/{id}', 'ProductController@copy')->name('admin-product-copy');
  Route::post('/product/update/{id}', 'ProductController@update')->name('admin-product-update');
  Route::get('/product/delete/{id}', 'ProductController@destroy')->name('admin-product-delete');
  Route::get('/product/products-models-by-brands', 'ProductController@productsModelsByBrands');
  Route::get('/product/get-prices-tables', 'ProductController@pricesTables');
  Route::post('/product/store-retailer-margins', 'ProductController@storeRetailerMargins')->name('store-retailer-margins');
  Route::get('/product/reset-supplier-margins', 'ProductController@resetSupplierMargins')->name('reset-supplier-margins');
  Route::get('/product/get-features-data', 'ProductController@featuresData');

  Route::get('/price-tables', 'PriceTablesController@index')->name('admin-price-tables');
  Route::get('/price-tables/create', 'PriceTablesController@create')->name('admin-price-tables-create');
  Route::get('/price-tables/import', 'PriceTablesController@import')->name('admin-price-tables-import');
  Route::post('/price-tables/upload', 'PriceTablesController@PostImport')->name('admin-price-tables-upload');
  Route::get('/price-tables/export', 'PriceTablesController@PostExport')->name('admin-price-tables-export');
  Route::post('/price-tables/create', 'PriceTablesController@store')->name('admin-price-tables-store');
  Route::get('/price-tables/edit/{id}', 'PriceTablesController@edit')->name('admin-price-tables-edit');
  Route::get('/price-tables/prices/view/{id}', 'PriceTablesController@viewPrices')->name('admin-prices-view');
  Route::post('/price-tables/update/{id}', 'PriceTablesController@update')->name('admin-price-tables-update');
  Route::get('/price-tables/delete/{id}', 'PriceTablesController@destroy')->name('admin-price-tables-delete');
  Route::get('/price-tables/prices/delete/{id}', 'PriceTablesController@destroyPrices')->name('admin-prices-delete');

  Route::get('/colors', 'ColorController@index')->name('admin-color-index');
  Route::get('/color/create', 'ColorController@create')->name('admin-color-create');
  Route::post('/color/create', 'ColorController@store')->name('admin-color-store');
  Route::get('/color/edit/{id}', 'ColorController@edit')->name('admin-color-edit');
  Route::get('/color/delete/{id}', 'ColorController@destroy')->name('admin-color-delete');

  Route::get('/services', 'ServiceController@index')->name('admin-service-index');
  Route::get('/service/create', 'ServiceController@create')->name('admin-service-create');
  Route::post('/service/create', 'ServiceController@store')->name('admin-service-store');
  Route::get('/service/edit/{id}', 'ServiceController@edit')->name('admin-service-edit');
  Route::get('/service/delete/{id}', 'ServiceController@destroy')->name('admin-service-delete');

  Route::get('/categories', 'CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'CategoryController@edit')->name('admin-cat-edit');
  /*Route::post('/category/update/{id}', 'CategoryController@update')->name('admin-cat-update');*/
  Route::get('/category/delete/{id}', 'CategoryController@destroy')->name('admin-cat-delete');

  Route::get('/my-features', 'FeaturesController@MyCategoriesIndex')->name('admin-features');
  Route::get('/my-features/create', 'FeaturesController@MyCategoryCreate')->name('admin-features-create');
  Route::post('/my-features/create', 'FeaturesController@MyCategoryStore')->name('admin-features-store');
  Route::get('/my-features/edit/{id}', 'FeaturesController@MyCategoryEdit')->name('admin-features-edit');
  Route::get('/my-features/delete/{id}', 'FeaturesController@MyCategoryDestroy')->name('admin-features-delete');

  Route::get('/brands', 'BrandController@index')->name('admin-brand-index');
  Route::get('/brand/create', 'BrandController@create')->name('admin-brand-create');
  Route::post('/brand/create', 'BrandController@store')->name('admin-brand-store');
  Route::get('/brand/edit/{id}', 'BrandController@edit')->name('admin-brand-edit');
  Route::post('/brand/update/{id}', 'BrandController@update')->name('admin-brand-update');
  Route::get('/brand/delete/{id}', 'BrandController@destroy')->name('admin-brand-delete');

  Route::get('/models', 'ModelController@index')->name('admin-model-index');
  Route::get('/model/create', 'ModelController@create')->name('admin-model-create');
  Route::post('/model/create', 'ModelController@store')->name('admin-model-store');
  Route::get('/model/edit/{id}', 'ModelController@edit')->name('admin-model-edit');
  Route::post('/model/update/{id}', 'ModelController@update')->name('admin-model-update');
  Route::get('/model/delete/{id}', 'ModelController@destroy')->name('admin-model-delete');

  Route::get('/items', 'ItemController@index')->name('admin-item-index');
  Route::get('/item/create', 'ItemController@create')->name('admin-item-create');
  Route::post('/item/create', 'ItemController@store')->name('admin-item-store');
  Route::get('/item/edit/{id}', 'ItemController@edit')->name('admin-item-edit');
  Route::post('/item/update/{id}', 'ItemController@update')->name('admin-item-update');
  Route::get('/item/delete/{id}', 'ItemController@destroy')->name('admin-item-delete');

  Route::get('/features', 'FeaturesController@index')->name('admin-feature-index');
  Route::get('/features/create', 'FeaturesController@create')->name('admin-feature-create');
  Route::post('/features/create', 'FeaturesController@store')->name('admin-feature-store');
  Route::get('/features/edit/{id}', 'FeaturesController@edit')->name('admin-feature-edit');
  Route::post('/features/update/{id}', 'FeaturesController@update')->name('admin-feature-update');
  Route::get('/features/delete/{id}', 'FeaturesController@destroy')->name('admin-feature-delete');

  Route::get('/features/add-default-feature/{id}', 'FeaturesController@edit')->name('add-default-feature');

  Route::get('/suppliers', 'UserController@Suppliers')->name('suppliers');
  Route::post('/send-request-supplier', 'UserController@SendRequestSupplier')->name('send-request-supplier');
  Route::get('/suppliers/details/{id}', 'UserController@DetailsSupplier')->name('supplier-details');

  Route::get('/retailers', 'UserController@Retailers')->name('retailers');
  Route::get('/retailers/details/{id}', 'UserController@DetailsRetailer')->name('retailer-details');
  Route::post('/accept-retailer-request', 'UserController@AcceptRetailerRequest')->name('accept-retailer-request');
  Route::post('/suspend-retailer-request', 'UserController@SuspendRetailerRequest')->name('suspend-retailer-request');
  Route::post('/delete-retailer-request', 'UserController@DeleteRetailerRequest')->name('delete-retailer-request');

  Route::get('/supplier-categories', 'UserController@SupplierCategories')->name('supplier-categories');
  Route::post('/supplier-categories-store', 'UserController@SupplierCategoriesStore')->name('supplier-categories-store');

  });

  Route::get('finalize', 'FrontendController@finalize');
  Route::post('the/genius/ocean/2441139', 'FrontEndController@subscription');

  Route::post('/user/payment/notify', 'PaymentController@notify')->name('payment.notify');
  Route::post('/stripe-submit', 'StripeController@store')->name('stripe.submit');

  Route::prefix('logstof')->group(function() {

  Route::get('/my-categories', 'CategoryController@MyCategoriesIndex')->name('admin-my-cat-index');
  Route::get('/my-category/create', 'CategoryController@MyCategoryCreate')->name('admin-my-cat-create');
  Route::post('/my-category/create', 'CategoryController@MyCategoryStore')->name('admin-my-cat-store');
  Route::get('/my-category/edit/{id}', 'CategoryController@MyCategoryEdit')->name('admin-my-cat-edit');
  Route::get('/my-category/delete/{id}', 'CategoryController@MyCategoryDestroy')->name('admin-my-cat-delete');

  Route::get('/features', 'DefaultFeaturesController@index')->name('default-features-index');
  Route::get('/features/create', 'DefaultFeaturesController@create')->name('default-features-create');
  Route::post('/features/create', 'DefaultFeaturesController@store')->name('default-features-store');
  Route::get('/features/edit/{id}', 'DefaultFeaturesController@edit')->name('default-features-edit');
  Route::get('/features/delete/{id}', 'DefaultFeaturesController@destroy')->name('default-features-delete');

  Route::get('/mark-delivered/{id}', 'AdminUserController@MarkDelivered');
  Route::get('/mark-received/{id}', 'AdminUserController@MarkReceived');
  Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
  Route::get('/invoice/{id}', 'AdminController@Invoice')->name('admin-hi');
  Route::get('/cancelled-invoice/{id}', 'AdminController@CancelledInvoice')->name('admin-chi');
  Route::get('/client-invoice/{id}', 'AdminController@ClientInvoice')->name('admin-ci');
  Route::get('/client-cancelled-invoice/{id}', 'AdminController@ClientCancelledInvoice')->name('admin-cci');
  Route::get('/view-images/{id}', 'AdminController@Images');
  Route::get('/download-invoice/{id}', 'AdminController@DownloadInvoice')->name('admin-download-hi');
  Route::get('/download-cancelled-invoice/{id}', 'AdminController@DownloadCancelledInvoice')->name('admin-download-chi');
  Route::get('/client-download-invoice/{id}', 'AdminController@ClientDownloadInvoice')->name('admin-download-ci');
  Route::get('/client-download-cancelled-invoice/{id}', 'AdminController@ClientDownloadCancelledInvoice')->name('admin-download-cci');
  Route::get('/add-terminals', 'AdminController@AddTerminals')->name('add-terminals');
  Route::get('/profile', 'AdminController@profile')->name('admin-profile');
  Route::post('/profile', 'AdminController@profileupdate')->name('admin-profile-update');
  Route::get('/reset-password', 'AdminController@passwordreset')->name('admin-password-reset');
  Route::post('/reset-password', 'AdminController@changepass')->name('admin-password-change');
  Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin-login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin-login-submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin-logout');
  Route::post('/admin-status-update', 'AdminController@AdminStatusUpdate')->name('admin-status-update');
  Route::get('/handyman-terms', 'AdminController@HandymanTerms')->name('admin-handyman-terms');
  Route::get('/client-terms', 'AdminController@ClientTerms')->name('admin-client-terms');
  Route::post('/handyman-terms-post', 'AdminController@HandymanTermsPost')->name('admin-handyman-terms-post');
  Route::post('/client-terms-post', 'AdminController@ClientTermsPost')->name('admin-client-terms-post');
  Route::get('/instruction-manual', 'AdminController@InstructionManual')->name('admin-instruction-manual');
  Route::post('/instruction-manual-post', 'AdminController@InstructionManualPost')->name('admin-instruction-manual-post');

  Route::get('/quotation-questions', 'AdminUserController@QuotationQuestions')->name('quotation-questions');
  Route::get('/create-question', 'AdminUserController@CreateQuestion')->name('create-question');
  Route::post('/create-question', 'AdminUserController@SubmitQuestion')->name('save-question');
  Route::get('/edit-question/{id}', 'AdminUserController@EditQuestion')->name('edit-question');
  Route::get('/delete-question/{id}', 'AdminUserController@DeleteQuestion')->name('delete-question');


  Route::get('/services-quotation-questions', 'AdminUserController@ServicesQuotationQuestions')->name('services-quotation-questions');
  Route::get('/create-services-question', 'AdminUserController@CreateServicesQuestion')->name('create-services-question');
  Route::post('/create-services-question', 'AdminUserController@SubmitServicesQuestion')->name('save-services-question');
  Route::get('/edit-services-question/{id}', 'AdminUserController@EditServicesQuestion')->name('edit-services-question');
  Route::get('/delete-services-question/{id}', 'AdminUserController@DeleteServicesQuestion')->name('delete-services-question');

  Route::get('/quotation-requests', 'AdminUserController@QuotationRequests')->name('quotation-requests');
  Route::get('/handyman-quotations/{id?}', 'AdminUserController@HandymanQuotations')->name('handyman-quotations');
  Route::get('/handyman-quotations-invoices/{id?}', 'AdminUserController@HandymanQuotationsInvoices')->name('handyman-quotations-invoices');
  Route::get('/handyman-commission-invoices/{id?}', 'AdminUserController@HandymanQuotationsInvoices')->name('handyman-commission-invoices');
  Route::get('/view-quote-request/{id}', 'AdminUserController@QuoteRequest');
  Route::get('/view-quotation/{id}', 'AdminUserController@ViewQuotation')->name('view-quotation');
  Route::get('/download-quote-request/{id}', 'AdminUserController@DownloadQuoteRequest');
  Route::get('/download-quote-invoice/{id}', 'AdminUserController@DownloadQuoteInvoice');
  Route::get('/download-commission-invoice/{id}', 'AdminUserController@DownloadCommissionInvoice');
  Route::get('/send-quote-request/{id}', 'AdminUserController@SendQuoteRequest');
  Route::post('/send-quote-request', 'AdminUserController@SendQuoteRequestHandymen')->name('send-quote-request');
  Route::post('/approve-handyman-quotations', 'AdminUserController@ApproveHandymanQuotations')->name('approve-handyman-quotations');
  Route::get('/handymans', 'AdminUserController@index')->name('admin-user-index');
  Route::get('/suppliers', 'AdminUserController@Suppliers')->name('admin-supplier-index');
  Route::get('/clients', 'AdminUserController@Clients')->name('admin-user-client');
  Route::get('/bookings', 'AdminUserController@UserBookings')->name('admin-user-bookings');
  Route::get('/user-requests', 'AdminUserController@UserRequests')->name('admin-user-requests');
  Route::get('/request/{id}', 'AdminUserController@UserRequest')->name('admin-user-request');
  Route::post('/request-update', 'AdminUserController@RequestProfileUpdate')->name('request-profile-update');
  Route::get('/handymans/create', 'AdminUserController@create')->name('admin-user-create');
  Route::post('/handymans/create', 'AdminUserController@store')->name('admin-user-store');
  Route::get('/handymans/edit/{id}', 'AdminUserController@edit')->name('admin-user-edit');
  Route::post('/handymans/update/{id}', 'AdminUserController@update')->name('admin-user-update');
  Route::post('/handymans/insurance-update/{id}', 'AdminUserController@InsuranceUpdate')->name('admin-user-insurance-update');
  Route::get('/handymans/delete/{id}', 'AdminUserController@destroy')->name('admin-user-delete');
  Route::get('/handymans/insurance/{id}', 'AdminUserController@Insurance')->name('admin-user-insurance');

  Route::get('/suppliers/create', 'AdminUserController@createSupplier')->name('admin-supplier-create');
  Route::get('/suppliers/edit/{id}', 'AdminUserController@editSupplier')->name('admin-supplier-edit');
  Route::get('/suppliers/details/{id}', 'AdminUserController@DetailsSupplier')->name('admin-supplier-details');
  Route::get('/suppliers/products/{id}', 'ProductController@ProductsSupplier')->name('supplier-products');

  Route::get('/handymans/details/{id}', 'AdminUserController@Details')->name('admin-user-details');

  Route::get('/handymans/client-details/{id}', 'AdminUserController@ClientDetails')->name('admin-user-client-details');

  Route::get('/handymans/status/{id1}/{id2}', 'AdminUserController@status')->name('admin-user-st');

  /*Route::get('/categories', 'CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'CategoryController@edit')->name('admin-cat-edit');
  //Route::post('/category/update/{id}', 'CategoryController@update')->name('admin-cat-update');//
  Route::get('/category/delete/{id}', 'CategoryController@destroy')->name('admin-cat-delete');*/

  /*Route::get('/services', 'ServiceController@index')->name('admin-service-index');
  Route::get('/service/create', 'ServiceController@create')->name('admin-service-create');
  Route::post('/service/create', 'ServiceController@store')->name('admin-service-store');
  Route::get('/service/edit/{id}', 'ServiceController@edit')->name('admin-service-edit');
  Route::get('/service/delete/{id}', 'ServiceController@destroy')->name('admin-service-delete');*/

  /*Route::get('/products', 'ProductController@index')->name('admin-product-index');
  Route::get('/product/create', 'ProductController@create')->name('admin-product-create');
  Route::get('/product/import', 'ProductController@import')->name('admin-product-import');
  Route::post('/product/upload', 'ProductController@PostImport')->name('admin-product-upload');
  Route::get('/product/export', 'ProductController@PostExport')->name('admin-product-export');
  Route::post('/product/create', 'ProductController@store')->name('admin-product-store');
  Route::get('/product/edit/{id}', 'ProductController@edit')->name('admin-product-edit');
  Route::post('/product/update/{id}', 'ProductController@update')->name('admin-product-update');
  Route::get('/product/delete/{id}', 'ProductController@destroy')->name('admin-product-delete');
  Route::get('/product/products-models-by-brands', 'ProductController@productsModelsByBrands');
  Route::get('/product/get-prices-tables', 'ProductController@pricesTables');*/

  /*Route::get('/price-tables', 'PriceTablesController@index')->name('admin-price-tables');
  Route::get('/price-tables/create', 'PriceTablesController@create')->name('admin-price-tables-create');
  Route::get('/price-tables/import', 'PriceTablesController@import')->name('admin-price-tables-import');
  Route::post('/price-tables/upload', 'PriceTablesController@PostImport')->name('admin-price-tables-upload');
  Route::get('/price-tables/export', 'PriceTablesController@PostExport')->name('admin-price-tables-export');
  Route::post('/price-tables/create', 'PriceTablesController@store')->name('admin-price-tables-store');
  Route::get('/price-tables/edit/{id}', 'PriceTablesController@edit')->name('admin-price-tables-edit');
  Route::get('/price-tables/prices/view/{id}', 'PriceTablesController@viewPrices')->name('admin-prices-view');
  Route::post('/price-tables/update/{id}', 'PriceTablesController@update')->name('admin-price-tables-update');
  Route::get('/price-tables/delete/{id}', 'PriceTablesController@destroy')->name('admin-price-tables-delete');
  Route::get('/price-tables/prices/delete/{id}', 'PriceTablesController@destroyPrices')->name('admin-prices-delete');*/

  /*Route::get('/colors', 'ColorController@index')->name('admin-color-index');
  Route::get('/color/create', 'ColorController@create')->name('admin-color-create');
  Route::post('/color/create', 'ColorController@store')->name('admin-color-store');
  Route::get('/color/edit/{id}', 'ColorController@edit')->name('admin-color-edit');
  Route::get('/color/delete/{id}', 'ColorController@destroy')->name('admin-color-delete');*/

  /*Route::get('/brands', 'BrandController@index')->name('admin-brand-index');
  Route::get('/brand/create', 'BrandController@create')->name('admin-brand-create');
  Route::post('/brand/create', 'BrandController@store')->name('admin-brand-store');
  Route::get('/brand/edit/{id}', 'BrandController@edit')->name('admin-brand-edit');
  Route::post('/brand/update/{id}', 'BrandController@update')->name('admin-brand-update');
  Route::get('/brand/delete/{id}', 'BrandController@destroy')->name('admin-brand-delete');*/

  /*Route::get('/models', 'ModelController@index')->name('admin-model-index');
  Route::get('/model/create', 'ModelController@create')->name('admin-model-create');
  Route::post('/model/create', 'ModelController@store')->name('admin-model-store');
  Route::get('/model/edit/{id}', 'ModelController@edit')->name('admin-model-edit');
  Route::post('/model/update/{id}', 'ModelController@update')->name('admin-model-update');
  Route::get('/model/delete/{id}', 'ModelController@destroy')->name('admin-model-delete');*/

  /*Route::get('/items', 'ItemController@index')->name('admin-item-index');
  Route::get('/item/create', 'ItemController@create')->name('admin-item-create');
  Route::post('/item/create', 'ItemController@store')->name('admin-item-store');
  Route::get('/item/edit/{id}', 'ItemController@edit')->name('admin-item-edit');
  Route::post('/item/update/{id}', 'ItemController@update')->name('admin-item-update');
  Route::get('/item/delete/{id}', 'ItemController@destroy')->name('admin-item-delete');*/

  /*Route::get('/features', 'FeaturesController@index')->name('admin-feature-index');
  Route::get('/features/create', 'FeaturesController@create')->name('admin-feature-create');
  Route::post('/features/create', 'FeaturesController@store')->name('admin-feature-store');
  Route::get('/features/edit/{id}', 'FeaturesController@edit')->name('admin-feature-edit');
  Route::post('/features/update/{id}', 'FeaturesController@update')->name('admin-feature-update');
  Route::get('/features/delete/{id}', 'FeaturesController@destroy')->name('admin-feature-delete');*/

  Route::get('/faq', 'FaqController@index')->name('admin-fq-index');
  Route::get('/faq/create', 'FaqController@create')->name('admin-fq-create');
  Route::post('/faq/create', 'FaqController@store')->name('admin-fq-store');
  Route::get('/faq/edit/{id}', 'FaqController@edit')->name('admin-fq-edit');
  Route::post('/faq/update/{id}', 'FaqController@update')->name('admin-fq-update');
  Route::post('/faqup', 'PageSettingController@faqupdate')->name('admin-faq-update');
  Route::get('/faq/delete/{id}', 'FaqController@destroy')->name('admin-fq-delete');


  Route::get('/blog', 'AdminBlogController@index')->name('admin-blog-index');
  Route::get('/blog/create', 'AdminBlogController@create')->name('admin-blog-create');
  Route::post('/blog/create', 'AdminBlogController@store')->name('admin-blog-store');
  Route::get('/blog/edit/{id}', 'AdminBlogController@edit')->name('admin-blog-edit');
  Route::post('/blog/edit/{id}', 'AdminBlogController@update')->name('admin-blog-update');
  Route::get('/blog/delete/{id}', 'AdminBlogController@destroy')->name('admin-blog-delete');

  Route::get('/testimonial', 'PortfolioController@index')->name('admin-ad-index');
  Route::get('/testimonial/create', 'PortfolioController@create')->name('admin-ad-create');
  Route::post('/testimonial/create', 'PortfolioController@store')->name('admin-ad-store');
  Route::get('/testimonial/edit/{id}', 'PortfolioController@edit')->name('admin-ad-edit');
  Route::post('/testimonial/edit/{id}', 'PortfolioController@update')->name('admin-ad-update');
  Route::get('/testimonial/delete/{id}', 'PortfolioController@destroy')->name('admin-ad-delete');


  Route::get('/advertise', 'AdvertiseController@index')->name('admin-adv-index');
  Route::get('/advertise/st/{id1}/{id2}', 'AdvertiseController@status')->name('admin-adv-st');
  Route::get('/advertise/create', 'AdvertiseController@create')->name('admin-adv-create');
  Route::post('/advertise/create', 'AdvertiseController@store')->name('admin-adv-store');
  Route::get('/advertise/edit/{id}', 'AdvertiseController@edit')->name('admin-adv-edit');
  Route::post('/advertise/edit/{id}', 'AdvertiseController@update')->name('admin-adv-update');
  Route::get('/advertise/delete/{id}', 'AdvertiseController@destroy')->name('admin-adv-delete');

  Route::get('/page-settings/about', 'PageSettingController@about')->name('admin-ps-about');
  Route::post('/page-settings/about', 'PageSettingController@aboutupdate')->name('admin-ps-about-submit');
  Route::get('/page-settings/contact', 'PageSettingController@contact')->name('admin-ps-contact');
  Route::post('/page-settings/contact', 'PageSettingController@contactupdate')->name('admin-ps-contact-submit');



  Route::get('/assign-permissions', 'AdminController@AssignPermissions')->name('admin-assign-permissions');
  Route::get('/assign-permissions/edit/{id}', 'AdminController@AssignPermissionEdit')->name('admin-assign-permission-edit');
  Route::post('/assign-permissions/store', 'AdminController@AssignPermissionsStore')->name('admin-assign-permission-store');
  Route::get('/permissions', 'AdminController@Permissions')->name('admin-permissions-index');
  Route::get('/permissions/create', 'AdminController@PermissionsCreate')->name('admin-permission-create');
  Route::post('/permissions/create', 'AdminController@PermissionsStore')->name('admin-permission-store');
  Route::get('/permissions/edit/{id}', 'AdminController@PermissionEdit')->name('admin-permission-edit');
  Route::get('/social', 'SocialSettingController@index')->name('admin-social-index');
  Route::get('/how-it-works', 'AdminController@HowItWorks')->name('admin-how-it-works');
  Route::post('/social/update', 'SocialSettingController@update')->name('admin-social-update');
  Route::post('/how-it-works/update', 'AdminController@HowItWorksUpdate')->name('admin-how-it-works-update');
  Route::get('/reasons-to-book', 'AdminController@ReasonsToBook')->name('admin-reasons-to-book');
  Route::post('/reasons-to-book/update', 'AdminController@ReasonsToBookUpdate')->name('admin-reasons-to-book-update');

  Route::get('/filter-settings', 'SocialSettingController@FilterSettings')->name('admin-filter-settings');
  Route::post('/filter/update', 'SocialSettingController@FilterUpdate')->name('admin-filter-update');


  Route::get('/seotools/analytics', 'SeoToolController@analytics')->name('admin-seotool-analytics');
  Route::post('/seotools/analytics/update', 'SeoToolController@analyticsupdate')->name('admin-seotool-analytics-update');
  Route::get('/seotools/keywords', 'SeoToolController@keywords')->name('admin-seotool-keywords');
  Route::post('/seotools/keywords/update', 'SeoToolController@keywordsupdate')->name('admin-seotool-keywords-update');

  Route::get('/general-settings/logo', 'GeneralSettingController@logo')->name('admin-gs-logo');
  Route::post('/general-settings/logo', 'GeneralSettingController@logoup')->name('admin-gs-logoup');

  Route::get('/general-settings/favicon', 'GeneralSettingController@fav')->name('admin-gs-fav');
  Route::post('/general-settings/favicon', 'GeneralSettingController@favup')->name('admin-gs-favup');


  Route::get('/general-settings/loader', 'GeneralSettingController@load')->name('admin-gs-load');
  Route::post('/general-settings/loader', 'GeneralSettingController@loadup')->name('admin-gs-loadup');

  Route::get('/general-settings/payments', 'GeneralSettingController@payments')->name('admin-gs-payments');
  Route::post('/general-settings/payments', 'GeneralSettingController@paymentsup')->name('admin-gs-paymentsup');

  Route::get('/general-settings/vats', 'GeneralSettingController@vats')->name('admin-gs-vats');
  Route::get('/general-settings/view-vat/{id}', 'GeneralSettingController@viewVat');
  Route::get('/general-settings/delete-vat/{id}', 'GeneralSettingController@deleteVat');
  Route::get('/general-settings/create-vat', 'GeneralSettingController@createVat')->name('admin-gs-create-vat');
  Route::post('/general-settings/vats', 'GeneralSettingController@vatsup')->name('admin-gs-vatsup');

  Route::get('/general-settings/contents', 'GeneralSettingController@contents')->name('admin-gs-contents');
  Route::post('/general-settings/contents', 'GeneralSettingController@contentsup')->name('admin-gs-contentsup');

  Route::post('/general-settings/contents-change', 'GeneralSettingController@contentsChange')->name('theme.change');

  Route::get('/general-settings/bgimg', 'GeneralSettingController@bgimg')->name('admin-gs-bgimg');
  Route::post('/general-settings/bgimgup', 'GeneralSettingController@bgimgup')->name('admin-gs-bgimgup');

  Route::get('/general-settings/about', 'GeneralSettingController@about')->name('admin-gs-about');
  Route::post('/general-settings/about', 'GeneralSettingController@aboutup')->name('admin-gs-aboutup');

  Route::get('/general-settings/address', 'GeneralSettingController@address')->name('admin-gs-address');
  Route::post('/general-settings/address', 'GeneralSettingController@addressup')->name('admin-gs-addressup');

  Route::get('/general-settings/footer', 'GeneralSettingController@footer')->name('admin-gs-footer');
  Route::post('/general-settings/footer', 'GeneralSettingController@footerup')->name('admin-gs-footerup');

  Route::get('/general-settings/bg-info', 'GeneralSettingController@bginfo')->name('admin-gs-bginfo');
  Route::post('/general-settings/bg-info', 'GeneralSettingController@bginfoup')->name('admin-gs-bginfoup');

  Route::get('/subscribers', 'SubscriberController@index')->name('admin-subs-index');
  Route::get('/subscribers/download', 'SubscriberController@download')->name('admin-subs-download');

  Route::get('/languages', 'LanguageController@lang')->name('admin-lang-index');
  Route::post('/languages', 'LanguageController@langup')->name('admin-lang-submit');
  });

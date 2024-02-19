<?php

use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchingController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\GetInformationController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\User\PayoutController;
use App\Http\Controllers\ManualRecaptchaController;
use App\Http\Controllers\khaltiPaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InAppNotificationController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\User\SellerController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\User\PlanPurchaseControlller;
use App\Http\Controllers\BidderController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\ReactController;
use App\Models\Language;
use App\Http\Controllers\User\NotificationPermissionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



$basicControl = basicControl();
Route::get('maintenance-mode', function () {
    $data['maintenanceMode'] = \App\Models\MaintenanceMode::first();
    return view(template() . 'maintenance', $data);
})->name('maintenance');


Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.update');

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
    });

    Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {

        Route::get('check', [VerificationController::class, 'check'])->name('check');
        Route::get('resend_code', [VerificationController::class, 'resendCode'])->name('resendCode');
        Route::post('mail-verify', [VerificationController::class, 'mailVerify'])->name('mailVerify');
        Route::post('sms-verify', [VerificationController::class, 'smsVerify'])->name('smsVerify');
        Route::post('twoFA-Verify', [VerificationController::class, 'twoFAverify'])->name('twoFA-Verify');

        Route::middleware('userCheck')->group(function () {

            Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
            Route::get('profile', [HomeController::class, 'profile'])->name('profile');
            Route::post('profile-update', [HomeController::class, 'profileUpdate'])->name('profile.update');
            Route::post('profile-update/image', [HomeController::class, 'profileUpdateImage'])->name('profile.update.image');
            Route::post('update/password', [HomeController::class, 'updatePassword'])->name('updatePassword');

            Route::post('save-token', [HomeController::class, 'saveToken'])->name('save.token');

            Route::post('save-token', [HomeController::class, 'saveToken'])->name('save.token');

            Route::post('kyc/submit', [HomeController::class, 'kycVerificationSubmit'])->name('kyc.verification.submit');
            Route::get('add-fund', [HomeController::class, 'addFund'])->name('add.fund');
            Route::get('funds', [HomeController::class, 'fund'])->name('fund.index');

            Route::get('transaction-list', [HomeController::class, 'index'])->name('transaction');
            Route::get('transaction-search', [HomeController::class, 'search'])->name('transaction.search');

            Route::get('twostep-security', [HomeController::class, 'twoStepSecurity'])->name('twostep.security');
            Route::post('twoStep-enable', [HomeController::class, 'twoStepEnable'])->name('twoStepEnable');
            Route::post('twoStep-disable', [HomeController::class, 'twoStepDisable'])->name('twoStepDisable');
            Route::middleware('kycVerification')->group(function () {

                /* Manage Buy and Sell Vehicle and Manage Plan*/
                Route::get('purchase/history',[PlanPurchaseControlller::class,'purchaseHistory'])->name('purchase.history');
                Route::get('purchase/plan/{plan_id}', [PlanPurchaseControlller::class, 'purchasePlan'])->name('purchase.plan');
                Route::get('upgrade/plan/{id}',[PlanPurchaseControlller::class,'upgradePlan'])->name('upgrade.plan');
                Route::get('payment-check-amount',[PlanPurchaseControlller::class,'checkAmount'])->name('plan.checkAmount');
                Route::post('confirm-plan',[PlanPurchaseControlller::class,'confirmPlan'])->name('confirm-plan');
                Route::post('/bid/{id}',[\App\Http\Controllers\BiddingController::class,'bid'])->name('bid');
                Route::get('sell/your/vehicle', [SellerController::class, 'index'])->name('show.listing.form')->middleware(['CheckSeller']);
                Route::post('store/vehicle', [SellerController::class, 'store'])->name('listing.vehicle')->middleware(['CheckSeller']);
                Route::get('listed/vehicle',[SellerController::class,'listedVehicle'])->name('listed.vehicle');
                Route::get('edit/vehicle/{id}',[SellerController::class,'edit'])->name('edit.vehicle');;
                Route::post('update/vehicle/{id}',[SellerController::class,'update'])->name('update.vehicle');;
                Route::get('delete/vehicle/{id}',[SellerController::class,'destroy'])->name('delete.vehicle');

                Route::get('bidding/history',[BidderController::class,'userBiddingHistory'])->name('bidding.history');

                Route::post('release/property',[SellerController::class,'releaseProperty'])->name('release.property');


                Route::post('confirm/payment',[BidderController::class,'payNow'])->name('confirm.payment');
                Route::post('store/report/{reporter_id}/{reported_id}/{vehicle_id}',[ReportController::class,'store'])->name('store.report');

                Route::get('vehicle/bidding/history/{id}',[SellerController::class,'vehicleBiddingHistory'])->name('vehicle.bidding.history');

                Route::get('vehicle-owner/messages/{id}/{bid_id}',[MessageController::class,'index'])->name('messages');
                Route::get('bidder/messages/{id}/{bid_id}',[MessageController::class,'showMessagesForBidder'])->name('bidder.message.show');
                Route::get('get/message/{id}',[MessageController::class,'getMessage'])->name('get.message');
                Route::post('send/message/',[MessageController::class,'sendMessage'])->name('send.message');
                Route::get('reports',[ReportController::class,'index'])->name('reports.conversation');
                Route::get('reports/conversation/{id}',[ReportController::class,'getConversation'])->name('get.conversation');
                Route::post('send/report/message',[ReportController::class,'sendMessage'])->name('send.report.message');
            });

            /*Get Mor Info */
           Route::post('get/more/info',[GetInformationController::class,'getInfo'])->name('get.info');
            /*Get Chart Data*/
                Route::get('get/chart/data',[HomeController::class,'getChartData'])->name('get.chart.data');
            /*Contact */
           Route::post('store/contact/information',[ContactController::class,'store'])->name('store.contact.information');
            /* user notification permission */
            Route::get('notification/permission',[NotificationPermissionController::class,'index'])->name('notification.permission');
            Route::post('notification/permission/update',[NotificationPermissionController::class,'notifyPermissionUpdate'])->name('notification.permission.update');

            /* PAYMENT REQUEST BY USER */
            Route::get('payout-list', [PayoutController::class, 'index'])->name('payout.index');
            Route::get('payout-search', [PayoutController::class, 'search'])->name('payout.search');

            Route::get('payout', [PayoutController::class, 'payout'])->name('payout');
            Route::get('payout-supported-currency', [PayoutController::class, 'payoutSupportedCurrency'])->name('payout.supported.currency');
            Route::get('payout-check-amount', [PayoutController::class, 'checkAmount'])->name('payout.checkAmount');
            Route::post('request-payout', [PayoutController::class, 'payoutRequest'])->name('payout.request');
            Route::post('payment-request', [DepositController::class, 'paymentRequest'])->name('payment.request');

            Route::match(['get', 'post'], 'confirm-payout/{trx_id}', [PayoutController::class, 'confirmPayout'])->name('payout.confirm');
            Route::post('confirm-payout/flutterwave/{trx_id}', [PayoutController::class, 'flutterwavePayout'])->name('payout.flutterwave');
            Route::post('confirm-payout/paystack/{trx_id}', [PayoutController::class, 'paystackPayout'])->name('payout.paystack');
            Route::get('payout-check-limit', [PayoutController::class, 'checkLimit'])->name('payout.checkLimit');
            Route::post('payout-bank-form', [PayoutController::class, 'getBankForm'])->name('payout.getBankForm');
            Route::post('payout-bank-list', [PayoutController::class, 'getBankList'])->name('payout.getBankList');

            /* ===== Push Notification ===== */
            Route::get('push-notification-show', [InAppNotificationController::class, 'show'])->name('push.notification.show');
            Route::get('push.notification.readAll', [InAppNotificationController::class, 'readAll'])->name('push.notification.readAll');
            Route::get('push-notification-readAt/{id}', [InAppNotificationController::class, 'readAt'])->name('push.notification.readAt');

            Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
                Route::get('/', [SupportTicketController::class, 'index'])->name('list');
                Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
                Route::post('/create', [SupportTicketController::class, 'store'])->name('store');
                Route::get('/view/{ticket}', [SupportTicketController::class, 'ticketView'])->name('view');
                Route::put('/reply/{ticket}', [SupportTicketController::class, 'reply'])->name('reply');
                Route::get('/download/{ticket}', [SupportTicketController::class, 'download'])->name('download');
            });

        });
    });


    Route::get('/captcha', [ManualRecaptchaController::class, 'reCaptCha'])->name('captcha');
    /* Searching Auction Vehicle */
    Route::get('filter/vehicle',[SearchingController::class,'filterVehicle'])->name('filter.vehicle');
    Route::get('filter/bidding-history',[SearchingController::class,'filterBiddingHistory'])->name('filter.bidding-history');
    Route::get('filter/listed-vehicle',[SearchingController::class,'filterListedVehicle'])->name('filter.listed-vehicle');
    Route::get('blog/searching',[SearchingController::class,'blogSearching'])->name('blog.search');

    /* Manage User Deposit */
    Route::get('supported-currency', [DepositController::class, 'supportedCurrency'])->name('supported.currency');
    Route::post('payment-request', [DepositController::class, 'paymentRequest'])->name('payment.request');
    Route::get('deposit-check-amount', [DepositController::class, 'checkAmount'])->name('deposit.checkAmount');

    Route::get('payment-process/{trx_id}/{type}', [PaymentController::class, 'depositConfirm'])->name('payment.process');
    Route::post('addFundConfirm/{trx_id}', [PaymentController::class, 'fromSubmit'])->name('addFund.fromSubmit');
    Route::match(['get', 'post'], 'success', [PaymentController::class, 'success'])->name('success');
    Route::match(['get', 'post'], 'failed', [PaymentController::class, 'failed'])->name('failed');
    Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', [PaymentController::class, 'gatewayIpn'])->name('ipn');

    Route::post('khalti/payment/verify/{trx}', [\App\Http\Controllers\khaltiPaymentController::class, 'verifyPayment'])->name('khalti.verifyPayment');
    Route::post('khalti/payment/store', [khaltiPaymentController::class, 'storePayment'])->name('khalti.storePayment');

    Auth::routes();

    Route::get('submit/react/{id}',[ReactController::class,'submit'])->name('submit.react');
    Route::get('unsubmit/react/{id}',[ReactController::class,'unsubmit'])->name('unsubmit.react');
    Route::get('get/react/{id}',[ReactController::class,'getReact'])->name('get.react');
    Route::get('/plan', [FrontendController::class, 'plan'])->name('plan');
    Route::get('/auction', [FrontendController::class, 'auction'])->name('auction');
    Route::get('/blogs', [FrontendController::class, 'blogs'])->name('blogs');
    Route::get('blog', [FrontendController::class, 'blogs'])->name('blog');
    Route::get('blogs/{category}/{id}',[FrontendController::class,'categoryBlogs'])->name('category.blogs');
    Route::get('blog-details/{slug}', [BlogController::class, 'blogDetails'])->name('blog.details');
    Route::get('property/details/{slug?}/{id}',[\App\Http\Controllers\BidderController::class,'viewAuctionDetails'])->name('auction.details');

    Route::get('language/{locale}', function ($locale) {
        $language = Language::where('short_name', $locale)->first();
        if (!$language) $locale = 'en';
        session()->put('lang', $locale);
        session()->put('rtl', $language ? $language->rtl : 0);
        return back();
    })->name('language');

    /*= Frontend Manage Controller =*/
    Route::get("/{slug?}", [FrontendController::class, 'page'])->name('page');

});



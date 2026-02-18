<?php

use App\Http\Controllers\Admin\Content\AdsController;
use App\Http\Controllers\Admin\Content\CommentController as ContentCommentController;
use App\Http\Controllers\Admin\Content\FaqController;
use App\Http\Controllers\Admin\Content\MediaController;
use App\Http\Controllers\Admin\Content\MenuController;
use App\Http\Controllers\Admin\Content\PageController;
use App\Http\Controllers\Admin\Content\PodcastCategoryController;
use App\Http\Controllers\Admin\Content\PodcastController as ContentPodcastController;
use App\Http\Controllers\Admin\Content\PostCategoryController;
use App\Http\Controllers\Admin\Content\PostController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Admin\Content\SliderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Log\LogController;
use App\Http\Controllers\Admin\Market\CategoryController;
use App\Http\Controllers\Admin\Market\CommentController;
use App\Http\Controllers\Admin\Market\CourseController;
use App\Http\Controllers\Admin\Market\InstallmentController;
use App\Http\Controllers\Customer\Market\CourseController as CustomerCourseController;
use App\Http\Controllers\Admin\Market\DiscountController;
use App\Http\Controllers\Admin\Market\LessionController;
use App\Http\Controllers\Admin\Market\OrderController;
use App\Http\Controllers\Admin\Market\PaymentController;
use App\Http\Controllers\Admin\Market\PlanController;
use App\Http\Controllers\Admin\Market\SessionController;
use App\Http\Controllers\Admin\Market\SettlementsController;
use App\Http\Controllers\Admin\Market\SubscriptionController;
use App\Http\Controllers\Admin\Market\WalletController;
use App\Http\Controllers\Admin\Notify\EmailController;
use App\Http\Controllers\Admin\Notify\EmailFileController;
use App\Http\Controllers\Admin\Notify\NotificationController;
use App\Http\Controllers\Admin\Notify\SMSController;
use App\Http\Controllers\Admin\Notify\BulkSMSController;
use App\Http\Controllers\Admin\Setting\GatewayController;
use App\Http\Controllers\Admin\Setting\NotificationSettingController;
use App\Http\Controllers\Admin\Setting\SecureRecordController;
use App\Http\Controllers\Admin\Setting\SmsPanelController;
use App\Http\Controllers\Admin\Setting\TemplateSettingController;
use App\Http\Controllers\Admin\Ticket\ContactController;
use App\Http\Controllers\Admin\Ticket\TicketController;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Admin\User\PermissionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\UserLessionReadController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Auth\Customer\AuthController;
use App\Http\Controllers\Customer\Content\BlogController;
use App\Http\Controllers\Customer\Content\PodcastController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\Profile\ProfileController;
use App\Http\Controllers\Customer\SalesProcess\CartController;
use App\Http\Controllers\Customer\SalesProcess\PaymentController as SalesProcessPaymentController;
use App\Http\Controllers\Customer\SalesProcess\ProfileCompletionController;
use App\Http\Controllers\Customer\SitemapController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ProfileCompletion;
use App\Http\Middleware\UserCheckLogin;
use Illuminate\Support\Facades\Route;

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


Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-courseCategories.xml', [SitemapController::class, 'courseCategories'])->name('sitemap.courseCategories');
Route::get('/sitemap-courses.xml', [SitemapController::class, 'courses'])->name('sitemap.course');
Route::get('/sitemap-blogs.xml', [SitemapController::class, 'blogs'])->name('sitemap.blogs');
Route::get('/sitemap-postCategories.xml', [SitemapController::class, 'postCategories'])->name('sitemap.postCategories');
Route::get('/sitemap-page.xml', [SitemapController::class, 'page'])->name('sitemap.page');
Route::get('/sitemap-podcastCategories.xml', [SitemapController::class, 'podcastCategories'])->name('sitemap.podcastCategories');
Route::get('/sitemap-podcasts.xml', [SitemapController::class, 'podcasts'])->name('sitemap.podcasts');







Route::get('/', [HomeController::class, 'index'])->name('customer.home');
Route::get('/contactUs', [HomeController::class, 'contactUs'])->name('customer.contactUs');
Route::post('/contact/store', [HomeController::class, 'contactStore'])->name('customer.contactStore');
Route::get('/rules', [HomeController::class, 'rules'])->name('customer.rules');


Route::get('/page/{page:slug}', [HomeController::class, 'page'])->name('customer.page');
Route::get('/teacher/{user:username?}', [HomeController::class, 'teacher'])->name('customer.teacher');




Route::get('/{lession}/download', [CustomerCourseController::class, 'download'])->name('media.download');
Route::get('/{lession}/fileDownload', [CustomerCourseController::class, 'fileDownload'])->name('media.download.file');
Route::get('/lesson/{course:slug}/{lession}/video-download', [CustomerCourseController::class, 'downloadLessonVideo'])->name('customer.lesson.video.download');

Route::get('/{course}/downloadLinks', [CustomerCourseController::class, 'downloadLinks'])->name('media.downloads');



Route::get('/courses/{courseCategory:slug?}', [CustomerCourseController::class, 'index'])->name('customer.courses');
Route::get('/course/{course:slug}', [CustomerCourseController::class, 'singleCourse'])->name('customer.course.singleCourse');
Route::get('/course/{course:slug}/lession/{lession}', [CustomerCourseController::class, 'showLession'])->name('customer.course.showLession');


Route::post('/add-comment/course/{course:slug}', [CustomerCourseController::class, 'addComment'])->name('customer.course.add-comment');
Route::post('/add-rate/course/{course:slug}', [CustomerCourseController::class, 'addRate'])->name('customer.course.add-rate');



Route::get('/blogs/{postCategory:slug?}', [BlogController::class, 'index'])->name('customer.blogs');
Route::get('/blog/{post:slug}', [BlogController::class, 'post'])->name('customer.singlePost');
Route::post('/add-comment/post/{post:slug}', [BlogController::class, 'addComment'])->name('customer.blog.add-comment');



Route::get('/podcasts/{podcastCategory:slug?}', [PodcastController::class, 'index'])->name('customer.podcasts');
Route::get('/podcast/{podcast:slug}', [PodcastController::class, 'singlePodcast'])->name('customer.singlePodcast');
Route::post('/add-comment/podcast/{podcast:slug}', [PodcastController::class, 'addComment'])->name('customer.podcast.add-comment');


Route::prefix('Auth')->middleware(['throttle:10,1'])->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.customer.registerForm');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.customer.register');
    Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.customer.loginForm');
    Route::get('/verficationEmail/{key}', [AuthController::class, 'verficationEmail'])->name('auth.customer.verficationEmail');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.customer.login');
    Route::get('/forgetPassword', [AuthController::class, 'forgetPasswordForm'])->name('auth.customer.forgetPasswordForm');
    Route::post('/forgetPassword', [AuthController::class, 'forgetPassword'])->name('auth.customer.forgetPassword');
    Route::get('/EmailResetPassword/{token}', [AuthController::class, 'EmailResetPasswordForm'])->name('auth.customer.EmailResetPasswordForm');
    Route::post('/EmailResetPassword/{token}', [AuthController::class, 'EmailResetPassword'])->name('auth.customer.EmailResetPassword');
    Route::get('/mobile', [AuthController::class, 'mobileForm'])->name('auth.customer.mobileForm');
Route::post('/mobile', [AuthController::class, 'mobile'])->name('auth.customer.mobile');
Route::get('mobile-confirm/{token}', [AuthController::class, 'mobileConfirmForm'])->name('auth.customer.mobile-confirm-form');
Route::post('/login-confirm/{token}', [AuthController::class, 'mobileConfirm'])->name('auth.customer.mobile-confirm');
Route::get('/login-resend-otp/{token}', [AuthController::class, 'loginResendOtp'])->name('auth.customer.login-resend-otp');
Route::get('/sms-login', [AuthController::class, 'smsLoginForm'])->name('auth.customer.smsLoginForm');
Route::post('/sms-login', [AuthController::class, 'smsLogin'])->name('auth.customer.smsLogin');
Route::get('/sms-login-confirm/{token}', [AuthController::class, 'smsLoginConfirmForm'])->name('auth.customer.smsLoginConfirmForm');
Route::post('/sms-login-confirm/{token}', [AuthController::class, 'smsLoginConfirm'])->name('auth.customer.smsLoginConfirm');
Route::get('/sms-login-resend-otp/{token}', [AuthController::class, 'smsLoginResendOtp'])->name('auth.customer.smsLoginResendOtp');
Route::get('/sms-forget-password', [AuthController::class, 'smsForgetPasswordForm'])->name('auth.customer.smsForgetPasswordForm');
Route::post('/sms-forget-password', [AuthController::class, 'smsForgetPassword'])->name('auth.customer.smsForgetPassword');
Route::get('/sms-forget-password-confirm/{token}', [AuthController::class, 'smsForgetPasswordConfirmForm'])->name('auth.customer.smsForgetPasswordConfirmForm');
Route::post('/sms-forget-password-confirm/{token}', [AuthController::class, 'smsForgetPasswordConfirm'])->name('auth.customer.smsForgetPasswordConfirm');
Route::get('/sms-reset-password/{token}', [AuthController::class, 'smsResetPasswordForm'])->name('auth.customer.smsResetPasswordForm');
Route::post('/sms-reset-password/{token}', [AuthController::class, 'smsResetPassword'])->name('auth.customer.smsResetPassword');
Route::get('/sms-forget-password-resend-otp/{token}', [AuthController::class, 'smsForgetPasswordResendOtp'])->name('auth.customer.smsForgetPasswordResendOtp');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});





Route::prefix('profile')->middleware(UserCheckLogin::class)->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('customer.profile');
    Route::post('/update', [ProfileController::class, 'update'])->name('customer.profile.update');
    Route::post('/ticket/create', [ProfileController::class, 'createTicket'])->name('customer.profile.ticket.create');
    Route::get('/ticket/show/{ticket}', [ProfileController::class, 'showTicket'])->name('customer.profile.ticket.show');
    Route::post('/answer/{ticket}', [ProfileController::class, 'answerTicket'])->name('customer.profile.ticket.answer');
    Route::post('/buySubscribe/{plan}', [ProfileController::class, 'buySubscribe'])->name('customer.profile.buySubscribe');
    Route::any('/payment-callback/{subscription}/{payment}', [ProfileController::class, 'paymentCallback'])->name('customer.profile.payment-call-back');

    // Customer Schedule Routes
    Route::prefix('schedule')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\ScheduleController::class, 'index'])->name('customer.schedule.index');
        Route::get('/show/{schedule}', [\App\Http\Controllers\Customer\ScheduleController::class, 'show'])->name('customer.schedule.show');
        Route::get('/get-week-schedule', [\App\Http\Controllers\Customer\ScheduleController::class, 'getWeekSchedule'])->name('customer.schedule.get-week');
    });

    // Customer Game Routes
    Route::prefix('game')->group(function () {
        Route::get('/show/{game}', [\App\Http\Controllers\Customer\Market\GameController::class, 'show'])->name('customer.game.show');
    });

    Route::namespace('SalesProcess')->group(function () {
        //cart
        Route::get('/cart', [CartController::class, 'cart'])->name('customer.sales-process.cart');
        Route::post('/copan-discount', [CartController::class, 'copanDiscount'])->name('customer.sales-process.copan-discount');
        Route::post('/add-to-cart/{course:slug}', [CartController::class, 'addToCart'])->name('customer.sales-process.add-to-cart');
        Route::get('/remove-from-cart/{cartItem}', [CartController::class, 'removeFromCart'])->name('customer.sales-process.remove-from-cart');

        //profile completion
        Route::get('/profile-completion', [ProfileCompletionController::class, 'profileCompletion'])->name('customer.sales-process.profile-completion');



        Route::middleware('profile.completion')->group(function () {
            //payment
            Route::post('/payment', [SalesProcessPaymentController::class, 'payment'])->name('customer.sales-process.payment');
            Route::post('/payment-submit', [SalesProcessPaymentController::class, 'paymentSubmit'])->name('customer.sales-process.payment-submit');
            Route::any('/order/payment-callback/{order}/{payment}', [SalesProcessPaymentController::class, 'paymentCallback'])->name('customer.sales-process.payment-call-back');
        });
    });
});
//Dashboard admin
Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
    Route::get('/marketing', [DashboardController::class, 'marketing'])->name('admin.marketing');
    Route::get('/notify', [DashboardController::class, 'notify'])->name('admin.notify');
    
    Route::prefix('game')->group(function () {
        Route::get('/', [GameController::class, 'index'])->name('admin.game.index');
        Route::post('/store', [GameController::class, 'store'])->name('admin.game.store');
        Route::get('/edit/{game}', [GameController::class, 'edit'])->name('admin.game.edit');
        Route::put('/update/{game}', [GameController::class, 'update'])->name('admin.game.update');
        Route::delete('/destroy/{game}', [GameController::class, 'destroy'])->name('admin.game.destroy');
        Route::get('/get-courses', [GameController::class, 'getCourses'])->name('admin.game.get-courses');
        Route::get('/get-seasons-by-course', [GameController::class, 'getSeasonsByCourse'])->name('admin.game.get-seasons-by-course');
        Route::get('/get-sub-seasons-by-main-season', [GameController::class, 'getSubSeasonsByMainSeason'])->name('admin.game.get-sub-seasons-by-main-season');
        Route::get('/get-games-by-sub-season', [GameController::class, 'getGamesBySubSeason'])->name('admin.game.get-games-by-sub-season');
    });

    Route::prefix('user')->namespace('User')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/user-information/{user}', [UserController::class, 'information'])->name('admin.user.user-information.index');
        Route::put('/user-information/{user}', [UserController::class, 'informationUpdate'])->name('admin.user.user-information.update');
        Route::get('/reject/{user}', [UserController::class, 'reject'])->name('admin.user.reject');
        Route::get('/accept/{user}', [UserController::class, 'accept'])->name('admin.user.accept');
        //admin-user
        Route::prefix('admin-user')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('admin.user.admin-user.index');
            Route::get('/roles/{admin}', [AdminUserController::class, 'roles'])->name('admin.user.admin-user.roles');
            Route::post('/roles/{admin}/store', [AdminUserController::class, 'rolesStore'])->name('admin.user.admin-user.roles.store');
            Route::get('/permissions/{admin}', [AdminUserController::class, 'permissions'])->name('admin.user.admin-user.permissions');
            Route::post('/permissions/{admin}/store', [AdminUserController::class, 'permissionsStore'])->name('admin.user.admin-user.permissions.store');
        });
        //role
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('admin.user.role.index');
            Route::get('/create', [RoleController::class, 'create'])->name('admin.user.role.create');
            Route::post('/store', [RoleController::class, 'store'])->name('admin.user.role.store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('admin.user.role.edit');
            Route::put('/update/{role}', [RoleController::class, 'update'])->name('admin.user.role.update');
            Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('admin.user.role.destroy');
            Route::put('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('admin.user.role.permission-update');
        });
        //permission
        Route::prefix('permission')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
            Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
            Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
            Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
            Route::delete('/destroy/{role}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');
        });
    });
    Route::prefix('logs')->group(function () {
        Route::get('/', [LogController::class, 'index'])->name('admin.log.index');
        Route::get('/show/{log}', [LogController::class, 'show'])->name('admin.log.show');
        Route::delete('/destory', [LogController::class, 'destory'])->name('admin.log.destory');
    });
    Route::prefix('market')->group(function () {

        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.market.category.index');
            Route::get('/edit/{courseCategory}', [CategoryController::class, 'edit'])->name('admin.market.category.edit');
            Route::put('/update/{courseCategory}', [CategoryController::class, 'update'])->name('admin.market.category.update');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.market.category.store');
            Route::delete('/destory/{courseCategory}', [CategoryController::class, 'destory'])->name('admin.market.category.destory');
            Route::get('/status/{courseCategory}', [CategoryController::class, 'status'])->name('admin.market.category.status');
        });




        Route::prefix('course')->group(function () {
            //course
            Route::get('/', [CourseController::class, 'index'])->name('admin.market.course.index');
            Route::get('/create', [CourseController::class, 'create'])->name('admin.market.course.create');
            Route::post('/store', [CourseController::class, 'store'])->name('admin.market.course.store');
            Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('admin.market.course.edit');
            Route::put('/update/{course}', [CourseController::class, 'update'])->name('admin.market.course.update');
            Route::delete('/destroy/{course}', [CourseController::class, 'destory'])->name('admin.market.course.destory');
            Route::put('progress/update/{course}', [CourseController::class, 'progressUpdate'])->name('admin.market.course.progress.update');
            Route::get('statistics/{course}', [CourseController::class, 'statistics'])->name('admin.market.course.statistics');
            Route::get('/rejection/{course}', [CourseController::class, 'rejection'])->name('admin.market.course.rejection');
            Route::get('/confirmation/{course}', [CourseController::class, 'confirmation'])->name('admin.market.course.confirmation');
            Route::get('/lockCourse/{course}', [CourseController::class, 'lockCourse'])->name('admin.market.course.lockCourse');
            Route::get('/showStudents/{course}', [CourseController::class, 'showStudentsCourse'])->name('admin.market.course.showStudentsCourse');
            Route::get('/AccessStudentToCourseSatus/{course}/{user}/status', [CourseController::class, 'AccessStudentToCourseSatus'])->name('admin.market.course.AccessStudentToCourseSatus.status');
            Route::get('/details/{course}', [CourseController::class, 'details'])->name('admin.market.course.details');
            Route::post('/add-student/{course}', [CourseController::class, 'addStudent'])->name('admin.market.course.details.addStudent');
            //end

            //session
            Route::prefix('{course}/session')->group(function () {
                Route::post('/', [SessionController::class, 'store'])->name('admin.market.course.session.store');
                Route::get('/edit/{season}', [SessionController::class, 'edit'])->name('admin.market.course.session.edit');
                Route::put('/update/{season}', [SessionController::class, 'update'])->name('admin.market.course.session.update');
                Route::delete('/destroy/{season}', [SessionController::class, 'destroy'])->name('admin.market.course.session.destroy');
                Route::post('/reorder', [SessionController::class, 'reorder'])->name('admin.market.course.session.reorder');
                Route::get('/confirmation_status/{season}/accept', [SessionController::class, 'accept'])->name('admin.market.course.session.accept');
                Route::get('/confirmation_status/{season}/reject', [SessionController::class, 'reject'])->name('admin.market.course.session.reject');
            });
            //endseasion



            //lession

            Route::prefix('{course}/lession')->group(function () {

                Route::delete('/destory/{lession}', [LessionController::class, 'destory'])->name('admin.market.course.lession.destory');
                Route::get('/reject/{lession}', [LessionController::class, 'reject'])->name('admin.market.course.lession.reject');
                Route::get('/accept/{lession}', [LessionController::class, 'accept'])->name('admin.market.course.lession.accept');
                Route::get('/pending/{lession}', [LessionController::class, 'pending'])->name('admin.market.course.lession.pending');
                Route::get('/edit/{lession}', [LessionController::class, 'edit'])->name('admin.market.course.lession.edit');
                Route::put('/update/{lession}', [LessionController::class, 'update'])->name('admin.market.course.lession.update');

                Route::get('/create/{season?}', [LessionController::class, 'create'])->name('admin.market.course.lession.create');
                Route::post('/store/{season?}', [LessionController::class, 'store'])->name('admin.market.course.lession.store');
                Route::patch('/accept-all', [LessionController::class, 'acceptAll'])->name('admin.market.course.lession-details.acceptAll');

                Route::prefix('/season/{season}')->group(function () {
                    Route::get('/', [LessionController::class, 'index'])->name('admin.market.course.season.lession.index');

                    //
                    Route::patch('/accept-multiple', [LessionController::class, 'acceptMultiple'])->name('admin.market.course.lession.acceptMultiple');
                    Route::patch('/reject-multiple', [LessionController::class, 'rejectMultiple'])->name('admin.market.course.lession.rejectMultiple');
                    Route::delete('/delete-multiple', [LessionController::class, 'destroyMultiple'])->name('admin.market.course.lession.destroyMultiple');

                    //
                    Route::post('/reorder', [LessionController::class, 'reorder'])->name('admin.market.course.lession.reorder');
                });
            });
            //comment
            Route::prefix('comment')->group(function () {
                Route::get('/', [CommentController::class, 'index'])->name('admin.market.comment.index');
                Route::get('/show/{comment}', [CommentController::class, 'show'])->name('admin.market.comment.show');
                Route::post('/store', [CommentController::class, 'store'])->name('admin.market.comment.store');
                Route::get('/edit/{id}', [CommentController::class, 'edit'])->name('admin.market.comment.edit');
                Route::put('/update/{id}', [CommentController::class, 'update'])->name('admin.market.comment.update');
                Route::delete('/destroy/{id}', [CommentController::class, 'destroy'])->name('admin.market.comment.destroy');
                Route::get('/approved/{comment}', [CommentController::class, 'approved'])->name('admin.market.comment.approved');
                Route::get('/viewCommentIndex/{comment}', [CommentController::class, 'viewCommentIndex'])->name('admin.market.comment.viewCommentIndex');
                Route::post('/answer/{comment}', [CommentController::class, 'answer'])->name('admin.market.comment.answer');
            });
        });
        // dicount

        Route::prefix('discount')->group(function () {
            //copan
            Route::get('/copan', [DiscountController::class, 'copan'])->name('admin.market.discount.copan');
            Route::get('/copan/create', [DiscountController::class, 'copanCreate'])->name('admin.market.discount.copan.create');
            Route::post('/copan/store', [DiscountController::class, 'copanStore'])->name('admin.market.discount.copan.store');
            Route::get('/copan/edit/{copan}', [DiscountController::class, 'copanEdit'])->name('admin.market.discount.copan.edit');
            Route::put('/copan/update/{copan}', [DiscountController::class, 'copanUpdate'])->name('admin.market.discount.copan.update');
            Route::delete('/copan/destroy/{copan}', [DiscountController::class, 'copanDestroy'])->name('admin.market.discount.copan.destroy');


            //common discount
            Route::get('/common-discount', [DiscountController::class, 'commonDiscount'])->name('admin.market.discount.commonDiscount');
            Route::post('/common-discount/store', [DiscountController::class, 'commonDiscountStore'])->name('admin.market.discount.commonDiscount.store');
            Route::get('/common-discount/edit/{commonDiscount}', [DiscountController::class, 'commonDiscountEdit'])->name('admin.market.discount.commonDiscount.edit');
            Route::put('/common-discount/update/{commonDiscount}', [DiscountController::class, 'commonDiscountUpdate'])->name('admin.market.discount.commonDiscount.update');
            Route::delete('/common-discount/destroy/{commonDiscount}', [DiscountController::class, 'commonDiscountDestroy'])->name('admin.market.discount.commonDiscount.destroy');
            Route::get('/common-discount/create', [DiscountController::class, 'commonDiscountCreate'])->name('admin.market.discount.commonDiscount.create');

            //ajax
            Route::get('/copan/status/{copan}', [DiscountController::class, 'copanStatus'])->name('admin.market.discount.copan.status');
            Route::get('/common-discount/status/{commonDiscount}', [DiscountController::class, 'commonDiscountStatus'])->name('admin.market.discount.commonDiscount.status');
        });

        Route::prefix('subscription')->group(function () {

            Route::prefix('plans')->group(function () {
                Route::get('/', [PlanController::class, 'index'])->name('admin.market.subscription.plan');
                Route::get('/create', [PlanController::class, 'create'])->name('admin.market.subscription.plans.create');
                Route::post('/store', [PlanController::class, 'store'])->name('admin.market.subscription.plans.store');
                Route::get('/edit/{plan}', [PlanController::class, 'edit'])->name('admin.market.subscription.plans.edit');
                Route::put('/update/{plan}', [PlanController::class, 'update'])->name('admin.market.subscription.plans.update');
                Route::delete('/destroy/{plan}', [PlanController::class, 'destroy'])->name('admin.market.subscription.plans.destroy');
            });
            Route::get('/', [SubscriptionController::class, 'index'])->name('admin.market.subscription.index');
            Route::get('/create', [SubscriptionController::class, 'create'])->name('admin.market.subscription.create');
            Route::post('/store', [SubscriptionController::class, 'store'])->name('admin.market.subscription.store');
            // Route::get('/edit/{subscription}', [SubscriptionController::class, 'edit'])->name('admin.market.subscription.edit');
            // Route::put('/update/{subscription}', [SubscriptionController::class, 'update'])->name('admin.market.subscription.update');
            Route::delete('/destroy/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.market.subscription.destroy');
            Route::get('/status/{subscription}', [SubscriptionController::class, 'status'])->name('admin.market.subscription.status');
            Route::get('/details/{subscription}', [SubscriptionController::class, 'details'])->name('admin.market.subscription.details');
        });

        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.market.order.index');
            Route::get('/{user}', [OrderController::class, 'orderUser'])->name('admin.market.order.userOrder');

            Route::get('/details/{order}', [OrderController::class, 'details'])->name('admin.market.order.details');
        });
        Route::prefix('payment')->group(function () {
            Route::get('/', [PaymentController::class, 'index'])->name('admin.market.payment.index');
            Route::get('/detail/{payment}', [PaymentController::class, 'detail'])->name('admin.market.payment.detail');
        });
        Route::prefix('settlements')->group(function () {
            Route::get('/', [SettlementsController::class, 'index'])->name('admin.market.settlements.index');
            Route::get('/create', [SettlementsController::class, 'create'])->name('admin.market.settlements.create');
            Route::post('/store', [SettlementsController::class, 'store'])->name('admin.market.settlements.store');
            //payment money
            Route::get('/payment/{settlement}', [SettlementsController::class, 'payment'])->name('admin.market.settlements.payment');
            Route::put('/payment/{settlement}/store', [SettlementsController::class, 'paymentStore'])->name('admin.market.settlements.payment.store');

            Route::get('/reject/{settlement}', [SettlementsController::class, 'reject'])->name('admin.market.settlements.reject');
            Route::get('/cancelled/{settlement}', [SettlementsController::class, 'cancelled'])->name('admin.market.settlements.cancelled');
            Route::get('/returned/{settlement}', [SettlementsController::class, 'returned'])->name('admin.market.settlements.returned');
        });
        Route::prefix('wallet')->group(function () {
            Route::get('/', [WalletController::class, 'index'])->name('admin.market.wallet.index');
            Route::get('/create', [WalletController::class, 'create'])->name('admin.market.wallet.create');
            Route::post('/store', [WalletController::class, 'store'])->name('admin.market.wallet.store');
            Route::get('/detail/{wallet}', [WalletController::class, 'detail'])->name('admin.market.wallet.detail');
        });
        
        Route::prefix('installment')->group(function () {
            Route::get('/', [InstallmentController::class, 'index'])->name('admin.market.installment.index');
            Route::post('/toggle-status/{installment}', [InstallmentController::class, 'toggleStatus'])->name('admin.market.installment.toggle-status');
        });
    });

    // Weekly Schedule Routes
    Route::prefix('schedule')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('admin.schedule.index');
        Route::get('/create', [\App\Http\Controllers\Admin\ScheduleController::class, 'create'])->name('admin.schedule.create');
        Route::post('/store', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('admin.schedule.store');
        Route::get('/show/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'show'])->name('admin.schedule.show');
        Route::get('/edit/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'edit'])->name('admin.schedule.edit');
        Route::put('/update/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('admin.schedule.update');
        Route::delete('/destroy/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('admin.schedule.destroy');
        Route::get('/get-schedule-data/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'getScheduleData'])->name('admin.schedule.get-data');
        Route::get('/get-lessons-by-course', [\App\Http\Controllers\Admin\ScheduleController::class, 'getLessonsByCourse'])->name('admin.schedule.get-lessons-by-course');
        Route::get('/get-seasons-by-course', [\App\Http\Controllers\Admin\ScheduleController::class, 'getSeasonsByCourse'])->name('admin.schedule.get-seasons-by-course');
        Route::get('/get-sub-seasons-by-main-season', [\App\Http\Controllers\Admin\ScheduleController::class, 'getSubSeasonsByMainSeason'])->name('admin.schedule.get-sub-seasons-by-main-season');
        Route::get('/get-lessons-by-season', [\App\Http\Controllers\Admin\ScheduleController::class, 'getLessonsBySeason'])->name('admin.schedule.get-lessons-by-season');
        Route::get('/get-lessons-by-sub-season', [\App\Http\Controllers\Admin\ScheduleController::class, 'getLessonsBySubSeason'])->name('admin.schedule.get-lessons-by-sub-season');
        Route::post('/send-sms/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'sendScheduleSms'])->middleware('can:send-sms-schedule-panel')->name('admin.schedule.send-sms');
        Route::post('/send-sms-warning/{schedule}', [\App\Http\Controllers\Admin\ScheduleController::class, 'sendWarningSms'])->middleware('can:send-sms-schedule-panel')->name('admin.schedule.sms-warning');
    });

    // User Lesson Read Management Routes
    Route::prefix('user-lesson-read')->group(function () {
        Route::get('/', [UserLessionReadController::class, 'index'])->name('admin.user-lesson-read.index');
        Route::post('/store', [UserLessionReadController::class, 'store'])->name('admin.user-lesson-read.store');
        Route::get('/get-seasons-by-course', [UserLessionReadController::class, 'getSeasonsByCourse'])->name('admin.user-lesson-read.get-seasons-by-course');
        Route::get('/get-sub-seasons-by-main-season', [UserLessionReadController::class, 'getSubSeasonsByMainSeason'])->name('admin.user-lesson-read.get-sub-seasons-by-main-season');
        Route::get('/get-lessons-by-sub-season', [UserLessionReadController::class, 'getLessonsBySubSeason'])->name('admin.user-lesson-read.get-lessons-by-sub-season');
        Route::get('/get-user-stats', [UserLessionReadController::class, 'getUserStats'])->name('admin.user-lesson-read.get-user-stats');
    });

    Route::prefix('content')->group(function () {
        Route::prefix('PodcastCategory')->group(function () {
            Route::get('/', [PodcastCategoryController::class, 'index'])->name('admin.content.podcastCategory.index');
            Route::get('/edit/{podcastCategory}', [PodcastCategoryController::class, 'edit'])->name('admin.content.podcastCategory.edit');
            Route::put('/update/{podcastCategory}', [PodcastCategoryController::class, 'update'])->name('admin.content.podcastCategory.update');
            Route::post('/store', [PodcastCategoryController::class, 'store'])->name('admin.content.podcastCategory.store');
            Route::delete('/destory/{podcastCategory}', [PodcastCategoryController::class, 'destory'])->name('admin.content.podcastCategory.destory');
            Route::get('/status/{podcastCategory}', [PodcastCategoryController::class, 'status'])->name('admin.content.podcastCategory.status');
        });
        Route::prefix('podcast')->group(function () {
            Route::get('/', [ContentPodcastController::class, 'index'])->name('admin.content.podcast.index');
            Route::get('/create', [ContentPodcastController::class, 'create'])->name('admin.content.podcast.create');
            Route::get('/edit/{podcast}', [ContentPodcastController::class, 'edit'])->name('admin.content.podcast.edit');
            Route::put('/update/{podcast}', [ContentPodcastController::class, 'update'])->name('admin.content.podcast.update');
            Route::post('/store', [ContentPodcastController::class, 'store'])->name('admin.content.podcast.store');
            Route::delete('/destory/{podcast}', [ContentPodcastController::class, 'destory'])->name('admin.content.podcast.destory');
            Route::get('/status/{podcast}', [ContentPodcastController::class, 'status'])->name('admin.content.podcast.status');
            Route::get('/accept/{podcast}', [ContentPodcastController::class, 'accept'])->name('admin.content.podcast.accept');
            Route::get('/rejection/{podcast}', [ContentPodcastController::class, 'reject'])->name('admin.content.podcast.reject');

            Route::get('/podcast', [ContentCommentController::class, 'podcast'])->name('admin.content.comment.podcast.index');
            //
            Route::patch('/accept-all', [ContentPodcastController::class, 'acceptAll'])->name('admin.content.podcast.acceptAll');
            Route::patch('/accept-multiple', [ContentPodcastController::class, 'acceptMultiple'])->name('admin.content.podcast.acceptMultiple');
            Route::patch('/reject-multiple', [ContentPodcastController::class, 'rejectMultiple'])->name('admin.content.podcast.rejectMultiple');
            Route::delete('/delete-multiple', [ContentPodcastController::class, 'destroyMultiple'])->name('admin.content.podcast.destroyMultiple');
        });

        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('admin.content.menu.index');
            Route::get('/create', [MenuController::class, 'create'])->name('admin.content.menu.create');
            Route::post('/store', [MenuController::class, 'store'])->name('admin.content.menu.store');
            Route::get('/edit/{menu}', [MenuController::class, 'edit'])->name('admin.content.menu.edit');
            Route::put('/edit/{menu}', [MenuController::class, 'update'])->name('admin.content.menu.update');
            Route::delete('destory/{menu}', [MenuController::class, 'destory'])->name('admin.content.menu.destory');
            Route::get('status/{menu}', [MenuController::class, 'status'])->name('admin.content.menu.status');
        });
        Route::prefix('slider')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('admin.content.slider.index');
            Route::get('/create', [SliderController::class, 'create'])->name('admin.content.slider.create');
            Route::post('/store', [SliderController::class, 'store'])->name('admin.content.slider.store');
            Route::get('/edit/{slider}', [SliderController::class, 'edit'])->name('admin.content.slider.edit');
            Route::put('/edit/{slider}', [SliderController::class, 'update'])->name('admin.content.slider.update');
            Route::delete('destory/{slider}', [SliderController::class, 'destory'])->name('admin.content.slider.destory');
            Route::get('/status/{slider}', [SliderController::class, 'status'])->name('admin.content.slider.status');
        });
        Route::prefix('category')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('admin.content.category.index');
            Route::get('/edit/{postCategory}', [PostCategoryController::class, 'edit'])->name('admin.content.category.edit');
            Route::put('/update/{postCategory}', [PostCategoryController::class, 'update'])->name('admin.content.category.update');
            Route::post('/store', [PostCategoryController::class, 'store'])->name('admin.content.category.store');
            Route::delete('/destory/{postCategory}', [PostCategoryController::class, 'destory'])->name('admin.content.category.destory');
            Route::get('/status/{postCategory}', [PostCategoryController::class, 'status'])->name('admin.content.category.status');
        });


        Route::prefix('post')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.content.post.index');
            Route::get('/create', [PostController::class, 'create'])->name('admin.content.post.create');
            Route::post('/store', [PostController::class, 'store'])->name('admin.content.post.store');
            Route::get('/edit/{post}', [PostController::class, 'edit'])->name('admin.content.post.edit');
            Route::put('/update/{post}', [PostController::class, 'update'])->name('admin.content.post.update');
            Route::delete('/destory/{post}', [PostController::class, 'destory'])->name('admin.content.post.destory');
            Route::get('/status/{post}', [PostController::class, 'status'])->name('admin.content.post.status');
            Route::get('/accept/{post}', [PostController::class, 'accept'])->name('admin.content.post.accept');
            Route::get('/rejection/{post}', [PostController::class, 'reject'])->name('admin.content.post.reject');


            //
            Route::patch('/accept-all', [PostController::class, 'acceptAll'])->name('admin.content.post.acceptAll');
            Route::patch('/accept-multiple', [PostController::class, 'acceptMultiple'])->name('admin.content.post.acceptMultiple');
            Route::patch('/reject-multiple', [PostController::class, 'rejectMultiple'])->name('admin.content.post.rejectMultiple');
            Route::delete('/delete-multiple', [PostController::class, 'destroyMultiple'])->name('admin.content.post.destroyMultiple');
        });
        //comment
        Route::prefix('comment')->group(function () {
            Route::get('/post', [ContentCommentController::class, 'post'])->name('admin.content.comment.post.index');
            Route::get('/show/{comment}', [ContentCommentController::class, 'show'])->name('admin.content.comment.show');
            Route::delete('/destroy/{comment}', [ContentCommentController::class, 'destroy'])->name('admin.content.comment.destroy');
            Route::get('/approved/{comment}', [ContentCommentController::class, 'approved'])->name('admin.content.comment.approved');
            Route::get('/status/{comment}', [ContentCommentController::class, 'status'])->name('admin.content.comment.status');
            Route::post('/answer/{comment}', [ContentCommentController::class, 'answer'])->name('admin.content.comment.answer');
        });
        //faq
        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('admin.content.faq.index');
            Route::get('/create', [FaqController::class, 'create'])->name('admin.content.faq.create');
            Route::post('/store', [FaqController::class, 'store'])->name('admin.content.faq.store');
            Route::get('/edit/{faq}', [FaqController::class, 'edit'])->name('admin.content.faq.edit');
            Route::put('/update/{faq}', [FaqController::class, 'update'])->name('admin.content.faq.update');
            Route::delete('/destroy/{faq}', [FaqController::class, 'destroy'])->name('admin.content.faq.destroy');
            Route::get('/status/{faq}', [FaqController::class, 'status'])->name('admin.content.faq.status');
        });


        //page
        Route::prefix('page')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('admin.content.page.index');
            Route::get('/create', [PageController::class, 'create'])->name('admin.content.page.create');
            Route::post('/store', [PageController::class, 'store'])->name('admin.content.page.store');
            Route::get('/edit/{page}', [PageController::class, 'edit'])->name('admin.content.page.edit');
            Route::put('/update/{page}', [PageController::class, 'update'])->name('admin.content.page.update');
            Route::delete('/destroy/{page}', [PageController::class, 'destroy'])->name('admin.content.page.destroy');
            Route::get('/status/{page}', [PageController::class, 'status'])->name('admin.content.page.status');

            Route::get('/contactUs', [PageController::class, 'contactUs'])->name('admin.content.page.contactUs');
            Route::put('/contactUs/update', [PageController::class, 'contactUsUpdate'])->name('admin.content.page.contactUs.update');
        });
        Route::prefix('media')->group(function () {
            Route::get('/', [MediaController::class, 'index'])->name('admin.content.media.index');
            Route::get('/create', [MediaController::class, 'create'])->name('admin.content.media.create');
            Route::post('/store', [MediaController::class, 'store'])->name('admin.content.media.store');
            Route::get('/details/{media}', [MediaController::class, 'details'])->name('admin.content.media.details');
            Route::delete('/delete/{media}', [MediaController::class, 'destory'])->name('admin.content.media.destory');
            Route::post('/ckeditor/upload', [MediaController::class, 'uploadCkeditorImage'])->name('admin.content.media.uploadCkeditorImage');
            Route::get('/upload/{media}', [MediaController::class, 'upload'])->name('admin.content.media.upload');
            Route::post('/chunkUpload/{media}', [MediaController::class, 'chunkUpload'])->name('admin.content.media.chunkUpload');
            Route::delete('/delete-multiple', [MediaController::class, 'destroyMultiple'])->name('admin.content.media.destroyMultiple');
        });
        Route::prefix('ads')->group(function () {
            Route::get('/', [AdsController::class, 'index'])->name('admin.content.ads.index');
            Route::get('/create', [AdsController::class, 'create'])->name('admin.content.ads.create');
            Route::post('/store', [AdsController::class, 'store'])->name('admin.content.ads.store');
            Route::get('/edit/{ads}', [AdsController::class, 'edit'])->name('admin.content.ads.edit');
            Route::put('/edit/{ads}', [AdsController::class, 'update'])->name('admin.content.ads.update');
            Route::delete('destory/{ads}', [AdsController::class, 'destory'])->name('admin.content.ads.destory');
        });
    });
    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.setting.index');
        Route::put('/update/{setting}', [SettingController::class, 'update'])->name('admin.setting.update');
        Route::get('/other', [SecureRecordController::class, 'index'])->name('admin.setting.secureRecord.index');
        Route::put('/other/update/{setting}', [SecureRecordController::class, 'update'])->name('admin.setting.secureRecord.update');
        //noti settings
        Route::prefix('notification')->namespace('notification')->group(function () {
            Route::get('/', [NotificationSettingController::class, 'index'])->name('admin.setting.notification.index');
            Route::put('/update', [NotificationSettingController::class, 'update'])->name('admin.setting.notification.update');
        });
        Route::prefix('template')->group(function () {
            Route::get('/', [TemplateSettingController::class, 'index'])->name('admin.setting.template.index');
            Route::get('/footer', [TemplateSettingController::class, 'footer'])->name('admin.setting.template.footer');
            Route::put('/footer', [TemplateSettingController::class, 'footerUpdate'])->name('admin.setting.template.footer.update');

            Route::put('/update/{templateSetting}', [TemplateSettingController::class, 'update'])->name('admin.setting.template.update');
        });
        //gateway
        Route::prefix('gateway')->namespace('gateway')->group(function () {
            Route::get('/', [GatewayController::class, 'index'])->name('admin.setting.gateway.index');
            Route::get('/edit/{gateway}', [GatewayController::class, 'edit'])->name('admin.setting.gateway.edit');
            Route::put('/update/{gateway}', [GatewayController::class, 'update'])->name('admin.setting.gateway.update');
            Route::get('/active/{gateway}', [GatewayController::class, 'active'])->name('admin.setting.gateway.active');
        });
            //gateway
        Route::prefix('sms')->namespace('sms')->group(function () {
            Route::get('/', [SmsPanelController::class, 'index'])->name('admin.setting.smsPanel.index');
            Route::get('/edit/{smsPanel}', [SmsPanelController::class, 'edit'])->name('admin.setting.smsPanel.edit');
            Route::put('/update/{smsPanel}', [SmsPanelController::class, 'update'])->name('admin.setting.smsPanel.update');
            Route::get('/active/{smsPanel}', [SmsPanelController::class, 'active'])->name('admin.setting.smsPanel.active');
        });


    });
    Route::prefix('ticket')->namespace('Ticket')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('admin.ticket.index');
        Route::get('/new-tickets', [TicketController::class, 'newTickets'])->name('admin.ticket.newTickets');
        Route::get('/open-tickets', [TicketController::class, 'openTickets'])->name('admin.ticket.openTickets');
        Route::get('/close-tickets', [TicketController::class, 'closeTickets'])->name('admin.ticket.closeTickets');
        Route::get('/show/{ticket}', [TicketController::class, 'show'])->name('admin.ticket.show');
        Route::post('/answer/{ticket}', [TicketController::class, 'answer'])->name('admin.ticket.answer');
        Route::get('/change/{ticket}', [TicketController::class, 'change'])->name('admin.ticket.change');
    });
    Route::prefix('contact')->namespace('Ticket')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('admin.contact.index');
        Route::get('/show/{contact}', [ContactController::class, 'show'])->name('admin.contact.show');
        Route::post('/answer/{contact}', [ContactController::class, 'answer'])->name('admin.contact.answer');
    });


    Route::prefix('notify')->namespace('Notify')->group(function () {

        //email
        Route::prefix('email')->group(function () {
            Route::get('/', [EmailController::class, 'index'])->name('admin.notify.email.index');
            Route::get('/create', [EmailController::class, 'create'])->name('admin.notify.email.create');
            Route::post('/store', [EmailController::class, 'store'])->name('admin.notify.email.store');
            Route::get('/edit/{email}', [EmailController::class, 'edit'])->name('admin.notify.email.edit');
            Route::put('/update/{email}', [EmailController::class, 'update'])->name('admin.notify.email.update');
            Route::delete('/destroy/{email}', [EmailController::class, 'destroy'])->name('admin.notify.email.destroy');
            Route::get('/status/{email}', [EmailController::class, 'status'])->name('admin.notify.email.status');
            Route::get('/send-mail/{email}', [EmailController::class, 'sendMail'])->name('admin.notify.email.send-mail');
        });

        //email file
        Route::prefix('email-file')->group(function () {
            Route::get('/{email}', [EmailFileController::class, 'index'])->name('admin.notify.email-file.index');
            Route::get('/{email}/create', [EmailFileController::class, 'create'])->name('admin.notify.email-file.create');
            Route::post('/{email}/store', [EmailFileController::class, 'store'])->name('admin.notify.email-file.store');
            Route::get('/edit/{file}', [EmailFileController::class, 'edit'])->name('admin.notify.email-file.edit');
            Route::put('/update/{file}', [EmailFileController::class, 'update'])->name('admin.notify.email-file.update');
            Route::delete('/destroy/{file}', [EmailFileController::class, 'destroy'])->name('admin.notify.email-file.destroy');
            Route::get('/status/{file}', [EmailFileController::class, 'status'])->name('admin.notify.email-file.status');
        });

        //sms
        Route::prefix('sms')->group(function () {
            Route::get('/', [SMSController::class, 'index'])->name('admin.notify.sms.index');
            Route::get('/create', [SMSController::class, 'create'])->name('admin.notify.sms.create');
            Route::post('/store', [SMSController::class, 'store'])->name('admin.notify.sms.store');
            Route::get('/edit/{sms}', [SMSController::class, 'edit'])->name('admin.notify.sms.edit');
            Route::put('/update/{sms}', [SMSController::class, 'update'])->name('admin.notify.sms.update');
            Route::delete('/destroy/{sms}', [SMSController::class, 'destroy'])->name('admin.notify.sms.destroy');
            Route::get('/status/{sms}', [SMSController::class, 'status'])->name('admin.notify.sms.status');
            Route::get('/send-sms/{sms}', [SMSController::class, 'sendSMS'])->name('admin.notify.sms.send-sms');
        });

        //bulk sms
        Route::prefix('bulk-sms')->group(function () {
            Route::get('/', [BulkSMSController::class, 'index'])->name('admin.notify.bulk-sms.index');
            Route::get('/create', [BulkSMSController::class, 'create'])->name('admin.notify.bulk-sms.create');
            Route::post('/store', [BulkSMSController::class, 'store'])->name('admin.notify.bulk-sms.store');
            Route::get('/{bulkSMSRecord}', [BulkSMSController::class, 'show'])->name('admin.notify.bulk-sms.show');
        });
        Route::prefix('notification')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('admin.notify.notification.index');
            Route::get('/create', [NotificationController::class, 'create'])->name('admin.notify.notification.create');
            Route::post('/store', [NotificationController::class, 'store'])->name('admin.notify.notification.store');
            Route::get('/edit/{notification}', [NotificationController::class, 'edit'])->name('admin.notify.notification.edit');
            Route::put('/update/{notification}', [NotificationController::class, 'update'])->name('admin.notify.notification.update');
            Route::delete('/destroy/{notification}', [NotificationController::class, 'destroy'])->name('admin.notify.notification.destroy');
            Route::get('/status/{notification}', [NotificationController::class, 'status'])->name('admin.notify.notification.status');
        });
    });
});

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


//Payment IPN
Route::get('/ipnbtc', 'User\DepositController@ipnBchain')->name('ipn.bchain');
Route::get('/ipnblockbtc', 'User\DepositController@blockIpnBtc')->name('ipn.block.btc');
Route::get('/ipnblocklite', 'User\DepositController@blockIpnLite')->name('ipn.block.lite');
Route::get('/ipnblockdog', 'User\DepositController@blockIpnDog')->name('ipn.block.dog');
Route::post('/ipnpaypal', 'User\DepositController@ipnpaypal')->name('ipn.paypal');
Route::post('/ipnperfect', 'User\DepositController@ipnperfect')->name('ipn.perfect');
Route::post('/ipnstripe', 'User\DepositController@ipnstripe')->name('ipn.stripe');
Route::post('/ipnskrill', 'User\DepositController@skrillIPN')->name('ipn.skrill');
Route::post('/ipncoinpaybtc', 'User\DepositController@ipnCoinPayBtc')->name('ipn.coinPay.btc');
Route::post('/ipncoinpayeth', 'User\DepositController@ipnCoinPayEth')->name('ipn.coinPay.eth');
Route::post('/ipncoinpaybch', 'User\DepositController@ipnCoinPayBch')->name('ipn.coinPay.bch');
Route::post('/ipncoinpaydash', 'User\DepositController@ipnCoinPayDash')->name('ipn.coinPay.dash');
Route::post('/ipncoinpaydoge', 'User\DepositController@ipnCoinPayDoge')->name('ipn.coinPay.doge');
Route::post('/ipncoinpayltc', 'User\DepositController@ipnCoinPayLtc')->name('ipn.coinPay.ltc');
Route::post('/ipncoin', 'User\DepositController@ipnCoin')->name('ipn.coinpay');
Route::post('/ipncoingate', 'User\DepositController@ipnCoinGate')->name('ipn.coingate');
//Payment IPN


Route::get('/', 'User\PagesController@home')->name('user.home')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/contact', 'User\PagesController@contact')->name('user.contact');
Route::get('/about', 'User\PagesController@about')->name('user.about');
Route::get('/hotels', 'User\PagesController@hotels')->name('user.hotels')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/hotel/{id}/show', 'User\HotelController@show')->name('user.hotel.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/hotel/review', 'User\HotelController@review')->name('user.hotel.review');
Route::get('/room/{id}/show', 'User\RoomController@show')->name('user.room.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/room/review', 'User\RoomController@review')->name('user.room.review');
Route::post('/room/booking', 'User\RoomController@booking')->name('user.room.booking');
Route::get('/room/search', 'User\RoomController@search')->name('user.room.search');
Route::get('/packages', 'User\PackageController@index')->name('user.package.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/package/{id}/show', 'User\PackageController@show')->name('user.package.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/package/buy', 'User\PackageController@buy')->name('user.package.buy');
Route::get('/package/search', 'User\PackageController@search')->name('user.package.search');
Route::get('/lounges', 'User\LoungeController@index')->name('user.lounge.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/lounge/{id}/show', 'User\LoungeController@show')->name('user.lounge.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/lounge/review', 'User\LoungeController@review')->name('user.lounge.review');
Route::post('/lounge/booking', 'User\LoungeController@booking')->name('user.lounge.booking');
Route::get('/lounge/search', 'User\LoungeController@search')->name('user.lounge.search');
Route::get('/pickups/index', 'User\PickupController@index')->name('user.pickup.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/pickup/{id}/show', 'User\PickupController@show')->name('user.pickup.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/pickup/review', 'User\PickupController@review')->name('user.pickup.review');
Route::post('/pickup/booking', 'User\PickupController@booking')->name('user.pickup.booking');
Route::get('/pickup/search', 'User\PickupController@search')->name('user.pickup.search');
Route::get('/rentcar/index', 'User\RentCarController@index')->name('user.rentcar.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::get('/rentcar/{id}/show', 'User\RentCarController@show')->name('user.rentcar.show')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
Route::post('/rentcar/review', 'User\RentCarController@review')->name('user.rentcar.review');
Route::post('/rentcar/booking', 'User\RentCarController@booking')->name('user.rentcar.booking');
Route::get('/rentcar/search', 'User\RentCarController@search')->name('user.rentcar.search');


// Subscription Store Route
Route::post('/subscriber', 'User\SubscriberController@store')->name('users.subsc.store');






// Ad increase route
Route::post('/ad/increaseAdView', 'User\AdController@increaseAdView')->name('ad.increaseAdView');

#=========== User Routes =============#
Route::group(['prefix' => 'user', 'middleware' => 'guest'], function () {
  Route::get('/showLoginForm', 'User\LoginController@showLoginForm')->name('user.showLoginForm');
  Route::post('/login', 'User\LoginController@authenticate')->name('user.login');

  Route::get('/showRegForm', 'User\RegController@showRegForm')->name('user.showRegForm');
  Route::post('/register', 'User\RegController@register')->name('user.reg');


  // Dynamic Routes
  Route::get('/{slug}/pages', 'User\PagesController@dynamicPage')->name('user.dynamicPage');


  // Contact Routes
  Route::get('/contact', 'User\PagesController@contact')->name('user.contact');
  Route::post('/contact/mail', 'User\PagesController@contactMail')->name('user.contactMail');



  // Password Reset Routes
  Route::get('/showEmailForm', 'User\ForgotPasswordController@showEmailForm')->name('user.showEmailForm');
  Route::post('/sendResetPassMail', 'User\ForgotPasswordController@sendResetPassMail')->name('user.sendResetPassMail');
  Route::get('/reset/{code}', 'User\ForgotPasswordController@resetPasswordForm')->name('user.resetPasswordForm');
  Route::post('/resetPassword', 'User\ForgotPasswordController@resetPassword')->name('user.resetPassword');
});

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/logout/{id?}', 'User\LoginController@logout')->name('user.logout');



    // Verification Routes...
    Route::get('/showEmailVerForm', 'User\VerificationController@showEmailVerForm')->name('user.showEmailVerForm');
  	Route::get('/showSmsVerForm', 'User\VerificationController@showSmsVerForm')->name('user.showSmsVerForm');
    Route::post('/checkEmailVerification', 'User\VerificationController@emailVerification')->name('user.checkEmailVerification');
    Route::post('/checkSmsVerification', 'User\VerificationController@smsVerification')->name('user.checkSmsVerification');
  	Route::post('/sendVcode', 'User\VerificationController@sendVcode')->name('user.sendVcode');



    // Package Routes
    Route::get('/packages', 'User\PackageController@index')->name('package.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser', 'packVal');
    Route::post('/package/buy', 'User\PackageController@buy')->name('package.buy');
    Route::get('/favorites', 'User\FavoriteController@index')->name('favorites.index')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');



	 Route::get('/transactions', 'User\TrxController@trxLog')->name('user.trxLog')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');


    // Profile Routes
    Route::get('/change-password', 'User\ProfileController@changePassword')->name('users.editPassword')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
  	Route::post('/update-password', 'User\ProfileController@updatePassword')->name('users.updatePassword');
    Route::get('/edit-profile', 'User\ProfileController@editprofile')->name('users.editprofile')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
  	Route::post('/update-profile', 'User\ProfileController@updateprofile')->name('users.updateprofile');




    // Bookings Routes
    Route::get('package/bookings', 'User\BookingController@package')->name('user.booking.package')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
    Route::get('room/bookings', 'User\BookingController@room')->name('user.booking.room')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
    Route::get('pickup/bookings', 'User\BookingController@pickup')->name('user.booking.pickup')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
    Route::get('rentcar/bookings', 'User\BookingController@rentcar')->name('user.booking.rentcar')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
    Route::get('lounge/bookings', 'User\BookingController@lounge')->name('user.booking.lounge')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');



    // Rejection Request
    Route::post('lounge/message', 'User\BookingController@loungemessage')->name('user.lounge.message');
    Route::post('room/message', 'User\BookingController@roommessage')->name('user.room.message');
    Route::post('package/message', 'User\BookingController@packagemessage')->name('user.package.message');
    Route::post('pickup/message', 'User\BookingController@pickupmessage')->name('user.pickup.message');
    Route::post('rent/message', 'User\BookingController@rentmessage')->name('user.rent.message');






    // All deposit methods...
  	Route::match(['get', 'post'], '/depositMethods', 'User\DepositController@showDepositMethods')->name('users.showDepositMethods')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
  	Route::post('/depositDataInsert', 'User\DepositController@depositDataInsert')->name('users.depositDataInsert');
  	Route::get('/deposit-preview', 'User\DepositController@depositPreview')->name('user.deposit.preview')->middleware('userEmailVerification', 'userSmsVerification', 'bannedUser');
  	Route::post('/deposit-confirm', 'User\DepositController@depositConfirm')->name('deposit.confirm');


});





#=========== Admin Routes =============#
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
	Route::get('/','Admin\AdminLoginController@index')->name('admin.loginForm');
	Route::post('/', 'Admin\AdminLoginController@authenticate')->name('admin.login');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
  Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');
	Route::get('/logout', 'Admin\AdminController@logout')->name('admin.logout');



  // Profile Routes

  Route::get('/changePassword', 'Admin\AdminController@changePass')->name('admin.changePass');
  Route::post('/profile/updatePassword', 'Admin\AdminController@updatePassword')->name('admin.updatePassword');
  Route::get('/profile/edit/{adminID}', 'Admin\AdminController@editProfile')->name('admin.editProfile');
	Route::post('/profile/update/{adminID}', 'Admin\AdminController@updateProfile')->name('admin.updateProfile');




  // Website Control Routes...
  Route::get('/generalSetting', 'Admin\GeneralSettingController@GenSetting')->name('admin.GenSetting');
	Route::post('/generalSetting', 'Admin\GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');
  Route::get('/EmailSetting', 'Admin\EmailSettingController@index')->name('admin.EmailSetting');
  Route::post('/EmailSetting', 'Admin\EmailSettingController@updateEmailSetting')->name('admin.UpdateEmailSetting');
  Route::get('/SmsSetting', 'Admin\SmsSettingController@index')->name('admin.SmsSetting');
  Route::post('/SmsSetting', 'Admin\SmsSettingController@updateSmsSetting')->name('admin.UpdateSmsSetting');



  // Ammenties Management...
  Route::get('/amenities/index', 'Admin\AmenityController@index')->name('admin.amenities.index');
  Route::post('/amenity/store', 'Admin\AmenityController@store')->name('admin.amenity.store');
  Route::post('/amenity/update', 'Admin\AmenityController@update')->name('admin.amenity.update');




  // Package Management
  Route::get('/package/index', 'Admin\PackageController@index')->name('admin.package.index');
  Route::get('/package/create', 'Admin\PackageController@create')->name('admin.package.create');
  Route::get('/package/{id}/edit', 'Admin\PackageController@edit')->name('admin.package.edit');
  Route::post('/package/store', 'Admin\PackageController@store')->name('admin.package.store');
  Route::post('/package/update', 'Admin\PackageController@update')->name('admin.package.update');
  Route::post('/package/hide', 'Admin\PackageController@hide')->name('admin.package.hide');
  Route::post('/package/show', 'Admin\PackageController@show')->name('admin.package.show');
  Route::get('/package/{id}/images', 'Admin\PackageController@getimgs')->name('admin.package.imgs');
  Route::get('/package/all', 'Admin\PackageController@all')->name('admin.package.all');
  Route::post('/package/accept', 'Admin\PackageController@accept')->name('admin.package.accept');
  Route::get('/package/rejected', 'Admin\PackageController@rejected')->name('admin.package.rejected');
  Route::post('/package/reject', 'Admin\PackageController@reject')->name('admin.package.reject');
  Route::get('/package/rejrequest', 'Admin\PackageController@rejrequest')->name('admin.package.rejrequest');




  // Hotel Management
  Route::get('/hotel/index', 'Admin\HotelController@index')->name('admin.hotel.index');
  Route::get('/hotel/create', 'Admin\HotelController@create')->name('admin.hotel.create');
  Route::get('/hotel/{id}/edit', 'Admin\HotelController@edit')->name('admin.hotel.edit');
  Route::post('/hotel/store', 'Admin\HotelController@store')->name('admin.hotel.store');
  Route::post('/hotel/update', 'Admin\HotelController@update')->name('admin.hotel.update');
  Route::post('/hotel/hide', 'Admin\HotelController@hide')->name('admin.hotel.hide');
  Route::post('/hotel/show', 'Admin\HotelController@show')->name('admin.hotel.show');
  Route::get('/hotel/{id}/images', 'Admin\HotelController@getimgs')->name('admin.hotel.imgs');
  Route::get('/room/all', 'Admin\HotelController@all')->name('admin.room.all');
  Route::post('/room/accept', 'Admin\HotelController@accept')->name('admin.room.accept');
  Route::get('/room/rejected', 'Admin\HotelController@rejected')->name('admin.room.rejected');
  Route::post('/room/reject', 'Admin\HotelController@reject')->name('admin.room.reject');
  Route::get('/room/rejrequest', 'Admin\HotelController@rejrequest')->name('admin.room.rejrequest');




  // Lounge Management
  Route::get('/lounge/index', 'Admin\LoungeController@index')->name('admin.lounge.index');
  Route::get('/lounge/create', 'Admin\LoungeController@create')->name('admin.lounge.create');
  Route::get('/lounge/{id}/edit', 'Admin\LoungeController@edit')->name('admin.lounge.edit');
  Route::post('/lounge/store', 'Admin\LoungeController@store')->name('admin.lounge.store');
  Route::post('/lounge/update', 'Admin\LoungeController@update')->name('admin.lounge.update');
  Route::post('/lounge/hide', 'Admin\LoungeController@hide')->name('admin.lounge.hide');
  Route::post('/lounge/show', 'Admin\LoungeController@show')->name('admin.lounge.show');
  Route::get('/lounge/{id}/images', 'Admin\LoungeController@getimgs')->name('admin.lounge.imgs');
  Route::get('/lounge/all', 'Admin\LoungeController@all')->name('admin.lounge.all');
  Route::post('/lounge/accept', 'Admin\LoungeController@accept')->name('admin.lounge.accept');
  Route::get('/lounge/rejected', 'Admin\LoungeController@rejected')->name('admin.lounge.rejected');
  Route::post('/lounge/reject', 'Admin\LoungeController@reject')->name('admin.lounge.reject');
  Route::get('/lounge/rejrequest', 'Admin\LoungeController@rejrequest')->name('admin.lounge.rejrequest');



  // Pickup Car Management
  Route::get('/pickupcar/index', 'Admin\PickupcarController@index')->name('admin.pickupcar.index');
  Route::get('/pickupcar/create', 'Admin\PickupcarController@create')->name('admin.pickupcar.create');
  Route::get('/pickupcar/{id}/edit', 'Admin\PickupcarController@edit')->name('admin.pickupcar.edit');
  Route::post('/pickupcar/store', 'Admin\PickupcarController@store')->name('admin.pickupcar.store');
  Route::post('/pickupcar/update', 'Admin\PickupcarController@update')->name('admin.pickupcar.update');
  Route::post('/pickupcar/hide', 'Admin\PickupcarController@hide')->name('admin.pickupcar.hide');
  Route::post('/pickupcar/show', 'Admin\PickupcarController@show')->name('admin.pickupcar.show');
  Route::get('/pickupcar/{id}/images', 'Admin\PickupcarController@getimgs')->name('admin.pickupcar.imgs');
  Route::get('/pickupcar/all', 'Admin\PickupcarController@all')->name('admin.pickupcar.all');
  Route::post('/pickupcar/accept', 'Admin\PickupcarController@accept')->name('admin.pickupcar.accept');
  Route::get('/pickupcar/rejected', 'Admin\PickupcarController@rejected')->name('admin.pickupcar.rejected');
  Route::post('/pickupcar/reject', 'Admin\PickupcarController@reject')->name('admin.pickupcar.reject');
  Route::get('/pickupcar/rejrequest', 'Admin\PickupcarController@rejrequest')->name('admin.pickupcar.rejrequest');





  // Dropoff Location Management
  Route::get('/pickup/{id}/dropoffs', 'Admin\DropoffController@index')->name('admin.pickup.dropoffs');
  Route::get('/dropoff/{id}/create', 'Admin\DropoffController@create')->name('admin.dropoff.create');
  Route::get('/dropoff/{id}/edit', 'Admin\DropoffController@edit')->name('admin.dropoff.edit');
  Route::post('/dropoff/store', 'Admin\DropoffController@store')->name('admin.dropoff.store');
  Route::post('/dropoff/update', 'Admin\DropoffController@update')->name('admin.dropoff.update');
  Route::post('/dropoff/hide', 'Admin\DropoffController@hide')->name('admin.dropoff.hide');
  Route::post('/dropoff/show', 'Admin\DropoffController@show')->name('admin.dropoff.show');



  // Room Management
  Route::get('/hotel/{id}/rooms', 'Admin\RoomController@index')->name('admin.hotel.rooms');
  Route::get('/room/{id}/create', 'Admin\RoomController@create')->name('admin.room.create');
  Route::get('/room/{id}/edit', 'Admin\RoomController@edit')->name('admin.room.edit');
  Route::post('/room/store', 'Admin\RoomController@store')->name('admin.room.store');
  Route::post('/room/update', 'Admin\RoomController@update')->name('admin.room.update');
  Route::post('/room/hide', 'Admin\RoomController@hide')->name('admin.room.hide');
  Route::post('/room/show', 'Admin\RoomController@show')->name('admin.room.show');
  Route::get('/room/{id}/images', 'Admin\RoomController@getimgs')->name('admin.room.imgs');




  // Rent Car Management
  Route::get('/rentcar/index', 'Admin\RentcarController@index')->name('admin.rentcar.index');
  Route::get('/rentcar/create', 'Admin\RentcarController@create')->name('admin.rentcar.create');
  Route::get('/rentcar/{id}/edit', 'Admin\RentcarController@edit')->name('admin.rentcar.edit');
  Route::post('/rentcar/store', 'Admin\RentcarController@store')->name('admin.rentcar.store');
  Route::post('/rentcar/update', 'Admin\RentcarController@update')->name('admin.rentcar.update');
  Route::post('/rentcar/hide', 'Admin\RentcarController@hide')->name('admin.rentcar.hide');
  Route::post('/rentcar/show', 'Admin\RentcarController@show')->name('admin.rentcar.show');
  Route::get('/rentcar/{id}/images', 'Admin\RentcarController@getimgs')->name('admin.rentcar.imgs');
  Route::get('/rentcar/all', 'Admin\RentcarController@all')->name('admin.rentcar.all');
  Route::post('/rentcar/accept', 'Admin\RentcarController@accept')->name('admin.rentcar.accept');
  Route::get('/rentcar/rejected', 'Admin\RentcarController@rejected')->name('admin.rentcar.rejected');
  Route::post('/rentcar/reject', 'Admin\RentcarController@reject')->name('admin.rentcar.reject');
  Route::get('/rentcar/rejrequest', 'Admin\RentcarController@rejrequest')->name('admin.rentcar.rejrequest');





  // User management Routes...
	Route::get('/userManagement/allUsers', 'Admin\UserManagementController@allUsers')->name('admin.allUsers');
  Route::get('/userManagement/allUsersSearchResult', 'Admin\UserManagementController@allUsersSearchResult' )->name('admin.allUsersSearchResult');
  Route::get('/userManagement/bannedUsers', 'Admin\UserManagementController@bannedUsers')->name('admin.bannedUsers');
	Route::get('/userManagement/bannedUsersSearchResult', 'Admin\UserManagementController@bannedUsersSearchResult' )->name('admin.bannedUsersSearchResult');
  Route::get('/userManagement/verifiedUsers', 'Admin\UserManagementController@verifiedUsers')->name('admin.verifiedUsers');
  Route::get('/userManagement/verUsersSearchResult', 'Admin\UserManagementController@verUsersSearchResult' )->name('admin.verUsersSearchResult');
  Route::get('/userManagement/mobileUnverifiedUsers', 'Admin\UserManagementController@mobileUnverifiedUsers')->name('admin.mobileUnverifiedUsers');
	Route::get('/userManagement/mobileUnverifiedUsersSearchResult', 'Admin\UserManagementController@mobileUnverifiedUsersSearchResult' )->name('admin.mobileUnverifiedUsersSearchResult');
  Route::get('/userManagement/emailUnverifiedUsers', 'Admin\UserManagementController@emailUnverifiedUsers')->name('admin.emailUnverifiedUsers');
  Route::get('/userManagement/emailUnverifiedUsersSearchResult', 'Admin\UserManagementController@emailUnverifiedUsersSearchResult' )->name('admin.emailUnverifiedUsersSearchResult');
	Route::get('/userManagement/userDetails/{userID}', 'Admin\UserManagementController@userDetails')->name('admin.userDetails');
  Route::post('/userManagement/updateUserDetails', 'Admin\UserManagementController@updateUserDetails')->name('admin.updateUserDetails');
  Route::get('/userManagement/addSubtractBalance/{userID}', 'Admin\UserManagementController@addSubtractBalance')->name('admin.addSubtractBalance');
  Route::post('/userManagement/updateUserBalance', 'Admin\UserManagementController@updateUserBalance')->name('admin.updateUserBalance');
  Route::get('/userManagement/emailToUser/{userID}', 'Admin\UserManagementController@emailToUser')->name('admin.emailToUser');
  Route::post('/userManagement/sendEmailToUser', 'Admin\UserManagementController@sendEmailToUser')->name('admin.sendEmailToUser');
  Route::get('/userManagement/depositLog/{userID}', 'Admin\UserManagementController@depositLog')->name('admin.userManagement.depositLog');
	Route::get('/userManagement/ads/{userID}', 'Admin\UserManagementController@ads')->name('admin.userManagement.ads');
  Route::get('/userManagement/transactions/{userID}', 'Admin\UserManagementController@trxlog')->name('admin.userManagement.trxlog');



  // Subscriber Management Routes
  Route::get('/subscribers', 'Admin\SubscManageController@subscribers')->name('admin.subscribers');
	Route::post('/mailtosubsc', 'Admin\SubscManageController@mailtosubsc')->name('admin.mailtosubsc');



  // Gateway Routes...
  Route::get('/gateways', 'Admin\GatewayController@index')->name('admin.gateways');
	Route::post('/gateway/update', 'Admin\GatewayController@update')->name('update.gateway');
	Route::post('/gateway/store', 'Admin\GatewayController@store')->name('store.gateway');




  // Menu Manager Routes
  Route::get('/menuManager/index', 'Admin\menuManagerController@index')->name('admin.menuManager.index');
	Route::post('/menuManager/store', 'Admin\menuManagerController@store')->name('admin.menuManager.store');
	Route::get('/menuManager/{menuID}/edit', 'Admin\menuManagerController@edit')->name('admin.menuManager.edit');
	Route::post('/menuManager/{menuID}/update', 'Admin\menuManagerController@update')->name('admin.menuManager.update');
	Route::post('/menuManager/{menuID}/delete', 'Admin\menuManagerController@delete')->name('admin.menuManager.delete');





  // Deposit Routes...
  Route::get('/deposit/pending','Admin\DepositController@pending')->name('admin.deposit.pending');
	Route::get('/deposit/showReceipt', 'Admin\DepositController@showReceipt')->name('admin.deposit.showReceipt');
	Route::post('/deposit/accept', 'Admin\DepositController@accept')->name('admin.deposit.accept');
	Route::post('/deposit/rejectReq','Admin\DepositController@rejectReq')->name('admin.deposit.rejectReq');
	Route::get('/deposit/acceptedRequests','Admin\DepositController@acceptedRequests')->name('admin.deposit.acceptedRequests');
	Route::get('/deposit/depositLog','Admin\DepositController@depositLog')->name('admin.deposit.depositLog');
	Route::get('/deposit/rejectedRequests','Admin\DepositController@rejectedRequests')->name('admin.deposit.rejectedRequests');




  // Interface Control Routes
  Route::get('/interfaceControl/logoIcon/index', 'Admin\InterfaceControl\LogoIconController@index')->name('admin.logoIcon.index');
	Route::post('/interfaceControl/logoIcon/update', 'Admin\InterfaceControl\LogoIconController@update')->name('admin.logoIcon.update');
  Route::get('/interfaceControl/about/index', 'Admin\InterfaceControl\AboutController@index')->name('admin.about.index');
  Route::post('/interfaceControl/about/update', 'Admin\InterfaceControl\AboutController@update')->name('admin.about.update');
  Route::get('/interfaceControl/slider/index', 'Admin\InterfaceControl\SliderController@index')->name('admin.slider.index');
	Route::post('/interfaceControl/slider/store', 'Admin\InterfaceControl\SliderController@store')->name('admin.slider.store');
	Route::post('/interfaceControl/slider/delete', 'Admin\InterfaceControl\SliderController@delete')->name('admin.slider.delete');
  Route::get('/interfaceControl/package/index', 'Admin\InterfaceControl\PackageController@index')->name('admin.ppackage.index');
	Route::post('/interfaceControl/package/update', 'Admin\InterfaceControl\PackageController@update')->name('admin.ppackage.update');
  Route::get('/interfaceControl/hotel/index', 'Admin\InterfaceControl\HotelController@index')->name('admin.photel.index');
  Route::post('/interfaceControl/hotel/update', 'Admin\InterfaceControl\HotelController@update')->name('admin.photel.update');
  Route::get('/interfaceControl/lounge/index', 'Admin\InterfaceControl\LoungeController@index')->name('admin.plounge.index');
  Route::post('/interfaceControl/lounge/update', 'Admin\InterfaceControl\LoungeController@update')->name('admin.plounge.update');
  Route::get('/interfaceControl/subsc/index', 'Admin\InterfaceControl\SubscSectionController@index')->name('admin.subsc.index');
  Route::post('/interfaceControl/subsc/update', 'Admin\InterfaceControl\SubscSectionController@update')->name('admin.subsc.update');
  Route::get('/interfaceControl/contact/index', 'Admin\InterfaceControl\ContactController@index')->name('admin.contact.index');
  Route::post('/interfaceControl/contact/update', 'Admin\InterfaceControl\ContactController@update')->name('admin.contact.update');
  Route::get('/interfaceControl/background/index', 'Admin\InterfaceControl\BackgroundImageController@background')->name('admin.background.index');
	Route::post('/interfaceControl/background/update', 'Admin\InterfaceControl\BackgroundImageController@backgroundUpdate')->name('admin.background.update');
  Route::get('/interfaceControl/fbComments/index', 'Admin\InterfaceControl\fbCommentController@index')->name('admin.fbComment.index');
	Route::post('/interfaceControl/fbComments/update', 'Admin\InterfaceControl\fbCommentController@update')->name('admin.fbComment.update');
  Route::get('/interfaceControl/footer/index', 'Admin\InterfaceControl\FooterController@index')->name('admin.footer.index');
	Route::post('/interfaceControl/footer/update', 'Admin\InterfaceControl\FooterController@update')->name('admin.footer.update');
  Route::get('/interfaceControl/choose/index', 'Admin\InterfaceControl\ChooseSectionController@index')->name('admin.choose.index');
	Route::post('/interfaceControl/choose/update', 'Admin\InterfaceControl\ChooseSectionController@textupdate')->name('admin.choose.textupdate');
	Route::post('/interfaceControl/choose/store', 'Admin\InterfaceControl\ChooseSectionController@store')->name('admin.choose.store');
	Route::post('/interfaceControl/choose/update/{choose}', 'Admin\InterfaceControl\ChooseSectionController@update')->name('admin.choose.update');
	Route::post('/interfaceControl/choose/destroy', 'Admin\InterfaceControl\ChooseSectionController@destroy')->name('admin.choose.destroy');




  // Ad Routes...
  Route::get('/Ad/index', 'Admin\AdController@index')->name('admin.ad.index');
	Route::get('/Ad/create', 'Admin\AdController@create')->name('admin.ad.create');
	Route::post('/Ad/store', 'Admin\AdController@store')->name('admin.ad.store');
	Route::get('/Ad/showImage', 'Admin\AdController@showImage')->name('admin.ad.showImage');
	Route::post('/Ad/delete', 'Admin\AdController@delete')->name('admin.ad.delete');



  // Transactions Route...
  Route::get('/trxlog', 'Admin\TrxController@index')->name('admin.trxLog');


  Route::get('/tos/index', 'Admin\TosController@index')->name('admin.tos.index');
	Route::post('/tos/update', 'Admin\TosController@update')->name('admin.tos.update');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ContactController;
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

Route::get('/', function () {
	return view('welcome');
});
Route::get('/send-email/{username?}/{email?}/{message?}/{token?}', [ContactController::class, 'sendEmail'])->name('sendemail');

Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('login', [CustomAuthController::class, 'customLogin'])->name('login');

Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('register', [CustomAuthController::class, 'customRegistration'])->name('register');
Route::get('register/sponsorId={sponsorId?}&amp;position={position?}', [CustomAuthController::class, 'registrationwithlink']);

Route::get('logout', [CustomAuthController::class, 'logOut'])->name('logout');
Route::post('logout', [CustomAuthController::class, 'logOut'])->name('logout');

Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('add_funds', 'App\Http\Controllers\Funds\Add_FundsController@index')->name('add_funds')->middleware('auth');
	Route::post('add_funds/payment', 'App\Http\Controllers\Funds\Add_FundsController@payment')->name('add_funds_payment')->middleware('auth');
	Route::post('add_funds/payment/admin', 'App\Http\Controllers\Funds\Add_FundsController@admin_payment')->name('add_funds_payment_admin')->middleware('auth');

	Route::get('pending_transactions', 'App\Http\Controllers\Funds\PendingController@index')->name('pending_transactions')->middleware('auth');

	Route::get('confirmed_transactions', 'App\Http\Controllers\Funds\ConfirmController@index')->name('confirmed_transactions')->middleware('auth');

	Route::get('expired_transactions', 'App\Http\Controllers\Funds\ExpireController@index')->name('expired_transactions')->middleware('auth');

	Route::get('make_investment', 'App\Http\Controllers\Funds\InvestmentController@index')->name('make_investment')->middleware('auth');
	Route::post('make_investment/post', 'App\Http\Controllers\Funds\InvestmentController@investment')->name('post_make_investment')->middleware('auth');

	Route::get('invest_others', 'App\Http\Controllers\Funds\InvestForOtherController@index')->name('invest_others')->middleware('auth');
	Route::post('invest_others/post', 'App\Http\Controllers\Funds\InvestForOtherController@investforother')->name('post_make_investment')->middleware('auth');

	Route::get('wallet_transfer', 'App\Http\Controllers\Funds\WalletTransferController@index')->name('wallet_transfer')->middleware('auth');
	Route::post('wallet_transfer/post', 'App\Http\Controllers\Funds\WalletTransferController@transfer')->name('post_wallet_transfer')->middleware('auth');

	Route::get('wallet_withdrawal', 'App\Http\Controllers\Funds\TransferToCashwalletController@index')->name('wallet_withdrawal')->middleware('auth');
	Route::post('wallet_withdrawal/post', 'App\Http\Controllers\Funds\TransferToCashwalletController@transfertocash')->name('post_wallet_withdrawal')->middleware('auth');

	Route::get('affiliate_presentaion', function () {
		return view('pages.affiliate.presentation');
	})->name('affiliate_presentaion');

	// team
	// Route::get('genealogy_tree', 'App\Http\Controllers\Team\GenealogyController@index')->name('genealogy_tree')->middleware('auth');
	Route::get('genealogy_tree/{id?}', 'App\Http\Controllers\Team\GenealogyController@index')->name('genealogy_tree')->middleware('auth');

	Route::get('direct_referral', 'App\Http\Controllers\Team\DirectReferralController@index')->name('direct_referral')->middleware('auth');
	Route::post('direct_referral/setNewPercentage', 'App\Http\Controllers\Team\DirectReferralController@setNewPercentage')->name('setNewDirectPercentage')->middleware('auth');

	Route::get('team_view', 'App\Http\Controllers\Team\TeamviewController@index')->name('team_view')->middleware('auth');

	Route::get('downline_investment', 'App\Http\Controllers\Team\DownlineController@index')->name('downline_investment')->middleware('auth');

	Route::get('direct_income', 'App\Http\Controllers\Income\DirectIncomeController@index')->name('direct_income')->middleware('auth');

	Route::get('roi_income', 'App\Http\Controllers\Income\RoiIncomeController@index')->name('roi_income')->middleware('auth');
	Route::post('roi_income/post', 'App\Http\Controllers\Income\RoiIncomeController@roiIncome')->name('post_roi_income')->middleware('auth');

	Route::get('binary_income', 'App\Http\Controllers\Income\BinaryBonusController@index')->name('binary_income')->middleware('auth');
	Route::post('binary_income/setNewPercentage', 'App\Http\Controllers\Income\BinaryBonusController@setNewPercentage')->name('setNewBinaryPercentage')->middleware('auth');


	Route::get('coordinator_income', function () {
		return view('pages.income.coordinator');
	})->name('coordinator_income');

	Route::get('elite_income', function () {
		return view('pages.income.elite');
	})->name('elite_income');

	Route::get('withdrawal_balance', 'App\Http\Controllers\Withdrawal\WithdrawalController@index')->name('withdrawal_balance')->middleware('auth');
	Route::post('withdrawal_balance/post', 'App\Http\Controllers\Withdrawal\WithdrawalController@withdrawal')->name('post_withdrawal_balance')->middleware('auth');

	Route::get('withdrawal_report', 'App\Http\Controllers\Withdrawal\WithdrawalReportController@index')->name('withdrawal_report')->middleware('auth');
	Route::post('withdrawal_report_admin/date', 'App\Http\Controllers\Withdrawal\WithdrawalReportController@changeDate')->middleware('auth');
	Route::post('withdrawal_report_admin/confirm', 'App\Http\Controllers\Withdrawal\WithdrawalReportController@confirm')->middleware('auth');
	Route::post('withdrawal_report_admin/cancel', 'App\Http\Controllers\Withdrawal\WithdrawalReportController@cancel')->middleware('auth');
	Route::get('withdrawal_report_admin/table/{date?}', 'App\Http\Controllers\Withdrawal\WithdrawalReportController@table')->name('withdrawal_report_admin_table')->middleware('auth');

	Route::get('inv_r', 'App\Http\Controllers\Reports\InvestmentreportsController@index')->name('inv_r')->middleware('auth');
	Route::get('inv_other', 'App\Http\Controllers\Reports\InvestForOtherreportsController@index')->name('inv_other')->middleware('auth');
	Route::get('transfer_r', 'App\Http\Controllers\Reports\TransfertocashreportsController@index')->name('transfer_r')->middleware('auth');
	Route::get('wallet_r', 'App\Http\Controllers\Reports\TransferToOtherCashReportsController@index')->name('wallet_r')->middleware('auth');

	// Route::get('wallet_r', function () {
	// 	return view('pages.reports.wallet_r');
	// })->name('wallet_r');

	// dd
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::post('profile/upload', 'App\Http\Controllers\ProfileController@upload')->name('fileUpload')->middleware('auth');
	Route::post('profile/changeUserInfo', 'App\Http\Controllers\ProfileController@changeUserInfo')->name('changeUserInfo')->middleware('auth');
	Route::post('profile/changePwd', 'App\Http\Controllers\ProfileController@changePwd')->name('changePwd')->middleware('auth');
	Route::post('profile/changeWalletAddress', 'App\Http\Controllers\ProfileController@changeWalletAddress')->name('changeWalletAddress')->middleware('auth');

	Route::get('memberprofile', ['as' => 'profile.member', 'uses' => 'App\Http\Controllers\ProfileController@memberprofile']);
	Route::post('memberprofile/delete', 'App\Http\Controllers\ProfileController@deleteUser')->name('deleteUser')->middleware('auth');
	Route::post('memberprofile/initializePWD', 'App\Http\Controllers\ProfileController@initializePWD')->name('initializePWD')->middleware('auth');

	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

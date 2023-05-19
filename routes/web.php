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

Route::get('/', function () {
   //return view('home');
    return view('auth.login');
});
//----------------applications----------------------
Route::get('/applications/{application}/getAction', 'ApplicationController@ajaxGetAction');
Route::get('/select_year', 'ApplicationController@select_year');
Route::post('/applications', 'ApplicationController@index');
Route::get('/applications', 'ApplicationController@index');
Route::get('/applications/{application}', 'ApplicationController@app');
//----------------subaction-------------------------
Route::get('/subactions/{subaction}', 'SubactionController@app')->name('Subaction');
//----------------contract-------------------------
Route::post('/contracts/motamem/{contract}', 'ContractController@motamem');
Route::get('/contracts/edit/{contract}', 'ContractController@edit');
Route::get('/contracts/delete/{contract}', 'ContractController@delete');
Route::patch('/contracts/{contract}', 'ContractController@editcontract');
Route::get('/contracts/assign/{contract}', 'ContractController@conassign');
Route::get('/contracts/credit/{source}', 'ContractController@ajaxGetCredits');
Route::get('/contracts/{contract}/show', 'ContractController@showContract')->name('ShowContract');
Route::get('/contracts/deleteconassign/{conassign}', 'ContractController@deletConassign');

Route::post('/contracts/addcontract', 'ContractController@addContract');

Route::post('/contracts/addconassign/{contract}', 'ContractController@addConassign');
Route::patch('/contracts/editconassign/{conassign}', 'ContractController@editConassign');
Route::get('/contracts/{subaction}/{cost}', 'ContractController@add');
//Route::get('/contracts/addconassign', 'ContractController@addConassign');
//Route::get('/contracts/addcon/{contract}', 'ContractController@addCon');
//-----------------spent----------------------------
Route::get('/spents/deleteSpent/{spent}', 'SpentController@deleteSpent');
Route::get('/spents/{source}/credit', 'SpentController@ajaxGetCredits')->name('spents.ajaxGetCredits');
Route::get('/spents/{source}/bud', 'SpentController@ajaxGetBuds');
Route::get('/spents/{spent}/edit', 'SpentController@edit');
Route::patch('/spents/edit/{spent}', 'SpentController@editSpent');
Route::get('/spents/{subaction}/{cost}', 'SpentController@add');

Route::post('/spents/addspent/{subaction}', 'SpentController@addSpent');
Route::post('/spents/addconspent/{contract}', 'SpentController@addconSpent');

Route::post('/spents/confirm', 'SpentController@Confirmed');
//---------------------------action----------------------------
Route::get('/actions/{action}/getsubaction', 'ActionController@ajaxGetSubaction');
Route::get('/actions/{action}', 'ActionController@app');
//----------------------assign-------------------------------
//show
Route::get('/assigns', 'AssignController@budgetindex');
Route::get('/assigns/budgetshow/{budget}', 'AssignController@showbudget');//اختصاص بودجه به برنامه ها
Route::get('/assigns/showAppassign/{appassign}', 'AssignController@showappas');
Route::get('/assigns/showact/{actassign}', 'AssignController@showact');

//add---------------
Route::get('/assigns/add2bud', 'AssignController@add2bud');
Route::post('/assigns/addtobud', 'AssignController@addtobud');
Route::post('/assigns/addtoapp/{budget}', 'AssignController@addtoapp');
Route::post('/assigns/add2act/{appassign}', 'AssignController@add2act');
Route::post('/assigns/add2sub/{actassign}', 'AssignController@add2sub');
//--------------allocate-------------------------
Route::post('assigns/allocate_budget/{budget}', 'AssignController@allocate_bud');
Route::post('assigns/allocate_app/{appassign}', 'AssignController@allocate_app');
Route::post('assigns/allocate_act/{actassign}', 'AssignController@allocate_act');
Route::post('assigns/allocate_sub/{subassign}', 'AssignController@allocate_sub');


//---
Route::post('/allocate/{alocate_budget}/editbud', 'AssignController@editallocate_bud');
Route::get('/allocate/{alocate_budget}/deletebud', 'AssignController@deleteallocate_bud');
Route::post('/allocate/{allocate_app}/editapp', 'AssignController@editallocate_app');
Route::get('/allocate/{allocate_app}/deleteapp', 'AssignController@deleteallocate_app');
Route::post('/allocate/{allocate_act}/editact', 'AssignController@editallocate_act');
Route::get('/allocate/{allocate_act}/deleteact', 'AssignController@deleteallocate_act');
Route::post('/allocate/{allocate_sub}/editsub', 'AssignController@editallocate_sub');
Route::get('/allocate/{allocate_sub}/deletesub', 'AssignController@deleteallocate_sub');
//edit---------------
Route::get('/assigns/editBudget/{budget}', 'AssignController@editbudget');
Route::patch('/assigns/editbud/{budget}', 'AssignController@editbud');
Route::patch('/assigns/editAppassign/{appassign}', 'AssignController@editAppAssign');
Route::patch('/assigns/editActassign/{appassign}/{actassign}', 'AssignController@editActAssign');
Route::patch('/assigns/editSubassign/{actassign}/{subassign}', 'AssignController@editSubAssign');
//Route::get('/assigns/add2app', 'AssignController@add2app');
//Route::get('/assigns', 'AssignController@index');


//======------------------------------Reports-----------------------------------
Route::get('/reports', 'ReportController@index');
Route::get('/reports/spent_subaction', 'ReportController@spent_subaction');
Route::post('/reports/spent_subaction', 'ReportController@spent_subaction');
//Route::get('/reports/export1', 'ReportController@export1');
Route::post('/reports/export1', 'ExportController@export1');

Route::get('/reports/spent_company', 'ReportController@spent_company');
Route::post('/reports/spent_company', 'ReportController@spent_company');
//-----
Route::get('/reports/fanavarPish', 'ReportController@fanavar_pish');
Route::post('/reports/fanavarPish', 'ReportController@fanavar_pish');
Route::get('/reports/Roshd', 'ReportController@roshd');
Route::post('/reports/Roshd', 'ReportController@roshd');

Route::get('/reports/Fanavar', 'ReportController@fanavar');
Route::post('/reports/Fanavar', 'ReportController@fanavar');

//------------------
Route::get('/reports/Apps', 'ReportController@appspent');
Route::post('/reports/Apps', 'ReportController@appspent');
Route::get('/reports/Acts', 'ReportController@actspent');
Route::post('/reports/Acts', 'ReportController@actspent');
Route::get('/reports/SubActs', 'ReportController@subactspent');
Route::post('/reports/SubActs', 'ReportController@subactspent');
//------------------------------------
Route::get('/reports/Persons', 'ReportController@person');
Route::get('/reports/Supports', 'ReportController@support');
Route::get('/reports/Research', 'ReportController@research');
Route::get('/reports/Commercialization', 'ReportController@commercialization');
//------------------------------
Route::get('/reports/FSPish', 'ReportController@fspishroshd');
//-----------------------------new--------------------
Route::get('/reports/subbudget', 'ReportController@subbudget');
Route::post('/reports/subbudget', 'ReportController@subbudget');
Route::post('/reports/export2', 'ExportController@export2');
//---
Route::get('/reports/subcredit', 'ReportController@subcredit');
Route::post('/reports/subcredit', 'ReportController@subcredit');
Route::post('/reports/subCreditExport', 'ExportController@subcredit');
//---
Route::get('/reports/pishreport', 'ReportController@pishreport');
Route::post('/reports/pishreport', 'ReportController@pishreport');
Route::post('/reports/vahedsroshdExport', 'ExportController@vahedsroshd');
//---
Route::get('/reports/roshdreport', 'ReportController@roshdreport');
Route::post('/reports/roshdreport', 'ReportController@roshdreport');
Route::post('/reports/vahedspishExport', 'ExportController@vahedspish');
//---
Route::get('/reports/fanreport', 'ReportController@fanreport');
Route::post('/reports/fanreport', 'ReportController@fanreport');
Route::post('/reports/vahedsfanExport', 'ExportController@vahedsfan');
//======------------------------------Company-----------------------------------
Route::get('/companies', 'CompanyController@index');
Route::get('/companies/add', 'CompanyController@add');
Route::post('/companies/addCompany', 'CompanyController@addCompany');

Route::get('/companies/edit/{company}', 'CompanyController@edit');
Route::patch('/companies/editCompany/{company}', 'CompanyController@editCompany');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//------------------------Users---------------------------------
Route::get('/users', 'UserController@index');
Route::get('/users/delete/{user}', 'UserController@delete');
Route::get('/users/addUser', 'UserController@AddUser');
Route::post('/users/NEWUser', 'UserController@NewUser');

Route::get('/users/edit/{user}', 'UserController@edit');
Route::patch('/users/EditUser/{user}', 'UserController@EditUser');
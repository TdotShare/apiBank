<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'person'], function () use ($router) {

    $router->get('/', function () {
        return 'Person is Work !';
    });

    $router->get('/all', 'PersonController@actionIndex'); 
    $router->get('/find/{id}', 'PersonController@actionFind');
    $router->post('/create', 'PersonController@actionCreate');
    $router->get('/delete/{id}', 'PersonController@actionDelete');
    $router->post('/update/{id}', 'PersonController@actionUpdate');

});

$router->group(['prefix' => 'wallet'], function () use ($router) {

    $router->get('/', function () {
        return 'Wallet is Work !';
    });

    $router->get('/all', 'WalletController@actionIndex');
    $router->get('/find/{id}', 'WalletController@actionFind');
    $router->post('/create', 'WalletController@actionCreate');
    $router->get('/delete/{id}', 'WalletController@actionDelete');
    $router->post('/update/{id}', 'WalletController@actionUpdate');
    $router->get('/join_p/{id}', 'WalletController@actionJoin_P'); //ดูบัญชี ที่ผูกกับ เจ้าของ
    $router->get('/join_pr/{id}', 'WalletController@actionJoin_PR'); //ดูบัญชี ที่ผูกกับ เจ้าของ และ ดูรายรับ
    $router->get('/join_pe/{id}', 'WalletController@actionJoin_PE'); //ดูบัญชี ที่ผูกกับ เจ้าของ และ รายจ่าย
    $router->get('/join_pre/{id}', 'WalletController@actionJoin_PRE'); //ดูบัญชี ที่ผูกกับ เจ้าของ และ รายจ่าย , รายรับ

    //search 
    
    $router->get('/join_pr/{id}/{search}', 'WalletController@actionJoin_PR'); //ดูบัญชี ที่ผูกกับ เจ้าของ และ รายรับ เลือกเดือน
    $router->get('/join_pe/{id}/{search}', 'WalletController@actionJoin_PE');  //ดูบัญชี ที่ผูกกับ เจ้าของ และ รายจ่าย เลือกเดือน
    $router->get('/join_pre/{id}/{search}', 'WalletController@actionJoin_PRE');  //ดูบัญชี ที่ผูกกับ เจ้าของ และ รายจ่าย , รายรับ เลือกเดือน

});

$router->group(['prefix' => 'revenue'], function () use ($router) {

    $router->get('/', function () {
        return 'Revenue is Work !';
    });

    $router->get('/all', 'RevenueController@actionIndex');
    $router->get('/find/{id}', 'RevenueController@actionFind');
    $router->post('/create', 'RevenueController@actionCreate');
    $router->get('/delete/{id}', 'RevenueController@actionDelete');
    $router->post('/update/{id}', 'RevenueController@actionUpdate');

});

$router->group(['prefix' => 'expenditure'], function () use ($router) {

    $router->get('/', function () {
        return 'Expenditure is Work !';
    });

    $router->get('/all', 'ExpenditureController@actionIndex');
    $router->get('/find/{id}', 'ExpenditureController@actionFind');
    $router->post('/create', 'ExpenditureController@actionCreate');
    $router->get('/delete/{id}', 'ExpenditureController@actionDelete');
    $router->post('/update/{id}', 'ExpenditureController@actionUpdate');

});

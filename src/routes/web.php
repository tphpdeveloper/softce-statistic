<?php


Route::middleware(['web', 'generate_menus', 'visitor', 'main_lang'])
    ->namespace('Softce\Statistic\Http\Controllers')
    ->group(function () {

        Route::get('statistic', ['as' => 'admin.statistic', 'uses' => 'StatisticController@show']);





    });
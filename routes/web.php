<?php

$this->get('pagseguro', 'PagSeguroController@pagseguro')->name('pagseguro');

$this->get('pagseguro-btn', function(){
    return view('pagseguro-btn');
});


Route::get('/', function () {
    return view('welcome');
});

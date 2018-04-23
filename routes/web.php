<?php

$this->get('pagseguro', 'PagSeguroController@pagseguro')->name('pagseguro');

$this->get('pagseguro-lightbox', 'PagSeguroController@lightbox')->name('pagseguro.lightbox');
$this->post('pagseguro-lightbox', 'PagSeguroController@lightboxCode')->name('pagseguro.lightbox.code');

$this->get('pagseguro-transparente', 'PagSeguroController@transparente')->name('pagseguro.transparente');
$this->post('pagseguro-transparente', 'PagSeguroController@getCode')->name('pagseguro.code.transparente');
$this->post('pagseguro-billet', 'PagSeguroController@billet')->name('pagseguro.billet');
$this->get('pagseguro-transparente-cartao', 'PagSeguroController@card')->name('pagseguro.trasnparente.card');
$this->post('pagseguro-transparente-cartao', 'PagSeguroController@cardTransaction')->name('pagseguro.card.transaction');

$this->get('pagseguro-btn', function(){
    return view('pagseguro-btn');
});


Route::get('/', function () {
    return view('welcome');
});

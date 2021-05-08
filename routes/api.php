<?php

use App\Http\Middleware\API\ChangeRequestAcceptHeader;

Route::middleware(ChangeRequestAcceptHeader::class)->group(function () {
    
    Route::post('/login', 'Auth\LoginController@login')->name('api.login');
    
    Route::get('documents', 'DocumentController@index')->name('api.documents.index'); // @TODO: singular ou plural?
    Route::post('documents', 'DocumentController@store')->name('api.documents.store'); // @TODO: singular ou plural?
    
    
    Route::get('sessions', 'SessionController@index')->name('api.session.index');
    Route::get('sessions/documents', 'SessionController@getByDocument')->name('api.session.get-by-document');
    Route::post('sessions', 'SessionController@store')->name('api.session.store');

    Route::post('attach-document', 'DocumentSessionController@attach')->name('api.documents.attach');
    
    Route::post('sessions/open', 'SessionController@openVotes')->name('api.session.open-votes');
    Route::post('sessions/close', 'SessionController@closeVotes')->name('api.session.close-votes');
    
    Route::post('register-vote', 'VoteController@registerVote')->name('api.register-vote');

    Route::get('session-statuses', 'SessionStatusController@index')->name('api.session-statuses');
    Route::get('document-statuses', 'DocumentStatusController@index')->name('api.document-statuses');
});
<?php

use App\Http\Middleware\API\ChangeRequestAcceptHeader;

Route::middleware(ChangeRequestAcceptHeader::class)->group(function () {
    
    Route::post('/login', 'Auth\LoginController@login')->name('api.login');
    
    Route::get('documents', 'DocumentController@index')->name('api.documents.index');
    Route::post('documents', 'DocumentController@store')->name('api.documents.store');
    Route::post('update_document', 'DocumentController@update')->name('api.documents.update');
    Route::delete('documents', 'DocumentController@delete')->name('api.documents.delete');
    Route::post('document/change-status' , 'DocumentController@changeDocumentStatus')->name('api.document.change-status');
    
    Route::get('sessions', 'SessionController@index')->name('api.session.index');
    Route::get('sessions/documents', 'SessionController@getByDocument')->name('api.session.get-by-document');
    Route::post('sessions', 'SessionController@store')->name('api.session.store');
    Route::post('sessions/change-status' , 'SessionController@changeSessionStatus')->name('api.session.change-status');

    Route::post('attach-document', 'DocumentSessionController@attach')->name('api.documents.attach');
    Route::post('detach-document', 'DocumentSessionController@detach')->name('api.documents.detach');
    
    Route::post('sessions/open', 'SessionController@openVotes')->name('api.session.open-votes');
    Route::post('sessions/close', 'SessionController@closeVotes')->name('api.session.close-votes');
    
    Route::post('register-vote', 'VoteController@registerVote')->name('api.register-vote');
    Route::get('votes', 'VoteController@index')->name('api.get-votes');

    Route::get('session-statuses', 'SessionStatusController@index')->name('api.session-statuses');
    Route::get('document-statuses', 'DocumentStatusController@index')->name('api.document-statuses');
});
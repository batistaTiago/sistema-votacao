<?php


Route::post('/login', 'Auth\LoginController@login')->name('api.login');

Route::get('documents', 'DocumentController@index')->name('api.documents.index'); // @TODO: singular ou plural?
Route::post('documents', 'DocumentController@store')->name('api.documents.store'); // @TODO: singular ou plural?


Route::get('sessions', 'SessionController@index')->name('api.session.index');
Route::get('sessions/documents', 'SessionController@getByDocument')->name('api.session.get-by-document');
Route::post('sessions', 'SessionController@store')->name('api.session.store');

Route::post('sessions/open/{session_id}', 'SessionController@openForVotes')->name('api.session.open-for-votes');
Route::post('sessions/close/{session_id}', 'SessionController@closeVoting')->name('api.session.open-for-votes');

Route::post('register-vote', 'VoteController@registerVote')->name('api.register-vote');
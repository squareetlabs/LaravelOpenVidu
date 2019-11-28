<?php

use Illuminate\Support\Facades\Route;

Route::post('/token', 'OpenViduController@token')->name('openvidu.token');
Route::delete('/recording{recordingId}', 'OpenViduController@deleteRecording')->name('openvidu.recording.delete');
Route::get('/session/{sessionId}', 'OpenViduController@session')->name('openvidu.session');

Route::post('/recording', 'OpenViduController@startRecording')->name('openvidu.recording.start');
Route::post('/recording/{recordingId}', 'OpenViduController@stopRecording')->name('openvidu.recording.stop');
Route::get('/recording{recordingId}', 'OpenViduController@recording')->name('openvidu.recording');
Route::delete('/recording{recordingId}', 'OpenViduController@deleteRecording')->name('openvidu.recording.delete');

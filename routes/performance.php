<?php

Route::get('/test/lessons/summary', 'PerformanceController@getSummary');

Route::post('/test/lessons/student/{id}', 'PerformanceController@addStudent');


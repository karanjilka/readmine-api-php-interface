<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('redmine/issue');
});

// Route::get('/laform-example', function () {
//     return view('laform-example');
// });
Route::resource('laform-example','LaFormExampleController');

Route::get('redmine/issue/clear-cache','Redmineapi\RedmineIssueController@clearCache');
Route::post('redmine/issue/timelog','Redmineapi\RedmineIssueController@postTimeLog');
Route::get('redmine/issues1','Redmineapi\RedmineIssueController@issueList1');
Route::get('redmine/issues-edit','Redmineapi\RedmineIssueController@issueEdit');
Route::post('redmine/issues-edit','Redmineapi\RedmineIssueController@postIssueEdit');
Route::resource('redmine/issue','Redmineapi\RedmineIssueController');
Route::resource('redmine/timeentry','Redmineapi\RedmineTimeEntry');

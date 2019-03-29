<?php

use Encore\Milestone\Http\Controllers\MilestoneController;

/*
|--------------------------------------------------------------------------
| 大记事路由
|--------------------------------------------------------------------------
*/
Route::resource('milestone', MilestoneController::class);

//编辑组织机构视图
Route::get('milestone/{id}/editOrg', MilestoneController::class . "@editOrg")->name('milestone.editOrg');
//编辑组织结构保存
Route::post('milestone/{id}/editOrg', MilestoneController::class . "@updateOrg")->name('milestone.updateOrg');
//编辑主办单位视图
Route::get('milestone/{id}/editSponsor', MilestoneController::class . "@editSponsor")->name('milestone.editSponsor');
//编辑主办单位保存
Route::post('milestone/{id}/editSponsor', MilestoneController::class . "@updateSponsor")->name('milestone.updateSponsor');
//编辑学术支持单位视图
Route::get('milestone/{id}/editSupport', MilestoneController::class . "@editSupport")->name('milestone.editSupport');
//编辑学术支持单位保存
Route::post('milestone/{id}/editSupport', MilestoneController::class . "@updateSupport")->name('milestone.updateSupport');

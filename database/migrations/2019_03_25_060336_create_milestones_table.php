<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seq',100)->default('')->comment("届数");
            $table->string('theme',100)->default('')->comment("主题");
            $table->string('list_bg',255)->default('')->comment("背景图");
            $table->string('date',20)->default('')->comment("举办日期");
            $table->string('year',10)->default('')->comment("举办年份");
            $table->integer('number')->default(1)->comment("第几届");
            $table->string('address',100)->default('')->comment("地点");
            $table->text('organizing')->comment('组织结构');
            $table->text('sponsor_unit')->comment('主办单位');
            $table->text('support_unit')->comment('学术支持单位');
            $table->integer('user_id')->unsigned()->default(0)->comment("操作人ID");
            $table->softDeletes();
            $table->timestamps();
            $table->comment = '大事记表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestones');
    }
}

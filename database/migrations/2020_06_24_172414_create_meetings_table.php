<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('restrict');
            $table->string('subject');
            $table->string('type');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('meeting_statuses')
                ->onDelete('restrict');
            $table->unsignedBigInteger('meeting_room_id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('restrict');
            $table->datetime('starts_at');
            $table->timestamp('ends_at');
            $table->string('feedback_url')->nullable();
            $table->text("observations")->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}

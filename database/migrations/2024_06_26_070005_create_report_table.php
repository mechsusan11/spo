<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report', function (Blueprint $table) {
            $table->id();
            $table->string('report_id');
            $table->integer('user_id');
            $table->unsignedBigInteger('report_type');
            $table->foreign('report_type')->references('id')->on('report_type_master')->onDelete('cascade');
            $table->unsignedBigInteger('sub_division');
            $table->foreign('sub_division')->references('id')->on('sub_division_master')->onDelete('cascade');
            $table->string('incident_details')->nullable();
            $table->dateTime('incident_date_time');
            $table->string('incident_address');
            $table->double('current_latitude')->nullable();
            $table->double('current_longitude')->nullable();
            $table->double('incident_latitude')->nullable();
            $table->double('incident_longitude')->nullable();
            $table->string('police_assigned')->nullable();
            $table->string('report_details')->nullable();
            $table->string('investigation_details')->nullable();
            $table->dateTime('investigation_date_time')->nullable();
            $table->string('audio_path')->nullable();
            $table->json('image_path')->nullable();
            $table->string('video_path')->nullable();
            $table->double('investigation_latitude')->nullable();
            $table->double('investigation_longitude')->nullable();
            $table->json('investigation_image_path')->nullable();
            $table->string('investigation_video_path')->nullable();
            // new update
            $table->integer('intel')->nullable();
            $table->integer('FIR_register')->nullable();
            $table->string('FIR_register_number')->nullable();
            $table->integer('accused_arrested')->nullable();
            $table->integer('property_ceased')->nullable();
            $table->integer('sub_division_mismatch')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report', function (Blueprint $table) {
            $table->dropForeign(['sub_division']);
        });
        Schema::dropIfExists('report');
    }
};

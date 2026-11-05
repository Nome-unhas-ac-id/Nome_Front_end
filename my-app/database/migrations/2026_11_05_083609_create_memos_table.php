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
        Schema::create('memos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->date('meeting_date');
            $table->time('meeting_time')->nullable();
            $table->time('meeting_end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('leader_name')->nullable();
            $table->string('notetaker_name')->nullable();
            $table->text('agenda')->nullable();
            $table->json('letter')->nullable();
            $table->json('attendees')->nullable();
            $table->longText('summary_text')->nullable();
            $table->longText('transcript')->nullable();
            $table->json('ai_raw_json')->nullable();
            $table->string('status')->default('draft');
            $table->string('error_message')->nullable();
            $table->uuid('latest_audio_job_id')->nullable()->index();
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();
            $table->index(['user_id', 'meeting_date', 'status']);
        });
        Schema::create('audio_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('memo_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedBigInteger('file_size');
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audio_jobs');
        Schema::dropIfExists('memos');
    }
};

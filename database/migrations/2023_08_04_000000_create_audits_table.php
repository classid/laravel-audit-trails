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
        Schema::create('audits', function (Blueprint $table) {
            $table->uuid('id');

            // object
            $table->string('auditable_type')->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->uuid('auditable_uuid')->nullable();

            // action
            $table->string('type');
            $table->string('message');
            $table->string('via')->nullable(); // console, mobile, web
            $table->string('url')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->json('tags')->nullable();

            // subject
            $table->string('performer_type')->nullable();
            $table->string('performer_id')->nullable();

            // generic column
            $table->boolean('is_auto')->default(false);
            $table->timestamps();

            $table->primary('id');
            $table->index(['auditable_type', 'auditable_id', 'auditable_uuid'], 'auditable_index');
            $table->index(['performer_type', 'performer_id'], 'performer_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};

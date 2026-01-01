<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
{
    Schema::create('subscriptions', function (Blueprint $table) {
        $table->id();
        
        // External User ID
        $table->unsignedBigInteger('user_id'); 
        
        $table->foreignId('package_id')->constrained('packages')->onDelete('cascade'); 
        $table->string('type')->index();
        $table->dateTime('started_at'); 
        $table->dateTime('ends_at');    
        $table->timestamps();

        $table->index('user_id'); 
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};

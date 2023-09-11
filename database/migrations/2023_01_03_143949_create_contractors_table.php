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
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();;
            $table->string('full_name', 300)->nullable();;
            $table->string('reg_code', 9)->unique()->index();
            $table->string('registration_date')->nullable();
            $table->string('registration_authority')->nullable();

            $table->string('exclude_date')->nullable();
            $table->string('address')->nullable();
            $table->string('post_address')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('state')->nullable();
            $table->tinyInteger('state_code')->unsigned()->nullable();

            $table->boolean('is_company')->default(1);
            $table->boolean('is_active')->default(1);

            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contractors');
    }
};

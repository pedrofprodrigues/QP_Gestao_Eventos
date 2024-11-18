<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {


        Schema::create('event_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_type')->unique();
        });
        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status')->unique();
        });


        Schema::create('appetizers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('price');
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
        });

        DB::statement('ALTER TABLE appetizers ALTER COLUMN price TYPE MONEY USING price::MONEY;');

        Schema::create('soups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('price');
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
        });

        DB::statement('ALTER TABLE soups ALTER COLUMN price TYPE MONEY USING price::MONEY;');

        Schema::create('fishes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('price');
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
        });

        DB::statement('ALTER TABLE fishes ALTER COLUMN price TYPE MONEY USING price::MONEY;');

        Schema::create('meats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('price');
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
        });

        DB::statement('ALTER TABLE meats ALTER COLUMN price TYPE MONEY USING price::MONEY;');

        Schema::create('desserts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('price');
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
        });

        DB::statement('ALTER TABLE desserts ALTER COLUMN price TYPE MONEY USING price::MONEY;');




        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->smallInteger('num_person');
            $table->smallInteger('num_children');
            $table->smallInteger('num_free_children');
            $table->timestamp('event_date_start')->nullable();
            $table->timestamp('event_date_end')->nullable();
            $table->foreignId('event_type')->constrained('event_types');
            $table->foreignId('appetizer')->constrained('appetizers');
            $table->foreignId('soup')->constrained('soups');
            $table->foreignId('fish')->constrained('fishes');
            $table->foreignId('meat')->constrained('meats');
            $table->foreignId('dessert')->constrained('desserts');
            $table->boolean('room_dinis');
            $table->boolean('room_isabel');
            $table->boolean('room_joaoiii');
            $table->boolean('room_leonor');
            $table->boolean('room_espelhos');
            $table->boolean('room_atrium');
            $table->boolean('lago');
            $table->boolean('jardim');
            $table->boolean('auditorio');
            $table->text('lago_extras')->nullable();
            $table->text('auditorio_extras')->nullable();
            $table->text('jardim_extras')->nullable();
            $table->text('entertainment')->nullable();
            $table->text('extras')->nullable();
            $table->string('decoration');
            $table->string('qp_resp_name');
            $table->string('qp_resp_contact', 31);
            $table->string('client_resp_name');
            $table->string('client_resp_contact', 31);
            $table->string('client_resp_email', 31);
            $table->foreignId('status')->constrained('statuses');
            $table->timestamp('created_at')->useCurrent();
        });

    
    }



    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('desserts');
        Schema::dropIfExists('fishes');
        Schema::dropIfExists('meats');
        Schema::dropIfExists('soups');
        Schema::dropIfExists('appetizers');
        Schema::dropIfExists('event_types');
        Schema::dropIfExists('statuses');

    }
};
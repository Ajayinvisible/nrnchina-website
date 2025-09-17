<?php

use App\Models\MemberGroup;
use App\Models\User;
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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MemberGroup::class);
            $table->foreignIdFor(User::class);
            $table->string('designation')->nullable();
            $table->string('father_name');
            $table->date('dob');
            $table->string('occuption')->nullable();
            $table->string('nationality');
            $table->string('address_nepal');
            $table->string('address_china');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};

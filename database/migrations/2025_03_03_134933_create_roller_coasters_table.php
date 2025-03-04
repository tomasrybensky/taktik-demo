<?php

use App\Models\Manufacturer;
use App\Models\ThemePark;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roller_coasters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Manufacturer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ThemePark::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->integer('speed');
            $table->integer('height');
            $table->integer('length');
            $table->integer('inversions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roller_coasters');
    }
};

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if ($schema->hasTable('links')) {
            return;
        }

        $schema->create('links', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 50);
            $table->string('icon', 255)->nullable();
            $table->string('url', 255);
            $table->boolean('is_internal')->default(0);
            $table->boolean('is_newtab')->default(0);

            $table->integer('position')->nullable();
            $table->boolean('use_relme')->default(false);
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('links')->onDelete('set null');

            $table->enum('visibility', ['everyone', 'members', 'mods'])->default('everyone');
            $table->index('visibility');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('links');
    },
];

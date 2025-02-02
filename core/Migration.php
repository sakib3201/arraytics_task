<?php

namespace Core;

interface Migration
{
    public function up();

    public function down();
}


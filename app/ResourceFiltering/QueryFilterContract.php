<?php

namespace App\ResourceFiltering;

interface QueryFilterContract
{
    public function apply($query);
}

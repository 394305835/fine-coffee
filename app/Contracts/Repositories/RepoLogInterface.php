<?php

namespace App\Contracts\Repositories;

interface RepoLogInterface
{

    public function write($input, int $level);

    // public function info($input);

    // public function log($input);

    // public function error($input);

    // public function warning($input);

    // public function debug($input);

}

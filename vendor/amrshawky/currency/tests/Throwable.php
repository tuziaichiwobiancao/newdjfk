<?php

namespace AmrShawky\Tests;

trait Throwable
{
    protected $throw;

    protected $throw_callback;

    public function throw(?callable $callback = null)
    {
        $this->throw = true;

        if ($callback) {
            $this->throw_callback = $callback;
        }
    }
}
<?php
namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait Pipeable{
    protected $pipeableThrough = [];

    public function pipeable(){
        return $this->pipeableThrough;
    }

    public static function pipe(){
        $self = new static;
        return app(Pipeline::class)
            ->send(self::query())
            ->through($self->pipeable())
            ->thenReturn();
    }
}
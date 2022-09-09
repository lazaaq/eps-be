<?php
namespace App\Traits;
use Illuminate\Support\Str;

trait Uuid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            try {
                $pk = $model->getKeyName();
                $model->$pk = (string) Str::uuid();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
?>

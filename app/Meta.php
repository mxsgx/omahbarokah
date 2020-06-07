<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'ref_id', 'key', 'value',
    ];

    /**
     * @param Product|int $id
     * @param string $key
     * @param boolean $single
     * @return \Illuminate\Database\Eloquent\Builder|Model|object
     */
    public static function product($id, $key, $single = true)
    {
        if ($id instanceof Product) {
            $id = $id->id;
        }

        $metas = self::where('type', '=', 'product')->where('key', '=', $key)->where('ref_id', '=', $id);

        return $single ? $metas->first() : $metas->get();
    }
}

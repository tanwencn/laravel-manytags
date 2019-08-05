<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Manytags\Concerns;

use Illuminate\Database\Eloquent\Model;
use Tanwencn\Manytags\Collection\RecursiveCollection;

trait HasChildren
{
    protected $infinite;

    public static function bootHasChildren()
    {
        static::deleting(function (Model $model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            $model->children()->forceDelete();
        });
    }

    public function newCollection(array $models = [])
    {
        return new RecursiveCollection($models);
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function infinite(bool $switch = true)
    {
        $this->infinite = $switch;
    }

    public function children()
    {
        if ($this->infinite)
            $this->hasMany(static::class, 'parent_id')->with('children');
        else
            return $this->hasMany(static::class, 'parent_id');
    }

    public function hasParent()
    {
        return !empty($this->parent);
    }

    public function scopeTree($query, $parent_id = 0, $columns = [])
    {
        if (empty($columns)) {
            $columns = $this->tree_filed ?: ['id', 'parent_id', 'title'];
        }

        return $query->where('parent_id', $parent_id)->select($columns)->with(['children' => function ($query) use ($columns) {
            $query->select($columns);
        }]);
    }

    public static function saveOrder($items, $parent_id = 0)
    {
        foreach ($items as $key => $item) {
            $model = static::findOrFail($item['id']);
            $model->order = $key;
            $model->parent_id = $parent_id;
            $model->save();

            if (!empty($item['children']))
                static::saveOrder($item['children'], $model->id);
        }
    }

    public function getOriginalAttribute()
    {
        return $this->getOriginal();
    }
}
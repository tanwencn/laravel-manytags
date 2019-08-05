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
use Illuminate\Support\Facades\DB;
use Tanwencn\Manytags\Scopes\OrderScope;
use Tanwencn\Manytags\Scopes\TaxonomyScope;

Class Manytags extends Model
{
    use HasChildren;

    public $relation_key = 'title';

    protected $fillable = ['title', 'slug', 'parent_id'];

    protected $table = 'terms';

    protected static function boot()
    {
        static::addGlobalScope(new TaxonomyScope());
        static::addGlobalScope(new OrderScope());

        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {
                return;
            }

            //清除多态关系链
            DB::table('termables')->where('term_id', $model->id)->delete();
        });

        static::saving(function ($model) {
            $model->taxonomy = snake_case(class_basename($model));
        });
    }

    public function setFirstSlugAttribute($value)
    {
        $this->attributes['slug'] = ucfirst($value);
    }
}
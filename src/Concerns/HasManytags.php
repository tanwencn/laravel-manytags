<?php
/**
 * http://www.tanecn.com
 * 作者: Tanwen
 * 邮箱: 361657055@qq.com
 * 所在地: 广东广州
 * 时间: 2018/3/14 16:59
 */

namespace Tanwencn\Manytags\Concerns;

trait HasManytags
{
    protected function toTags($related)
    {
        return $this->morphToMany($related, 'termable', null, null, 'term_id');
    }
}
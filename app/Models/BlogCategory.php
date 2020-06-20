<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 *
 * @package App\Models
 *
 * @property-read BlogCategory  $parentCategory
 * @property-read string        $parentTitle
 */
class BlogCategory extends Model
{
  use SoftDeletes;

  /**
   * Id корня
   */
  const ROOT = 1;

  protected $fillable = [
    'title',
    'slug',
    'parent_id',
    'description',
  ];

  /**
   * Получить родительскую категорию
   *
   * @return BlogCategory
   */
  public function parentCategory()
  {
    return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
  }

  /**
   * Пример аксесуара (Accessor)
   *
   * @url https://laravel.com/docs/5.8/eloquent-mutators
   *
   * @return string
   */
  public function getParentTitleAttribute()
  {
    $title = $this->parentCategory->title
      ?? ($this->isRoot()
        ? 'Корень'
        : '???');

    return $title;
  }

  /**
   * Является ли текущий объект корневым
   *
   * @return bool
   */
  public function isRoot()
  {
    return $this->id === BlogCategory::ROOT;
  }

  /**
   * Пример аксесуара
   *
   * @param string $valueFromObject
   *
   * @return bool|mixed|null|string|string[]
   */
  public function getTitleAttribute($valueFromObject)
  {
    return mb_strtoupper($valueFromObject);
  }

  /**
   * Пример мутатора
   *
   * @param string $incomingValue
   */
  public function setTitleAttribute($incomingValue)
  {
    $this->attributes['title'] = mb_strtolower($incomingValue);
  }

}

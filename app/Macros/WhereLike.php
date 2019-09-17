<?php
namespace App\Macros;

use Illuminate\Database\Eloquent\Builder;

class WhereLike
{
  /**
   * Eloquent Builder
   *
   * @var Builder
   */
  protected $builder;

  /**
   * Contruct method
   *
   * @param Builder $builder
   */
  public function __construct(Builder $builder) {
    $this->builder = $builder;
  }

  /**
   * Search a term on the attributes passed
   *
   * @param string|array $attrs
   * @param string $term
   * @return Builder
   */
  public function search($attrs, string $term)
  {
    switch(gettype($attrs)) {
      case 'string':
        $this->addWhereLike($attrs, $term);
        break;
      case 'array':
        foreach($attrs as $attr) {
          $this->addWhereLike($attr, $term);
        }
        break;
    }
    return $this->builder;
  }

  /**
   * Add a WhereLike on the Builder
   *
   * @param string $attr
   * @param string $term
   * @return void
   */
  private function addWhereLike(string $attr, string $term)
  {
    $this->builder->orWhere($attr, 'LIKE', "%{$term}%");
  }
}

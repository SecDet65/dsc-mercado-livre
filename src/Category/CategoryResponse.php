<?php
namespace Dsc\MercadoLivre\Category;

use Dsc\MercadoLivre\Http\MeliResponseInterface;

class CategoryResponse implements MeliResponseInterface
{
    /**
     * @return string
     */
    public function getEntityTarget()
    {
        return Category::class;
    }
}
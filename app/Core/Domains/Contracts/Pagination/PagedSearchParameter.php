<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/3/18
 * Time: 10:10 AM
 */

namespace App\Core\Domains\Contracts\Pagination;


/**
 * @OA\Schema(
 *     @OA\Property(
 *         property="pagination",
 *         description="Pagination of page",
 *         type="object",
 *         @OA\Property(
 *             property="page",
 *             type="integer",
 *             format="int32",
 *             example=1
 *         ),
 *         @OA\Property(
 *             property="perpage",
 *             type="integer",
 *             format="int32",
 *             example=10
 *         ),
 *     ),
 *     @OA\Property(
 *         property="sort",
 *         description="Sort of page",
 *         type="object",
 *         @OA\Property(
 *             property="sort",
 *             type="string",
 *             enum={"ASC", "DESC"},
 *             default="",
 *             example="ASC"
 *         ),
 *         @OA\Property(
 *             property="field",
 *             type="string",
 *             example="id"
 *         ),
 *     ),
 *     required={
 *         "page",
 *         "perpage",
 *         "sort",
 *         "field"
 *     }
 * )
 * Class PagedSearchParameter
 * @package App\Core\Domains\Contracts\Pagination
 */
class PagedSearchParameter
{
    public $draw;

    public $columns;

    public $order;

    public $start;

    public $length;

    public $search;


    public $pagination;

    public $query;

    public $sort;


    /**
     * @return mixed
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @param mixed $draw
     */
    public function setDraw($draw): void
    {
        $this->draw = $draw;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search): void
    {
        $this->search = $search;
    }

    /**
     * @return mixed
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @param mixed $pagination
     */
    public function setPagination($pagination): void
    {
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort): void
    {
        $this->sort = $sort;
    }
}
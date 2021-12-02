<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicationNote;

use App\Domains\HumanResources\Recruitment\VacancyApplicant\VacancyApplicantEloquent;
use App\Domains\HumanResources\Recruitment\VacancyApplicationNote\Contracts\VacancyApplicationNoteInterface;
use App\Infrastructures\EloquentAbstract;

/**
 * @OA\Schema(
 *     description="Vacancy Applicant Note eloquent",
 *     title="Vacancy Applicant Note eloquent",
 *     required={"vacancy_application_id", "note"}
 * )
 * VacancyApplicationNoteEloquent.
 */
class VacancyApplicationNoteEloquent extends EloquentAbstract implements VacancyApplicationNoteInterface
{
    /**
     * @OA\Property(
     *     property="vacancy_application_id",
     *     type="integer",
     *     format="int64",
     *     description="Vacancy application id property",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     property="note",
     *     type="string",
     *     description="Note property"
     * )
     *
     * @var string
     */

    //<editor-fold desc="#field">

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  VacancyApplicationNoteInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vacancy_application_id', 'note'
    ];

    protected $searchable = [
        'vacancy_application_id', 'note'
    ];

    protected $orderable = [
        'vacancy_application_id', 'note'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getVacancyApplicationId()
    {
        return $this->vacancy_application_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVacancyApplicationId($vacancy_application_id)
    {
        $this->vacancy_application_id = $vacancy_application_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNote()
    {
        return $this->note;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function vacancy_application()
    {
        return $this->belongsTo(VacancyApplicantEloquent::class, 'vacancy_application_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    
    //</editor-fold>

    
    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateVacancyApplicationNoteEloquent",
 *     description="Create vacancy applicant note eloquent",
 *     title="Create vacancy applicant note eloquent",
 *     required={"vacancy_application_id", "note"},
 *     @OA\Property(property="vacancy_application_id", ref="#/components/schemas/VacancyApplicationNoteEloquent/properties/vacancy_application_id"),
 *     @OA\Property(property="note", ref="#/components/schemas/VacancyApplicationNoteEloquent/properties/note"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateVacancyApplicationNoteEloquent",
 *     description="Update vacancy applicant note eloquent",
 *     title="Update vacancy applicant note eloquent",
 *     required={"id", "vacancy_application_id", "note"},
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(
 *                   property="id",
 *                   type="integer",
 *                   format="int64",
 *                   description="Id property",
 *                   example=1
 *              )
 *          ),
 *          @OA\Schema(ref="#/components/schemas/CreateVacancyApplicationNoteEloquent")
 *     }
 * )
 */

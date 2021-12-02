<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts\RecruitmentScheduleInterface;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\VacancyApplicantEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Recruitment Schedule eloquent",
 *     title="Recruitment Schedule eloquent",
 *     required={"vacancy_application_id", "schedule_date"}
 * )
 * RecruitmentScheduleEloquent.
 */
class RecruitmentScheduleEloquent extends EloquentAbstract implements RecruitmentScheduleInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="vacancy_application_id",
     *     type="integer",
     *     format="int64",
     *     description="Vacancy Application id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="schedule_date",
     *     description="Schedule date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
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
    protected $table = RecruitmentScheduleInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vacancy_application_id', 'schedule_date'
    ];

    protected $searchable = [
        'vacancy_application_id', 'schedule_date'
    ];

    protected $orderable = [
        'vacancy_application_id', 'schedule_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [
        'deleted_at'
    ];

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
    public function getScheduleDate()
    {
        return $this->schedule_date;
    }

    /**
     * {@inheritdoc}
     */
    public function setScheduleDate($schedule_date)
    {
        $this->schedule_date = $schedule_date;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function vacancyApplication()
    {
        return $this->belongsTo(VacancyApplicantEloquent::class, 'vacancy_application_id');
    }

    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateRecruitmentScheduleEloquent",
 *     description="Create work area eloquent",
 *     title="Create work area eloquent",
 *     required={"vacancy_application_id", "schedule_date"},
 *     @OA\Property(property="vacancy_application_id", ref="#/components/schemas/RecruitmentScheduleEloquent/properties/vacancy_application_id"),
 *     @OA\Property(property="schedule_date", ref="#/components/schemas/RecruitmentScheduleEloquent/properties/schedule_date")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateRecruitmentScheduleEloquent",
 *     description="Update work area eloquent",
 *     title="Update work area eloquent",
 *     required={"id", "vacancy_application_id", "name", "slug"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateRecruitmentScheduleEloquent")
 *     }
 * )
 */

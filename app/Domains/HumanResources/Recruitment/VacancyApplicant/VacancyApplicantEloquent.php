<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant;

use App\Domains\HumanResources\Recruitment\Applicant\ApplicantEloquent;
use App\Domains\HumanResources\Vacancy\VacancyEloquent;
use App\Domains\HumanResources\MasterData\RecruitmentStage\RecruitmentStageEloquent;
use App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts\VacancyApplicantInterface;
use App\Infrastructures\EloquentAbstract;

/**
 * @OA\Schema(
 *     description="Vacancy Applicant eloquent",
 *     title="Vacancy Applicant eloquent",
 *     required={"applicant_id", "vacancy_id", "recruitment_stage_id", "cover_letter", "rating"}
 * )
 * VacancyApplicantEloquent.
 */
class VacancyApplicantEloquent extends EloquentAbstract implements VacancyApplicantInterface
{
    /**
     * @OA\Property(
     *     property="applicant_id",
     *     type="integer",
     *     format="int64",
     *     description="Applicant id property",
     *     example=1
     * )
     *
     * @var integer
     */

     /**
     * @OA\Property(
     *     property="vacancy_id",
     *     type="integer",
     *     format="int64",
     *     description="Vacancy id property",
     *     example=1
     * )
     *
     * @var integer
     */
    
     /**
     * @OA\Property(
     *     property="recruitment_stage_id",
     *     type="integer",
     *     format="int64",
     *     description="Recruitment stage id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="cover_letter",
     *     type="string",
     *     description="Cover letter property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="rating",
     *     type="string",
     *     description="Rating property",
     *     enum={"1", "2", "3", "4", "5"},
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
    protected $table =  VacancyApplicantInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'applicant_id', 'vacancy_id', 'recruitment_stage_id', 'cover_letter', 'rating'
    ];

    protected $searchable = [
        'applicant_id', 'vacancy_id', 'recruitment_stage_id', 'cover_letter', 'rating'
    ];

    protected $orderable = [
        'applicant_id', 'vacancy_id', 'recruitment_stage_id', 'cover_letter', 'rating'
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
    public function getApplicantId()
    {
        return $this->applicant_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setApplicantId($applicant_id)
    {
        $this->applicant_id = $applicant_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVacancyId()
    {
        return $this->vacancy_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setVacancyId($vacancy_id)
    {
        $this->vacancy_id = $vacancy_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecruitmentStageId()
    {
        return $this->recruitment_stage_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRecruitmentStageId($recruitment_stage_id)
    {
        $this->recruitment_stage_id = $recruitment_stage_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCoverLetter()
    {
        return $this->cover_letter;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCoverLetter($cover_letter)
    {
        $this->cover_letter = $cover_letter;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRating()
    {
        return $this->rating;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function applicant()
    {
        return $this->belongsTo(ApplicantEloquent::class, 'applicant_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function vacancy()
    {
        return $this->belongsTo(VacancyEloquent::class, 'vacancy_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function recruitment_stage()
    {
        return $this->belongsTo(RecruitmentStageEloquent::class, 'recruitment_stage_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    
    //</editor-fold>

    
    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateVacancyApplicantEloquent",
 *     description="Create vacancy applicant eloquent",
 *     title="Create vacancy applicant eloquent",
 *     required={"applicant_id", "vacancy_id", "recruitment_stage_id", "cover_letter", "rating"},
 *     @OA\Property(property="applicant_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/applicant_id"),
 *     @OA\Property(property="vacancy_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/vacancy_id"),
 *     @OA\Property(property="recruitment_stage_id", ref="#/components/schemas/VacancyApplicantEloquent/properties/recruitment_stage_id"),
 *     @OA\Property(property="cover_letter", ref="#/components/schemas/VacancyApplicantEloquent/properties/cover_letter"),
 *     @OA\Property(property="rating", ref="#/components/schemas/VacancyApplicantEloquent/properties/rating"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateVacancyApplicantEloquent",
 *     description="Update vacancy applicant eloquent",
 *     title="Update vacancy applicant eloquent",
 *     required={"id", "applicant_id", "vacancy_id", "recruitment_stage_id", "cover_letter", "rating"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateVacancyApplicantEloquent")
 *     }
 * )
 */

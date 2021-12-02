<?php

namespace App\Domains\HumanResources\MasterData\AdditionalQuestion;

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts\AdditionalQuestionInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Additional Question eloquent",
 *     title="Additional Question eloquent",
 *     required={"company_id", "question", "is_required", "status"}
 * )
 * AdditionalQuestionEloquent.
 */
class AdditionalQuestionEloquent extends EloquentAbstract implements AdditionalQuestionInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="company_id",
     *     type="integer",
     *     format="int64",
     *     description="Company id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="question",
     *     type="string",
     *     description="Question property"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="is_required",
     *     type="integer",
     *     format="int32",
     *     description="Is required property (required = 1; not required = 0)",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="status",
     *     type="string",
     *     description="Status property",
     *     enum={"DRAFT", "PUBLISH", "PENDING"},
     *     default=""
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
    protected $table =  AdditionalQuestionInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'question', 'is_required', 'status'
    ];

    protected $searchable = [
        'company_id', 'question', 'is_required', 'status'
    ];

    protected $orderable = [
        'company_id', 'question', 'is_required', 'status'
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
    public function getCompanyId()
    {
        return $this->company_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIsRequired()
    {
        return $this->is_required;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setIsRequired($is_required)
    {
        $this->is_required = $is_required;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function company()
    {
        return $this->belongsTo(CompanyEloquent::class, 'company_id');
    }

    //</editor-fold>


    //<editor-fold desc="#has many relation">
    //</editor-fold>
}

/**
 * @OA\Schema(
 *     schema="CreateAdditionalQuestionEloquent",
 *     description="Create additional question eloquent",
 *     title="Create additional question eloquent",
 *     required={"company_id", "question", "is_required", "status"},
 *     @OA\Property(property="company_id", ref="#/components/schemas/AdditionalQuestionEloquent/properties/company_id"),
 *     @OA\Property(property="question", ref="#/components/schemas/AdditionalQuestionEloquent/properties/question"),
 *     @OA\Property(property="is_required", ref="#/components/schemas/AdditionalQuestionEloquent/properties/is_required"),
 *     @OA\Property(property="status", ref="#/components/schemas/AdditionalQuestionEloquent/properties/status")
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateAdditionalQuestionEloquent",
 *     description="Update additional question eloquent",
 *     title="Update additional question eloquent",
 *     required={"id", "company_id", "question", "is_required", "status"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateAdditionalQuestionEloquent")
 *     }
 * )
 */

<?php

namespace App\Domains\WorkAgreementLetter;

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\MasterData\LetterType\LetterTypeEloquent;
use App\Domains\MediaLibrary\MediaLibraryEloquent;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterInterface;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     description="Work agreement letter eloquent",
 *     title="Work agreement letter eloquent",
 *     required={"employee_id", "letter_type_id", "reference_number", "start_date", "end_date"}
 * )
 * WorkAgreementLetterEloquent.
 */
class WorkAgreementLetterEloquent extends EloquentAbstract implements WorkAgreementLetterInterface
{
    use SoftDeletes;

    /**
     * @OA\Property(
     *     property="employee_id",
     *     description="Employee id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="letter_type_id",
     *     description="Letter type id property",
     *     type="integer",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="reference_number",
     *     description="Reference number property",
     *     type="string"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="start_date",
     *     description="Start date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="end_date",
     *     description="End date property",
     *     type="string",
     *     format="date-time",
     *     example="2020-01-01 00:00:00"
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="description",
     *     description="Description number property",
     *     type="string"
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
    protected $table =  WorkAgreementLetterInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'letter_type_id', 'reference_number', 'start_date', 'end_date', 'description', 'created_by', 'modified_by'
    ];

    protected $searchable = [
        'employee_id', 'letter_type_id', 'reference_number', 'start_date', 'end_date', 'description', 'created_by', 'modified_by'
    ];

    protected $orderable = [
        'employee_id', 'letter_type_id', 'reference_number', 'start_date', 'end_date', 'description', 'created_by', 'modified_by'
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
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLetterTypeId()
    {
        return $this->letter_type_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setLetterTypeId($letter_type_id)
    {
        $this->letter_type_id = $letter_type_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceNumber()
    {
        return $this->reference_number;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setReferenceNumber($reference_number)
    {
        $this->reference_number = $reference_number;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
        return $this;
    }

    //</editor-fold


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeEloquent::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|mixed
     */
    public function letterType()
    {
        return $this->belongsTo(LetterTypeEloquent::class, 'letter_type_id');
    }

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    public function morphMediaLibraries()
    {
        return $this->morphToMany(MediaLibraryEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_libraryable_id',
            'media_library_id');
    }

    //</editor-fold>


    //</editor-fold
}

/**
 * @OA\Schema(
 *     schema="CreateWorkAgreementLetterEloquent",
 *     description="Create work agreement letter eloquent",
 *     title="Create work agreement letter eloquent",
 *     required={"employee_id", "letter_type_id", "reference_number", "start_date", "end_date"},
 *     @OA\Property(property="employee_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/employee_id"),
 *     @OA\Property(property="letter_type_id", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/letter_type_id"),
 *     @OA\Property(property="reference_number", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/reference_number"),
 *     @OA\Property(property="start_date", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/start_date"),
 *     @OA\Property(property="end_date", ref="#/components/schemas/WorkAgreementLetterEloquent/properties/end_date"),
 * )
 */

/**
 * @OA\Schema(
 *     schema="UpdateWorkAgreementLetterEloquent",
 *     description="Update work agreement letter eloquent",
 *     title="Update work agreement letter eloquent",
 *     required={"id", "employee_id", "letter_type_id", "reference_number", "start_date", "end_date"},
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
 *          @OA\Schema(ref="#/components/schemas/CreateWorkAgreementLetterEloquent")
 *     }
 * )
 */
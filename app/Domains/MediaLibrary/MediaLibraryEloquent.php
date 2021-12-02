<?php
namespace App\Domains\MediaLibrary;


use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\ProjectAddendumEloquent;
use App\Domains\HumanResources\Project\ProjectEloquent;
use App\Domains\MediaLibrary\Contracts\MediaLibraryInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterInterface;
use App\Domains\RegistrationLetter\RegistrationLetterEloquent;
use App\Domains\User\Profile\Contracts\ProfileInterface;
use App\Domains\User\Profile\ProfileEloquent;
use App\Domains\User\UserEloquent;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterInterface;
use App\Domains\WorkAgreementLetter\WorkAgreementLetterEloquent;
use App\Infrastructures\EloquentAbstract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Ramsey\Uuid\Uuid;

/**
 * @OA\Schema(
 *     description="Media library eloquent",
 *     title="Media library eloquent",
 *     required={"company_id", "collection", "original_file", "generate_file", "extension", "mime_type", "disk", "path", "size"}
 * )
 * MediaLibraryEloquent.
 */
class MediaLibraryEloquent extends EloquentAbstract implements MediaLibraryInterface
{
    /**
     * @OA\Property(
     *     property="user_id",
     *     type="integer",
     *     format="int64",
     *     description="User id property",
     *     example=1
     * )
     *
     * @var integer
     */

    /**
     * @OA\Property(
     *     property="collection",
     *     description="Collection property",
     *     type="string",
     *     enum={"STORAGE", "COMPANY", "PROFILE",
           "EMPLOYEE", "WORK_AGREEMENT_LETTER", "REGISTRATION_LETTER",
           "PROJECT", "PROJECT_ADDENDUM", "APPLICANT"},
     *     default=""
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="original_file",
     *     type="string",
     *     description="Original file property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="generate_file",
     *     type="string",
     *     description="Generate file property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="extension",
     *     type="string",
     *     description="Extension property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="type",
     *     type="string",
     *     description="Type property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="mime_type",
     *     type="string",
     *     description="Mime type property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="disk",
     *     type="string",
     *     description="Disk property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="path",
     *     type="string",
     *     description="Path type property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="width",
     *     type="string",
     *     description="Width property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="height",
     *     type="string",
     *     description="Height property",
     * )
     *
     * @var string
     */

    /**
     * @OA\Property(
     *     property="size",
     *     type="string",
     *     description="Size property",
     * )
     *
     * @var string
     */


    //<editor-fold desc="#field">

    public $keyType = 'string';
    public $incrementing = false;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table =  MediaLibraryInterface::TABLE_NAME;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'collection', 'original_file', 'generate_file', 'extension', 'type', 'mime_type', 'disk', 'path', 'width', 'height', 'size',
    ];

    protected $searchable = [
        'user_id', 'collection', 'original_file', 'generate_file', 'extension', 'type', 'mime_type', 'disk', 'path', 'width', 'height', 'size',
    ];

    protected $orderable = [
        'user_id', 'collection', 'original_file', 'generate_file', 'extension', 'type', 'mime_type', 'disk', 'path', 'width', 'height', 'size',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4();
        });
    }

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection()
    {
        return $this->collection;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOriginalFile()
    {
        return $this->original_file;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setOriginalFile($original_file)
    {
        $this->original_file = $original_file;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGenerateFile()
    {
        return $this->generate_file;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setGenerateFile($generate_file)
    {
        $this->generate_file = $generate_file;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {
        return $this->extension;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setMimeType($mime_type)
    {
        $this->mime_type = $mime_type;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDisk()
    {
        return $this->disk;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDisk($disk)
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSize($size)
    {
        $this->size = $size;
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

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#many to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserEloquent::class, 'user_id');
    }

    //</editor-fold>


    //<editor-fold desc="#polymorphism many to many relation">

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphCompanies()
    {
        return $this->morphedByMany(CompanyEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphEmployees()
    {
        return $this->morphedByMany(EmployeeEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany|mixed
     */
    public function morphWorkAgreementLetters()
    {
        return $this->morphedByMany(WorkAgreementLetterEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany|mixed
     */
    public function morphWorkRegistrationLetters()
    {
        return $this->morphedByMany(RegistrationLetterEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphProfiles()
    {
        return $this->morphedByMany(ProfileEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphProjects()
    {
        return $this->morphedByMany(ProjectEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphProjectAddendums()
    {
        return $this->morphedByMany(ProjectAddendumEloquent::class,
            'media_libraryable',
            'media_libraryables',
            'media_library_id',
            'media_libraryable_id');
    }

    //</editor-fold>


    //</editor-fold>

}

//Custom relation
Relation::morphMap([
    CompanyInterface::MORPH_NAME => CompanyEloquent::class,
    EmployeeInterface::MORPH_NAME => EmployeeEloquent::class,
    WorkAgreementLetterInterface::MORPH_NAME => WorkAgreementLetterEloquent::class,
    RegistrationLetterInterface::MORPH_NAME => RegistrationLetterEloquent::class,
    ProfileInterface::MORPH_NAME => ProfileEloquent::class,
    ProjectInterface::MORPH_NAME => ProjectEloquent::class,
    ProjectAddendumInterface::MORPH_NAME => ProjectAddendumEloquent::class,
]);

/**
 * @OA\Schema(
 *     schema="UploadFileMediaLibraryEloquent",
 *     description="Upload file media library eloquent",
 *     title="Upload file media library eloquent",
 *     required={"company_id", "collection"},
 *     @OA\Property(property="user_id", ref="#/components/schemas/MediaLibraryEloquent/properties/user_id"),
 *     @OA\Property(property="collection", ref="#/components/schemas/MediaLibraryEloquent/properties/collection")
 * )
 */

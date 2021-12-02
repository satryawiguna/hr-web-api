<?php
namespace App\Domains\MediaLibrary\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface MediaLibraryInterface extends BaseEntityInterface
{
    const TABLE_NAME = 'media_libraries';
    const MORPH_NAME = 'media_libraries';

    

    /**
     * Get user_id.
     *
     * @return mixed
     */
    public function getUserId();
    
    /**
     * Set user_id.
     *
     * @param $user_id
     *
     * @return mixed
     */
    public function setUserId($user_id);

    /**
     * Get collection.
     *
     * @return mixed
     */
    public function getCollection();
    
    /**
     * Set collection.
     *
     * @param $collection
     *
     * @return mixed
     */
    public function setCollection($collection);

    /**
     * Get original file.
     *
     * @return mixed
     */
    public function getOriginalFile();
    
    /**
     * Set original file.
     *
     * @param $original_file
     *
     * @return mixed
     */
    public function setOriginalFile($original_file);

    /**
     * Get generate file.
     *
     * @return mixed
     */
    public function getGenerateFile();
    
    /**
     * Set generate file.
     *
     * @param $generate_file
     *
     * @return mixed
     */
    public function setGenerateFile($generate_file);

    /**
     * Get extension.
     *
     * @return mixed
     */
    public function getExtension();
    
    /**
     * Set extension.
     *
     * @param $extension
     *
     * @return mixed
     */
    public function setExtension($extension);

    /**
     * Get type.
     *
     * @return mixed
     */
    public function getType();

    /**
     * Set type.
     *
     * @param $type
     *
     * @return mixed
     */
    public function setType($type);

    /**
     * Get mime_type.
     *
     * @return mixed
     */
    public function getMimeType();
    
    /**
     * Set mime_type.
     *
     * @param $mime_type
     *
     * @return mixed
     */
    public function setMimeType($mime_type);

    /**
     * Get disk.
     *
     * @return mixed
     */
    public function getDisk();
    
    /**
     * Set disk.
     *
     * @param $disk
     *
     * @return mixed
     */
    public function setDisk($disk);

    /**
     * Get path.
     *
     * @return mixed
     */
    public function getPath();

    /**
     * Set path.
     *
     * @param $path
     *
     * @return mixed
     */
    public function setPath($path);

    /**
     * Get width.
     *
     * @return mixed
     */
    public function getWidth();

    /**
     * Set width.
     *
     * @param $width
     *
     * @return mixed
     */
    public function setWidth($width);

    /**
     * Get height.
     *
     * @return mixed
     */
    public function getHeight();

    /**
     * Set height.
     *
     * @param $height
     *
     * @return mixed
     */
    public function setHeight($height);

    /**
     * Get size.
     *
     * @return mixed
     */
    public function getSize();
    
    /**
     * Set size.
     *
     * @param $size
     *
     * @return mixed
     */
    public function setSize($size);

    /**
     * Get created by.
     *
     * @return mixed
     */
    public function getCreatedBy();

    /**
     * Set created by.
     *
     * @param $created_by
     *
     * @return mixed
     */
    public function setCreatedBy($created_by);

    /**
     * Get modified by.
     *
     * @return mixed
     */
    public function getModifiedBy();

    /**
     * Set modified by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setModifiedBy($modified_by);


    //<editor-fold desc="#polymorphism many to many relation">

    /**
     * @return mixed
     */
    public function user();

    //</editor-fold>


    //<editor-fold desc="#polimorphism many to many relation">

    /**
     * @return mixed
     */
    public function morphCompanies();

    /**
     * @return mixed
     */
    public function morphEmployees();

    /**
     * @return mixed
     */
    public function morphWorkAgreementLetters();

    /**
     * @return mixed
     */
    public function morphWorkRegistrationLetters();

    /**
     * @return mixed
     */
    public function morphProfiles();

    /**
     * @return mixed
     */
    public function morphProjects();

    /**
     * @return mixed
     */
    public function morphProjectAddendums();

    //</editor-fold>
}

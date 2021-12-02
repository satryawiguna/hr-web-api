<?php

namespace App\Domains;


use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Contracts\BaseEntityInterface;
use App\Infrastructures\EloquentAbstract;
use DateTime;
use ErrorException;
use Illuminate\Support\Facades\Config;
use phpDocumentor\Reflection\Types\Integer;

abstract class ServiceAbstract
{
    //<editor-fold desc="#public (method)">

    /**
     * Return new instance.
     * @param array|null $attributes
     * @return mixed
     */
    public function newInstance(array $attributes = null)
    {
        return $this->repository->newInstance($attributes);
    }

    /**
     * Return main repository.
     */
    public function repository()
    {
        return $this->repository;
    }

    /**
     * Get all records.
     * @return mixed
     */
    public function all(): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository()->all();

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }


        return $response;
    }

    /**
     * Paginated List.
     * @param int $limit
     * @param int $offset
     * @param array $columns
     * @return GenericCollectionResponse
     */
    public function lists(int $limit = 10, int $offset = 0, array $columns = ['*']): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository()->lists($limit, $offset, $columns);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * Get record by ID.
     * @param int $id
     * @return ObjectResponse
     */
    public function get(int $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $this->repository()->get($id);

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * Find record by ID.
     * @param $id
     * @return mixed
     */
    public function find(int $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $this->repository()->find($id);

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * Find record by multiple fields.
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            $results = $this->repository()->findWhere($where);

            $response->setDtoList($results);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * Delete record by multiple fields condition.
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where): BasicResponse
    {
        return $this->repository()->deleteWhere($where);
    }

    /**
     * First entity or create new.
     * @param array $attributes
     * @return mixed
     */
    public function firstOrCreate(array $attributes): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $this->repository()->firstOrCreate($attributes);

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * First entity or Null.
     * @param array $attributes
     * @return mixed
     */
    public function firstOrNull(array $attributes): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $this->repository()->firstOrNull($attributes);

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * Get Count.
     * @return mixed
     */
    public function count(): Integer
    {
        return $this->repository()
            ->count();
    }

    /**
     * Save or update record.
     * @param BaseEntityInterface $object
     * @return ObjectResponse
     */
    public function save(BaseEntityInterface $object): ObjectResponse
    {
        if ($object->getKey()) {
            return $this->repository()->update($object);
        }

        return $this->repository()->create($object);
    }

    /**
     * Delete record.
     * @param BaseEntityInterface $object
     * @return ObjectResponse
     */
    public function destroy(BaseEntityInterface $object): ObjectResponse
    {
        return $this->repository()->delete($object);
    }

    //</editor-fold>


    //<editor-fold desc="#protected (method)">

    protected function setAuditableInformationFromRequest($entity, $request = null)
    {
        if (is_object($entity)) {
            if ($entity->getKey()) {
                $entity->modified_by = (!$request) ? $entity->getRequestBy() : $request->getRequestBy();
            } else {
                $entity->created_by = (!$request) ? $entity->getRequestBy() : $request->getRequestBy();
            }
        }

        if (is_array($entity)) {
            $date = new DateTime('now');

            if (!array_key_exists('id', $entity) || $entity['id'] == 0) {
                $entity['updated_by'] = (!$request) ? $entity->getRequestBy() : $request->getRequestBy();
                $entity['updated_at'] = $date->format(Config::get('datetime.format.database_datetime'));
            } else {
                $entity['created_by'] = (!$request) ? $entity->getRequestBy() : $request->getRequestBy();
                $entity['created_at'] = $date->format(Config::get('datetime.format.database_datetime'));
            }

            return $entity;
        }

    }

    //</editor-fold>
}

<?php

namespace App\Http\Controllers;


use App\Core\Services\Request\AuditableRequest;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\BooleanResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait BaseController
{
    //<editor-fold desc="#protected (method)">

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicSuccessJson()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 1:
                $arg1 = $args[0];

                if ($arg1 instanceof BasicResponse) {
                    return response()->json([
                        'status' => $arg1->getFirstMessageResponseSuccessStatus(),
                        'message' => $arg1->getLastMessageResponseSuccessText()
                    ], $arg1->getFirstMessageResponseSuccessStatus());
                } elseif (is_array($arg1)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['messages']
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            case 2:
                $arg1 = $args[0];
                $arg2 = $args[1];

                if ($arg1 instanceof BasicResponse &&
                    (is_array($arg2) || is_bool($arg2) || is_int($arg2) || is_string($arg2) || is_object($arg2) || $arg2 instanceof Collection)) {
                    return response()->json([
                        'status' => $arg1->getFirstMessageResponseSuccessStatus(),
                        'message' => $arg1->getLastMessageResponseSuccessText(),
                        'data' => $arg2
                    ], $arg1->getFirstMessageResponseSuccessStatus());
                } elseif (is_array($arg1) && is_array($arg2)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['messages'],
                        'data' => $arg2
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            default:
                trigger_error('Expecting one arguments', E_USER_ERROR);
                break;
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicInfoJson()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 1:
                $arg1 = $args[0];

                if ($arg1 instanceof BasicResponse) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseInfoStatus(),
                        'message' => $arg1->getLastMessageResponseInfoText()
                    ], $arg1->getLastMessageResponseInfoStatus());
                } elseif (is_array($arg1)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['messages']
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            case 2:
                $arg1 = $args[0];
                $arg2 = $args[1];

                if ($arg1 instanceof BasicResponse &&
                    (is_array($arg2) || is_bool($arg2) || is_int($arg2) || is_string($arg2) || is_object($arg2) || $arg2 instanceof Collection)) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseInfoStatus(),
                        'message' => $arg1->getLastMessageResponseInfoText(),
                        'data' => $arg2
                    ], $arg1->getLastMessageResponseInfoStatus());
                } elseif (is_array($arg1) && is_array($arg2)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['messages'],
                        'data' => $arg2
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            default:
                trigger_error('Expecting correct argument', E_USER_ERROR);
                break;
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicWarningJson()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 1:
                $arg1 = $args[0];

                if ($arg1 instanceof BasicResponse) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseWarningStatus(),
                        'message' => $arg1->getLastMessageResponseWarningText()
                    ], $arg1->getLastMessageResponseWarningStatus());
                } elseif (is_array($arg1)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['messages']
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            case 2:
                $arg1 = $args[0];
                $arg2 = $args[1];

                if ($arg1 instanceof BasicResponse &&
                    (is_array($arg2) || is_bool($arg2) || is_int($arg2) || is_string($arg2) || is_object($arg2) || $arg2 instanceof Collection)) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseWarningStatus(),
                        'message' => $arg1->getLastMessageResponseWarningText(),
                        'data' => $arg2
                    ], $arg1->getLastMessageResponseWarningStatus());
                } elseif (is_array($arg1) && is_array($arg2)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['message'],
                        'data' => $arg2
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            default:
                trigger_error('Expecting correct argument', E_USER_ERROR);

                break;
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getBasicErrorJson()
    {
        $args = func_get_args();

        switch (count($args)) {
            case 1:
                $arg1 = $args[0];

                if ($arg1 instanceof BasicResponse) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseErrorStatus(),
                        'message' => $arg1->getLastMessageResponseErrorText()
                    ], $arg1->getLastMessageResponseErrorStatus());
                } elseif (is_array($arg1)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['message']
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            case 2:
                $arg1 = $args[0];
                $arg2 = $args[1];

                if ($arg1 instanceof BasicResponse &&
                    (is_array($arg2) || is_bool($arg2) || is_int($arg2) || is_string($arg2) || is_object($arg2) || $arg2 instanceof Collection)) {
                    return response()->json([
                        'status' => $arg1->getLastMessageResponseErrorStatus(),
                        'message' => $arg1->getLastMessageResponseErrorText(),
                        'data' => $arg2
                    ], $arg1->getLastMessageResponseErrorStatus());
                } elseif (is_array($arg1) && is_array($arg2)) {
                    return response()->json([
                        'status' => $arg1['status'],
                        'message' => $arg1['message'],
                        'data' => $arg2
                    ], $arg1['status']);
                } else {
                    trigger_error('Incorrect parameters passed', E_USER_ERROR);
                }

                break;

            default:
                trigger_error('Expecting correct argument', E_USER_ERROR);

                break;
        }
    }



    /**
     * @param callable $searchMethod
     * @param callable $dtoObjectToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getObjectJson(callable $searchMethod,
                                     callable $dtoObjectToRowJsonMethod)
    {
        $response = $searchMethod();
        $rowJsonData = $dtoObjectToRowJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($rowJsonData);
        }


        return $this->getBasicErrorJson($response);
    }

    /**
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getListJson(callable $searchMethod,
                                   callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod();
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getListSearchJson(Request $request,
                                         callable $searchMethod,
                                         callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param callable $searchMethod
     * @param callable $dtoPageSearchToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getPagedSearchJson(Request $request,
                                          callable $searchMethod,
                                          callable $dtoPageSearchToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter);
        $rowJsonData = $dtoPageSearchToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountPage' => $parameter->length,
                'rowCountTotal' => $response->_totalCount
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @return ListSearchRequest
     */
    protected function generateListSearchParameter(Request $request)
    {
        $listSearchRequest = new ListSearchRequest();

        //For Select2
        $listSearchRequest->query = $request->input('query');

        return $listSearchRequest;
    }

    /**
     * @param Request $request
     * @return PageSearchRequest
     */
    protected function generatePageSearchParameter(Request $request)
    {
        $pageSearchRequest = new PageSearchRequest();

        //For Angular Datatable
        $pageSearchRequest->draw = (integer)$request->input('draw');
        $pageSearchRequest->columns = $request->input('columns');
        $pageSearchRequest->order = $request->input('order');
        $pageSearchRequest->start = (integer)$request->input('start');
        $pageSearchRequest->length = (integer)$request->input('length');
        $pageSearchRequest->search = $request->input('search');

        //For JQuery Datatable
        $pageSearchRequest->pagination = $request->input('pagination');
        $pageSearchRequest->query = $request->input('query');
        $pageSearchRequest->sort = $request->input('sort');

        return $pageSearchRequest;
    }

    /**
     * @param AuditableRequest $auditableRequest
     */
    protected function setRequestAuthor(AuditableRequest $auditableRequest): void
    {
        if (Auth::user()) {
            $auditableRequest->request_by = Auth::user()->username;
        } else {
            $auditableRequest->request_by = 'system';
        }
    }

    //</editor-fold>
}

<?php namespace OMS\Http\Controllers;

use OMS\Http\Controllers\BaseController;
use Response;
/**
 * Class APIController
 */
class APIController extends BaseController {
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * Respond with a generic error. Expects the status code to be already set.
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return Response::json([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ], $this->statusCode);
    }

    /**
     * Respond that a resource wasn't found
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not found.')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * Function for throwing ISE 500
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = "Internal Error")
    {
        return $this->setStatusCode(500)->responWithError($message);
    }

    /**
     * Set the status code of the response
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the status code of this request
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}
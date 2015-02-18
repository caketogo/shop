<?php namespace OMS\Http\Requests\API;

use OMS\Http\Requests\Request;
use OMS\Http\Controllers\APIController;

class APIRequest extends Request {
    /**
     * This function will be called if the validation fails with the errors passed into it.
     * We use our API Controller to respond with the errors to create an identical interface throughout.
     *
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        // Create a new instance of the API Controller
        $controller = new APIController;

        // Get the status code to 400 (aka bad request)
        $controller->setStatusCode(400);

        // Get a clean array of errors (Laravel preloads it into some crap format)
        foreach($errors AS $error) {
            foreach($error AS $nestedError) {
                $cleanedErrors[] = $nestedError;
            }
        }

        // Create a JSON response with the errors array
        return $controller->respondWithError($cleanedErrors);
    }

    /**
     * No logic needed here at this stage. This could be overrided when needed
     * in classes that implement it
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
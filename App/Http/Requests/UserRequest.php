<?php namespace AlistairShaw\YewCMS\App\Http\Requests;

use Request;

class UserRequest extends YewCMSRequest {

    public function rules()
    {
        switch ($this->method())
        {
            case 'PUT':
                return [
                    'email'    => 'email',
                    'password' => 'min:6'
                ];
                break;
            case 'POST':
                return [
                    'email'    => 'required|email',
                    'password' => 'required|min:6'
                ];
                break;
            default:
                return [];
        }
    }

    public function authorize()
    {
        $user = $this->authUser();

        // id not permitted
        if (Request::input('id') && ! ($this->get('id') === Request::input('id')))
        {
            $this->errorMessage = 'Invalid or unexpected parameter: id';

            return false;
        }

        return true;
    }

}
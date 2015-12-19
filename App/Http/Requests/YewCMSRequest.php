<?php namespace AlistairShaw\YewCMS\App\Http\Requests;

use AlistairShaw\YewCMS\App\Base\Services\UserAuth\UserAuth;
use App;
use Request;

class YewCMSRequest extends Request {

    /**
     * @return null
     */
    protected function authUser()
    {
        try
        {
            return $this->resolveUserAuth()->getUser();
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    /**
     * @return UserAuth
     */
    protected function resolveUserAuth()
    {
        return App::make('AlistairShaw\YewCMS\App\Base\Services\UserAuth\UserAuth');
    }

}
<?php namespace AlistairShaw\YewCMS\App\Base\Services\ApiResponder;

class ApiResponder {

	/**
	 * @param bool   $success
	 * @param array  $data
	 * @param string $message
	 * @param bool   $return Set to false to echo and exit rather than returning the value
	 * @return mixed
	 */
	public static function respondAjax($success, $data = [], $message = '', $return = true)
	{
		$returnData = [];

		// OK response
		if ($success)
		{
			$returnData = $data;
			if ($return) return $returnData;

			echo json_encode($returnData);
			exit();
		}

		// error response
		http_response_code(400);
		if ($data) $returnData['data'] = $data;
		if ($message) $returnData['message'] = $message;

		return abort(400, json_encode($returnData));
	}

}
<?php
namespace App\Http;
use Illuminate\Http\JsonResponse as IlluminateJsonResponse;
use phpDocumentor\Reflection\Types\Integer;
/**
 * This class is wrapper of base Illuminate\Http\JsonResponse
 * to specify response structure
 *
 * @see Illuminate\Http\JsonResponse
 */
class JsonResponse extends IlluminateJsonResponse
{
    /**
     * @var int response code
     */
    protected $code = 0;
    /**
     * @var string|array response message
     */
    protected $message;
    /**
     * @var array response
     */
    protected $response = [];
    /**
     * Constructor
     *
     * {@inheritdoc}
     */
    public function __construct($data = null, $status = 200, $headers = [], $options = 0)
    {
        $this->message = 'Success';
        parent::__construct($data, $status, $headers, $options);
    }
    /**
     * Set code for response (default is 0)
     *
     * @param int $code
     * @return self
     */
    public function withCode($code)
    {
        $this->code = (int)$code;
        $this->setData();
        return $this;
    }
    /**
     * Set message for response (default is "")
     *
     * @param string|array $mesasge
     * @return self
     */
    public function withMessage($message)
    {
        $this->message = $message;
        $this->setData();
        return $this;
    }
    /**
     * Override setData function
     *
     * {@inheritdoc}
     */
    public function setData($data = [])
    {
        if ($data) {
            $this->response = $data;
        }
        return parent::setData($this->build());
    }
    /**
     * Get response json structure, you should edit this for
     * any customize structure
     *
     * @param void
     * @return array
     */
    protected function build()
    {
		return [
			'result' => [
				'error' => [
					'code' => $this->code,
					'message' => $this->message
				],
				'data' => $this->response
			]
        ];
    }
}
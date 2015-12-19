<?php namespace AlistairShaw\YewCMS\App\Base\ValueObjects;

class DataSet {

    /**
     * @var Collection
     */
    private $data;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * Returns a object taking PHP native value(s) as argument(s).
     *
     * @return ValueObject
     */
    public static function fromNative()
    {
        $data = func_get_args()[0];
        $count = func_get_args()[1];
        $limit = func_get_args()[2];
        $offset = func_get_args()[3];
        return new static($data, $count, $limit, $offset);
    }

    /**
     * @param Collection $data
     * @param int        $count
     * @param int        $limit
     * @param int        $offset
     */
    public function __construct(Collection $data, $count, $limit, $offset)
    {
        $this->data   = $data;
        $this->count  = (int) $count;
        $this->limit  = (int) $limit;
        $this->offset = (int) $offset;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];
        foreach ($this->data as $data)
        {
            if ($data instanceof Image)
            {
                $result[] = Image::getPicArray($data);
            }
            else
            {
                $result[] = $data->toArray();
            }
        }

        return [
            'count' => $this->count,
            'result' => $result,
            'limit' => $this->limit,
            'offset' => $this->offset
        ];
    }

    /**
     * To drop one element
     * @param $key
     */
    public function forget($key)
    {
        $this->data->forget($key);
        $this->count--;
    }

    /**
     * @return Collection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function __toString() {
        return json_encode($this->data);
    }
}
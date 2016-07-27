<?php


namespace DPodsiadlo\SvgCharts\Charts;


abstract class Chart
{

    protected $data = null;
    protected $options = [];

    /**
     * @return string
     */
    abstract public function render();

    public function __construct($data, $options = null)
    {
        $this->data = $data;

        if (isset($options) && is_array($options)) {
            $this->options = array_merge($this->options, $options);
        }
    }


    /**
     * @return string
     */
    public function toBase64()
    {
        return base64_encode($this->render());
    }


    /**
     * @return string
     */
    public function toImgSrc()
    {
        return "data:image/svg+xml;base64," . $this->toBase64();
    }

}
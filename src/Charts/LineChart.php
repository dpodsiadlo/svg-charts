<?php


namespace DPodsiadlo\SvgCharts\Charts;


use Illuminate\Support\Facades\View;

class LineChart extends Chart
{

    protected $options = [
        'colors' => ['#32638e'],
        'fillColor' => ['#32638e'],
        'stroke' => 1,
        'axisColor' => '#4a4a4c',
        'axisWidth' => 2,
        'gridColor' => '#9c9c9b',
        'gridWidth' => 1,
        'valueGroups' => 5,
        'width' => 1600,
        'height' => 900,
        'margin' => 10
    ];


    private $min = null;
    private $max = null;


    public function __construct($data, $options)
    {
        parent::__construct($data, $options);


        $this->min = PHP_INT_MAX;
        $this->max = -PHP_INT_MAX;

        for ($i = 0; $i < count($this->data['data']); $i++) {
            foreach ($this->data['data'][$i] as $val) {
                $this->min = min($this->min, $val);
                $this->max = max($this->max, $val);
            }
        }

        if ($this->min < $this->max) {
            $exp = floor(log($this->max, 10));
            $base = pow(10, $exp - 1);

            $this->max = ceil($this->max / $base) * $base;
            $this->min = floor($this->min / $base) * $base;
        } else {
            $this->min = 0;
            $this->max = 0;

        }


    }

    /**
     * @return string
     */
    public function render()
    {
        return View::make("svg-charts::line-chart", array_merge([
            'paths' => $this->paths(),
            'grid' => $this->grid(),
            'isEmpty' => $this->isEmpty()
        ], $this->options, $this->dimensions()
        ))->render();
    }


    /**
     * @return bool
     */
    private function isEmpty()
    {
        foreach ($this->data['data'] as $data) {
            if (!empty($data)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    private function dimensions()
    {
        return [
            'axisX0' => $this->axisX0,
            'axisY0' => $this->axisY0,
            'axisX1' => $this->axisX1,
            'axisY1' => $this->axisY1
        ];
    }

    /**
     * @return array
     */
    private function grid()
    {
        $res = [
            'values' => [],
            'labels' => []
        ];


        $step = ceil(count($this->data['labels']) / 10);

        $i = 0;
        $wth = ($this->width * .9 - 2 * $this->margin) / count($this->data['labels']);
        $x = $this->margin + ($this->width * 0.1);

        foreach ($this->data['labels'] as $ts => $label) {
            if (0 === $i++ % $step) {

                $res['labels'][$x] = $this->data['labels'][$ts];
                $x += $wth * $step;

            }
        }


        for ($i = 1; $i < $this->valueGroups; $i++) {
            $y = strval($this->height * .9 - $this->margin - ($i / $this->valueGroups) * ($this->height * .9 - 2 * $this->margin));
            $res['values'][$y] = $this->min + $i * ($this->max - $this->min) / $this->valueGroups;

            if (isset($this->options['valueFormatter'])) {
                $res['values'][$y] = $this->options['valueFormatter']($res['values'][$y]);
            }
        }


        return $res;
    }

    /**
     * @return array
     */
    private function paths()
    {
        $res = [];

        $wth = $this->width * .9 - 2 * $this->margin;
        $hth = $this->height * .9 - 2 * $this->margin;

        foreach ($this->data['data'] as $data) {

            $c = count($data);

            $stepX = $wth / $c;

            $x = $this->axisX0 - $stepX;


            $path = "M" . $this->axisX0 . " " . $this->axisY0;

            foreach ($data as $value) {
                $y = $this->axisY0 - ($value - $this->min) / max($this->max - $this->min, 1) * $hth;

                $x += $stepX;
                $path .= " L" . $x . " " . $y;


            }

            $path .= " L" . $x . " " . $this->axisY0;


            $res[] = $path;
        }


        return $res;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'axisX0':
                return $this->margin + $this->width * 0.1;
                break;
            case 'axisY0':
                return $this->height * 0.9 - $this->margin;
                break;
            case 'axisX1':
                return $this->width - $this->margin;
                break;
            case 'axisY1':
                return $this->margin;
                break;
            default:
                return $this->options[$name];
        }


    }

}

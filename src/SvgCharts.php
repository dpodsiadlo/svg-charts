<?php

namespace DPodsiadlo\SvgCharts;

use DPodsiadlo\SvgCharts\Charts\LineChart;

class SvgCharts
{

    public function lineChart($data, $options = null)
    {
        return new LineChart($data, $options);
    }

}
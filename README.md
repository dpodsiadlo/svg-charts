# SVG Charts 

A package for Laraver to generate SVG charts compatible with DOMPDF. 

### Installation

Via Composer

``` bash
$ composer require dpodsiadlo/svg-charts
```

### Configuration

Once installed, register Laravel service provider, in your `config/app.php`:

```php
'providers' => [
	...
    DPodsiadlo\SvgCharts\Providers\SvgChartsServiceProvider::class,
]
```



### Basic Usage

#### Line chart
```blade
@inject('svgCharts', '\DPodsiadlo\SvgCharts\SvgCharts')

    <img style="width: 174mm; height: 80mm"
         src="{{$svgCharts->lineChart([
            'labels' => [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            'data' => [
                [1,2,3,4,1,2,6], // First dataset
                [4,1,22,3,4,55,1] //Second dataset
            ]
         ],[
        'colors' => ['#32638e','#f00000'], //Colors for datasets
        'axisColor' => '#4a4a4c',
        'axisWidth' => 2,
        'gridColor' => '#9c9c9b',
        'gridWidth' => 1,
        'valueGroups' => 5,
        'width' => 1600,
        'height' => 900,
        'valueFormatter' => function($value){ // Closure for formatting values
            return money_lc($value);
        }
     ])->toImgSrc()}}"/>
```

### License

The MIT License (MIT). Please see [License File](https://github.com/dpodsiadlo/svg-charts/blob/master/LICENSE) for more information.

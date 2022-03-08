<svg id="svg" xmlns="http://www.w3.org/2000/svg" width="{{$width}}" height="{{$height}}">
    @if(!$isEmpty)
        <g>
            <line x1="{{$axisX0}}"
                  y1="{{$axisY0}}"
                  x2="{{$axisX1}}"
                  y2="{{$axisY0}}"
                  style="stroke:{{$axisColor}};stroke-width:{{$axisWidth}}"/>

            <line x1="{{$axisX0}}"
                  y1="{{$axisY0}}"
                  x2="{{$axisX0}}"
                  y2="{{$axisY1}}"
                  style="stroke:{{$axisColor}};stroke-width:{{$axisWidth}}"/>

            @foreach($grid['values'] as $y => $val)
                <line x1="{{$margin}}"
                      y1="{{$y}}"
                      x2="{{$axisX1}}"
                      y2="{{$y}}"
                      style="stroke:{{$gridColor}};stroke-width:{{$gridWidth}}"/>
                <text style="font-family: sans-serif; font-size: 20pt;" x="{{$margin}}" y="{{$y-$height*.01}}" fill="{{$axisColor}}"
                      text-anchor="start">{{$val}}</text>
            @endforeach
            @foreach($grid['labels'] as $x => $label)
                <line x1="{{$x}}"
                      y1="{{$height*.9-$margin}}"
                      x2="{{$x}}"
                      y2="{{$height*.91-$margin}}"
                      style="stroke:{{$gridColor}};stroke-width:{{$gridWidth}}"/>
                <text style="font-family: sans-serif; font-size: 20pt;" x="{{$x}}" y="{{$height*.93}}" fill="{{$axisColor}}"
                      text-anchor="middle">{{$label}}</text>
            @endforeach


        </g>

        @foreach($paths as $i => $path)
            <path d="{{$path}}" stroke="{{$colors[$i]}}" stroke-width="{{$stroke}}" fill="{{$fillColor[$i]}}"/>
        @endforeach
    @else
        <text style="font-family: sans-serif; font-size: 25pt;" x="{{$width*.5}}" y="{{$height*.5}}" fill="{{$gridColor}}"
              text-anchor="middle">No data.
        </text>
    @endif
</svg>

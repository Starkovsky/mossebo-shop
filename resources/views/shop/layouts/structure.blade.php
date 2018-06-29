@php
    $layouts = [
        1 => [
            'col-sm-12 col-md-6 col-lg-6'
        ],

        2 => [
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6'
        ],

        3 => [
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4'
        ],

        4 => [
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6'
        ],

        5 => [
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4'
        ],

        6 => [
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4'
        ],

        7 => [
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
        ],

        8 => [
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-6',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
            'col-sm-12 col-md-6 col-lg-4',
        ]
    ];

    $itemsCount = count($items);

    $left = $itemsCount;
    $steps = [];
    $perStepChanger = 7;

    while($left > 0) {
        $perStepChanger = $perStepChanger === 7 ? 8 : 7;

        if ($left > $perStepChanger) {
            $steps[] = $perStepChanger;
            $left = $left - $perStepChanger;
        }
        else {
            $steps[] = $left;
            $left = 0;
        }
    }

    $index = 0;
@endphp

<div class="container">
    <div class="row">
        @foreach ($steps as $i => $step)
            @foreach($layouts[$step] as $class)
                <div class="{{ $class }}">
                    @include($chunkName, ['item' => $items[$index++]])
                </div>
            @endforeach
        @endforeach
    </div>
</div>


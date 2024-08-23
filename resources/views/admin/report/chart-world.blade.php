@extends('layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0"> گزارشات </h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a> اطلاعات دانشجویان </a>
                                </li>
                                <li class="breadcrumb-item active">توزیع پراکندگی
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div id="svgMap"></div>
            <script>
                new svgMap({
                    targetElementID: 'svgMap',
                    data: {
                        data: {
                            gdp: {
                                name: 'تعداد دانشجویان',
                                format: '{0} نفر',
                                thousandSeparator: ',',
                                // thresholdMax: 100000,
                                // thresholdMin: 0
                            },
                        },
                        applyData: 'gdp',
                        values: {
                            <?php
                            foreach ($countriesArr as $symbol=>$count){
                                if ($count>0){
                                    echo $symbol.': { gdp: '.($count).'},';
                                }else{break;}
                            }
                            ?>
                        }
                    }
                });

            </script>
        </div>
    </div>
</div>
@endsection

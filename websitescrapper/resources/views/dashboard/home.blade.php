@extends('layouts.app')

@section('content')
<script src="{{ URL::asset('js/custom_js/news_list.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{URL::asset('css/style.css')}}" />
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <h1> Latest News </h1>
                    <div class="pull-right blue">

                        <a id="csv" class="export_data"> <i class="fa fa-file-excel-o red"
                                                            title="Export to CSV"></i> </a>

                        <a id="json" style="background: none; border: none; padding: 0 0 !important;"
                           class="export_data"> <i
                                class="glyphicon glyphicon-save"
                                title="Export to JSON"></i> </a>

                        <form method="post" id="exporttocsv" name="exporttocsv" action="export_file">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">                                                
                            <input type="hidden" name="filetype" id="filetype" value="" />
                        </form>
                    </div>
                    <div class="table-responsive" style="clear:both">
                        <div id="news_data"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

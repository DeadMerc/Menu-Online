@extends('layouts.master')  @section('mainRows')     @parent
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            
        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Обзоры</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">
        <table id="example" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>id</td>
                    <td>Name</td>
                    <td>Phone</td>
                    <td>Review</td>
                </tr>
            </thead>

            <tbody>

                <?php
                //print_r($shops);
                ?>
                @foreach($reviews as $item)
                <tr>
                    <td>{{ $item->id }} </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->review }}</td>
                    <td >
                        @if($item->publish == 0)
                            <a style="float:left;" class="btn btn-info publish{{$item->id}}" onclick="reviewPublish({{$item->id}})">Опубликовать</a>
                        @else
                            <a style="float:left;" class="btn btn-info unpublish{{$item->id}}" onclick="reviewUnPublish({{$item->id}})">Снять с публикации</a>
                        @endif
                        <a style="float: left" href="/admin/review/{{$item->id}}" class="btn btn-info">Редактировать</a>
                        {!! Form::open(['method'=>'DELETE','action' => array('ReviewsController@destroy', $item->id),'style'=>'float:left;']) !!}
                        {!! Form::hidden('id', $item->id) !!}
                        {!! Form::submit('Удалить', ['class' => 'btn btn-danger','onclick'=>'confirm("Вы действительно хотите удалить?");']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div><!--/.row-->
</div>	<!--/.main-->
@endsection
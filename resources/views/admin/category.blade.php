@extends('layouts.master')  @section('mainRows')     @parent
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="#">
                    <svg class="glyph stroked home">
                        <use xlink:href="#stroked-home"></use>
                    </svg>
                </a></li>

        </ol>
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Категория</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">

        @if(isset($item->id))
            {!! Form::model($item, ['id'=>'categoryTableAdd','method'=>'PUT','route' => array('api.categories.update', $item->id)]) !!}
            {!! Form::hidden('id', $item->id) !!}
        @else
            {!! Form::open(['id'=>'categoryTableAdd','method' => 'POST', 'action' => 'CategoriesController@store']) !!}
        @endif
        <div class="form-group">
            {!! Form::label('parent_id', 'Category parent') !!}
            {!! Form::select('parent_id',$parents,null,array('class'=>'form-control','placeholder'=>'Category_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Name', 'Title') !!}
            {!! Form::text('name',null,array('class'=>'form-control','placeholder'=>'Title')) !!}
        </div>
        <div class="form-group">{!! Form::file('image') !!}
        </div>
        @if(isset($item->id))
            <div>
                {!! Form::submit('Обновить', ['class' => 'btn btn-info']) !!}
            </div>
        @else
            <div>
                {!! Form::submit('Добавить', ['class' => 'btn btn-info']) !!}
            </div>
        @endif

        {!! Form::close() !!}

    </div><!--/.row-->
</div>    <!--/.main-->
@endsection
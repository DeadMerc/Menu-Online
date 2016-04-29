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
            <h1 class="page-header">Отзыв</h1>
        </div>
    </div><!--/.row-->

    <div class="row mainRow">

        @if(isset($item->id))
            {!! Form::model($item, ['id'=>'reviewTableAdd','method'=>'PUT','route' => array('api.reviews.update', $item->id)]) !!}
            {!! Form::hidden('id', $item->id) !!}
        @else
            {!! Form::open(['id'=>'reviewTableAdd','method' => 'POST', 'action' => 'ReviewsController@store']) !!}
        @endif
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name',null,array('class'=>'form-control','placeholder'=>'name')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('review', 'Review') !!}
            {!! Form::textarea('review',null,array('class'=>'form-control','placeholder'=>'Review')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('phone', 'phone') !!}
            {!! Form::text('phone',null,array('class'=>'form-control','placeholder'=>'phone')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('shop_id', 'Shop id') !!}
            {!! Form::text('shop_id',null,array('class'=>'form-control','placeholder'=>'shop_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('user_id', 'User id') !!}
            {!! Form::text('user_id',null,array('class'=>'form-control','placeholder'=>'user_id')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('rating', 'Rating range(0,10)') !!}
            {!! Form::text('rating',null,array('class'=>'form-control','placeholder'=>'Rating range(0,10)')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Publish', 'Publish 0/1') !!}
            {!! Form::text('publish',null,array('class'=>'form-control','placeholder'=>'Publish range(0,1)')) !!}
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
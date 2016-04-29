@extends('layouts.master')

@section('mainRows')
    @parent
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
                <h1 class="page-header">Заведения</h1>
            </div>
        </div><!--/.row-->

        <div class="row mainRow">

            <script>

            </script>

            <div class="form-group">
                <label for="sel1">Выберите категорию</label>
                <select onchange="getShopsByCategory($(this));" class="form-control">
                    <option disabled selected>-- Выберите --</option>
                    <?php
                    //var_dump($categories);
                    ?>
                    @foreach($categories as $category)
                        <optgroup label="{{$category['main']['name']}}">
                            @if(isset($category['childrens']))
                                @foreach($category['childrens'] as $children)
                                    <option value="{{$children['id']}}">{{$children['name']}}</option>
                    @endforeach
                    @endif
                    @endforeach
                </select>
            </div>


            <table id="example" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <td>id</td>
                    <!--
                    
                    <td>Street</td>-->
                    <td>Category</td>
                    <td>Image</td>
                    <td>City</td>
                    <td>Title</td>
                    <td>Actions</td>
                </tr>
                </thead>

                <tbody class="shops">

                <?php
                //var_dump($shops);die;
                ?>
                @foreach($shops as $item)
                    <tr>
                        <td>{{ $item->id }} </td>
                        <td>{{ $item->category->name or 'Связь нарушена' }}</td>
                        @if(1 != 1)
                            <td><img height="100px" width="300px" src="/images/{{$item->photos[0]->image }}"></td>
                        @else
                            <td>Временно недоступно</td>
                        @endif

                        <td>{{ $item->city->name or 'Связь нарушена' }}</td>
                        <td>{{ $item->title }}</td>
                        <td>
                            <a style="float: left" href="/admin/shop/{{$item->id}}"
                               class="btn btn-info">Редактировать</a>
                            {!! Form::open(['method'=>'DELETE','action' => array('ShopsController@destroy', $item->id),'style'=>'float:left;']) !!}
                            {!! Form::hidden('id', $item->id) !!}
                            {!! Form::submit('Удалить', ['class' => 'btn btn-danger','']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!--/.row-->
    </div>    <!--/.main-->
@endsection

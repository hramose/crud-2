@extends('crud::master')

@section('subheader')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ trans('crud::form.title.create-model', ['model' => $MasterInstance->getModelSingularName()]) }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
@stop

@section('sidebar')
    <ul class="nav nav-sidebar">
        <li>
            <a href="{{ route('crud.index', $ModelName) }}">
                <i class="fa fa-long-arrow-left"></i>
                {{ trans('crud::form.button.back-to-index', ['model' => $MasterInstance->getModelPluralName()]) }}
            </a>
        </li>
        <li>
            <a href="{{ route('crud.create', $ModelName) }}">
                <i class="fa fa-plus"></i>
                {{ trans('crud::index.button.create-new', ['model' => $MasterInstance->getModelSingularName()]) }}
            </a>
        </li>
    </ul>
@stop

@section('content')

    {!! CRUDForm::open(['route' => ['crud.store', $ModelName], 'class' => 'form-horizontal', 'files' => true]) !!}
    @include('crud::partials._form')
    {!! CRUDForm::close() !!}

@stop
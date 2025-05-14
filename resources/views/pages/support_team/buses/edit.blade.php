@extends('layouts.master')
@section('page_title', 'Edit Bus - '.$bus->number_plate)
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Edit Bus</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('buses.update', $bus->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Number Plate <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="number_plate" value="{{ $bus->number_plate }}" required type="text" class="form-control" placeholder="e.g. ABC-1234">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Model <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="model" value="{{ $bus->model }}" required type="text" class="form-control" placeholder="e.g. Toyota Coaster">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Year <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="year" value="{{ $bus->year }}" required type="number" class="form-control" placeholder="e.g. 2020">
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Bus <i class="icon-paperplane ml-2"></i></button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

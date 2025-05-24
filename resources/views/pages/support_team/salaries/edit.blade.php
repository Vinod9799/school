@extends('layouts.master')
@section('page_title')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Edit Driver</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('salaries.update', $salary->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Basic <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="basic" value="{{ $salary->basic }}" required type="text" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Fuel Expense Number  <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="fuel_expense" value="{{ $salary->fuel_expense }}" required type="text" class="form-control" placeholder="e.g. Toyota Coaster">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Other Expense <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="other_expense" value="{{ $salary->other_expense }}" required type="number" class="form-control" placeholder="e.g. 2020">
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

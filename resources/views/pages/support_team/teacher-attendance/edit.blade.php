@extends('layouts.master')
@section('page_title', 'Edit Bus - '.$attendance->number_plate)
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Edit attendances</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('attendance.update', $attendance->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Name <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="name" value="{{ $attendance->name }}" required type="text" class="form-control" placeholder="e.g. ABC-1234">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Licence Number  <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="license_number" value="{{ $attendance->license_number }}" required type="text" class="form-control" placeholder="e.g. Toyota Coaster">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Phone <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="phone" value="{{ $attendance->phone }}" required type="number" class="form-control" placeholder="e.g. 2020">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label font-weight-semibold">Address <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input name="address" value="{{ $attendance->address }}" required type="text" class="form-control" placeholder="e.g. 2020">
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

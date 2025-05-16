@extends('layouts.master')
@section('page_title', 'Manage Buses')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage Buses</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#all-buses" class="nav-link active" data-toggle="tab">All Buses</a></li>
            <li class="nav-item"><a href="#new-bus" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Add New Bus</a></li>
        </ul>

        <div class="tab-content">
            {{-- List of Buses --}}
            <div class="tab-pane fade show active" id="all-buses">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Number Plate</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buses as $bus)
                            <tr>
                                <td>{{ $bus->number_plate }}</td>
                                <td>{{ $bus->model }}</td>
                                <td>{{ $bus->year }}</td>
                                {{-- <td>
                                    <a href="{{ route('buses.edit', $bus) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('buses.destroy', $bus) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this bus?')">Delete</button>
                                    </form>
                                </td> --}}
                                <td class="text-center">
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-left">
                                                    @if(Qs::userIsTeamSA())
                                                    {{--Edit--}}
                                                    <a href="{{ route('buses.edit', $bus->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                   @endif
                                                        @if(Qs::userIsSuperAdmin())
                                                    {{--Delete--}}
                                                    <a id="{{ $bus->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $bus->id }}" action="{{ route('buses.destroy', $bus->id) }}" class="hidden">@csrf @method('delete')</form>
                                                        @endif

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Create New Bus --}}
            <div class="tab-pane fade" id="new-bus">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info border-0 alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            <span>Fill out the form below to add a new bus to your fleet.</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <form class="ajax-store" method="post" action="{{ route('buses.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Number Plate <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="number_plate" value="{{ old('number_plate') }}" required type="text" class="form-control" placeholder="e.g. ABC-1234">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Model <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="model" value="{{ old('model') }}" required type="text" class="form-control" placeholder="e.g. Toyota Coaster">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Year <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="year" value="{{ old('year') }}" required type="number" class="form-control" placeholder="e.g. 2020">
                                </div>
                            </div>

                            <div class="text-right">
                                <button id="ajax-btn" type="submit" class="btn btn-primary">Add Bus <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- end new bus tab --}}
        </div>
    </div>
</div>

@endsection

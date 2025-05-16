@extends('layouts.master')
@section('page_title', 'Manage salaries')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage salaries</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#all-salaries" class="nav-link active" data-toggle="tab">All salaries</a></li>
            <li class="nav-item"><a href="#new-salaries" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Add New salaries</a></li>
        </ul>

        <div class="tab-content">
            {{-- List of salaries --}}
            <div class="tab-pane fade show active" id="all-salaries">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Driver</th>
                            <th>Basic</th>
                            <th>Fel Expense</th>
                            <th>Other Expense</th>
                            <th>Total Pay</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salaries as $sal)
                            <tr>
                                <td>{{ $sal->driver_id }}</td>
                                <td>{{ $sal->basic }}</td>
                                <td>{{ $sal->fuel_expense }}</td>
                                <td>{{ $sal->other_expense }}</td>
                                <td>{{ $sal->total_pay }}</td>
                                {{-- <td>
                                    <a href="{{ route('salaries.edit', $sal) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('salaries.destroy', $sal) }}" method="POST" style="display:inline;">
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
                                                    <a href="{{ route('salaries.edit', $sal->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                   @endif
                                                        @if(Qs::userIsSuperAdmin())
                                                    {{--Delete--}}
                                                    <a id="{{ $sal->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $sal->id }}" action="{{ route('salaries.destroy', $sal->id) }}" class="hidden">@csrf @method('delete')</form>
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
            <div class="tab-pane fade" id="new-salaries">
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
                        <form class="ajax-store" method="post" action="{{ route('salaries.store') }}">
                            @csrf
                        <div class="form-group row">
                                <label for="driver_id" class="col-lg-3 col-form-label font-weight-semibold">Bus</label>
                                <div class="col-lg-9">
                                    <select required data-placeholder="Select Class Type" class="form-control select" name="driver_id" id="driver_id">

                                            @foreach($driver as $ct)
                                            <option {{ old('driver_id') == @$ct->id ? 'selected' : '' }} value="{{ @$ct->id  ?? ''}}">{{ $ct->name ?? 'sds' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Basic <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="basic" value="{{ old('basic') }}"  type="number" class="form-control" placeholder="">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Fuel Expense <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="fuel_expense" value="{{ old('fuel_expense') }}"  type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Other Expense <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="other_expense" value="{{ old('other_expense') }}"  type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="text-right">
                                <button id="ajax-btn" type="submit" class="btn btn-primary">Add salaries <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- end new bus tab --}}
        </div>
    </div>
</div>

@endsection

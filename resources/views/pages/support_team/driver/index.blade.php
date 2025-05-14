@extends('layouts.master')
@section('page_title', 'Manage driver')
@section('content')

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">Manage driver</h6>
        {!! Qs::getPanelOptions() !!}
    </div>

    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight">
            <li class="nav-item"><a href="#all-driver" class="nav-link active" data-toggle="tab">All driver</a></li>
            <li class="nav-item"><a href="#new-driver" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Add New Driver</a></li>
        </ul>

        <div class="tab-content">
            {{-- List of driver --}}
            <div class="tab-pane fade show active" id="all-driver">
                <table class="table datatable-button-html5-columns">
                    <thead>
                        <tr>
                            <th>Number Plate</th>
                            <th>Lisence Number</th>
                            <th>phone</th>
                            <th>Bus</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($driver as $bus)
                            <tr>
                                <td>{{ $bus->name }}</td>
                                <td>{{ $bus->license_number }}</td>
                                <td>{{ $bus->phone }}</td>
                                <td>{{ $bus->bus_id }}</td>
                                {{-- <td>
                                    <a href="{{ route('drivers.edit', $bus) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('drivers.destroy', $bus) }}" method="POST" style="display:inline;">
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
                                                    <a href="{{ route('drivers.edit', $bus->id) }}" class="dropdown-item"><i class="icon-pencil"></i> Edit</a>
                                                   @endif
                                                        @if(Qs::userIsSuperAdmin())
                                                    {{--Delete--}}
                                                    <a id="{{ $bus->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i> Delete</a>
                                                    <form method="post" id="item-delete-{{ $bus->id }}" action="{{ route('drivers.destroy', $bus->id) }}" class="hidden">@csrf @method('delete')</form>
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
            <div class="tab-pane fade" id="new-driver">
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
                        <form class="ajax-store" method="post" action="{{ route('drivers.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Name <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="name" value="{{ old('name') }}" required type="text" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Licence Number <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="license_number" value="{{ old('license_number') }}" required type="text" class="form-control" placeholder="e.g. Toyota Coaster">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Phone <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="phone" value="{{ old('phone') }}" required type="number" class="form-control" placeholder="e.g. 2020">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Address <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="address" value="{{ old('address') }}" required type="text" class="form-control" placeholder="e.g. 2020">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-lg-3 col-form-label font-weight-semibold">Image <span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input name="image"  required type="file" class="form-control" placeholder="e.g. 2020">
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label for="bus_id" class="col-lg-3 col-form-label font-weight-semibold">Bus</label>
                                    <div class="col-lg-9">
                                        <select required data-placeholder="Select Class Type" class="form-control select" name="bus_id" id="bus_id">

                                               @foreach($bus as $ct)
                                                <option {{ old('bus_id') == @$ct->id ? 'selected' : '' }} value="{{ @$ct->id  ?? ''}}">{{ $ct->number_plate ?? 'sds' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            <div class="text-right">
                                <button id="ajax-btn" type="submit" class="btn btn-primary">Add Driver <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- end new bus tab --}}
        </div>
    </div>
</div>

@endsection

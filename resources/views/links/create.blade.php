@extends('layouts.main')

@section('title', 'Links')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create new</h4>
                <div class="page-title-right d-flex gap-2">
                    <a href="{{ route('links') }}" class="btn btn-light">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" form="createForm">Create</button>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start form -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('links.store') }}" method="POST" id="createForm">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Title your link" value="{{ old('title') }}">
                        @error('title')
                            <small class="fst-italic text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="destination" class="form-label">Destination <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="destination" autofocus name="destination" placeholder="https://example.com/my-long-url" value="{{ old('destination') }}" autofocus>
                        @error('destination')
                            <small class="fst-italic text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <hr>
                    <div class="mb-4">
                        <div class="form-label fs-6 fw-semibold">Short link</div>
                        <div class="d-flex">
                            <div style="width: 30%">
                                <label for="domain" class="form-label">Domain</label>
                                <div class="form-control d-flex justify-content-between" id="domain">
                                    <span>{{ env('APP_URL') }} </span>
                                    <i class="bi bi-lock"></i>
                                </div> 
                            </div>
                            <div class="text-center slash" style="width: 5%;bottom:-37px;position: relative;">/</div>
                            <div style="width: 60%">
                                <label for="custom-link" class="form label">Custom back-half</label>
                                <input type="text" class="form-control fst-italic" name="custom_link" placeholder="(optional)" value="{{ old('custom_link') }}">
                                @error('custom_link')
                                    <small class="fst-italic text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end form -->

        

    </div>
@endsection
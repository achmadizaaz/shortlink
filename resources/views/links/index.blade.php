@extends('layouts.main')

@section('title', 'Links')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Links</h4>
                <div class="page-title-right">
                    <a href="{{ route('links.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i> Create a link
                    </a>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start alert -->
        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Successfully</h4>
                <hr>
                <p class="mb-0">{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Failed --}}
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Failed</h4>
                <hr>
                <p class="mb-0">{{ session('failed') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- end alert -->

          {{-- Alert errors --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Errors:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- End Alert errors --}}

        <!-- start page main -->
        <div class="card p-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="d-flex align-items-center" style="width: 250px">
                    <div class="me-2 fw-bold">
                        Show :
                    </div>
                    <form action="{{ route('users.show.page')}}" method="GET">
                        <select name="show" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 100px">
                            <option value="10" @if (session('showPageUsers') == 10)
                                selected
                            @endif>10</option>
                            <option value="25" @if (session('showPageUsers') == 25)
                            selected
                            @endif>25</option>
                            <option value="50" @if (session('showPageUsers') == 50)
                            selected
                            @endif>50</option>
                            <option value="100" @if (session('showPageUsers') == 100)
                            selected
                            @endif>100</option>
                        </select>
                    </form>
                    <div class="ms-2 fw-bold">
                        Data
                    </div>
                </div>
               <div class="d-flex gap-1">
                    {{-- Input Pencarian --}}
                    <form action="{{ route('users')}}" method="GET" class="d-flex gap-1">
                        <input type="text" name="search" class="form-control"  placeholder="Searching" value="{{request('search') }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    {{-- Button Reset --}}
                    <a href="{{ route('users') }}" class="btn btn-info text-white" title="Reset">
                        <i class="bi bi-circle"></i>
                    </a>
                </div>
            </div>
            <hr>
            @foreach ($shorten as $short)
                <div class="mb-3 border-bottom pb-2">
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="checkbox[]" value="{{ $short->id }}">
                        </div>
                        <div>
                            @if ('asdasd')
                                @else
                                <img src="{{ asset('assets/images/no-image.webp') }}" width="38px" height="38px" class="rounded-5 border border-3 border-secondary">
                            @endif
                            <img src="https://t0.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url=http://getbootstrap.com&size=32" width="38px" height="38px" class="rounded-5 border border-3 border-secondary">
                        </div>
                        <div>
                            <div class="form-label fs-5 fw-bold">
                                {{ $short->title }}
                            </div>
                            <div class="form-label">
                                <a href="{{ env('APP_URL').'/'.$short->slug }}" class="fw-semibold fs-6" target="__blank">{{ env('APP_URL').'/'.$short->slug }}</a>
                            </div>
                            <div class="form-label">
                                <a href="{{ $short->destination }}" class="text-secondary" target="__blank">{{ $short->destination }}</a>
                            </div>
                            <div class="mt-4 d-flex gap-3 small">
                                <div>
                                    <i class="bi bi-bar-chart"></i> {{ $short->visitor }} Visitor
                                </div>

                                <div>
                                    <i class="bi bi-calendar3 me-2"></i> {{ $short->created_at->format('d F Y') }}
                                </div>
                            </div>
                        </div>
                        {{-- 3 --}}
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-light rounded-4 bi bi-copy copyLink" data-copy="{{ env('APP_URL').'/'.$short->slug }}" data-id="#{{ $short->slug }}" id="{{ $short->slug }}"> Salin link</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- end page main -->


    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function(e) {
            $('.copyLink').click(function() {
                let copy = $(this).data('copy');
                let id = $(this).data('id');
                // console.log(id);
                
                // Create input tag dan append body
                let temp = $("<input>");
                $("body").append(temp);

                // Select text temp from textToCopy
                temp.val(copy).select();
                // Execute to copy text
                document.execCommand('copy');
                // Remove temp
                temp.remove();

                // Custome css and change icon button
                $(id).addClass("text-success bi-link").removeClass('bi-union').html(' Link tersalin')

                // Set animasi selama 2 detik
                // Kembalikan ke awal setelah 2 detik
                setTimeout(function() { 
                    $(".copyLink").addClass('bi-copy').removeClass("text-success bi-union")
                    $(id).html(' Salin link')
                    }, 1000);
            });
        });
    </script>
@endpush
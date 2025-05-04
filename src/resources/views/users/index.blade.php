@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($users as $user)
        <div class="row">
            <div class="col-6 offset-3">
                <a href="/profile/{{ $user->id }}">
                    <img src="{{ $user->profile->profileImage() }}" class="w-100">
                </a>
            </div>
        </div>
        <div class="row pt-2 pb-4">
            <div class="col-6 offset-3">
                <div>
                    <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $user->id }}">
                            <span class="text-dark">{{ $user->username }}</span>
                        </a>
                    </span> {{ $user->profile->title }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
</div>
@endsection

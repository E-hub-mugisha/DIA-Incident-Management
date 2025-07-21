@extends('layouts.app')
@section('title','Profile')
@section('content')

<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">
                                    {{ __('Profile') }}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="col-md-6">
                        @include('profile.partials.update-password-form')

                    </div>

                    <div class="col-md-12">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
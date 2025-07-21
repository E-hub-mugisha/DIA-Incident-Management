<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div class="form-group mb-3">
                <label for="update_password_current_password" :value="__('Current Password')">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="form-group mb-3">
                <label for="update_password_password" :value="__('New Password')">New Password</label>
                <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="form-group mb-3">
                <label for="update_password_password_confirmation" :value="__('Confirm Password')">Confirm Password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn btn-sm btn-success">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
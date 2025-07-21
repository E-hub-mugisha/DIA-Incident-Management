<div class="card">
    <div class="card-header">
        <h2 class="card-title">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </div>
    <div class="card-body">
        <div class="flex items-center gap-4">
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                Delete Account
            </button>
        </div>
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your account?') }}
                            </h2>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>

                            <div class="form-group mb-3">
                                <label for="password" :value="__('Current Password')">Current Password</label>
                                <input id="password" name="password" type="password" class="form-control"/>
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>

                            <button class="btn btn-danger" type="submit">
                                {{ __('Delete Account') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
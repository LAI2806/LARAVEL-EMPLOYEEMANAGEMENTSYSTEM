<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <header class="mb-4 text-center">
                        <h2 class="fw-semibold mb-1">{{ __('Update Password') }}</h2>
                        <p class="text-muted small">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>

                    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="update_password_current_password" class="form-label">
                                {{ __('Current Password') }}
                            </label>
                            <input id="update_password_current_password" name="current_password" type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   autocomplete="current-password">
                            @error('current_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password" class="form-label">
                                {{ __('New Password') }}
                            </label>
                            <input id="update_password_password" name="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="update_password_password_confirmation" class="form-label">
                                {{ __('Confirm Password') }}
                            </label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>

                            @if (session('status') === 'password-updated')
                                <div class="text-success small" x-data="{ show: true }" x-show="show" 
                                     x-transition x-init="setTimeout(() => show = false, 2000)">
                                    {{ __('Saved.') }}
                                </div>
                            @endif
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
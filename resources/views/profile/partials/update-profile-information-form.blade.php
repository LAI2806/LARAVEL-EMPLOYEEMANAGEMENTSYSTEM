<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <header class="mb-4 text-center">
                        <h2 class="fw-semibold mb-1">{{ __('Profile Information') }}</h2>
                        <p class="text-muted small">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-muted small mb-1">
                                        {{ __('Your email address is unverified.') }}
                                    </p>
                                    <button form="send-verification" class="btn btn-link p-0 text-decoration-underline small">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="text-success small mt-2">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>

                            @if (session('status') === 'profile-updated')
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
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Prefix Name -->
        <div>
            <x-input-label for="prefixname" :value="__('Prefix Name')" />
            <select name="prefixname" class="block mt-1 w-full rounded border-gray-300" id="prefixname">
                <option value="" @if(old('prefixname') == '' || $user->prefixname == '') selected @endif></option>
                <option value="Mr" @if(old('prefixname') == 'Mr' || $user->prefixname == 'Mr') selected @endif>Mr</option>
                <option value="Mrs" @if(old('prefixname') == 'Mrs' || $user->prefixname == 'Mrs') selected @endif>Mrs</option>
                <option value="Ms" @if(old('prefixname') == 'Ms' || $user->prefixname == 'Ms') selected @endif>Ms</option>
            </select>
            <x-input-error :messages="$errors->get('prefixname')" class="mt-2" />
        </div>

        <!-- First Name -->

        <div>
            <x-input-label for="firstname" :value="__('First Name')" />
            <x-text-input id="firstname" name="firstname" type="text" class="mt-1 block w-full" :value="old('firstname', $user->firstname)" required autofocus autocomplete="firstname" />
            <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
        </div>

        <!-- Middle Name -->

        <div>
            <x-input-label for="middlename" :value="__('Middle Name')" />
            <x-text-input id="middlename" name="middlename" type="text" class="mt-1 block w-full" :value="old('middlename', $user->middlename)" autofocus autocomplete="middlename" />
            <x-input-error class="mt-2" :messages="$errors->get('middlename')" />
        </div>

        <!-- Last Name -->

        <div>
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" name="lastname" type="text" class="mt-1 block w-full" :value="old('lastname', $user->lastname)" required autofocus autocomplete="lastname" />
            <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
        </div>

        <!-- Suffix Name -->

        <div>
            <x-input-label for="suffixname" :value="__('Suffix Name')" />
            <x-text-input id="suffixname" name="suffixname" type="text" class="mt-1 block w-full" :value="old('suffixname', $user->suffixname)" autofocus autocomplete="suffixname" />
            <x-input-error class="mt-2" :messages="$errors->get('suffixname')" />
        </div>

        <!-- Username -->

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Picture -->
        <div class="mt-4">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" class="mb-2"/>
            <x-photo-input :picture="old('avatar') ?? $user->avatar ?? asset('media/profile_photo/default/default.jpg')" />
            <x-input-error :messages="$errors->get('photo')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

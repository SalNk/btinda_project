<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {{-- @vite('ressources/css/app.css') --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <section class="bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <div
                class="relative flex items-end px-4 pb-10 pt-60 sm:pb-16 md:justify-center lg:pb-24 bg-gray-50 sm:px-6 lg:px-8">
                <div class="absolute inset-0">
                    <img class="object-cover w-full h-full" src="{{ asset('images/register.jpg') }}" alt="" />
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
                <div class="relative">
                    <div class="w-full max-w-xl xl:w-full xl:mx-auto xl:pr-24 xl:max-w-xl">
                        <h3 class="text-4xl font-bold text-white">Rejoignez la communauté de BTinda Nayo et facilitez
                            vos livraisons en toute simplicité !</h3>
                    </div>
                    <ul class="grid grid-cols-1 mt-10 sm:grid-cols-2 gap-x-8 gap-y-4">
                        <li class="flex items-center space-x-3">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full">
                                <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium text-white"> Livraison rapide et fiable </span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full">
                                <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium text-white"> Suivi des livraisons en temps réel </span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full">
                                <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium text-white"> Gestion des litiges simplifiée </span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <div
                                class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full">
                                <svg class="w-3.5 h-3.5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="text-lg font-medium text-white"> Evaluations des livreurs pour plus de
                                confiance </span>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="flex items-center justify-center px-4 py-10 bg-white sm:px-6 lg:px-4 sm:py-16 lg:py-20">
                <div class="xl:w-full xl:max-w-sm 2xl:max-w-md xl:mx-auto">
                    <h2 class="text-3xl font-bold leading-tight text-black sm:text-4xl">Inscription</h2>
                    <p class="mt-2 text-base text-gray-600">Vous avez déjà un compte ? <a href="{{ route('login') }}"
                            class="font-medium text-blue-600 transition-all duration-200 hover:text-blue-700 focus:text-blue-700 hover:underline">Connectez-vous</a>
                    </p>
                    <form action="{{ route('register') }}" method="POST" class="mt-8">
                        @csrf
                        <!-- Message d'erreur -->
                        @if (session()->has('error'))
                            <p class="mt-2 text-sm text-red-600">{{ session()->get('error') }}</p>
                        @endif

                        <div class="space-y-5">
                            <!-- Nom -->
                            <div>
                                <label for="name" class="text-base font-medium text-gray-900">Nom complet</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="text" name="name" id="name"
                                        placeholder="Entrez votre nom complet" value="{{ old('name') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="text-base font-medium text-gray-900">Adresse email</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="email" name="email" id="email" placeholder="Entrez votre email"
                                        value="{{ old('email') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Avatar -->
                            <div>
                                <label for="avatar" class="text-base font-medium text-gray-900">Avatar</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="file" name="avatar" id="avatar"
                                        class="block w-full py-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                </div>
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="text-base font-medium text-gray-900">Mot de passe</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="password" name="password" id="password"
                                        placeholder="Entrez votre mot de passe"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="password_confirmation" class="text-base font-medium text-gray-900">Mot de
                                    passe de confirmation</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="Entrez votre mot de passe"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('password_confirmation')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div>
                                <label for="address" class="text-base font-medium text-gray-900">Adresse</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="text" name="address" id="address"
                                        placeholder="Entrez votre adresse" value="{{ old('address') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="text-base font-medium text-gray-900">Téléphone</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="text" name="telephone" id="telephone"
                                        placeholder="Entrez votre numéro de téléphone" value="{{ old('telephone') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('telephone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nom du magasin -->
                            <div>
                                <label for="shop_name" class="text-base font-medium text-gray-900">Nom du
                                    magasin</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="text" name="shop_name" id="shop_name"
                                        placeholder="Entrez le nom de votre magasin" value="{{ old('shop_name') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('shop_name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Adresse du magasin -->
                            <div>
                                <label for="shop_address" class="text-base font-medium text-gray-900">Adresse du
                                    magasin</label>
                                <div class="mt-2.5 relative text-gray-400 focus-within:text-gray-600">
                                    <input type="text" name="shop_address" id="shop_address"
                                        placeholder="Entrez l'adresse de votre magasin"
                                        value="{{ old('shop_address') }}"
                                        class="block w-full py-4 pl-3 pr-4 text-black placeholder-gray-500 border border-gray-200 rounded-md bg-gray-50 focus:outline-none focus:border-blue-600 focus:bg-white" />
                                    @error('shop_address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Soumettre -->
                            <div>
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-full px-4 py-4 text-base font-semibold text-white transition-all duration-200 border border-transparent rounded-md bg-gradient-to-r from-fuchsia-600 to-blue-600 focus:outline-none hover:opacity-80 focus:opacity-80">
                                    S'inscrire
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</body>

</html>

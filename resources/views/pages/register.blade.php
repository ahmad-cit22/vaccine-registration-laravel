@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <main class="flex-grow flex flex-col items-center justify-center px-4">

        <div class="py-4 flex flex-col justify-center sm:py-12">
            <div class="relative py-1 sm:max-w-xl sm:mx-auto">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-300 to-green-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
                </div>
                <div class="relative px-7 py-10 bg-white shadow-lg sm:rounded-3xl sm:px-16 sm:py-10">
                    <div class="max-w-sm mx-auto mb-3">
                        <div class="max-w-lg mx-auto">
                            <h1 class="text-3xl font-bold text-center text-green-900 mb-6">Get Vaccinated Quickly!</h1>
                            <p class="text-md text-center text-gray-700 mb-5 overflow-wrap break-word">
                                Care for your safety by registering for your COVID-19
                                vaccine now with us. It's fast, easy, and secure.
                            </p>
                        </div>
                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <div class="divide-y divide-gray-200">
                                <div class="pt-8 text-base leading-6 space-y-6 text-gray-700 sm:text-lg sm:leading-7">

                                    <div class="relative">
                                        <input autocomplete="off" id="name" name="name" type="text" value="{{ old('name') }}"
                                            class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-green-600 mb-2 mt-1"
                                            placeholder="Name" required />
                                        <label for="name"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Name</label>
                                        @error('name')
                                            <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <input autocomplete="off" id="nid" name="nid" type="number" value="{{ old('nid') }}"
                                            class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-green-600 mb-2 mt-1"
                                            placeholder="NID" required />
                                        <label for="nid"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">NID</label>
                                        @error('nid')
                                            <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <input autocomplete="off" id="email" name="email" type="email" value="{{ old('email') }}"
                                            class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-green-600 mb-2 mt-1"
                                            placeholder="Email" required />
                                        <label for="email"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Email</label>
                                        @error('email')
                                            <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <select id="vaccine_center_id" name="vaccine_center_id"
                                            class="peer h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-green-600 mb-2 mt-1"
                                            required>
                                            <option value="" disabled selected>Select a Vaccine Center</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $center->id }}" {{ old('vaccine_center_id') == $center->id ? 'selected' : '' }}>{{ $center->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="vaccine_center_id"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Vaccine
                                            Center</label>
                                        @error('vaccine_center_id')
                                            <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <button
                                            class="bg-green-500 text-white rounded-md px-2 py-1 hover:bg-green-600 ease-in-out duration-300">Register</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

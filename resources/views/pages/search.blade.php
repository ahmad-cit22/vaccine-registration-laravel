@extends('layouts.master')

@section('title', 'Vaccine Search')

@section('content')
    <main class="flex-grow flex flex-col items-center justify-center px-4">
        <div class="py-6 flex flex-col justify-center sm:py-12">
            <div class="relative py-3 sm:max-w-xl sm:mx-auto">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-300 to-green-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
                </div>
                <div class="relative px-7 py-10 bg-white shadow-lg sm:rounded-3xl sm:px-16 sm:py-10">
                    <div class="max-w-sm mx-auto">
                        <div class="max-w-lg mx-auto">
                            <h1 class="text-3xl font-bold text-center text-green-900 mb-6">Check Vaccination Status</h1>
                            <p class="text-md text-center text-gray-700 mb-6">
                                Stay informed about your vaccination. Enter your NID below & see your vaccination status
                                instantly.
                            </p>
                        </div>

                        <form id="searchForm" action="{{ route('search') }}" method="GET" novalidate>
                            <div class="divide-y divide-gray-200">
                                <div class="pt-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">

                                    <div class="relative">
                                        <input autocomplete="off" id="nid" name="nid" type="number"
                                            class="peer h-10 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-green-600 mb-2"
                                            placeholder="NID" required />
                                        <label for="nid"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-gray-400 peer-focus:-top-3.5 peer-focus:text-gray-600">
                                            Enter Your NID
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <button type="submit"
                                            class="bg-green-500 text-white rounded-md px-2 py-1 hover:bg-green-600 ease-in-out duration-300">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="result mt-4 text-center" id="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const searchForm = document.getElementById('searchForm');
        const resultDiv = document.getElementById('result');

        searchForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            resultDiv.innerHTML = '';

            const nid = document.getElementById('nid').value;

            try {
                const response = await fetch('{{ route('search') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        nid
                    })
                });

                if (response.ok) {
                    const data = await response.json();

                    if (data.status != 'validationFailed') {
                        if (data.status == 'Not registered') {
                            Swal.fire({
                                icon: "warning",
                                title: `${data.status}`,
                                text: `${data.message}`,
                            });
                        } else if (data.status == 'Not scheduled') {
                            Swal.fire({
                                icon: "info",
                                title: `${data.status}`,
                                text: `${data.message}`,
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: `${data.status}`,
                                text: `${data.message}`,
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            text: `${data.message}`,
                        });
                    }

                } else if (response.status === 422) {
                    const errors = await response.json();

                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: `${errors.errors.nid[0]}`,
                    });
                } else {
                    throw new Error('An unexpected error occurred.');

                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: `An unexpected error occurred. Please try again.`,
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops!",
                    text: `${error.message}`,
                });
            }
        });
    </script>
@endsection

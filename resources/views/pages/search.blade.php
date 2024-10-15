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
                            <h1 class="text-3xl font-bold text-center text-green-900 mb-6">Check Vaccination Status
                            </h1>
                            <p class="text-md text-center text-gray-700 mb-6">
                                Stay informed about your vaccination. Enter your NID below & see your vaccination
                                status instantly.
                            </p>
                        </div>

                        <form id="searchForm">
                            <div class="divide-y divide-gray-200">
                                <div class="pt-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">

                                    <div class="relative">
                                        <input autocomplete="off" id="nid" name="nid" type="text"
                                            class="peer h-10 w-full border-b-2 border-gray-300 text-gray-900 placeholder-transparent focus:outline-none focus:border-green-600 mb-2"
                                            placeholder="NID" required />
                                        <label for="nid"
                                            class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:text-gray-400 peer-focus:-top-3.5 peer-focus:text-gray-600">Enter
                                            Your NID</label>
                                    </div>

                                    <div class="relative">
                                        <button type="submit"
                                            class="bg-green-500 text-white rounded-md px-2 py-1 hover:bg-green-600 ease-in-out duration-300">Search</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#searchForm').on('submit', function(e) {
            e.preventDefault();

            let nid = $('#nid').val();
            let resultDiv = $('#result');
            resultDiv.html(''); // Clear previous result

            $.ajax({
                type: 'POST',
                url: '{{ route('search') }}',
                data: {
                    nid: nid
                },
                success: function(response) {
                    resultDiv.html(
                        `<strong>Status:</strong> ${response.status}<br><strong>Message:</strong> ${response.message}`
                    );
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        resultDiv.html(`<p class="text-red-600">${errors.nid[0]}</p>`);
                    } else {
                        resultDiv.html(
                            `<p class="text-red-600">Something went wrong, please try again.</p>`);
                    }
                }
            });
        });
    </script>
@endsection

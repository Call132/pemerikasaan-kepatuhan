<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>


    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" href="{{ asset('img/SIS-RISKA-fix.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('img/SIS-RISKA-fix.ico') }}" type="image/x-icon">

    @stack('style')
    <style>
        /* Tambahkan CSS ini untuk membuat ikon menjadi bentuk bulat */
        link[rel="icon"],
        link[rel="shortcut icon"] {
            border-radius: 50%;
        }
    </style>

    <!-- Template CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">


</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('partials.header')

            <!-- Sidebar -->
            @include('partials.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('partials.footer')
        </div>
    </div>
    <script>
        let isRefreshing = false;

        // Saat halaman diperbarui
        window.onbeforeunload = function() {
            isRefreshing = true;
        }

        // When the browser or tab is being closed
        window.addEventListener('beforeunload', function(event) {
            if (!isRefreshing) {
                event.preventDefault();
                // Send an AJAX request to the logout route
                // Example using jQuery:
                $.ajax({
                    url: '/logout', // Replace with your actual logout route
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}", // Include CSRF token if using Laravel
                    },
                    success: function(response) {

                        if (response.success) {
                            // Successful logout
                            console.log('Logout successful.');
                        } else {
                            // Logout failed
                            console.error('Logout failed.');
                        }
                    },
                });
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    @stack('scripts')


    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
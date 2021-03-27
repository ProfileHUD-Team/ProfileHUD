<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ProfileHUD</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth

                    <a href="{{ url('/aboutus') }}" class="ml-4 text-sm text-gray-700 underline">About Us</a>
                </div>
            @endif

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                         width="550.000000pt" height="240.000000pt" viewBox="0 0 402.000000 176.000000"
                         preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,176.000000) scale(0.100000,-0.100000)"
                           fill="#000000" stroke="none">
                            <path d="M70 875 l0 -835 1950 0 1950 0 0 835 0 835 -1950 0 -1950 0 0 -835z
                                m3868 803 c9 -9 12 -201 12 -802 0 -435 -4 -797 -8 -804 -7 -10 -399 -12
                                -1928 -10 l-1919 3 -3 790 c-1 435 0 800 3 813 l5 22 1913 0 c1475 0 1916 -3
                                1925 -12z"/>
                            <path d="M150 875 l0 -755 1870 0 1870 0 0 755 0 755 -1870 0 -1870 0 0 -755z
                                m3708 -2 l2 -723 -1840 0 -1840 0 0 718 c0 395 3 722 7 725 3 4 830 6 1837 5
                                l1831 -3 3 -722z"/>
                            <path d="M1415 1068 c-15 -11 -35 -39 -45 -62 -10 -23 -24 -49 -32 -59 -13
                                -18 -16 -18 -62 7 -64 34 -149 36 -212 4 l-44 -22 -24 23 c-22 21 -30 22 -107
                                16 -46 -3 -98 -8 -115 -11 -29 -4 -34 -1 -51 33 -11 21 -35 48 -53 61 -30 20
                                -45 22 -165 22 -115 0 -134 -2 -148 -18 -15 -16 -17 -46 -17 -214 0 -228 0
                                -228 91 -228 71 0 88 13 97 75 l7 50 50 5 c55 6 81 18 109 49 11 12 22 21 27
                                21 4 0 9 -39 10 -86 5 -101 15 -114 94 -114 70 0 85 17 85 99 0 71 12 101 40
                                101 16 0 20 -7 20 -35 0 -48 32 -108 76 -142 29 -21 50 -28 99 -31 83 -5 125
                                10 173 62 l40 43 6 -30 c10 -51 32 -67 91 -67 72 0 85 16 85 107 0 80 6 103
                                26 103 11 0 14 -20 14 -88 0 -108 10 -122 88 -122 43 0 56 4 73 25 l22 24 19
                                -24 c16 -21 28 -25 72 -25 57 0 77 13 91 59 l8 25 23 -27 c42 -49 83 -67 156
                                -67 82 0 112 11 161 58 31 31 37 33 37 16 0 -11 7 -30 16 -42 13 -19 24 -22
                                78 -22 80 0 94 14 98 95 3 59 3 60 33 60 30 0 30 -1 35 -61 7 -83 18 -94 95
                                -94 96 0 95 -2 95 232 0 230 1 228 -98 228 -72 0 -92 -19 -92 -87 0 -32 -4
                                -43 -19 -48 -36 -11 -51 4 -51 55 0 64 -19 80 -98 80 -80 0 -92 -16 -92 -118
                                l0 -74 -41 36 c-51 47 -76 56 -150 56 -71 0 -113 -16 -153 -59 -37 -39 -46
                                -28 -46 60 0 83 -15 99 -88 99 -42 0 -54 -4 -70 -25 l-20 -26 -16 23 c-14 20
                                -28 24 -104 30 -162 12 -197 10 -227 -14z m166 -13 c3 -2 3 -20 1 -39 -4 -31
                                -8 -35 -35 -38 -43 -4 -52 -38 -10 -38 26 0 28 -3 28 -40 0 -37 -2 -40 -27
                                -40 l-28 0 0 -105 0 -105 -57 0 -58 0 3 105 c3 99 2 105 -16 105 -16 0 -21 8
                                -24 40 -3 36 -1 40 19 40 20 0 23 5 23 35 0 25 8 44 25 60 20 21 33 25 88 25
                                35 0 66 -2 68 -5z m-930 -21 c53 -27 74 -110 45 -179 -21 -50 -68 -75 -142
                                -75 l-62 0 6 -65 5 -65 -67 0 -66 0 0 200 0 200 125 0 c95 0 134 -4 156 -16z
                                m1074 -24 l0 -40 -57 0 -58 0 0 40 0 40 58 0 58 0 -1 -40z m185 -160 l0 -200
                                -55 0 -55 0 0 200 0 200 55 0 55 0 0 -200z m580 130 l0 -70 68 0 67 0 -3 70
                                -4 70 66 0 66 0 0 -200 0 -200 -66 0 -66 0 4 80 3 80 -67 0 -68 0 0 -80 0 -80
                                -65 0 -65 0 0 200 0 200 65 0 65 0 0 -70z m-720 -25 c0 -8 -4 -15 -10 -15 -5
                                0 -10 7 -10 15 0 8 5 15 10 15 6 0 10 -7 10 -15z m-790 -15 c18 -10 18 -11 0
                                -49 -16 -32 -23 -38 -43 -34 -41 8 -57 -28 -57 -124 l0 -83 -57 0 -58 0 0 145
                                0 145 53 0 c46 0 52 -2 52 -21 0 -21 1 -20 21 5 21 27 56 34 89 16z m270 -8
                                c108 -54 108 -220 0 -274 -80 -41 -197 -9 -232 62 -38 74 -9 173 60 209 47 25
                                125 27 172 3z m994 -7 c33 -22 51 -56 61 -112 l7 -43 -116 0 c-64 0 -116 -3
                                -116 -7 0 -3 7 -15 17 -25 18 -20 63 -24 80 -7 8 8 30 9 67 5 l56 -7 -21 -31
                                c-28 -39 -75 -58 -141 -58 -66 0 -115 24 -146 70 -20 29 -23 45 -20 91 5 64
                                31 108 80 133 43 22 152 17 192 -9z m-519 -130 l0 -145 -57 0 -58 0 0 145 0
                                145 58 0 57 0 0 -145z"/>
                            <path d="M492 915 c0 -44 0 -45 33 -45 35 0 65 21 65 45 0 24 -30 45 -65 45
                                -33 0 -33 -1 -33 -45z"/>
                            <path d="M1131 856 c-21 -26 -25 -83 -7 -111 33 -51 96 -18 96 50 0 60 -58 99
                                -89 61z m47 -67 c-1 -13 -7 -23 -13 -22 -13 3 -18 30 -11 50 10 24 29 1 24
                                -28z"/>
                            <path d="M2095 850 c-18 -20 -17 -20 38 -20 57 0 67 6 45 28 -19 19 -63 14
                                -83 -8z"/>
                            <path d="M2817 1062 c-14 -15 -17 -42 -17 -158 0 -154 11 -195 66 -246 41 -38
                                75 -48 161 -48 95 0 149 23 189 82 28 40 29 44 32 196 4 188 2 192 -94 192
                                -88 0 -94 -10 -94 -161 0 -129 -4 -149 -29 -149 -35 0 -41 21 -41 150 0 153
                                -4 160 -97 160 -45 0 -64 -4 -76 -18z m143 -156 c0 -138 1 -146 22 -160 29
                                -21 67 -20 90 1 16 14 18 33 18 160 l0 143 66 0 65 0 -3 -154 c-3 -168 -8
                                -183 -71 -230 -56 -41 -207 -33 -261 14 -45 40 -56 86 -56 239 l0 131 65 0 65
                                0 0 -144z"/>
                            <path d="M3286 1058 c-13 -18 -16 -56 -16 -208 0 -247 -11 -232 169 -228 131
                                3 140 4 179 31 130 86 117 345 -21 408 -34 15 -66 19 -169 19 -120 0 -128 -1
                                -142 -22z m299 -28 c103 -50 128 -245 41 -329 -43 -42 -81 -51 -213 -51 l-113
                                0 0 200 0 200 122 0 c101 0 129 -3 163 -20z"/>
                            <path d="M3430 850 l0 -110 40 0 c59 0 80 28 80 107 0 54 -4 68 -25 88 -16 17
                                -35 25 -60 25 l-35 0 0 -110z m84 32 c12 -44 -3 -97 -29 -97 -16 0 -21 8 -23
                                44 -2 25 -1 55 3 68 8 34 37 25 49 -15z"/>
                        </g>
                    </svg>
                </div>

        </div>
    <a href="welcome.blade.php">Reload Welcome<</a>
    </body>
</html>

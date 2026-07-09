<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Twitter Clone</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!-- Main Layout -->
    <div class="p-relative h-screen" style="background-color: #15202b">
        <div class="flex justify-center">

            <header class="text-white h-12 py-4 h-auto">
                @include('home.left-sidebar')
            </header>

            <main role="main">
                <div class="flex" style="width: 990px;">
                    @include('home.feed')
                    @include('home.right-sidebar')
                </div>
            </main>

        </div>
    </div>
</body>

<style>
.overflow-y-auto::-webkit-scrollbar, .overflow-y-scroll::-webkit-scrollbar, .overflow-x-auto::-webkit-scrollbar, .overflow-x::-webkit-scrollbar, .overflow-x-scroll::-webkit-scrollbar, .overflow-y::-webkit-scrollbar, body::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.overflow-y-auto, .overflow-y-scroll, .overflow-x-auto, .overflow-x, .overflow-x-scroll, .overflow-y, body {
  -ms-overflow-style: none;
  /* IE and Edge */
  scrollbar-width: none;
  /* Firefox */
}

.bg-dim-700 {
  --bg-opacity: 1;
  background-color: #192734;
}

html, body {
  margin: 0;
  background-color: #15202b;
}

svg.paint-icon {
  fill: currentcolor;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
 @include('shop.partial.header')
</head>

<body>
  @include('sweetalert::alert')
  <div id="app">
    {{-- <div id="preloder">
        <div class="loader"></div>
    </div> --}}
    {{-- <div class="main-wrapper"> --}}
      @include('shop.partial.topbar')
      {{-- @include('partial.sidebar') --}}
      @include('sweetalert::alert')
      <!-- Main Content -->
      @yield('content')
      @include('shop.partial.footer')
    {{-- </div> --}}
  </div>

 @include('shop.partial.script')
</body>
</html>

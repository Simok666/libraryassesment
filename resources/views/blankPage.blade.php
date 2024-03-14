@extends('layout.admin')

@section('title', 'Dashboard')
@section('title_page', 'Blank Page')
@section('desc_page', 'Ini Masih Blank Page BOS')

{{-- @section('style')
<style>
    .card-title {
        color: red
    }

</style>
@endsection --}}

{{-- @section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.html">Siu</a></li>
    <li class="breadcrumb-item active" aria-current="page">Layout Default</li>
</ol>
@endsection --}}

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Blank Page</h4>
    </div>
    <div class="card-body">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, commodi? Ullam quaerat similique iusto
        temporibus, vero aliquam praesentium, odit deserunt eaque nihil saepe hic deleniti? Placeat delectus
        quibusdam ratione ullam!
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Blank Page</h4>
    </div>
    <div class="card-body">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, commodi? Ullam quaerat similique iusto
        temporibus, vero aliquam praesentium, odit deserunt eaque nihil saepe hic deleniti? Placeat delectus
        quibusdam ratione ullam!
    </div>
</div>
@endsection

@section('scripts')
<script>
    alert("Script");
    // document ready adn on click .cart-title change color
    $(document).ready(function() {
        $(".card-title").click(function() {
            $(this).css("color", getRandomColor());
        });
    });

    // function random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>
@endsection

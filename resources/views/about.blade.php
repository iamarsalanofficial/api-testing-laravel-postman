@extends('layouts.master')


@section('content')
    <h1>Hello Arsalan</h1>
    @verbatim
        <div id="app">{{ message }}</div>
    @endverbatim
@endsection

@php
    $fruit = ["Apple","Banana", "Orange", "Graphs"]
@endphp

@push('script')
    
<script>
const data = {{ Js::from($fruit)}};
data.forEach(entry => console.log(entry));
</script>




<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<script>
  const { createApp, ref } = Vue

  createApp({
    setup() {
      const message = ref('Hello vue!')
      return {
        message
      }
    }
  }).mount('#app')
</script>
@endpush


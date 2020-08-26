@extends('layouts.app')

@section('content')
<div class="col-lg-6">
                                <div class="au-card m-b-10">
                                    <div class="au-card-inner">
                                        <h3 class="title-2 m-b-40">Data Kios</h3>
                                      <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>
<script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>

@endsection
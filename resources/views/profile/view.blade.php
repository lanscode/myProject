<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12/04/2016
 * Time: 11:15
 */
?>

@extends('layouts.master')

@section('title',  Auth::user()->first_name . ' ' . Auth::user()->last_name)

@section('content')

@endsection
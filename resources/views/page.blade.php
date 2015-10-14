@extends('yewcms::common.standard-layout')
@section('title', $page->title)
@section('description', $page->meta_description)
@section('keywords', $page->meta_keywords)
@section('body-class', 'cms-page cms-page-' . str_replace('/', '-', $page->slug ? $page->slug : 'home'))
@section('content')


@stop
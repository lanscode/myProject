<?php
/**
 * Created by PhpStorm.
 * User: Joel
 * Date: 12/04/2016
 * Time: 00:25
 */
?>

@extends('layouts.master')

@section('title', $task->title .' | '. $project->title)

@section('style-link')
    <link rel="stylesheet" href="{{ asset('assets/css/project.css') }}">
@endsection

@section('content')
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Accueil</a></li>
        <li><a href="{{ url('/project/'.$project->id) }}">{{ $project->title }}</a></li>
        <li><a href="{{ url('/project/'.$project->id.'/tasks') }}">Tâches</a></li>
        <li class="active">{{ $task->title }}</li>
    </ol>

    <div class="row">
        <div class="col-md-6">
            <h2 class="text-info">{{ $task->title }}</h2>
            <div class="text-muted" style="">
                <h5>
                    <i class="glyphicon glyphicon-time"></i> du {{ $task->beginning_date->formatLocalized("%d %B %Y") }}
                    @if($task->ending_date != null)
                        au {{ $task->ending_date->formatLocalized("%d %B %Y") }}
                    @endif

                </h5>
                <h5 class="">
                    <i class="glyphicon glyphicon-user"></i> Par {{ $task->author->user->first_name . ' ' . $task->author->user->last_name }}
                </h5>
                <h5>
                    {!! $task->getStatus() !!}
                </h5>
            </div>
            @if(Auth::user()->userable instanceof App\Mentor or Auth::user()->userable->id == $task->author_id)
                <div>
                    @if(Auth::user()->userable->id == $task->author_id && $task->status =='1' && Auth::user()->userable instanceof App\Student)
                        <a type="submit" class="btn btn-warning" style="margin: 5px 0px;" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/end') }}">
                            <i class="glyphicon glyphicon-ok"></i> &nbsp;Terminé
                        </a>
                    @endif
                    @if(Auth::user()->userable instanceof App\Mentor && $task->status =='2')

                        <button type="button" class="btn btn-warning" data-toggle="modal" role="dialog" data-target="#end_task">
                            <i class="glyphicon glyphicon-option-vertical"></i> &nbsp;Décider
                        </button>

                        <div class="modal fade" id="end_task" tabindex="-1" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Validation</h4>
                                    </div>
                                    <div class="modal-body">
                                        Voulez vous mettre fin à la Tache?
                                    </div>
                                    <div class="modal-footer">
                                        <a type="submit" class="btn btn-success" style="margin: 5px 0px;" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/validate') }}">
                                            <i class="glyphicon glyphicon-ok"></i>&nbsp;Terminer
                                        </a>
                                        <a type="submit" class="btn btn-warning" style="margin: 5px 0px;" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/cancel') }}">
                                            <i class="glyphicon glyphicon-remove"></i>&nbsp;A revoir
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($task->status!=3)
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
                            Ajouter un fichier
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Uploader un Fichier</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/file') }}" role="form" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="file" name="media" /> <br>
                                            <button type="submit²" class="btn btn-success">Uploader</button>
                                        </form>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <a class="btn btn-info" style="margin: 5px 0px;" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/edit') }}">
                            <i class="glyphicon glyphicon-pencil"></i> &nbsp;Editer
                        </a>

                    @endif

                    @if(Auth::user()->userable instanceof App\Mentor)
                                <!-- Suppression -->
                        <button type="button" class="btn btn-danger" data-toggle="modal" role="dialog" data-target="#del_event">
                            <i class="glyphicon glyphicon-trash"></i> &nbsp;Supprimer
                        </button>
                    @endif

                    <div class="modal fade" id="del_event" tabindex="-1" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Suppréssion</h4>
                                </div>
                                <div class="modal-body">
                                    Etes-vous sur de vouloir supprimer cet cette tâche?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                                    <a class="btn btn-danger" style="" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/delete') }}">
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="">
                <h4>Description</h4>
                <p>
                    {!! $task->description !!}
                </p>
            </div>

            <br>
            <div>
                <table class="table table-striped">
                    <tbody>
                    @foreach($task->files as $f)
                        <tr>
                            <td>
                                <div class="media">
                                    <!--
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object circle img-circle" src="{{ asset('uploads/img/profile_pics/' . $f->author->picture) }}" alt="..." width="40" height="40">
                                        </a>
                                    </div>
                                    -->
                                    <div class="media-body media-middle">
                                        <a href="{{ asset('uploads/files/'.$f->link) }}" >
                                            <i class="fa fa-paperclip"></i> {{ $f->title }}
                                        </a>
                                        @if((Auth::user()->userable instanceof App\Mentor or Auth::user()->userable->id == $task->author->id) and $task->status != '3')
                                            <a data-toggle="modal" role="dialog" data-target="#deleteFile{{ $f->id }}" >
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                            <div class="modal fade" id="deleteFile{{ $f->id }}" tabindex="-1" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Suppression du fichier</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            Etes-vous sur de vouloir supprimer ce Fichier?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                                                            <a class="btn btn-danger" style="" href="{{ url('project/'.$project->id.'/tasks/'.$task->id.'/file/'.$f->id.'/delete') }}">
                                                                Supprimer
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <span class="pull-right">
                                            {{ $f->created_at->diffForHumans() }}
                                        </span>
                                        <br>
                                        <span class="text-muted">{{ $f->author->first_name . ' ' . $f->author->last_name }} </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <?php

            $progress = 0;
            $class = 'progress-bar-primary';
            if($task->ending_date){
                if(Carbon\Carbon::now() <= $task->ending_date  ){
                    if($task->beginning_date->formatLocalized('%d/%m/%Y') != $task->ending_date->formatLocalized('%d/%m/%Y')){
                        $progress = ceil(($task->beginning_date->diffInDays(Carbon\Carbon::now()) / $task->beginning_date->diffInDays($task->ending_date) ) * 100);
                    }else{
                        $progress = 100;
                        $class = 'progress-bar-warning';
                    }
                }else{
                    $progress = 100;
                    $class = 'progress-bar-danger';
                }
            }
            if($task->status == 3){
                $progress = 100;
                $class = 'progress-bar-success';
            }
            ?>
            <div class="progress xs" style="margin-top: 10px;">
                <div class="progress-bar {{ $class }}" style="width: {{ $progress }}%;"></div>
            </div>
            <br>
        </div>
        <div class="col-md-5 col-md-push-1">
            @foreach($o_tasks as $t)
                <?php

                $progress = 0;
                $class = 'progress-bar-primary';
                if($t->ending_date){
                    if(Carbon\Carbon::now() <= $t->ending_date  ){
                        if($t->beginning_date->formatLocalized('%d/%m/%Y') != $t->ending_date->formatLocalized('%d/%m/%Y')){
                            $progress = ceil(($t->beginning_date->diffInDays(Carbon\Carbon::now()) / $t->beginning_date->diffInDays($t->ending_date) ) * 100);
                        }else{
                            $progress = 100;
                            $class = 'progress-bar-warning';
                        }
                    }else{
                        $progress = 100;
                        $class = 'progress-bar-danger';
                    }
                }
                if($t->status == 3){
                    $progress = 100;
                    $class = 'progress-bar-success';
                }
                ?>
                <div>
                    <div class="clearfix">
                        <a href="{{ url('project/'. $project->id . '/tasks/'.$t->id) }}"><span class="pull-left">{{ $t->title }}</span></a>
                        <small class="pull-right">{{ $progress }}%</small>
                    </div>
                    <div class="progress xs" style="margin-top: 10px;">
                        <div class="progress-bar {{ $class }}" style="width: {{ $progress }}%;"></div>
                    </div>
                </div>
            @endforeach
            @if(count($project->tasks) > 3)
                <div>
                    <div class="item" style="text-align: center;">
                        <a href="{{url('project/'. $project->id . '/tasks')}}">Voir tout</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Chat box -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-comments-o"></i>
            <h3 class="box-title">Commentaires</h3>
        </div>
    </div>
    <form action="{{ url('/project/'.$project->id . '/tasks/'.$task->id.'/comment') }}" method="post">
        {{ csrf_field() }}
        <div class="box-footer">
            <div class="input-group">
                <input class="form-control" name="content" placeholder="Type message...">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </form>

    <div class="box-body chat" id="chat-box">

        @foreach($task->comments as $c)
            <div class="item">
                <img src="{{ asset('uploads/img/profile_pics/' . $c->author->picture) }}" alt="user image" class="online">

                <p class="message">
                    <a href="#" class="name">
                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> {{ $c->created_at->diffForHumans(Carbon\Carbon::now()) }}</small>
                        {{ $c->author->first_name . ' ' . $c->author->last_name }}
                    </a>
                    {{ $c->content }}
                </p>
            </div>
        @endforeach

    </div>

@endsection


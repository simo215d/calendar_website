@extends('layouts.app')

@section('content')
<div class="card-header">{{ __('Dashboard') }}</div>

<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    {{ __('You are logged in!') }}
    <p>Here is your calendar</p>
    <form action="{{ route('home.store') }}">
        <label for="">Name</label>
        <input type="text" name="name"><br>
        <label for="">Day</label>
        <input type="text" name="day"><br>
        <label for="">Start time (as % of day)</label>
        <input type="time" name="starttime"><br>
        <label for="">End time (as % of day)</label>
        <input type="time" name="endtime"><br>
        <input type="submit" value="Add task">
    </form>
    <div style="background-color: black; padding: 3px; position: relative;" id="calendar-container">
        <div id="days-container" style="display: flex;height: 600px;">
            <div>
                <div style="height:30px;background-color:beige">Week 69</div>
                <div style="height: 570px; width: 75px; background-color:limegreen; display: flex;flex-direction: column;">
                    <div style="background-color: pink;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">0-3</p></div>
                    <div style="background-color: beige;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">3-6</p></div>
                    <div style="background-color: pink;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">6-9</p></div>
                    <div style="background-color: beige;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">9-12</p></div>
                    <div style="background-color: pink;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">12-15</p></div>
                    <div style="background-color: beige;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">15-18</p></div>
                    <div style="background-color: pink;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0">18-21</p></div>
                    <div style="background-color: beige;flex-grow: 1; display: flex; justify-content: center; align-content: center; flex-direction: column;text-align:center"><p style="margin:0;">21-24</p></div>
                </div>
            </div>
            <?php
            for ($x = 0; $x < 7; $x++) {
                $currentday;
                switch ($x) {
                    case 0: $currentday="monday"; break;
                    case 1: $currentday="tuesday"; break;
                    case 2: $currentday="wedensday"; break;
                    case 3: $currentday="thursday"; break;
                    case 4: $currentday="friday"; break;
                    case 5: $currentday="saturday"; break;
                    case 6: $currentday="sunday"; break;
                }
                ?>
                <div style="background-color:  <?php if($x%2==0){echo '#7434eb';}else echo'turquoise';?>;flex-grow: 1;">
                    <div style="background-color: <?php if($x%2==0){echo 'pink';}else echo'beige';?>; height:30px">
                        <p style="margin: 0;"><?php echo $currentday?></p>
                    </div>
                    <div style="height: 570px; position: relative;">
                    @foreach($tasks as $task)
                        @if($task->day==$currentday)
                        <div onclick="TaskClicked(this)" id="div{{$task->day}}{{$task->id}}" style="background-color: white; cursor: pointer; height: calc(<?php echo $task->endtime?>% - <?php echo $task->starttime?>%);position: absolute; top: <?php echo $task->starttime?>%;left: 0px; width: 100%;">
                            <p style="margin:0; font-size:12px; text-align: right"><?php 
                                //only diplay time, if the height is big enough to contain it
                                if ($task->endtime-$task->starttime>2) {
                                    //need to add the extra 0 sometimes, since thats how time looks fx 07:01
                                    $starttimewithzeroes1 = floor(($task->starttime/100)*24);
                                    $starttimewithzeroes2 = floor((($task->starttime/100)*24-floor(($task->starttime/100)*24))*60);
                                    $endtimewithzeroes1 = floor(($task->endtime/100)*24);
                                    $endtimewithzeroes2 = floor((($task->endtime/100)*24-floor(($task->endtime/100)*24))*60);
                                    if ($starttimewithzeroes1<10) {
                                        $starttimewithzeroes1 = "0".strval($starttimewithzeroes1);
                                    }
                                    if ($starttimewithzeroes2<10) {
                                        $starttimewithzeroes2 = "0".strval($starttimewithzeroes2);
                                    }
                                    if ($endtimewithzeroes1<10) {
                                        $endtimewithzeroes1 = "0".strval($endtimewithzeroes1);
                                    }
                                    if ($endtimewithzeroes2<10) {
                                        $endtimewithzeroes2 = "0".strval($endtimewithzeroes2);
                                    }
                                    echo $starttimewithzeroes1 . ":" . $starttimewithzeroes2 . " to " . $endtimewithzeroes1 . ":" . $endtimewithzeroes2;
                                }
                            ?></p>
                            <?php
                                //TODO if task is more than one line then this is one line off btw
                                //only diplay task, if the height is big enough to contain it
                                if (($task->endtime-$task->starttime)>4.5) {
                                    echo "<p style='margin:0;'>$task->name</p>";
                                }
                            ?>
                        </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            <?php 
            } 
            ?>
        </div>
        <!-- on click get tasks position -->
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
@endsection
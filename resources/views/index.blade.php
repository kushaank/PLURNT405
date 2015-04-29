
@extends('template')

@section('content')

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('/img/music.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>PLURNT</h1>
                        <hr class="small">
                        <span class="subheading">Find the next big headliner!</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->

    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php foreach($songs as $song) : ?>

                <div class="post-preview">
                    <a href="<?php echo $song->link?>">
                        <h2 class="post-title">
                            <?php echo $song->title ?>
                        </h2>
                    </a>
                        <h3 class="post-subtitle">
                            <?php echo $song->artist ?>
                        </h3>
                    <h4>
                    <a href="<?php echo url("/songs/".$song->id) ?>"> Listen & Comment!</a>
                    </h4>
                    <?php foreach($users as $user) : ?>

                        <?php if($user->user_id == $song->userid) :?>
                    <p class="post-meta">Posted by <a href="#"><?php echo $user->name ?></a></p>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
                <hr>


                    <?php endforeach; ?>


            </div>
        </div>


    </div>

    <hr>

    <!-- Footer -->
@endsection

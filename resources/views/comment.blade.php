@extends('template')

@section('content')
<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('/img/about-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="page-heading">
                    <h1>Comments</h1>
                    <hr class="small">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <br/>
    <h3>Submit a comment for <?php echo $info->title ?> </h3>
    <?php
    
    include(app_path().'/Services/Soundcloud.php');

    // create a client object with your app credentials
    $client =  new Services_Soundcloud('acdde4a4f1d8b575b2cfa40730c1d3e2', '763eea34b31b1b8a22fa9372c1ea4704');
    $client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));

    // get a tracks oembed data
//    $track_url = 'http://soundcloud.com/forss/flickermood';
//    $embed_info = json_decode($client->get('oembed', array('url' => $info->link)));
    if(\Cache::has("soundcloud-$info->title"))
    {
        $embed_info = \Cache::get("soundcloud-$info->title");

    }
    else
    {
        //extracting json data for the movie mentioned
        $track_url = 'http://soundcloud.com/forss/flickermood';
        $embed_info = json_decode($client->get('oembed', array('url' => $info->link)));

        \Cache::put("soundcloud-$info->title", $embed_info, 60);
    }
    // render the html for the player widget
    print $embed_info->html;
    ?>
    <div class="row">
        <div>
            <h3>Write your comment</h3>
            <form role="form" method ="post" action= "/home/comment">
                <input type="hidden" name="id" value="<?php echo $info->id; ?>">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" >
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text"  name= "title" placeholder="title" value="<?php echo Request::old('title') ?>" class="search-query">



                    <div class="form-group">

                        <label for="review">Comment</label>
                        <textarea class="form-control" name="review" rows="5" id="comment"><?php echo Request::old('comment')?></textarea>
                    </div>

                </div>
                <div class="form-group">
                    <button type="submit" class="btn" name="submit"><i class="icon-search">Submit</i></button>
                </div>
                <?php foreach($errors->all() as $errorMessage):?>
                    <?php echo $errorMessage?>
                    <br>
                <?php endforeach ?>
                <?php if (Session::has('success')) : ?>
                    <h3><?php echo Session::get('success') ?></h3>
                    <br>
                <?php endif ?>
            </form>
        </div>


    </div>
    <div >
        <h4 class="text-center">Previous Comments</h4>
        <table class="table table-bordered">
            <thread>
                <tr>
                    <th>Title</th>
                    <th>Description</th>

                </tr>
            </thread>
            <tbody>
            <?php foreach($comments as $review):?>
                <tr>
                    <td><?php echo $review->title ?></td>
                    <td><?php echo $review->description ?></td>

                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div><!-- /.container -->

<hr>

<!-- Footer -->
@endsection
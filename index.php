<?php 
	$baseurl = '';
	$baseurl = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
	$baseurl .= '://'. $_SERVER['HTTP_HOST'];
	$baseurl .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	
	
	$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
	
	
	$uri = $_SERVER['REQUEST_URI'];
	
	$uris = explode('/', $uri);
	
	$peekobjectid = $uris[count($uris) - 1];
?>
<!DOCTYPE html>

<html>
	<head>
	    <meta charset="utf-8">
	    <title>Peek</title>
	    <link rel="shortcut icon" type="image/png" href="<?php echo $baseurl?>assets/images/peek.ico" sizes="128x128">
	    
	    <script src="<?php echo $baseurl?>assets/javascripts/jquery-1.9.0.min.js" type="text/javascript"></script>
	    <script type="text/javascript" src="http://www.parsecdn.com/js/parse-1.3.0.min.js"></script>
	    <script type="text/javascript" src="<?php echo $baseurl?>assets/javascripts/jquery.skippr.min.js"></script>
	    
	    <link rel="stylesheet" media="screen" href="<?php echo $baseurl?>assets/stylesheets/main.css">
	    <link rel="stylesheet" href="<?php echo $baseurl?>assets/stylesheets/jquery.skippr.css">
	
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	
	    <!-- itunes 
	    <meta name="apple-itunes-app" content="app-id=752511884, app-argument=pop://posts/107694">
		-->
	    <!-- for Google 
	    <meta name="description" content="Peek" /> 
	     -->                            
	    <meta name="application-name" content="Peek" />
		
		<!-- facebook metatags 
		<meta property="fb:app_id"          content="423296984437203" /> 
		<meta property="og:site_name"       content="Pop" /> 
		<meta property="og:type"            content="article" /> 
		<meta property="og:url"             content="https://gopop.co/107694" /> 
		<meta property="og:image"           content="http://kino03.gopop.co/D08F3C0B-0F58-46FA-BB8B-0BE2B87C56DC.432350275.505006_9.jpg" />
		<meta property="og:title"           content="A Pop by @jshapes" />
	
		<meta name="og:description"    content="Pastel city #carswap #colorswap photos by Joshua Nguyen.  https://gopop.co/107694" />
		-->
		<!-- twitter 
		<meta name="twitter:card" content="player" />
		<meta name="twitter:site" content="@poptheapp" />
		<meta name="twitter:site:id" content="1967612166" />
		
		<meta name="twitter:description"    content="Pastel city #carswap #colorswap photos by Joshua Nguyen.  https://gopop.co/107694" />
		
		<meta name="twitter:title" content="A Pop by @jshapes" />
		<meta name="twitter:image:src" content="http://kino03.gopop.co/D08F3C0B-0F58-46FA-BB8B-0BE2B87C56DC.432350275.505006_9.jpg" />
		<meta name="twitter:image:width" content="480" />
		<meta name="twitter:image:height" content="480" />
		<meta name="twitter:player" content="https://gopop.co/107694/twitter" />
		<meta name="twitter:player:width" content="435" />
		<meta name="twitter:player:height" content="435" />
		<meta name="twitter:player:stream" content="http://kino04.gopop.co/a5225c9b6dc297ec09f2dbc41d5098ce9041cc1f.mp4" />
		<meta name="twitter:player:stream:content_type" content="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
		<meta name="twitter:app:name:iphone" content="Pop" />
		<meta name="twitter:app:id:iphone" content="752511884" />
		<meta name="twitter:app:url:iphone" content="pop://posts/107694" />
		-->
	
	    <script>
	    	$(function(){
	    	    Parse.initialize("hc8p6x8cf38rUGcvTujMLbKA3tP7cziTaUFwRcPD"
	    	    	    , "jXcc8twkMXAbVR18W9KSvXdrJ25AKG3z8kCEPlpZ");
	    	    
	    	    var PeekObject = Parse.Object.extend("Peek");
	    	    var query = new Parse.Query(PeekObject);
	    	    query.equalTo("objectId", "<?php echo $peekobjectid?>");
	    	    query.find({
	    	      success: function(results) {

		    	      if(results.length == 0)
			    	      return;
		    	      
		    	      var photo1 = results[0].get('photo1');
		    	      var photo2 = results[0].get('photo2');

		    	      var caption = results[0].get('caption');
		    	      var lower_caption = results[0].get('lower_caption');

		    	     

		    	     

		    	      var createdAt = results[0].createdAt;
		    	      var startTime = new Date();
		    	      var elapsed = (startTime.getTime() - createdAt.getTime()) / 1000; 

		    	      var created = '';
			    	  if(elapsed < 60)
			    	  {
				    	  // second
			    		  created = elapsed + ' s ago';
				    	  
			    	  } else if( elapsed >= 60 && elapsed < 3600 )
			    	  {
				    	  // minutes

			    		  created = Math.round(elapsed / 60) + ' min ' + elapsed % 60 + ' s ago';
			    		  
			    	  } else if ( elapsed >= 3600 && elapsed < 24*3600 )
			    	  {
				    	  // hours

			    		  created = Math.round(elapsed / 3600) + ' hours ago';
			    		  
			    	  } else {
				    	  // day

			    		  created = Math.round(elapsed / (24*3600)) + ' days ago';
			    	  }
		    	      		    	      
		    	      $('.bubble-caption').text(lower_caption);
		    	      $('.username').text(caption);
		    	      
		    	      $('#posted').text(created);

		    	      $('.pop-caption').show();

		    	      // show image
		    	      
		    	      $photodiv = $('<div><img /></div>');

		    	      $('img', $photodiv).attr('src', photo1.url());
		    	       
		    	      $("#random").append($photodiv);


		    	      $photodiv = $('<div><img /></div>');

		    	      $('img', $photodiv).attr('src', photo2.url());
		    	       
		    	      $("#random").append($photodiv);

		    	      
		    	      $("#random").skippr();
		    	      
	    	      },
	    	      error: function(error) {
	    	        alert("Error: " + error.code + " " + error.message);
	    	      }
	    	    });
	    	    
	    	    
		   	});
	    </script>
	    
	    <style type="text/css">
	    
	    #pop-player img {
	    	width: 450px;
	    }
	    </style>
    </head>
<body>
<div class="post-single-web">
    <header>
        <div class="container">
            <a href="http://peek.com"><img class="head-logo" src="<?php echo $baseurl?>assets/images/peek-logo.png"/></a>
            <div class="sub-title">Two photos. One hidden. Press to reveal your story.</div>
        </div>
    </header>

    <div id="pop-section">
        <div class="container">
            <div id="pop-player">
            	<div id="random">
            	</div>
            	<div class="pop-bottom-logo"></div>
            </div> <!-- pop-player -->
            <div class="pop-head clearfix">
                <div class="user-meta clearfix">
                    <div class="user-profile-image left-col"></div>
                    <div class="right-col">
                        <div class="username"></div>
                        <div id="posted" class="time"></div>
                    </div>
                </div>
                <div class="pop-caption clearfix" style="display:none">
                    <div class="bubble-caption"></div>
                </div>

                <div id="action-bar" class="clearfix">
                    <div class="inner-wrapper">
						
                         
                         <ul class="right-list">
                            <li>
                                <a href="https://itunes.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=910377405&mt=8" target="itunes_store">
                                    <img class="download-badge" src="<?php echo $baseurl?>assets/images/Download_on_the_App_Store_Badge_US-UK_135x40.png"/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> <!-- action bar -->
            </div>
        </div>
    </div>
</div>
    
    <!--
    <script>
      
    var popJson = {"id":107694,"user":{"id":9,"username":"jshapes","full_name":"seeing the world in twos","profile_image":"https://s3-us-west-1.amazonaws.com/poprelease/628A76D2-D1D2-4ADE-B30F-AF298FEE192D.420853437.024661_9_t.jpg"},"date_created":1410657365,"cover_image":"http://kino03.gopop.co/D08F3C0B-0F58-46FA-BB8B-0BE2B87C56DC.432350275.505006_9.jpg","caption":"Pastel city #carswap #colorswap photos by Joshua Nguyen. ","do_i_like_it":false,"is_editor_pick":true,"is_popular":true,"is_sensitive":false,"clips":[{"format":"image","image_url":"http://kino03.gopop.co/D08F3C0B-0F58-46FA-BB8B-0BE2B87C56DC.432350275.505006_9.jpg","thumbnail_url":"http://kino03.gopop.co/4BE914D7-8125-4DA5-A77C-5D0EB181C267.432350275.505006_9_t.jpg","width":480,"height":480,"clip_user_id":9,"clip_username":"jshapes"},{"format":"image","image_url":"http://kino03.gopop.co/30066D1F-BB7F-4767-A748-928AA365E22C.432350306.532725_9.jpg","thumbnail_url":"http://kino03.gopop.co/E155D04F-84BE-441D-AB22-559480264EAF.432350306.532725_9_t.jpg","width":480,"height":480,"clip_user_id":9,"clip_username":"jshapes"}],"reply_count":2,"profile_post":false,"likes_count":72,"conversation":{"first_profile_image":"http://kino03.gopop.co/C1EAC349-BCE6-496C-95A0-16BC4DFCD628.427213983.255983_22113_t.jpg","second_profile_image":"https://s3-us-west-1.amazonaws.com/poprelease/412B86CE-6C92-4252-9FEB-7D6BC862273A.414029349.860090_284_t.jpg","children_cover_image":"http://kino03.gopop.co/D08F3C0B-0F58-46FA-BB8B-0BE2B87C56DC.432350275.505006_9.jpg","hidden":false},"video_url":"http://kino04.gopop.co/a5225c9b6dc297ec09f2dbc41d5098ce9041cc1f.mp4","video":{"mp4_video_url":"http://kino04.gopop.co/a5225c9b6dc297ec09f2dbc41d5098ce9041cc1f.mp4","webm_video_url":"http://kino04.gopop.co/a5225c9b6dc297ec09f2dbc41d5098ce9041cc1f.webm","gif_url":"http://kino04.gopop.co/a5225c9b6dc297ec09f2dbc41d5098ce9041cc1f.gif","is_mp4_video_ready":true,"is_webm_video_ready":true,"is_gif_ready":true},"frame_delay":63,"user_mentions":[],"hashtags":[{"name":"carswap","indices":[12,20]},{"name":"colorswap","indices":[21,31]}],"editor_hashtags":[],"likers":[{"id":377,"name":"Ronit Yankovich","username":"roniyanko"},{"id":74009,"name":"Rafiq Shah","username":"rafiqshah"},{"id":73982,"name":"Alondra Delgado","username":"Londraaa___"},{"id":33266,"name":"Beverly Vasquez","username":"beverlyvs"},{"id":13003,"name":"Holley Nichols","username":"holleybygolly"},{"id":73700,"name":"بحر من الهموم","username":"Baraa"}]}
    </script>
	-->
	<!-- 
    <script src="/assets/javascripts/post.js" type="text/javascript"></script>
    <script src="/assets/pop-player/popplayer.js" type="text/javascript"></script>
     -->


  </body>
</html>


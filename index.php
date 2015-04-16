<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Mova: Movement Analytics Platform</title>

		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
		<link href="jq/css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="jq/css/jquery-ui-slider-pips.css">
		<link rel="stylesheet" type="text/css" href="styles/jqx.base.css">
		<link href="css/style.css" rel="stylesheet"/>

		<script type="text/javascript" src="lib/d3.v3.min.js"></script>
		<script type="text/javascript" src="lib/math.min.js"></script>


		<script type="text/javascript" src="js/bvhReader.js"></script>
		<script type="text/javascript" src="js/fileHandler.js"></script>
		<script type="text/javascript" src="js/csvMocapReader.js"></script>

		<script type="text/javascript" src="js/featureTimelineVis.js"></script>
		<script type="text/javascript" src="js/figureVis.js"></script>
		<script type="text/javascript" src="js/featuresLib.js"></script>
		<script type="text/javascript" src="js/figureAnim.js"></script>
		<script type="text/javascript" src="js/movan.js"></script>
		<script type="text/javascript" src="js/trajectory.js"></script>

		<script src="jq/jquery-2.0.3.min.js"></script>
		<script src="jq/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="jq/jquery.fileupload.js"></script>
		<script src="jq/jquery.iframe-transport.js"></script>
		<script src="jq/jquery-ui-slider-pips.min.js"></script>
		<script src="jq/jquery.selectric.js"></script>

		<script type="text/javascript" src="lib/math.min.js"></script>
		<script type="text/javascript" src="lib/jqx-all.js"></script>
		<script type="text/javascript" src="js/annotation-track.js"></script>
		<script type="text/javascript" src="js/annotation.js"></script>
		<script type="text/javascript" src="lib/video.js"></script>

		<script type="text/javascript" src="js/body.js"></script>

		<script>
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] ||
				function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o), m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-46098170-1', 'sfu.ca');
			ga('send', 'pageview');

		</script>


		<style>
	    .track{
	      opacity: .5;
	    }

	    .segment{
	      cursor: move;
	      opacity: .3
	    }

	    rect.selected{
	      fill: red;
	    }

	    .background{
	      fill: yellow;
	      opacity: .7;
	    }

	    .brush{
	      opacity: .5;
	    }

	    .slider .handle {
	      fill: #fff;
	      stroke: #000;
	      stroke-opacity: .5;
	      stroke-width: 1.25px;
	      cursor: crosshair;
	    }

	    rect.selected-ex{
	      fill: orange;
	    }
		</style>
	</head>
	<body>
	<script type="text/javascript" src="js/ui.js"></script>
		<div id="header" style="clear:both;">
			<h1 style="float: left;">Mova: Movement Analytics Platform</h1>
			<h4 style="float: right;">Version 0.7  |   <a href="Mova_Intro.mov" target="_blank">Video Intro</a></h4>
		</div>

		<div id="canCont">
			<div id="lefttabs">
				<ul>
					<li>
						<a href="#figure">Figure Sketch</a>
					</li>
					<li>
						<a href="#anim">Animation</a>
					</li>
				</ul>

				<!-- tabs-container is used here to ensure that #featureList does not appear
					before the content of dynamically added tabs -->
				<div id="left-tabs-container">
					<div id="anim">
						<button id="btnPlay">
							&nbsp;Play&nbsp;&nbsp;
						</button>
					</div>
					<div id="figure">

					</div>
				</div>


				<div id="featureList">

				</div>
			</div>

			<div id="divider" style="vertical-align: middle;">
			<!-- Use font-awesome for left and right arrow here -->
				<span id="divider-btn"><i class="fa fa-play fa-sm"></i></span>
			</div>
			
			<div id="righttabs">
				<ul>

				</ul>

				<div id="right-tabs-container">

				</div>
			</div>

			<div id="legends">
				<div style="font-family: Verdana, Arial, sans-serif;font-weight: bold;font-size: 11.5pt;padding-bottom: 5px;">
					Legends:
				</div>
			</div>
				<div id="annotation-area" >
					<div id="controls-wrapper" style="display: table; margin: 0 auto;">
						<span id="play-btn"><i class="fa fa-play fa-3x"></i></span>
						<span id="pause-btn"><i class="fa fa-pause fa-3x"></i></span>
						<span id="download-btn"><i class="fa fa-save fa-3x"></i></span>
						<span id="link"></span>
					</div>
				    <svg id="svg-container" width="900" height="300" style="margin-left: 10px;"></svg>
				    <div id="annotation-graph-dialog">
				        <div id='jqxTree'>
				        </div>
				    </div>
				</div>
		</div>

		<div id="sidebar">
			<ul class="tooboxTitle">
				<li class="toolboxTitleText">
					<a href="#sideAcaccordion"><img class="ui-icon ui-icon-circle-triangle-s"/> Toolbox</a>
				</li>
			</ul>
			<div id="sideAcaccordion">
				<!-- <h2>Take Info</h2>
				<div id="takeinfo" class="sidetab">

				</div> -->
				<h2>Files</h2>
				<div id="filelist" class="sidetab">

					<div class="sidetabtitle">
						Upload a file:
					</div>

					<input id="fileupload" type="file" name="files[]" data-url="http://cgi.sfu.ca/~oalemi/movan/srv/upload.php" multiple/>

					<div style="margin-top:5px" class="sidetabtitle">
						Select a file:
					</div>
					<select name="drop1" id="fileSelect" size="4" multiple="multiple"
					onchange="movan.loadNew()" style="border:2px solid #ccc; width:200px; height: 120px; overflow-y: auto;">
					 <option value="movs/MS2_8Walk_M_nopos.bvh" selected="selected">MS2_8Walk_M_nopos.bvh</option>
						<option value="movs/Slash_x4_0001KAREN.bvh">Slash_x4_0001KAREN.bvh</option>
						<option value="movs/MS2_8Walk_M.bvh">MS2_8Walk_M.bvh</option>
						<option value="Dab1.csv">Dab1.bvh</option>
						<option value="Flick1.csv">Flick1.bvh</option>
						<option value="Slash4.csv">Slash4.bvh</option>
						<option value="Glide3.csv">Glide3.bvh</option>
						<option value="Wring2.csv">Wring2.bvh</option>
					</select>

				</div>

				<h2>Features</h2>
				<div id="features" class="sidetab">

					<div class="sidetabtitle" style="margin-top:0.5em">
						Select a joint:
					</div>

					<div id="jointDropdown" class="ui-widget ui-widget-content ui-state-default ui-corner-all"
					style="">
						<p id = "jointLabel">
							-
						</p>
						<b id = "jointDropDownArrow" style2="float:right;margin-top:0.5em" class2="ui-icon ui-icon-circle-triangle-s">&#9662;</b>
						<div id="jointChooser" style="display:none;position:absolute;width:198px;z-index:10">

						</div>
					</div>

					<div class="sidetabtitle">
						Select a feature:
					</div>

					<select id="featDropdown"></select>

					<button type="button" id="btnAddFeat">
						Add
					</button>

				</div>

				<h2>Visual Controls</h2>
				<div id="controls" class="sidetab">
					<div class="sidetabtitle">
						Skip Frames:
					</div>

					<div id="sldSkip2" class="slider"></div>

					<div class="sidetabtitle">
						Padding:
					</div>

					<div id="sldPad2" class="slider"></div>
					<br/>

					<div id="sldTest" class="slider"></div>
					<br/>
					<button id="btnSave">
						Save as SVG
					</button>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			d3.timer(anim.drawFigure, 0.0083);
			movan.loadFeatures();
			//movan.loadNew();

		</script>

		<script type="text/javascript">
			//url: "http://cgi.sfu.ca/~oalemi/movan/srv/upload.php",
			$(function() {
				$('#fileupload').fileupload({
					dataType : 'csv',
					done : function(e, data) {
						console.log(data);
						$.each(data.result.files, function(index, file) {
							$('<p/>').text(file.name).appendTo(document.body);
						});
					}
				});
			});
		</script>
		<div id="footer" style="clear:both;text-align:center;padding-top:20px;">
			<small>(C) Omid Alemi - Fall 2013</small>
		</div>

				<script>
			state = {
				playing: false,
				currentTime: 0,
				maxTime: 0,
				tickTime: 250,
				tickListeners: [],
				tick: function(){
					if(this.playing){
						this.currentTime = +this.currentTime + +this.tickTime;
						for(var i in this.tickListeners){
							var listener = this.tickListeners[i];
							listener.tick();
						}
					}
				},
				setPlaying: function(play){
					this.playing = play;
					for(var i in this.tickListeners){
						var listener = this.tickListeners[i];
						if(play){
							listener.play();
						}else{
							listener.pause();
						}
						
					}
				}
			}

			//this is an array of all the resources
			remoteResourceMapByType = {};


				$(document).ready(function() {
				/**
				 * Source : http://stackoverflow.com/questions/814613/how-to-read-get-data-from-a-url-using-javascript
				 */
				function parseURLParams(url) {
			        var queryStart = url.indexOf("?") + 1,
			            queryEnd   = url.indexOf("#") + 1 || url.length + 1,
			            query = url.slice(queryStart, queryEnd - 1),
			            pairs = query.replace(/\+/g, " ").split("&"),
			            parms = {}, i, n, v, nv;

			        if (query === url || query === "") {
			            return;
			        }

			        for (i = 0; i < pairs.length; i++) {
			            nv = pairs[i].split("=");
			            n = decodeURIComponent(nv[0]);
			            v = decodeURIComponent(nv[1]);

			            if (!parms.hasOwnProperty(n)) {
			                parms[n] = [];
			            }

			            parms[n].push(nv.length === 2 ? v : null);
			        }
			        return parms;
		    	}

			    function apiCall(url, cbk){
			      $.ajax({
			         type: "GET",
			         url: url,
			         success: cbk
			      });
			    }

				var params = parseURLParams(document.URL);

				var take_id = params["take_id"][0];
				var url = "/takes/"+take_id+".json";

				apiCall(url, function(data){
				  var data_tracks = data.data_tracks;

				  var bvhFiles = [];
				  var c3dFiles = [];
				  var movFiles = [];
				  var mp4Files = [];
				  data_tracks.forEach(function(d){

				  	var resourceURL = d.data_track_url;
				  	var lastIndexOfHyphen = resourceURL.lastIndexOf("-");
				  	var resourceType = resourceURL.substring(lastIndexOfHyphen + 1, resourceURL.lastIndexOf("."));

				  	if(!remoteResourceMapByType[resourceType]){
				  		remoteResourceMapByType[resourceType] = [];
				  	}
		  			remoteResourceMapByType[resourceType].push(resourceURL);
				  })

				  //add a bvh tab for each
				  for(var type in remoteResourceMapByType){
				  	var resources = remoteResourceMapByType[type];
				  	for(var i in resources){
				  		var resource = resources[i];
				  		showResource(type, resource);
				  	}
				  }


				  function showResource(type, resource){
				  	console.log("#showResource " + type + " " + resource)
				  	switch(type){
				  		case "bvh":
				  		apiCall(resource, function(data){
				  			var asset_url = data.asset_url;

				  			// TODO uncomment following lines for creating new tab for bvh after fixing in Omid's code
				  			// for now assume that there just a single bvh that gets loaded in the default bvh tab
				  			// remove this line and uncomment next; commented for dev purpose only
				  			// fileHandler.loadDataTrack(asset_url,movan.callbackForData);

				  			state.tickListeners.push({
				  				tick: function(){

				  				},
				  				play: function(){

				  				},
				  				pause: function(){

				  				}
				  			});

				  			// var tabId = asset_url.substring(asset_url.lastIndexOf("/")+1, asset_url.lastIndexOf("?"));
				  			// //add the nav pill for tab
				  			// $("<li><a href='#"+tabId+"'>"+tabId+"</a></li>").appendTo("#maintabs ul")
				  			// //add the tab
				  			// $("<div id='"+tabId+"'></div>").appendTo("#tabs-container");
				  			// $("#maintabs").tabs("refresh");
				  		})
				  		break;

				  		case "mp4":
				  		//TODO create new tab and load the video
		  				apiCall(resource, function(data){
				  			var asset_url = data.asset_url;

				  			var tabId = asset_url.substring(asset_url.lastIndexOf("/")+1, asset_url.lastIndexOf("?"));
				  			//add the nav pill for tab
				  			$("<li><a href='#"+tabId+"'>"+tabId+"</a></li>").appendTo("#lefttabs ul")
				  			//add the tab
				  			$("<div id='"+tabId+"'><video id='mp4-video-"+tabId+"' width='640'> \
				  				<source type='video/mp4' src='"+asset_url+"' width='640'></video></div>").appendTo("#left-tabs-container");
				  			$("#lefttabs").tabs("refresh");


				  			var tabId_1 = asset_url.substring(asset_url.lastIndexOf("/")+1, asset_url.lastIndexOf("?")) + "_1";
				  			//add the nav pill for tab
				  			$("<li><a href='#"+tabId_1+"'>"+tabId_1+"</a></li>").appendTo("#righttabs ul");
				  			//add the tab
				  			$("<div id='"+tabId_1+"'><video id='mp4-video-"+tabId_1+"' width='640'> \
				  				<source type='video/mp4' src='"+asset_url+"' width='640'></video></div>").appendTo("#right-tabs-container");
				  			$("#righttabs").tabs("refresh");



				  			var player = videojs('mp4-video-'+tabId);

				  			state.tickListeners.push({
				  				tick: function(){
				  					//TODO: this line should be called only once
				  					$('video').attr("width", 640);

				  					//TODO the controls should be hidden when initiating the player.
				  					$('div.vjs-control-bar').hide();
				  						console.log("Playing")
					  					var playerCurrentTime = player.currentTime();
					  					var newTime = state.currentTime/ 1000;
					  					if(Math.abs(playerCurrentTime - newTime) > 1){
					  						player.currentTime(newTime)
					  					}else{
					  						player.play();
					  					}
			  					},
				  				play: function(){
				  					player.play();
				  				},
				  				pause: function(){
				  					player.pause();
				  				}
				  			});

				  			var player_1 = videojs('mp4-video-'+tabId_1);

				  			state.tickListeners.push({
				  				tick: function(){
				  					//TODO: this line should be called only once
				  					$('video').attr("width", 640);

				  					//TODO the controls should be hidden when initiating the player.
				  					$('div.vjs-control-bar').hide();

				  					var player1CurrentTime = player_1.currentTime();
				  					var newTime = state.currentTime/ 1000;
				  					if(Math.abs(player1CurrentTime - newTime) > 1){
				  						player_1.currentTime(newTime)
				  					}else{
				  						player_1.play();
				  					}

				  				},
				  				play: function(){
				  					player_1.play();
				  				},
				  				pause: function(){
				  					player_1.pause();
				  				}
				  			});
				  		});
				  		break;

				  		case "mov":
				  		//TODO create new tab and load the video
				  		apiCall(resource, function(data){
				  			var asset_url = data.asset_url;

				  			var tabId = asset_url.substring(asset_url.lastIndexOf("/")+1, asset_url.lastIndexOf("?"));
				  			//add the nav pill for tab
				  			$("<li><a href='#"+tabId+"'>"+tabId+"</a></li>").appendTo("#lefttabs ul")
				  			//add the tab
				  			$("<div id='"+tabId+"'><video id='mov-video-'"+tabId+" width='640px'> \
				  				<source type='video/mov' src='"+asset_url+"'></video></div>").appendTo("#tabs-container");
				  			$("#lefttabs").tabs("refresh");
				  		});
				  		break;

				  	}
				  }
				});

				//find a way to calculate the maxTime
				state.maxTime = 45000; // number of milliseconds

				// TODO need to move this function call to inside the apiCall callback
				$("#annotation-area").width($("#canCont").width() - $("#legends").width() - 25);
				initAnnotation();
			});
		</script>
 </body>
</html>

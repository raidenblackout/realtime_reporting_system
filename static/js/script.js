let shouldRun=true;
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function openFileDialogue() {
  $("#file-input").click();
}
$(document).ready(function () {
  $("#file-input").change(function () {
    let fileList = this.files;
    for (let i = 0; i < fileList.length; i++) {
      if(fileList[i].type.includes("video")){
        getVideoCover(fileList[i]).then(blob => {
        if ($(".photo-video-upload-inner").attr("class").includes("taken")) {
          $(".photo-video-upload-inner").append(
            "<img src='" +
            URL.createObjectURL(blob) +
              "' class='img-thumbnail' style='width:200px; height:200px; object-fit: scale-down'><div class='video-upload-overlay'><i class='fas fa-play'></i></div>");
        } else {
          $(".photo-video-upload-inner").empty();
          $(".photo-video-upload-inner").addClass("taken");
          $(".photo-video-upload-inner").append("<img src='" +URL.createObjectURL(blob)+"' class='img-thumbnail' style='width:200px; height:200px; object-fit: scale-down'><div class='video-upload-overlay'><i class='fas fa-play'></i></div>");
        }
      });

      }else{
        loadFileImages(fileList[i],i);
      }
    }
  });
  $("#post-box").on('hidden.bs.modal',function(e){
    console.log("hidden");
    $(".photo-video-upload-inner").removeClass("taken");
    if( !$(".photo-video-upload-inner").attr("class").includes("justify-content-center")){
      $(".photo-video-upload-inner").addClass("justify-content-center"); 
    }
    $(".photo-video-upload-inner").empty();
    $(".photo-video-upload-inner").append(
      "<div class='d-flex justify-content-center' onclick='openFileDialogue()'><div class='modal-icon'><i class='fa-solid fa-camera-retro'></i></div></div>");
  });
  attachCommentListener();
  intervalCaller(getCurrentEmergency,5000);
});

function loadFileImages(f,id) {
  var file = f;
  var reader = new FileReader();
  reader.onload = function (e) {
    if ($(".photo-video-upload-inner").attr("class").includes("taken")) {
      $(".photo-video-upload-inner").append(
        "<img src='" +
          e.target.result +
          "' class='img-thumbnail' id='"+id+"' style='width:200px; height:200px; object-fit: scale-down'>"
      );
    } else {
      $(".photo-video-upload-inner").empty();
      $(".photo-video-upload-inner").addClass("taken");
      $(".photo-video-upload-inner").append(
        "<img src='" +
          e.target.result +
          "' class='img-thumbnail' id='"+id+"' style='width:200px; height:200px; object-fit: scale-down'>"
      );
    }
  };
  reader.readAsDataURL(file);
}
function getVideoCover(file, seekTo = 0.0) {
  console.log("getting video cover for file: ", file);
  return new Promise((resolve, reject) => {
      // load the file to a video player
      const videoPlayer = document.createElement('video');
      videoPlayer.setAttribute('src', URL.createObjectURL(file));
      videoPlayer.load();
      videoPlayer.addEventListener('error', (ex) => {
          reject("error when loading video file", ex);
      });
      // load metadata of the video to get video duration and dimensions
      videoPlayer.addEventListener('loadedmetadata', () => {
          // seek to user defined timestamp (in seconds) if possible
          if (videoPlayer.duration < seekTo) {
              reject("video is too short.");
              return;
          }
          // delay seeking or else 'seeked' event won't fire on Safari
          setTimeout(() => {
            videoPlayer.currentTime = seekTo;
          }, 200);
          // extract video thumbnail once seeking is complete
          videoPlayer.addEventListener('seeked', () => {
              console.log('video is now paused at %ss.', seekTo);
              // define a canvas to have the same dimension as the video
              const canvas = document.createElement("canvas");
              canvas.width = videoPlayer.videoWidth;
              canvas.height = videoPlayer.videoHeight;
              // draw the video frame to canvas
              const ctx = canvas.getContext("2d");
              ctx.drawImage(videoPlayer, 0, 0, canvas.width, canvas.height);
              // return the canvas image as a blob
              ctx.canvas.toBlob(
                  blob => {
                      resolve(blob);
                  },
                  "image/jpeg",
                  0.75 /* quality */
              );
          });
      });
  });
}

function upVote(post_id,user_id) {
  $.ajax({
    url: "modules/upvoteAPI.php",
    type: "POST",
    dataType: "json",
    data: {
      post_id: post_id,
      user_id: user_id
    },
    success: function (data) {
      console.log(data);
      if (data['success']==true) {
        setVote(data['my_vote'],post_id,data);
      }
    }
  });
}
function downVote(post_id,user_id) {
  $.ajax({
    url: "modules/downvoteAPI.php",
    type: "POST",
    dataType: "json",
    data: {
      post_id: post_id,
      user_id: user_id
    },
    success: function (data) {
      if (data['success']==true) {
        console.log(data);
        setVote(data['my_vote'],post_id,data);
      }
    }
  });
}

function setVote(vote,post_id,data) {
  if(vote=='-1'){
    $("#downvote-" + post_id).addClass("downvoted");
    $("#downvote-" + post_id).removeClass("downvote");
    $("#downvote-count-" + post_id).text(data['downvote_count']);
    $("#upvote-" + post_id).removeClass("upvoted");
    $("#upvote-" + post_id).addClass("upvote");
    $("#upvote-count-" + post_id).text(data['upvote_count']);
  }else if(vote=='1'){
    $("#upvote-" + post_id).addClass("upvoted");
    $("#upvote-" + post_id).removeClass("upvote");
    $("#upvote-count-" + post_id).text(data['upvote_count']);
    $("#downvote-" + post_id).removeClass("downvoted");
    $("#downvote-" + post_id).addClass("downvote");
    $("#downvote-count-" + post_id).text(data['downvote_count']);
  }else{
    $("#upvote-" + post_id).removeClass("upvoted");
    $("#upvote-" + post_id).addClass("upvote");
    $("#upvote-count-" + post_id).text(data['upvote_count']);
    $("#downvote-" + post_id).removeClass("downvoted");
    $("#downvote-" + post_id).addClass("downvote");
    $("#downvote-count-" + post_id).text(data['downvote_count']);
  }
}
function toggleBookMark(post_id,user_id){
  $.ajax({
    url: "modules/toggleBookMarkAPI.php",
    type: "POST",
    dataType: "json",
    data: {
      post_id: post_id,
      user_id: user_id
    },
    success: function (data) {
      if (data['success']==true) {
        $("#bookmark-ribbon-" + post_id).toggleClass("bookmarked");
      }
    }
  });
}

function postComment(post_id, user_id){
    let comment_box = $('#comment-box-' + post_id);
    let comment_text = comment_box.val();
    $.ajax({
      url: "modules/commentAPI.php",
      type: "POST",
      dataType: "json",
      data: {
        comment_text: comment_text,
        post_id: post_id,
        user_id: user_id
      },
      success: function (data) {
        console.log(data);
        if (data['success']==true) {
          comment_box.val("");
          data=data['comment'];
          let comment_html = getCommentHtml(data);
          $("#commentlist-" + post_id).append(comment_html);
        }
      }
    });
}
function attachCommentListener(){
  console.log("attachCommentListener");
  $(".comment-box").on("keyup",function(e){
    if(e.keyCode==13){
      let comment_box = $(this);
      let comment_text = comment_box.val();
      let post_id = comment_box.attr("data-post-id");
      let user_id = comment_box.attr("data-user-id");
      $.ajax({
        url: "modules/commentAPI.php",
        type: "POST",
        dataType: "json",
        data: {
          comment_text: comment_text,
          post_id: post_id,
          user_id: user_id
        },
        success: function (data) {
          console.log(data);
          if (data['success']==true) {
            comment_box.val("");
            data=data['comment'];
            let comment_html = getCommentHtml(data);
            $("#commentlist-" + post_id).append(comment_html);
          }
        }
      });
    }
  });
}

function getCommentHtml(comment){
  let content=`<div class="comment">
        <div class="media">
            <img class="align-self-start mr-3" src="static/images/{user_url}" alt="Generic placeholder image" style="background-color: black;width: 5vh; height: 5vh; object-fit: scale-down; border-radius: 100%">
            <div class="media-body">
                <div class="d-flex flex-column">
                    <strong>
                        <span>{user_fullname}</span>
                    </strong>
                    <p>{post_comment}</p>
                </div>
            </div>
        </div>
    </div>`;
  content = content.replace("{user_url}",comment['user_url']);
  content=content.replace("{user_fullname}",comment['comment_user']['fname']+" "+comment['comment_user']['lname']);
  content=content.replace("{user_id}",comment['comment_user']['user_id']);
  content=content.replace("{post_comment}",comment['comment']);
  return content;
}

function sharePost($post_id){
  $.ajax({
    url: "modules/shareAPI.php",
    type: "POST",
    dataType: "json",
    data: {
      post_id: $post_id
    },
    success: function (data) {
      console.log(data);
      if (data['success']==true) {
        console.log(data);
        location.reload();
      }
    }
  });
}

function getCurrentEmergency(){
  $.ajax({
    url: "modules/getCurrentEmergencyAPI.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      if (data['success']==true) {
        console.log("success");
        let emergencyHeadline = $("#emergency-headline");
        let emergencyLink = $("#emergency-link");
        emergencyHeadline.text(data['post']['p_content']);
        if(emergencyLink.length>0){
          emergencyLink.attr("href",'/realtime_reporting_system/explore.php?post_id='+data['post']['p_id']);
        }else{
          let headlineLinkContainer = $('#headline-link-container');
          headlineLinkContainer.append('<a href="/realtime_reporting_system/explore.php?post_id='+data['post']['p_id']+'" class="btn btn-danger btn-sm">Learn More</a>');
        }
      }
    }
  });
}

function intervalCaller(foo, time){
  console.log("intervalCaller");
  foo();
  if(shouldRun){
    setTimeout(function(){
      intervalCaller(foo,time);
    },time);
  }
}
function changeShouldRun(){
  shouldRun = !shouldRun;
}
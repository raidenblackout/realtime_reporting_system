
<?php
require_once 'modules/classList.php';
require_once 'modules/dependencyFunctions.php';
function getCommentHTML(Comment $comment){
    $content='<div class="comment">
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
</div>';
    $profile_url = getProfileURL($comment->user_id)['profile_url'];
    $content=str_replace('{user_url}',$profile_url,$content);
    $content=str_replace('{user_fullname}',$comment->comment_user->fname." ".$comment->comment_user->lname,$content);
    $content=str_replace('{post_comment}',$comment->comment,$content);
    return $content;
}
function getImageHTML($url){
    $ext = pathinfo($url, PATHINFO_EXTENSION);
    if($ext=="mp4"){
        $content='
        <div class="post-image">
        <video id="player" controls>
        <source src="static/videos/'.$url.'" autoplay="true"
            pip muted="true" type="video/mp4">
        </video>
        </div>';
        return $content;
    }else{
        $content='<div class="post-image">
        <img src="static/images/{url}"></img>
        </div>';
        $content=str_replace('{url}',$url,$content);
        return $content;
    }
}
function getSharedPostView(Post $post){
    $content = '<div class="post-header d-flex w-100">
    <img class="align-self-start mr-3" src="static/images/{user_url}" alt="Generic placeholder image" style="background-color: black;width: 5vh; height: 5vh; object-fit: scale-down; border-radius: 100%">
    <strong>
        <span>{user_fullname}</span>
    </strong>
    <div class="flex-fill"></div>
    </div>
    <div class="post-body">
        {content}
    </div>
    <div class="post-images d-flex align-items-center justify-content-center">
    {image_area}
    </div>';
    $user = getUser($post->user_id);
    $profile_url = getProfileURL($post->user_id)['profile_url'];
    $content=  str_replace('{user_url}',$profile_url,$content);
    $content = str_replace('{user_id}', $post->user_id, $content);
    $content = str_replace('{user_fullname}', $user->fname." ".$user->lname, $content);
    $post2 = clone $post;
    $post2->user_id = $post->post_owner;
    $content = str_replace('{content}', ($post->post_owner == $post->user_id ? ($post->content == "" ? "" : '<p>'.$post->content.'</p>'): getIndividualPost($post2)), $content);
    $content = str_replace('{up_votes}', $post->up_votes, $content);
    $content = str_replace('{down_votes}', $post->down_votes, $content);
    $content = str_replace('{comments_count}', $post->comments_count, $content);
    $content = str_replace('{post_id}', $post->post_id, $content);
    $image_area='';
    foreach($post->images as $image){
        $result = getImageHTML($image);
        $image_area .= $result;
    }
    $content = str_replace('{image_area}', $image_area, $content);
    return $content;


}
function getIndividualPost(Post $post){
    $content = '<div class="post-container">
    <div class="post-header d-flex w-100">
        <img class="align-self-start mr-3" src="static/images/{user_url}" alt="Generic placeholder image" style="background-color: black;width: 5vh; height: 5vh; object-fit: scale-down; border-radius: 100%">
        <strong>
            <span>{user_fullname}</span>
        </strong>
        <a href="explore.php?category={category}" class="category-badge">
            <span class="badge badge-{badge-state}">{category}</span>
        </a>
        <div class="flex-fill"></div>
        <div class="bookmark">
            <i class="fa fa-bookmark {status}" onclick="toggleBookMark({post_id},{current_user_id})" id="bookmark-ribbon-{post_id}"></i>
        </div>
    </div>
    <div class="post-body">
        {content}
    </div>
    <div class="post-images d-flex align-items-center justify-content-center">
    {image_area}
    </div>
    <div class="d-flex post-footer">
        <div class="footer-icons d-flex align-items-center flex-fill justify-content-center">
            <div class="{upvote-status}" id="upvote-{post_id}" onclick="upVote({post_id},{current_user_id})">
                <i class="fa-solid fa-arrow-up" ></i>
                <span id="upvote-count-{post_id}">{up_votes}</span>
            </div>
            <div class="{downvote-status}" id="downvote-{post_id}"  onclick="downVote({post_id},{current_user_id})">
                <i class="fa-solid fa-arrow-down"></i>
                <span id="downvote-count-{post_id}">{down_votes}</span>
            </div>
        </div>
        <div class="d-flex align-items-center flex-fill justify-content-center">
            <div class="comment-icon">
                <a data-toggle="collapse" data-target="#comment-container-{post_id}" aria-expanded="true" aria-label="Toggle navigation">
                    <i class="fa-solid fa-comment-alt"></i>
                </a>
            </div>
            <span>{comments_count}</span>
        </div>
        <div class="d-flex align-items-center flex-fill justify-content-center">
            <i class="fa fa-share pr-1" onclick="sharePost({post_id})"></i>
            <span>Share</span>
        </div>
    </div>
    <div class="comment-container collapse" id="comment-container-{post_id}">
        <div class="commentlist" id="commentlist-{post_id}">
            {comment_area}
        </div>
        <div class="comment-post">
            <div class="media">
                <img class="align-self-start mr-3" src="static/images/{current_user_url}" alt="Generic placeholder image" style="background-color: black;width: 5vh; height: 5vh; object-fit: scale-down; border-radius: 100%">
                <div class="media-body">
                    <div class="d-flex flex-column">
                        <textarea class="form-control comment-box" data-post-id="{post_id}" data-user-id="{current_user_id}" placeholder="Write a comment..." id="comment-box-{post_id}"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
    $profile_url = getProfileURL($post->user_id)['profile_url'];
    $current_user_url = getProfileURL($_SESSION['user_id'])['profile_url'];
    $content=  str_replace('{user_url}',$profile_url,$content);
    $content = str_replace('{current_user_url}',$current_user_url,$content);
    $content = str_replace('{user_id}', $post->user_id, $content);
    $content = str_replace('{user_fullname}', $post->post_user->fname." ".$post->post_user->lname, $content);
    $post2 = clone $post;
    $post2->user_id = $post->post_owner;
    if($post->post_owner == $post->user_id){
        $content = str_replace('{content}', ($post->content == "" ? "" : '<p>'.$post->content.'</p>'), $content);
        $content = str_replace('{up_votes}', $post->up_votes, $content);
        $content = str_replace('{down_votes}', $post->down_votes, $content);
        $content = str_replace('{comments_count}', $post->comments_count, $content);
        $content = str_replace('{post_id}', $post->post_id, $content);
        $comment_area = '';
        foreach($post->comments as $comment){
            $result = getCommentHTML($comment);
            $comment_area .= $result;
        }
        $image_area='';
        foreach($post->images as $image){
            $result = getImageHTML($image);
            $image_area .= $result;
        }
        $content = str_replace('{comment_area}', $comment_area, $content);
        $content = str_replace('{image_area}', $image_area, $content);
        $my_vote = checkVote($post->post_id,$_SESSION['user_id']);
        if($my_vote == 1){
            $content = str_replace('{upvote-status}', 'upvoted', $content);
            $content = str_replace('{downvote-status}', 'downvote', $content);
        }
        else if($my_vote == -1){
            $content = str_replace('{upvote-status}', 'upvote', $content);
            $content = str_replace('{downvote-status}', 'downvoted', $content);
        }
        else{
            $content = str_replace('{upvote-status}', 'upvote', $content);
            $content = str_replace('{downvote-status}', 'downvote', $content);
        }
        $content = str_replace('{status}', getBookMarkStatus($post->post_id,$_SESSION['user_id'])==true? 'bookmarked':'', $content);
        $content = str_replace('{current_user_id}', $_SESSION['user_id'], $content);
    }else{
        $profile_url = getProfileURL($post->user_id)['profile_url'];
        $content=  str_replace('{user_url}',$profile_url,$content);
        $content = str_replace('{content}', getSharedPostView($post2), $content);
        $content = str_replace('{up_votes}', $post->up_votes, $content);
        $content = str_replace('{down_votes}', $post->down_votes, $content);
        $content = str_replace('{comments_count}', $post->comments_count, $content);
        $content = str_replace('{post_id}', $post->post_id, $content);
        $comment_area = '';
        foreach($post->comments as $comment){
            $result = getCommentHTML($comment);
            $comment_area .= $result;
        }
        $image_area='';
        $content = str_replace('{comment_area}', $comment_area, $content);
        $content = str_replace('{image_area}', $image_area, $content);
        $my_vote = checkVote($post->post_id,$_SESSION['user_id']);
        if($my_vote == 1){
            $content = str_replace('{upvote-status}', 'upvoted', $content);
            $content = str_replace('{downvote-status}', 'downvote', $content);
        }
        else if($my_vote == -1){
            $content = str_replace('{upvote-status}', 'upvote', $content);
            $content = str_replace('{downvote-status}', 'downvoted', $content);
        }
        else{
            $content = str_replace('{upvote-status}', 'upvote', $content);
            $content = str_replace('{downvote-status}', 'downvote', $content);
        }
        $content = str_replace('{status}', getBookMarkStatus($post->post_id,$_SESSION['user_id'])==true? 'bookmarked':'', $content);
        $content = str_replace('{current_user_id}', $_SESSION['user_id'], $content);
    }
    $content = str_replace('{category}', $post->category, $content);
    if($post->category=='Emergency'){
        $content = str_replace('{badge-state}', 'danger', $content);
    }else{
        $content = str_replace('{badge-state}', 'primary ', $content);
    }
    return $content;
}
?>
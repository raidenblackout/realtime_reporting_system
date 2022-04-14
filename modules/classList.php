<?php
class User{
    public $fname;
    public $lname;
    public $email;
    private $password;
    public $user_id;
    public $username;
    function __construct($fname,$lname,$email,$password,$user_id,$username){
        $this->fname = $fname;
        $this->lname = $lname;
        $this->email = $email;
        $this->password = $password;
        $this->user_id = $user_id;
        $this->username = $username;
    }
};
class Comment{
    public $comment_id;
    public $comment;
    public $user_id;
    public $post_id;
    public $comment_date;
    public $comment_user;
    public $user_url;
    function __construct($comment_id,$comment,$user_id,$post_id,$comment_date,$comment_user){
        $this->comment_id = $comment_id;
        $this->comment = $comment;
        $this->user_id = $user_id;
        $this->post_id = $post_id;
        $this->comment_date = $comment_date;
        $this->comment_user = $comment_user;
    }
};
class Post{
    public $post_id;
    public $content;
    public $user_id;
    public $post_date;
    public $up_votes;
    public $down_votes;
    public $comments_count;
    public $post_owner;
    public $post_user;
    public $comments;
    public $category;
    public $images;
    function __construct($post_id,$content,$user_id,$post_date,$up_votes,$down_votes,$comments_count,$post_owner,$comments, $category,$post_user){
        $this->post_id = $post_id;
        $this->content = $content;
        $this->user_id = $user_id;
        $this->post_date = $post_date;
        $this->up_votes = $up_votes;
        $this->down_votes = $down_votes;
        $this->comments_count = $comments_count;
        $this->post_owner = $post_owner;
        $this->comments = $comments;
        $this->category = $category;
        $this->post_user = $post_user;
    }
    
};



?>
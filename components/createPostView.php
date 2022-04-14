<div class="media" id="create-post">
    <?php
    require_once 'modules/dependencyImporter.php';
    $data='<img class="align-self-start mr-3" src="static/images/{user_url}" alt="Generic placeholder image" style="background-color: black;width: 5vh; height: 5vh; object-fit: scale-down; border-radius: 100%">';
    $user_url=getProfileUrl($_SESSION['user_id'])['profile_url'];
    echo str_replace('{user_url}',$user_url,$data);
    ?>
    <div class="media-body">
        <input type="text" class="form-control" placeholder="What's happening?" data-toggle="modal" data-target="#post-box" style="height: 7vh">
        <div class="post-attach d-flex flex-start align-items-center">
            <div data-toggle="modal" data-target="#post-box">
                <i class="fa fa-camera" data-toggle="tooltip" data-placement="top" data-title="Take a photo"></i>
            </div>
            <div data-toggle="modal" data-target="#post-box">
                <i class="fa fa-video-camera" data-toggle="tooltip" data-placement="top" data-title="Take a video"></i>
            </div>
            <div data-toggle="modal" data-target="#post-box">
                <i class="fa fa-image" data-toggle="tooltip" data-placement="top" data-title="Upload Photos"></i>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="post-box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <form action="modules/createPost.php" method="POST" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="create-post-title">Create a Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea type="text" name="content" class="form-control" placeholder="What's happening?" style="resize: none"></textarea>
                    <div class="photo-video-upload-outer d-flex justify-content-center align-items-center">
                        <div class="photo-video-upload-inner d-flex justify-content-center align-items-center">
                            <div class="d-flex justify-content-center" onclick="openFileDialogue()">
                                <div class="modal-icon">
                                    <i class="fa-solid fa-camera-retro"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <select class="form-control custom-select" aria-label="Category" name="category" required>
                        <option selected disabled>Select a category</option>
                        <?php
                        require_once 'modules/dependencyImporter.php';
                        $categories = getCategories();
                        foreach ($categories as $category) {
                            echo '<option value="' . $category['c_name'] . '">' . $category['c_name'] . '</option>';
                        }

                        ?>
                    </select>
                </div>
                <input type="file" name="image" id="file-input" style="display: none">
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn bg-color-main w-100">Post</button>
                </div>
            </div>
        </div>
    </form>
</div>
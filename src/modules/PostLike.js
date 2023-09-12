import $ from "jquery";

class PostLike {
  constructor() {
    this.events();
  }
  events() {
    //class given to span
    $(".post-like-box").on("click", this.clickDispatcher.bind(this));
  }
  //methods

  clickDispatcher(e) {
    let currentPostLikeBox = $(e.target).closest(".post-like-box");
    if (currentPostLikeBox.data("exists") == "yes") {
      this.deletePostLike(currentPostLikeBox);
    } else {
      this.createPostLike(currentPostLikeBox);
    }
  }
  createPostLike(currentPostLikeBox) {
    $.ajax({
      url: bbeData.root_url + "/wp-json/bbe/v1/managePostLike",
      type: "POST",
      data: { postId: currentPostLikeBox.data("post") },
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
  deletePostLike(currentPostLikeBox) {
    $.ajax({
      url: bbeData.root_url + "/wp-json/bbe/v1/managePostLike",
      type: "DELETE",
      data: {},
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default PostLike;

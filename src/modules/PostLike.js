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
      this.deletePostLike();
    } else {
      this.createPostLike();
    }
  }
  createPostLike() {
    $.ajax({
      url: bbeData.root_url + "/wp-json/bbe/v1/managePostLike",
      type: "POST",
      success: (response) => {
        console.log(response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
  deletePostLike() {
    $.ajax({
      url: bbeData.root_url + "/wp-json/bbe/v1/managePostLike",
      type: "DELETE",
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

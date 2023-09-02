import $ from "jquery";

class Search {
  //1. describe/initiate object
  constructor() {
    this.addSearchHTML();
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    //storing state of overlay
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }
  //2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  //3. methods
  typingLogic() {
    // only if current value is not equals to the previous value
    if (this.searchField.val() !== this.previousValue) {
      // with every keypress the timer will reset.
      clearTimeout(this.typingTimer);
      if (this.searchField.val()) {
        // only implement if it is not already displayed
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
        // if there's nothing in the search field
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }
  //this will run after 2000ms
  getResults() {
    //ist argument--where we wana send req
    $.getJSON(
      `${
        bbeData.root_url
      }/wp-json/bbe/v1/search?term=${this.searchField.val()}`,
      (results) => {
        this.resultsDiv.html(`
        <div class="row">
        <div class="one-third">
        <h2 class="search-overlay__section-title">General Information</h2>
        ${
          results.generalInfo.length
            ? ' <ul class="link-list min-list">'
            : "<p>No general information matches that search ☹"
        }
      
        ${results.generalInfo
          .map(
            (post) =>
              `<li><a href="${post.permalink}">${post.title}</a>${
                post.type === "post" ? ` by ${post.authorName}` : ""
              }</li>`
          )
          .join("")}
        ${results.generalInfo.length.length ? "</ul>" : ""} 
        </div>


        
        <div class="one-third">
        <h2 class="search-overlay__section-title">Programs</h2>
        ${
          results.programs.length
            ? ' <ul class="link-list min-list">'
            : `<p>No programs match that search. <a href="${bbeData.root_url}/programs">View all programs</a></p>`
        }
      
  ${results.programs
    .map((post) => `<li><a href="${post.permalink}">${post.title}</a></li>`)
    .join("")}
        ${results.programs.length ? "</ul>" : ""} 
        <h2>Instructors</h2>
        ${
          results.instructors.length
            ? '<ul class="professor-cards">'
            : `<p>No instructors match that search.</p>`
        }
          ${results.instructors
            .map(
              (item) => `
            <li class="professor-card__list-item">
              <a class="professor-card" href="${item.permalink}">
                <img class="professor-card__image" src="${item.image}">
                <span class="professor-card__name">${item.title}</span>
              </a>
            </li>
          `
            )
            .join("")}
        ${results.instructors.length ? "</ul>" : ""}
        </div>

        <div class="one-third">
        <h2 class="search-overlay__section-title">Campuses</h2>
        ${
          results.campuses.length
            ? ' <ul class="link-list min-list">'
            : `<p>No campuses match that search ☹ <a href="${bbeData.root_url}/campuses"> View all Campuses</a> </p>`
        }
      
  ${results.campuses
    .map((post) => `<li><a href="${post.permalink}">${post.title}</a></li>`)
    .join("")}
        ${results.campuses.length.length ? "</ul>" : ""} 
        
        <h2>Events</h2>
        </div>
        </div>
      `);
        this.isSpinnerVisible = false;
      }
    );
  }
  keyPressDispatcher(e) {
    // only show when any other input is not focused on the screen.
    if (
      e.keyCode === 83 &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.openOverlay();
    }
    if (e.keyCode === 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val("");
    setTimeout(() => this.searchField.focus(), 301);
    this.isOverlayOpen = true;
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }

  addSearchHTML() {
    $("body").append(`
      <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" class="search-term" autocomplete="off" placeholder="What are you looking for?" id="search-term">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
      </div>
  
      <div class="container">
        <div id="search-overlay__results">
         
        </div>
      </div>
    </div>
      `);
  }
}

export default Search;

class MobileMenu {
  constructor() {
    this.menu = document.querySelector(".site-header__menu");
    this.openButton = document.querySelector(".site-header__menu-trigger");
    this.events();
  }

  events() {
    this.openButton.addEventListener("click", () => this.toggleMenu());
    window.addEventListener("resize", () => this.closeMenuOnResize());
  }

  toggleMenu() {
    this.openButton.classList.toggle("fa-bars");
    this.openButton.classList.toggle("fa-window-close");
    this.menu.classList.toggle("site-header__menu--active");
  }

  closeMenuOnResize() {
    const windowWidth = window.innerWidth;

    // Close the menu and reset the mobile menu icon on screens larger than 768px
    if (windowWidth > 768) {
      this.openButton.classList.remove("fa-window-close");
      this.openButton.classList.add("fa-bars");
      this.menu.classList.remove("site-header__menu--active");
    }
  }
}

export default MobileMenu;

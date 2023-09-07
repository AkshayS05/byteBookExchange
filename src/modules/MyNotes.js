const deleteNotes = document.querySelectorAll(".delete-note");
class MyNotes {
  //constructor
  constructor() {
    this.events();
  }
  events() {
    deleteNotes.forEach((deleteNote) => {
      deleteNote.addEventListener("click", this.deleteNote);
    });
  }
  //custom methods
  async deleteNote(event) {
    try {
      console.log(event.target);
      const deleteResponse = await fetch(
        `${bbeData.root_url}/wp-json/wp/v2/note/104`,
        {
          method: "DELETE",
          headers: {
            "X-WP-Nonce": bbeData.nonce,
          },
        }
      );
      return deleteResponse.json();
    } catch (err) {
      console.log(err);
    }
  }
}

export default MyNotes;

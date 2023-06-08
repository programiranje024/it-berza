window.addEventListener("load", () => {
  setInterval(() => {
    const textarea = document.querySelector("textarea");
    if (textarea) {
      if (textarea.value !== "" || textarea === document.activeElement) {
        return;
      }
    }

    location.reload();
  }, 3000);
});

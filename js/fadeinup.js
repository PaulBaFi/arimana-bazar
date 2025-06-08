function toggleButtons() {
  const container = document.getElementById("settingsContent");
  const buttons = container.querySelectorAll(".settings-content-btn");

  if (container.classList.contains("show")) {
    container.classList.remove("show");
    buttons.forEach((btn) => {
      btn.style.opacity = 0;
      btn.style.transform = "translateY(20px)";
      btn.style.animation = "none";
    });
  } else {
    container.classList.add("show");
    buttons.forEach((btn, index) => {
      btn.style.animation = "none";
      void btn.offsetWidth;
      btn.style.animation = `fadeInUp 0.5s ease forwards`;
      btn.style.animationDelay = `${index * 0.1}s`;
    });
  }
}

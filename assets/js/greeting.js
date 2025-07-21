function getHourPeriod() {
  const hour = new Date().getHours();
  if (hour >= 6 && hour < 12) return "morning";
  if (hour >= 12 && hour < 18) return "afternoon";
  return "night";
}

document.addEventListener("DOMContentLoaded", () => {
  const period = getHourPeriod();

  const backgrounds = {
    morning: 'url("assets/images/bgmorning.svg")',
    afternoon: 'url("assets/images/bgafternoon.svg")',
    night: 'url("assets/images/bgnight.svg")',
  };

  const panel = document.getElementById("greetingPanel");

  if (panel) {
    panel.style.backgroundImage = backgrounds[period];
  }
});

function getGreeting() {
  const hour = new Date().getHours();
  if (hour >= 6 && hour < 12) return "☀️ Buenos días";
  if (hour >= 12 && hour < 18) return "🌤️ Buenas tardes";
  return "🌙 Buenas noches";
}

document.addEventListener("DOMContentLoaded", () => {
  const greetingElement = document.getElementById("greeting");
  if (greetingElement) {
    greetingElement.textContent = getGreeting();
  }
});
